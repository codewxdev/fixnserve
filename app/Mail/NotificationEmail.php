<?php

// app/Mail/NotificationEmail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->data['subject'] ?? 'Notification')
            ->markdown('emails.notification')
            ->with([
                'user' => $this->data['user'] ?? null,
                'content' => $this->data['content'] ?? $this->data['message'] ?? '',
                'type' => $this->data['notification_type'] ?? null,
                'actionUrl' => $this->data['action_url'] ?? null,
                'actionText' => $this->data['action_text'] ?? null,
            ]);
    }
}
