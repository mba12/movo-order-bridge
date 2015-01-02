<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DeployCommand extends Command
{

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
        echo exec("git checkout production");
        echo exec("git merge master --no-ff");
        if ($this->option('inc')) {
            $currentBranch = exec('git symbolic-ref --short HEAD');
            if ($currentBranch != "production") {
                echo "You must be in the production branch to do this operation!";
                return;
            }
            $this->incrementJavascript();
            $this->commitAndPushConfig();
            echo "Incrementing Javascript...\n";
        }
        if ($this->confirm('This will run Git Pull on the production server and push your changes live! Do you wish to continue? [yes|no]')) {
            $commands = [
                'cd /var/www/vhosts/rx7w-7k7n.accessdomain.com/',
                'php artisan down',
                'git reset --hard',
                'git pull origin production',
                'git reset --hard',
            ];

            if ($this->option('migrate'))
                $commands[] = 'php artisan migrate --force';

            if ($this->option('composer'))
                $commands[] = 'composer install --no-dev';

            $commands[] = "php artisan up";
            SSH::into('production')->run(
                $commands
            );
        }
        echo exec("git checkout master")."\n";
        $this->info('All done!');

    }

    private function incrementJavascript()
    {
        $path = app_path() . "\config\packages\stolz\assets\config.php";
        $contents = File::get($path);
        $newString = preg_replace_callback("/'local' \? (\d*) : (\d*)/", function ($matches) {
            $parts = explode(" ", $matches[0]);
            $len = sizeof($parts);
            $parts[$len - 1] += 1;
            return implode(" ", $parts);
        }, $contents);
        File::put($path, $newString);

    }

    protected function getOptions()
    {
        return array(
            array('inc', "i", InputOption::VALUE_NONE, 'Increment javascript', null),
            array('migrate', "m", InputOption::VALUE_NONE, 'Run a migration', null),
            array('composer', "c", InputOption::VALUE_NONE, 'Run composer', null),
        );
    }

    private function commitAndPushConfig()
    {
        $path = app_path() . "\config\packages\stolz\assets\config.php";
        echo exec("git commit -m 'incrementing' " . $path);
        echo exec("git push origin production");
    }


}
