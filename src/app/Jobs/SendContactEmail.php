<?php

namespace LaravelFrance\Jobs;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendContactEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    /**
     * @var array
     */
    private $requestData;

    /**
     * Create a new job instance.
     *
     */
    public function __construct(array $requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * Execute the job.
     *
     * @param Mailer $mailer
     */
    public function handle(Mailer $mailer)
    {
        $data = [
            'name' => $this->requestData['name'],
            'email' => $this->requestData['phone'],
            'sujet' => $this->requestData['subject'],
            'content' => $this->requestData['mailContent']
        ];

        $mailer->send('contact.email.mail', $data, function (Message $message) use ($data) {
            return $message
                ->replyTo($data['email'], $data['name'])
                ->to('julien@laravel.fr', 'Julien Tant')
                ->subject('Contact depuis Laravel.fr');
        });
    }
}
