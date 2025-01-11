<?php

namespace App\Mail;

use App\Services\Mail\Dto\CompanyDto;
use App\Services\Mail\Dto\InviteDto;
use App\Services\Mail\Dto\UserDto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteUserToCompanyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private readonly InviteDto $inviteDto,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Вас пригласили в ' . $this->inviteDto->getCompanyName(),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.account-invite',
            with: [
                'inviteDto' => $this->inviteDto,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
