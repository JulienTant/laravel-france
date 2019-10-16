<?php

namespace LaravelFrance\Jobs\Slack;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendInvitation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var
     */
    private $email;
    /**
     * @var array
     */
    private $parameters;

    /**
     * Create a new job instance.
     *
     * @param $email
     * @param array $parameters
     */
    public function __construct($email, array $parameters = [])
    {
        $this->email = $email;
        $this->parameters = $parameters;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        slack('UserAdmin')->invite($this->email, $this->parameters);

        $this->delete();
    }
}
