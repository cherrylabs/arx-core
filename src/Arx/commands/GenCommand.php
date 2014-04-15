<?php namespace Arx;

use Arx;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Arx\classes\Composer;
use Arx\classes\Str;

class GenCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'arx:gen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Arx Generator Command';

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

        $args = $this->argument();

        $opts = $this->option();

        if($args['type'] == 'grunt'){


            // generate grunt config

            $info = array();

            $info['$project_name'] = $this->ask('What\'s the name of your project ?', @\Config::get('project.name'));

            $info['$project_description'] = $this->ask('What\'s the description of your project ?', @\Config::get('project.description'));

            $info['$author'] = $this->ask('What\'s your name ?', @\Config::get('workbench.name'));

            # copy .bowerrc & Gruntfile

            copy(__DIR__.'/../../views/generators/.bowerrc', base_path('.bowerrc'));

            copy(__DIR__.'/../../views/generators/Gruntfile.js', base_path('Gruntfile.js'));

            # Generate bower.json

            $bower = Str::smrtr(file_get_contents(__DIR__.'/../../views/generators/bower.json.stub'), $info, array('<%=', '%>'));

            if(file_put_contents(base_path('bower.json'), $bower)){
                $this->info('bower.json copied');
            }

            # Generate package.json.tpl.php

            $package = Str::smrtr(file_get_contents(__DIR__.'/../../views/generators/package.json.stub'), $info, array('<%=', '%>'));

            if(file_put_contents(base_path('package.json'), $package)){
                $this->info('package.json copied');
            }

            $this->info('Arx Grunt generated !');
        }

        // Better Gen Command

        if($args['type'] == 'command'){

            $info = array('namespace' => null);

            if(! $info['name'] = $args['name']){
                $info['name'] = $this->ask("What's the name of your Command ?");
            }

            if($opts['bench']){

                $aBench = explode('/', $opts['bench']);

                $info['namespace'] = ucfirst($aBench[0]).'\\'.ucfirst($aBench[1]);
                $info['namespace_path'] = ucfirst($aBench[0]).'/'.ucfirst($aBench[1]);

                $info['path'] = base_path('workbench/'.$opts['bench']).'/src/'.$info['namespace_path'].'/commands';

            } elseif($opts['namespace']){

                $info['namespace'] = $opts['namespace'];

                $info['path'] = Composer::getPathByNamespace($info['namespace']).'/commands';

            } else {
                $info['path'] = app_path('commands');
            }

            if(!empty($info['namespace'])){
                $info['namespace'] = 'namespace '.$info['namespace'].';';
            }

            $genCommand = Str::smrtr(file_get_contents(__DIR__.'/../../views/generators/command.stub'), $info, array('<%=', '%>'));

            if(file_put_contents($info['path'].'/'.$info['name'].'.php', $genCommand)){
                $this->info('Command copied');
            }

            $this->info('Arx Command generated !');

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
