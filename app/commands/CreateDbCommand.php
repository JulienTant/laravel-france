<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateDbCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'db:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the database for specified env (MySQL only).';

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
        $default = Config::get('database.default');
        $infos = Config::get('database.connections.'.$default);


        $connection = new PDO($infos['driver'].":host=".$infos['host'], $infos['username'], $infos['password']);
        $connection->query("DROP DATABASE IF EXISTS ". $infos['database']);
        $connection->query("CREATE DATABASE ". $infos['database']);

        $this->info('Database "'. $infos['database'] . '" created');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }
}
