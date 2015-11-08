<?php

namespace LaravelFrance\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSlackInvitation extends Job implements SelfHandling, ShouldQueue
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
        \Log::debug((array)slack('UserAdmin')->invite($this->email, $this->parameters));

        $this->delete();
    }

}
