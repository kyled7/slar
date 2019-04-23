<?php

namespace App\Console\Commands\Generator;

use Illuminate\Support\Str;

class CrudGenerator extends BaseGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a full-set of Admin CRUD';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $targetName = $this->getTargetName();

        $this->info("Create model: $targetName");
        $this->generateModel($targetName);

        $this->call('make:repository', [
            'name' => $targetName,
        ]);

        $this->call('make:services', [
            'name' => $targetName,
        ]);

        $this->info("Create $targetName".'Controller');
        $this->generateController($targetName);

        $this->info("Create views for $targetName");
        $this->generateViews($targetName);

        $this->info("Create unit tests for $targetName");
        $this->generateTest($targetName);
    }

    /**
     * Generate Controller file.
     *
     * @param $name
     */
    protected function generateController($name)
    {
        //Generate Requests
        $this->callSilent('make:request', [
            'name' => 'Create'.ucwords($name).'Request',
        ]);
        $this->callSilent('make:request', [
            'name' => 'Update'.ucwords($name).'Request',
        ]);

        $this->proceedAndSaveFile($name, 'controller',
            $this->getControllerPath().ucwords($name).'Controller.php');
    }

    /**
     * Generate Model file.
     *
     * @param $name
     */
    protected function generateModel($name)
    {
        $this->callSilent('make:model', [
            'name'        => 'Models/'.ucwords($name),
            '--migration' => true,
            '--factory'   => true,
        ]);
    }

    /**
     * Generate Views.
     *
     * @param $name
     */
    protected function generateViews($name)
    {
        $viewPath = $this->getViewPath().strtolower(Str::plural($name));
        //Create view folder
        if (!$this->filesystem->isDirectory($viewPath)) {
            $this->filesystem->makeDirectory($viewPath);
        }

        $this->proceedAndSaveFile($name, 'view_index', $viewPath.'/index.blade.php');
        $this->proceedAndSaveFile($name, 'view_create', $viewPath.'/create.blade.php');
        $this->proceedAndSaveFile($name, 'view_show', $viewPath.'/show.blade.php');
        $this->proceedAndSaveFile($name, 'view_edit', $viewPath.'/edit.blade.php');
    }

    protected function generateTest($name)
    {
        $testPath = $this->getTestsPath().'Feature/'.ucwords($name).'Test.php';
        $this->proceedAndSaveFile($name, 'unittest', $testPath);
    }
}
