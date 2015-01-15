<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateInsertFromTableCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'movo:insert';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

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
		$table= $this->argument("table");
		$words=explode("_",$table);

		for ($i = 0; $i <sizeof($words) ; $i++) {
			$words[$i]=ucwords(strtolower($words[$i])) ;
		}
		$class=implode($words, "");
		$class=str_replace("_","",$class);
		$columns = Schema::getColumnListing($this->argument("table"));
		echo $class."::create([";
		for ($i = 0; $i < sizeof($columns); $i++) {
			echo '"'.$columns[$i].'" =>$data["'.$columns[$i].'"],';
		}
		echo "]);";
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('table', InputArgument::REQUIRED, 'table name'),
		);
	}


}
