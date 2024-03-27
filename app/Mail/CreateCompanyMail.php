<?php

namespace App\Mail;

use App\Services\Mail\Dto\CompanyDto;
use App\Services\Mail\Dto\UserDto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreateCompanyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private readonly UserDto $userDto,
        private readonly CompanyDto $companyDto,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Компания успешно создана',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.create-company',
            with: [
                'user' => $this->userDto,
                'company' => $this->companyDto,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
