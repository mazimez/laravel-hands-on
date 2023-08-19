<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class SampleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $test_message = null;
    public $file = null;
    public $extension = null;

    /**
     * Create a new message instance.
     *
     * @return void
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
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
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
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'test_mail'
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        if ($this->file) {
            return [
                Attachment::fromData(fn () => $this->file, 'file' . '.' . $this->extension),
            ];
        }
        return [];
    }
}
