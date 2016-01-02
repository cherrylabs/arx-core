<?php namespace Arx;

use Arx;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\HttpFoundation\File\File;

class PublishCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'arx:publish-assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a custom publish assets boilerplate';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        if ($this->confirm('This will override existing assets files, do you whish to continue ?')) {

            $dir = __DIR__ . '/../../views/generators/assets/';

            $files = glob($dir . '*');

            $name = $this->ask('What\'s the name of your project ?', 'my-project');
            $description = $this->ask('Please describe your project', 'Laravel awesome project');

            foreach ($files as $file) {
                if (is_file($file)) {

                    $tmp = Arx\classes\Str::smrtr(
                        file_get_contents($file),
                        ['project.name' => strtolower(str_slug($name)), 'project.description' => $description],
                        ['<%=', '%>']
                    );

                    $file = str_replace($dir, '', $file);

                    file_put_contents(base_path($file), $tmp);

                } elseif (is_dir($file)) {
                    $folder = str_replace($dir, '', $file);
                    app('files')->copyDirectory($file, resource_path('assets/' . $folder));
                }
            }

            $this->info('Default Arx assets created');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }

}
