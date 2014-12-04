<?php

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Movo\Shipping\IngramShipping;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RetryFailedIngramShippingCommand extends ScheduledCommand {

	protected $name = 'movo:retry-ingram-shipping';
    protected $description = 'Attempt to resend failed orders to Ingram and mark them as resolved';

	public function __construct()
	{
		parent::__construct();
	}


	public function schedule(Schedulable $scheduler)
	{
		return $scheduler->everyHours(1);
	}


	public function fire()
	{
		IngramShipping::retryFailedOrders();
	}



}
