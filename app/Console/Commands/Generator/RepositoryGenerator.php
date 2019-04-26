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
        $this->proceedAndSaveFile(
            $name,
            'repository_interface',
            $this->getRepositoriesPath().ucwords($name).'RepositoryInterface.php'
        );
    }

    /**
     * Generate repository file.
     *
     * @param $name
     */
    protected function generateRepository($name)
    {
        $this->proceedAndSaveFile(
            $name,
            'repository',
            $this->getRepositoriesPath().'/Eloquent/'.ucwords($name).'EloquentRepository.php'
        );
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    protected function bindInterface($name)
    {
        $className = ucwords($name);

        $bindService = $this->filesystem->get($this->getBindServiceProviderPath());
        $key = '//---MORE BINDING---//';

        $bind = '$this->app->singleton(
            \\App\\Repositories\\'.$className.'RepositoryInterface::class,
            \\App\\Repositories\\Eloquent\\'.$className.'EloquentRepository::class
        );'.PHP_EOL.'
        '.$key;
        $bindService = str_replace($key, $bind, $bindService);
        $this->filesystem->put($this->getBindServiceProviderPath(), $bindService);

        return true;
    }
}
