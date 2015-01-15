<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateXMLParserFromTableCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'movo:parse-xml';

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

		$columns = Schema::getColumnListing($this->argument("table"));
		echo '$data=[];'."\n";
		for ($i = 0; $i < sizeof($columns); $i++) {
			echo '$data["'.str_replace("_", "-",$columns[$i]).'"] = (String)$xml->xpath("//'.str_replace("_", "-",$columns[$i]).'")[0];'."\n";
		}
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
