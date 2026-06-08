<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
use App\Models\Item;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | TOYYIBPAY ONLINE PAYMENT
    |--------------------------------------------------------------------------
    */

    public function createBill(Request $request, $claimId)
    {
        $claim = Claim::with(['item.user', 'user'])->findOrFail($claimId);
        $item  = $claim->item;

        // Only Owner may initiate payment
        $ownerUser = $item->type === 'found' ? $claim->user : $item->user;
        if (auth()->id() !== $ownerUser->id) {
            return back()->with('error', 'Unauthorised access.');
        }

        // Create bill via ToyyibPay API
        $response = Http::asForm()->post(env('TOYYIBPAY_URL') . '/index.php/api/createBill', [
            'userSecretKey'     => env('TOYYIBPAY_SECRET_KEY'),
            'categoryCode'      => env('TOYYIBPAY_CATEGORY_CODE'),
            'billName'          => 'UTM FoundIt - Delivery Fee',
            'billDescription'   => 'Delivery fee for item: ' . $item->title,
            'billPriceSetting'  => 1,        // fixed price
            'billPayorInfo'     => 1,        // collect payer info
            'billAmount'        => 1000,     // RM10.00 in cents
            'billReturnUrl'     => route('payment.return', $claimId),
            'billCallbackUrl'   => route('payment.callback', $claimId),
            'billExternalReferenceNo' => 'CLAIM-' . $claimId,
            'billTo'            => $ownerUser->name,
            'billEmail'         => $ownerUser->email,
            'billPhone'         => '0000000000',
            'billSplitPayment'  => 0,
            'billSplitPaymentArgs' => '',
            'billPaymentChannel'=> 0,        // FPX
            'billContentEmail'  => 'Thank you for your payment. Your item will be shipped soon.',
            'billChargeToCustomer' => 1,
        ]);

        $data = $response->json();
        if (isset($data[0]['BillCode'])) {
    $billCode = $data[0]['BillCode'];

    // Save bill code + shipping address in claim
    $claim->update([
        'bill_code'        => $billCode,
        'shipping_address' => $request->shipping_address,
    ]);

    // Redirect to ToyyibPay checkout
    return redirect(env('TOYYIBPAY_URL') . '/' . $billCode);
}

        return back()->with('error', 'Failed to create payment. Please try manual transfer instead.');
    }

    /*
    |--------------------------------------------------------------------------
    | CALLBACK — ToyyibPay calls this after payment
    | status_id: 1 = success, 2 = pending, 3 = failed
    |--------------------------------------------------------------------------
    */

    public function callback(Request $request, $claimId)
    {
        $claim = Claim::with(['item.user', 'user'])->findOrFail($claimId);
        $item  = $claim->item;

        $statusId = $request->input('status_id');

        if ($statusId == 1) {
            // Payment successful
            $claim->update([
                'payment_method'     => 'online',
                'payment_status'     => 'paid',
                'transaction_id'     => $request->input('transaction_id'),
                'shipping_address'   => $claim->shipping_address ?? 'To be provided',
            ]);

            $item->update(['status' => 'claimed']);

            // Resolve roles
            $finderUser = $item->type === 'found' ? $item->user : $claim->user;
            $ownerUser  = $item->type === 'found' ? $claim->user : $item->user;

            // Email Finder: payment received, please ship
            try {
                Mail::send([], [], function ($msg) use ($finderUser, $ownerUser, $item) {
                    $msg->to($finderUser->email)
                        ->subject('[UTM FoundIt] Payment Received — Please Ship ' . $item->title)
                        ->html("
                            <div style='font-family:Arial,sans-serif;padding:25px;color:#333;max-width:600px;border:1px solid #e5e7eb;border-radius:16px;'>
                                <h2 style='color:#800000;'>Hello, {$finderUser->name}!</h2>
                                <p><strong>{$ownerUser->name}</strong> has completed the RM10 payment online for <strong>{$item->title}</strong>.</p>
                                <p>Please log in and check the shipping address, then ship the item and click <strong>Mark as Returned / Shipped</strong>.</p>
                                <p>
                                    <a href='" . url('/items') . "' style='background:#800000;color:#fff;padding:12px 24px;text-decoration:none;border-radius:8px;font-weight:bold;display:inline-block;'>
                                        Go to Items
                                    </a>
                                </p>
                                <p style='color:#999;font-size:12px;margin-top:20px;'>Automated email — do not reply.</p>
                            </div>
                        ");
                });
            } catch (\Exception $e) {
                \Log::error('Payment callback email failed: ' . $e->getMessage());
            }
        }

        return response('OK', 200);
    }

    /*
    |--------------------------------------------------------------------------
    | RETURN — User redirected back after payment
    |--------------------------------------------------------------------------
    */

    public function returnUrl(Request $request, $claimId)
{
    $claim    = Claim::with(['item.user', 'user'])->findOrFail($claimId);
    $claim->refresh();
    
    $statusId = $request->input('status_id');

    if ($statusId == 1) {
        $claim->update([
            'payment_method' => 'online',
            'payment_status' => 'paid',
            'transaction_id' => $request->input('transaction_id'),
        ]);

        $claim->item->update(['status' => 'claimed']);

        $claim->refresh();

        // Resolve roles
        $finderUser = $claim->item->type === 'found' ? $claim->item->user : $claim->user;
        $ownerUser  = $claim->item->type === 'found' ? $claim->user : $claim->item->user;
        $item       = $claim->item;
        $address    = $claim->shipping_address ?? 'Please contact the owner for shipping address.';
        // Email Finder
        try {
            $address = $claim->shipping_address ?? 'Please check with the owner for shipping address.';

            Mail::send([], [], function ($msg) use ($finderUser, $ownerUser, $item, $address) {
                $msg->to($finderUser->email)
                    ->subject('[UTM FoundIt] Payment Received — Please Ship ' . $item->title)
                    ->html("
                        <div style='font-family:Arial,sans-serif;padding:25px;color:#333;max-width:600px;border:1px solid #e5e7eb;border-radius:16px;'>
                            <h2 style='color:#800000;'>Hello, {$finderUser->name}!</h2>
                            <p><strong>{$ownerUser->name}</strong> has completed the RM10 payment for <strong>{$item->title}</strong>.</p>
                            <div style='background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:15px;margin:20px 0;'>
                                <p style='margin:0 0 6px;font-weight:bold;color:#166534;'>Ship to this address:</p>
                                <p style='margin:0;font-size:14px;'>{$address}</p>
                            </div>
                            <p>Please ship the item, then log in and click <strong>Mark as Returned / Shipped</strong>.</p>
                            <p>
                                <a href='" . url('/items') . "' style='background:#800000;color:#fff;padding:12px 24px;text-decoration:none;border-radius:8px;font-weight:bold;display:inline-block;'>
                                    Go to Items
                                </a>
                            </p>
                            <p style='color:#999;font-size:12px;margin-top:20px;'>Automated email — do not reply.</p>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
            \Log::error('returnUrl email to Finder failed: ' . $e->getMessage());
        }

        return redirect('/items')->with('status', 'Payment successful! The finder has been notified to ship your item. 🎉');
    }

    return redirect('/items')->with('error', 'Payment was not completed. Please try again or use manual transfer.');
}
}