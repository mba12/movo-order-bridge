<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CatCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'movo:cat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab log file contents';

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
     * @return mixed
     */
    public function fire()
    {


        $commands = [
            'cd /var/www/vhosts/rx7w-7k7n.accessdomain.com/',
            'cat app/storage/logs/' . $this->option('file').".log",
        ];

        SSH::into('production')->run(
            $commands
        );

        $this->info('All done!');

    }


    protected function getOptions()
    {
        return array(
            array('file', "f", InputOption::VALUE_REQUIRED, 'file to cat', null),
        );
    }

}
