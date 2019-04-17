<?php

namespace App\Console\Commands\Generator;

use Illuminate\Console\Command;

abstract class BaseGenerator extends Command
{
    /**
     *
     * get stub content
     *
     * @param $type
     * @return bool|string
     */
    protected function getStubs($type) : string
    {
        return file_get_contents(__DIR__ . "/stubs/$type.stub");
    }

    /**
     * Get path for save controller files
     * @return string
     */
    protected function getControllerPath() : string
    {
        return app_path('Http/Controllers/Admin/');
    }

    /**
     * Get path for save Repository files
     * @return string
     */
    protected function getRepositoriesPath() : string
    {
        return app_path('Repositories/');
    }

    /**
     * Get path for update Repository files
     * @return string
     */
    protected function getBindServiceProviderPath() : string
    {
        return app_path('Providers/AppServiceProvider.php');
    }

    /**
     * Get path for save Services files
     * @return string
     */
    protected function getServicesPath() : string
    {
        return app_path('Services/');
    }

    /**
     * Get target name
     * @return array|null|string
     */
    protected function getTargetName()
    {
        return $this->argument('name');
    }
}
