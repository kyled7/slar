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

        $this->info("Create services: $targetName");
        $this->generateService($targetName);
    }

    protected function generateService($name)
    {
        $serviceTemplate = str_replace(
            [
                '{{Model}}',
                '{{model}}',
                '{{models}}'
            ],
            [
                ucwords($name),
                strtolower($name),
                strtolower(str_plural($name))
            ],
            $this->getStubs('services')
        );

        file_put_contents($this->getServicesPath() . ucwords($name) . 'Services.php', $serviceTemplate);
    }
}
