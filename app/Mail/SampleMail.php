<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;

class SampleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $test_message = null;
    public $file = null;
    public $extension = null;

    /**
     * Create a new message instance.
     */
    public function __construct(
        $test_message,
        $file = null,
        $extension = null
    ) {
        $this->test_message = $test_message;
        $this->file = $file;
        $this->extension = $extension;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                config('mail.from')['address'],
                'Some Other Project'
            ),
            subject: 'Test Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'test_mail'
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if ($this->file) {
            return [
                Attachment::fromData(fn() => $this->file, 'file' . '.' . $this->extension),
            ];
        }
        return [];
    }
}
