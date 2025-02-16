<?php

namespace App\Mail;

use App\Services\Mail\Dto\UserDto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private readonly UserDto $userDto,
        private readonly string $code,
    ) {
    }

    public function build(): self
    {
        return $this->subject('Parts Sotrans - восстановление пароля')
            ->view('emails.account-reset-password',
                [
                    'user' => $this->userDto,
                    'link' => config('app.url').'/forgotPassword/'.$this->code,
                ]);
    }
}
