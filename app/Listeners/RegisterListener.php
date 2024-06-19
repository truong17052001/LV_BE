<?php

namespace App\Listeners;

use App\Events\RegisterEvent;
use App\Models\User;
use App\Repositories\Client\TokenRepository;
use App\Support\Helper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;

class RegisterListener
{
    /**
     * Create the event listener.
     */
    private TokenRepository $tokenRepository;
    //
    public function __construct(TokenRepository $tokenRepo)
    {
        $this->tokenRepository = $tokenRepo;
    }

    /**
     * Handle the event.
     */
    public function handle(RegisterEvent $event): void
    {
        //
        $user = $event->user;
        $otp = Helper::generateOtp(6);
        $this->tokenRepository->create([
            "user_id"=> $user->id,
            "otp" => $otp,
            "expired_at" => Carbon::now()->subMinutes(15),
        ]);
    }
}
