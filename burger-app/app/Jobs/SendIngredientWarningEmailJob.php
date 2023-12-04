<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\IngredientWarningMail;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Mail;

class SendIngredientWarningEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private Ingredient $ingredient)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //send email in queue background
        Mail::to(config('from.address'))->send(new IngredientWarningMail($this->ingredient));
    }
}
