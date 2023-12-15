<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PostDeletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $post_title;

    public $deletion_reason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($post_title, $deletion_reason)
    {
        $this->post_title = $post_title;
        $this->deletion_reason = $deletion_reason;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Post Deleted',
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
            view: 'post_deleted',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
