<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DeployCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'movo:deploy';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Deploy to git';

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
		SSH::run(array(
			'cd /var/www/vhosts/rx7w-7k7n.accessdomain.com/',
			'git reset --hard',
			'git pull origin production',
			'git reset --hard',
		));
	}



}
