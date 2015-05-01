<?php namespace Arx;

use Arx;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Arx\classes\Composer;
use Arx\classes\Str;

class MakeCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'arx:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Arx Make Generator Command';

    /**
     * Create a new command instance.
     *
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

        $args = $this->argument();

        $opts = $this->option();

        var_dump($args, $opts);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('type', InputArgument::REQUIRED, false),
            array('name', InputArgument::OPTIONAL, false)
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('path', null, InputOption::VALUE_OPTIONAL, 'Path to install', null),
            array('bench', null, InputOption::VALUE_OPTIONAL, 'Workbench', null),
            array('namespace', null, InputOption::VALUE_OPTIONAL, 'Namespace', null),
        );
    }

}
