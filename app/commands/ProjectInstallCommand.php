<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ProjectInstallCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'project:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the project.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->info('Installation of the project...');
        $this->info('> Creating DB');
        $this->call('db:create');
        $this->info('> Creating DB Structure');
        $this->call('migrate');

        $fillingDb = strtolower($this->ask('Fill the DB with seeds ? [Y/n]'));

        if ($fillingDb != 'n') {
            $this->info('> Filling DB with seeds');
            $this->call('db:seed');
        }
        $this->info('Done !');

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
        );
    }
}
