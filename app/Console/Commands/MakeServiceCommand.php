<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class MakeServiceCommand extends Command
{
    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $pathInterface = $this->getSourceFilePathInterface();
        $path = $this->getSourceFilePath();

        $this->makeDirectory(dirname($pathInterface));
        $this->makeDirectory(dirname($path));

        $contentsInterface = $this->getSourceFileInterface();
        $contents = $this->getSourceFile();

        if (!$this->files->exists($pathInterface)) {
            $this->files->put($pathInterface, $contentsInterface);
            $this->info("File : {$pathInterface} created");
        } else {
            $this->error("File : {$pathInterface} already exits");
        }

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->error("File : {$path} already exits");
        }

        // call artisan
        if ($this->files->exists($path) || $this->files->exists($pathInterface)) {
            $name = $this->getSingularClassName($this->argument('name'));

            Artisan::call("make:request Create{$name}Request");
            Artisan::call("make:request Update{$name}Request");
            Artisan::call("make:resource {$name}Resource");
        }
    }

    /**
     * Return the Singular Capitalize Name
     * 
     * @param $name
     * @return string
     */
    public function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    /**
     * Return the stub file path
     * 
     * @return string
     */
    public function getStubPathInterface()
    {
        return base_path('stubs/service_interface.stub');
    }
    
    /**
     * Return the stub file path
     * 
     * @return string
     */
    public function getStubPath()
    {
        return base_path('stubs/service.stub');
    }

    /**
     * Map the stub variables present in stub to its value
     *
     * @return array
     */
    public function getStubVariablesInterface()
    {
        $name = $this->getSingularClassName($this->argument('name'));

        return [
            'NAMESPACE' => 'App\\Interfaces',
            'CLASS_NAME' => $name,
            'MODEL' => $name,
        ];
    }
    
    /**
     * Map the stub variables present in stub to its value
     *
     * @return array
     */
    public function getStubVariables()
    {
        $name = $this->getSingularClassName($this->argument('name'));

        return [
            'NAMESPACE' => 'App\\Services',
            'CLASS_NAME' => $name,
            'MODEL' => $name,
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFileInterface()
    {
        return $this->getStubContents($this->getStubPathInterface(), $this->getStubVariablesInterface());
    }
    
    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile()
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePathInterface()
    {
        return base_path('App/Interfaces') . DIRECTORY_SEPARATOR . $this->getSingularClassName($this->argument('name')) . 'ServiceInterface.php';
    }
    
    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return base_path('App/Services') . DIRECTORY_SEPARATOR . $this->getSingularClassName($this->argument('name')) . 'Service.php';
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}
