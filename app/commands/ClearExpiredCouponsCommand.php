<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ClearExpiredCouponsCommand extends ScheduledCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'movo:clear-expired-coupons';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Clear coupon tokens that are a week old.';

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
	 * When a command should run
	 *
	 * @param Scheduler $scheduler
	 * @return \Indatus\Dispatcher\Scheduling\Schedulable
	 */
	public function schedule(Schedulable $scheduler)
	{
		return $scheduler->everyMinutes(1);//daily()->hours(0);
	}


	public function fire()
	{
		Log::info("hey this works!!!");
		return;
		$oneWeekAgoDate = date("Y-m-d", strtotime("-1 week"));
		DB::table('coupon_instances')->where('created_at', '<', $oneWeekAgoDate)->delete();
	}



}
