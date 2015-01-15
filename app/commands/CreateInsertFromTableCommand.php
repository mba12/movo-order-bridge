<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateInsertFromTableCommand extends Command
{

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
        $table = $this->argument("table");
        $words = explode("_", $table);

        for ($i = 0; $i < sizeof($words); $i++) {
            $words[$i] = ucwords(strtolower($words[$i]));
        }
        $class = implode($words, "");
        $class = str_replace("_", "", $class);

        $classText = File::get(base_path() . "\\app\\commands\\templates\\xml_table.txt");
        $classText = str_replace("%CLASS%", $class, $classText);
        $classText = str_replace("%TABLE%", $table, $classText);


        $columns = Schema::getColumnListing($this->argument("table"));
        $insertText = $class . "::create([" . "\n";
        for ($i = 0; $i < sizeof($columns); $i++) {
            if($columns[$i]=="created_at"||$columns[$i]=="updated_at") continue;
            $insertText .= "\t\t\t" . '"' . $columns[$i] . '" =>$data["' . str_replace("_", "-", $columns[$i]) . '"],' . "\n";
        }
        $insertText .="\t\t" . "]);" . "\n";
        $classText = str_replace("%CREATE%", $insertText, $classText);

        $dataText = '$data=[];' . "\n";
        for ($i = 0; $i < sizeof($columns); $i++) {
            if($columns[$i]=="created_at"||$columns[$i]=="updated_at") continue;
            $dataText .= "\t\t" .'$data["' . str_replace("_", "-", $columns[$i]) . '"] = (String)$xml->xpath("//' . str_replace("_", "-", $columns[$i]) . '")[0];' . "\n";
        }
        $classText = str_replace("%DATA%", $dataText, $classText);
        $filePath = base_path() . "\\app\\models\\" . $class . ".php";

        if (File::exists($filePath)) {
            if ($this->confirm('This file already exists! Do you wish to overwrite? [yes|no]')) {
                File::put($filePath, $classText);
            }else{
                $this->info('XML parser for ' . $class . " aborted");
            }

        } else {
            File::put($filePath, $classText);

        }
        $this->info('XML parser for ' . $class . " is created!");

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
