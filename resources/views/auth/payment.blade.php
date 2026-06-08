<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTMFoundIt - Payment & Delivery</title>
    
    <style>
        body {
            margin: 0;
            padding: 40px 20px;
            background-color: #f5f5f5;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(127,29,29,0.01) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(153,27,27,0.01) 0%, transparent 50%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23991b1b' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 80vh;
        }

        /* QR Magnifier */
        .qr-wrapper {
            position: relative;
            display: inline-block;
            cursor: zoom-in;
        }
        .qr-wrapper img {
            max-width: 150px;
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 5px;
            background: white;
            transition: opacity 0.2s;
        }
        .qr-wrapper:hover img {
            opacity: 0.85;
        }
        .qr-hint {
            font-size: 11px;
            color: #999;
            margin-top: 6px;
            display: block;
        }

        /* Modal overlay */
        #qr-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.75);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            cursor: zoom-out;
        }
        #qr-modal.active {
            display: flex;
        }
        #qr-modal img {
            max-width: 85vw;
            max-height: 85vh;
            border-radius: 16px;
            border: 4px solid white;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            animation: popIn 0.2s ease;
        }
        #qr-modal-close {
            position: absolute;
            top: 20px;
            right: 24px;
            color: white;
            font-size: 32px;
            cursor: pointer;
            font-weight: bold;
            line-height: 1;
            opacity: 0.8;
            transition: opacity 0.2s;
        }
        #qr-modal-close:hover { opacity: 1; }

        @keyframes popIn {
            from { transform: scale(0.85); opacity: 0; }
            to   { transform: scale(1);    opacity: 1; }
        }
    </style>
</head>
<body>

    {{-- QR Modal --}}
    <div id="qr-modal" onclick="closeQrModal()">
        <span id="qr-modal-close" onclick="closeQrModal()">✕</span>
        <img id="qr-modal-img" src="" alt="QR Code">
    </div>

    <div style="width: 100%; max-width: 500px; display: flex; flex-direction: column; gap: 20px;">
        
        <div style="background: white; border-radius: 18px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #eef0f2;">
            <div style="background: linear-gradient(135deg, #8b4747, #1e0101); padding: 18px 20px; text-align: center;">
                <h1 style="color: white; margin: 0; font-size: 24px; letter-spacing: 1px; font-weight: bold;">
                    UTMFoundIt
                </h1>
                <p style="color: #f1dede; margin: 5px 0 0 0; font-size: 13px;">
                    Payment & Delivery Summary
                </p>
            </div>

            <div style="padding: 25px;">
                <div style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #f0f0f0; font-size: 14px; color: #666;">
                    <strong>Item to Claim:</strong> <span style="color: #333;">{{ $claim->item->title }}</span>
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 15px; color: #555; padding-bottom: 15px; border-bottom: 1px dashed #ddd;">
                    <span>Delivery Rate</span>
                    <span style="font-weight: 600; color: #333;">RM 10.00</span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 16px; font-weight: bold; color: #1e0101;">Total Amount</span>
                    <span style="font-size: 22px; font-weight: 800; color: #7b1111;">RM 10.00</span>
                </div>
            </div>
        </div>

        <div style="background: #fff5f5; border-left: 4px solid #7b1111; border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; flex-direction: column; gap: 15px;">
            <div>
                <h4 style="color: #7b1111; margin-top: 0; margin-bottom: 5px; font-size: 15px; font-weight: bold;">
                    Finder's Bank Account Details
                </h4>
                <p style="color: #555; font-size: 13px; line-height: 1.4; margin: 0;">
                    Please perform a manual bank transfer or scan the QR code to pay the finder:
                </p>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 6px; font-size: 14px; color: #333;">
                <div><strong>Account Holder:</strong> {{ $claim->item->user->name }}</div>
                <div><strong>Bank Name:</strong> {{ $claim->item->bank_name ?? 'Not Specified' }}</div>
                <div><strong>Account Number:</strong> {{ $claim->item->bank_account ?? 'Not Specified' }}</div>
            </div>

            @if($claim->item->bank_qr)
                <div style="text-align: center; margin-top: 10px; padding-top: 15px; border-top: 1px dashed #ddd;">
                    <p style="font-size: 12px; color: #666; font-weight: bold; margin-bottom: 8px;">Scan QR to Pay:</p>
                    <div class="qr-wrapper" onclick="openQrModal('{{ asset('storage/' . $claim->item->bank_qr) }}')">
                        <img src="{{ asset('storage/' . $claim->item->bank_qr) }}" alt="Bank QR">
                        <span class="qr-hint">🔍 Tap to enlarge</span>
                    </div>
                </div>
            @endif
        </div>

        {{-- Shipping Address (shared for both methods) --}}
    <div style="background: white; border-radius: 18px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #eef0f2;">
        <h3 style="color: #800000; margin-top: 0; margin-bottom: 15px; font-size: 18px; font-weight: bold;">
            📍 Shipping Address
        </h3>
        <textarea id="shipping_address_input" rows="3" required
            placeholder="Receiver name, phone number, full address..."
            style="width:100%;padding:12px;border:1px solid #ccc;border-radius:8px;font-size:14px;background:#fafafa;font-family:Arial,sans-serif;resize:vertical;box-sizing:border-box;"></textarea>
    </div>

    {{-- Payment Method --}}
    <div style="background: white; border-radius: 18px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #eef0f2;">
        <h3 style="color: #800000; margin-top: 0; margin-bottom: 6px; font-size: 18px; font-weight: bold;">
            💳 Choose Payment Method
        </h3>
        <p style="color:#888;font-size:13px;margin:0 0 18px;">Select how you'd like to pay the RM10 delivery fee.</p>

        {{-- Option 1: Pay Online --}}
        <form action="{{ route('payment.create', $claim->id) }}" method="POST" id="online-form">
            @csrf
            <input type="hidden" name="shipping_address" id="online_address">
            <button type="submit" onclick="return passAddress('online_address')"
                style="width:100%;background:linear-gradient(135deg,#1d4ed8,#2563eb);color:white;padding:14px;border:none;border-radius:10px;font-size:15px;font-weight:bold;cursor:pointer;margin-bottom:12px;display:flex;align-items:center;justify-content:center;gap:10px;">
                ⚡ Pay Online via FPX — RM10.00
                <span style="font-size:11px;background:rgba(255,255,255,0.2);padding:3px 8px;border-radius:20px;font-weight:600;">Recommended</span>
            </button>
        </form>

        <div style="display:flex;align-items:center;gap:10px;margin:16px 0;">
            <div style="flex:1;height:1px;background:#eee;"></div>
            <span style="color:#aaa;font-size:12px;font-weight:600;">OR</span>
            <div style="flex:1;height:1px;background:#eee;"></div>
        </div>

        {{-- Option 2: Manual Transfer --}}
        <form action="{{ route('claims.uploadReceipt', $claim->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="shipping_address" id="manual_address">

            <p style="font-size:13px;font-weight:bold;color:#555;margin:0 0 10px;">📤 Manual Bank Transfer</p>

            <div style="display:flex;flex-direction:column;gap:8px;">
                <div>
                    <label style="font-size:12px;font-weight:bold;color:#888;text-transform:uppercase;display:block;margin-bottom:4px;">Payment Receipt (image)</label>
                    <input type="file" name="payment_receipt_image" required
                           style="padding:10px;border:1px solid #ccc;border-radius:8px;font-size:14px;background:#fafafa;width:100%;box-sizing:border-box;">
                    @error('payment_receipt_image')
                        <span style="color:#7b1111;font-size:13px;">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" onclick="return passAddress('manual_address')"
                    style="background:#7b1111;color:white;padding:14px;border:none;border-radius:10px;font-size:15px;font-weight:bold;cursor:pointer;">
                    Submit Receipt & Notify Finder
                </button>
            </div>
        </form>
    </div>

        <div style="text-align: center;">
            <a href="/items" style="color: #666; font-size: 14px; text-decoration: none;">← Cancel and return to items</a>
        </div>

    </div>

    <script>
        function openQrModal(src) {
            document.getElementById('qr-modal-img').src = src;
            document.getElementById('qr-modal').classList.add('active');
        }
        function closeQrModal() {
            document.getElementById('qr-modal').classList.remove('active');
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeQrModal();
        });

        function passAddress(targetId) {
        const addr = document.getElementById('shipping_address_input').value.trim();
        if (!addr) {
            alert('Please fill in your shipping address first.');
            return false;
        }
        document.getElementById(targetId).value = addr;
        return true;
    }
    </script>

</body>
</html>