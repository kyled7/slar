<?php

namespace App\Console\Commands\Generator;

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
    }

    /**
     * Generate Controller file.
     *
     * @param $name
     */
    protected function generateController($name)
    {
        $controllerTemplate = str_replace(
            [
                '{{Model}}',
                '{{model}}',
                '{{models}}',
            ],
            [
                ucwords($name),
                strtolower($name),
                strtolower(str_plural($name)),
            ],
            $this->getStubs('controller')
        );

        file_put_contents($this->getControllerPath().ucwords($name).'Controller.php', $controllerTemplate);
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
        ]);
    }
}
