<?php

namespace LaravelFranceOld\Jobs\Slack;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use LaravelFranceOld\Jobs\Job;

class SendInvitation extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

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
