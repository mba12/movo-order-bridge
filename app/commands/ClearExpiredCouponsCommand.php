<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ClearExpiredCouponsCommand extends ScheduledCommand
{

    protected $name = 'movo:clear-expired-coupons';


    protected $description = 'Clear coupon tokens that are a week old.';

    public function __construct()
    {
        parent::__construct();
    }


    public function schedule(Schedulable $scheduler)
    {
        return $scheduler->daily()->hours(0);
    }


    public function fire()
    {
        $oneWeekAgoDate = date("Y-m-d", strtotime("-1 week"));
        DB::table('coupon_instances')->where('created_at', '<', $oneWeekAgoDate)->delete();
    }


}
