<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;

class AutoConfirmClaims extends Command
{
    // Nama command yang akan ditaip di terminal
    protected $signature = 'claim:auto-confirm';
    protected $description = 'Automatically confirm claims if the claimant forgets to click after 3 days';

    public function handle()
    {
        // Cari item yang mana Finder dah confirm, Claimant belum confirm, status belum close, dan tidak ada dispute
        $items = Item::where('finder_confirmed', true)
                     ->where('claimant_confirmed', false)
                     ->where('is_disputed', false)
                     ->where('status', 'claimed')
                     ->where('finder_confirmed_at', '<=', now()->subDays(3))
                     ->get();

        foreach ($items as $item) {
            $item->update([
                'claimant_confirmed' => true,
                'status' => 'returned' // Auto-close item deal
            ]);
            
            $this->info("Item ID {$item->id} has been automatically closed after 3 days of silence.");
        }

        $this->info('Auto-confirmation system executed successfully.');
    }
}