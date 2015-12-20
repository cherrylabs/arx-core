<?php namespace Arx;

use Arx;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Arx\classes\Str;

class AngularCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:angular';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new angular app|controller|directive|filter|service script template';

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

        $type = $args['type'] ?: 'app';

        $file = file_get_contents(__DIR__.'/../../views/generators/angular/'.$type.'.js.stub');

        if ($type == 'app') {
            $name = $args['name'];
        } else{
            $name = $args['name'].ucfirst(strtolower($type));
        }

        $data = array_dot([
            'namespace' => $args['name'],
            'name' => $name,
            'modules' => isset($opts['modules']) ? $opts['modules'] : '',
        ]);

        $file = Str::smrtr($file, $data, ['<%= ', ' %>']);

        if (!$args['folder']) {
            $args['folder'] = 'components';
        }

        $path = $opts['path'].'/'.$args['folder'].'/'.$args['name'].'/';

        if (isset($opts['bench'])) {
            $path = ('workench/'.$opts['bench'].'/public/src/js/');
        }

        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }

        $filepath = $path . $name.'.js';

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
            array('name', InputArgument::REQUIRED, false),
            array('type', InputArgument::OPTIONAL, false),
            array('folder', InputArgument::OPTIONAL, false),
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
            array('path', null, InputOption::VALUE_OPTIONAL, 'Path to install', 'resources/assets/js'),
            array('bench', null, InputOption::VALUE_OPTIONAL, 'Workbench', null),
            array('modules', null, InputOption::VALUE_OPTIONAL, 'Modules to load', null),
        );
    }

}
