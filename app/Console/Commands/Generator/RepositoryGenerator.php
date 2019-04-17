<?php

namespace App\Console\Commands\Generator;

class RepositoryGenerator extends BaseGenerator
{
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
    protected $description = 'Create a repository set';

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

        $this->info("Create repository: $targetName");
        $this->generateInterface($targetName);
        $this->generateRepository($targetName);

        $this->bindInterface($targetName);
    }

    /**
     * Generate interface file.
     *
     * @param $name
     */
    protected function generateInterface($name)
    {
        $repositoryInterfaceTemplate = str_replace(
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
            $this->getStubs('repository_interface')
        );

        file_put_contents($this->getRepositoriesPath().ucwords($name).'RepositoryInterface.php', $repositoryInterfaceTemplate);
    }

    /**
     * Generate repository file.
     *
     * @param $name
     */
    protected function generateRepository($name)
    {
        $repositoryTemplate = str_replace(
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
            $this->getStubs('repository')
        );

        file_put_contents($this->getRepositoriesPath().'/Eloquent/'.ucwords($name).'EloquentInterface.php', $repositoryTemplate);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    protected function bindInterface($name)
    {
        $className = ucwords($name);

        $bindService = file_get_contents($this->getBindServiceProviderPath());
        $key = '//---MORE BINDING---//';

        $bind = '$this->app->singleton('.PHP_EOL.'            \\App\\Repositories\\'.$className.'RepositoryInterface::class,'.PHP_EOL.'            \\App\\Repositories\\Eloquent\\'.$className.'EloquentRepository::class'.PHP_EOL.'        );'.PHP_EOL.'        '.$key;
        $bindService = str_replace($key, $bind, $bindService);
        file_put_contents($this->getBindServiceProviderPath(), $bindService);

        return true;
    }
}
