<?php

namespace App\Listeners;

use App\Events\LowStockWarningEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\SendIngredientWarningEmailJob;

class SendLowStockWarningNotificationListener
{
    
    /**
     * Handle the event.
     */
    public function handle(LowStockWarningEvent $event): void
    {
        
        // dispatch to background and continue our work 
        dispatch(new SendIngredientWarningEmailJob($event->ingredient));
    }
}
