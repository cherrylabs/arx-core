<?php namespace Arx;

use Arx;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Arx\classes\Str;

class JsCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:js';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Js ES6 Class ex: artisan make:js shared/api/apiService will generate a Js class in assets/js/shared/api/apiService';

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

        $file = file_get_contents(__DIR__.'/../../views/generators/js/es6-class.js.stub');

        # Define the name of the class

        $parts = explode('/', $args['name']);

        $className = array_pop($parts);

        # Define the folder path of the class
        $folderPath = implode('/', $parts).'/';

        # Prepare data to replace
        $data = array_dot([
            'name' => $className
        ]);

        # Replace data
        $file = Str::smrtr($file, $data, ['<%= ', ' %>']);

        # check if folder exist
        $path = $opts['path'].'/'.$folderPath;

        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }

        $filepath = $path.$className.'.js';

        file_put_contents($filepath, $file);

        $this->info($filepath.' created');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, false)
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
            array('path', null, InputOption::VALUE_OPTIONAL, 'Path to install (default : resources/assets/js)', 'resources/assets/js')
        );
    }

}
