<?php

namespace App\Console\Commands\Generator;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

abstract class BaseGenerator extends Command
{
    protected $filesystem;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    /**
     * get stub content.
     *
     * @param $type
     *
     * @return bool|string
     */
    protected function getStubs($type) : string
    {
        return $this->filesystem->get(__DIR__."/stubs/$type.stub");
    }

    /**
     * Get path for save controller files.
     *
     * @return string
     */
    protected function getControllerPath() : string
    {
        return app_path('Http/Controllers/Admin/');
    }

    /**
     * Get path for save View files.
     *
     * @return string
     */
    protected function getViewPath() : string
    {
        return resource_path('views/admin/');
    }

    /**
     * Get path for save Repository files.
     *
     * @return string
     */
    protected function getRepositoriesPath() : string
    {
        return app_path('Repositories/');
    }

    /**
     * Get path for update Repository files.
     *
     * @return string
     */
    protected function getBindServiceProviderPath() : string
    {
        return app_path('Providers/AppServiceProvider.php');
    }

    /**
     * Get path for save Services files.
     *
     * @return string
     */
    protected function getServicesPath() : string
    {
        return app_path('Services/');
    }

    /**
     * Get target name.
     *
     * @return array|null|string
     */
    protected function getTargetName()
    {
        return $this->argument('name');
    }

    /**
     * Replace & save file.
     *
     * @param $stub
     * @param $path
     * @param $name
     */
    protected function proceedAndSaveFile($name, $stub, $path)
    {
        $template = str_replace([
            '{{Model}}',
            '{{model}}',
            '{{models}}',
        ], [
            ucwords($name),
            strtolower($name),
            strtolower(Str::plural($name)),
        ],
            $this->getStubs($stub)
        );
        $this->filesystem->put($path, $template);
    }
}
