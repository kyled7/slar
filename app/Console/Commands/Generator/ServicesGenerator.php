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
    protected $description = 'Create a services file';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $targetName = $this->getTargetName();

        $this->info("Create services: $targetName");
        $this->generateService($targetName);
    }

    protected function generateService($name)
    {
        $this->proceedAndSaveFile($name, 'services',
            $this->getServicesPath() . ucwords($name) . 'Services.php');
    }
}
