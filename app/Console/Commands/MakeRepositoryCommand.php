<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class MakeRepositoryCommand extends Command
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
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new repository class';

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
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
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
        return base_path('stubs/repository_interface.stub');
    }
    
    /**
     * Return the stub file path
     * 
     * @return string
     */
    public function getStubPath()
    {
        return base_path('stubs/repository.stub');
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
            'NAMESPACE' => 'App\\Repositories',
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
        return base_path('App/Interfaces') . DIRECTORY_SEPARATOR . $this->getSingularClassName($this->argument('name')) . 'RepositoryInterface.php';
    }
    
    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return base_path('App/Repositories') . DIRECTORY_SEPARATOR . $this->getSingularClassName($this->argument('name')) . 'Repository.php';
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
