<?php

namespace App\Console\Commands\Generator;

class ServicesGenerator extends BaseGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:services {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a services set';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $targetName = $this->getTargetName();

        $this->info("Create services: $targetName");
        $this->generateInterface($targetName);
        $this->generateServices($targetName);

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
            'services_interface',
            $this->getServicesPath().ucwords($name).'ServicesInterface.php'
        );
    }

    /**
     * Generate repository file.
     *
     * @param $name
     */
    protected function generateServices($name)
    {
        $this->proceedAndSaveFile(
            $name,
            'services',
            $this->getServicesPath().'/Production/'.ucwords($name).'Services.php'
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
            \\App\\Services\\'.$className.'ServicesInterface::class,           
            \\App\\Services\\Production\\'.$className.'Services::class
        );'. PHP_EOL .'
        '.$key;
        $bindService = str_replace($key, $bind, $bindService);
        $this->filesystem->put($this->getBindServiceProviderPath(), $bindService);

        return true;
    }
}
