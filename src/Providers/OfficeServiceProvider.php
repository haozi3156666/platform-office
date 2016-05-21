<?php namespace Sanatorium\Office\Providers;

use Cartalyst\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class SyncServiceProvider extends ServiceProvider {

    /**
     * {@inheritDoc}
     */
    public function boot()
    {
        $this->prepareResources();

        $this->registerLaravelExcel();

        $this->registerBarryvdhDompdf();
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {

    }

    /**
     * Prepare the package resources.
     *
     * @return void
     */
    protected function prepareResources()
    {
        $config = realpath(__DIR__.'/../../config/config.php');

        $this->mergeConfigFrom($config, 'sanatorium-office');

        $this->publishes([
            $config => config_path('sanatorium-office.php'),
        ], 'config');
    }

    protected function registerBarryvdhDompdf()
    {
        $serviceProvider = 'Barryvdh\DomPDF\ServiceProvider';

        if ( class_exists($serviceProvider) )
        {
            if (!$this->app->getProvider($serviceProvider))
            {
                $this->app->register($serviceProvider);
            }
        }

        if ( class_exists('Barryvdh\DomPDF\Facade') )
        {
            AliasLoader::getInstance()->alias('Excel', 'Barryvdh\DomPDF\Facade');
        }
    }

    protected function registerLaravelExcel()
    {
        $serviceProvider = 'Maatwebsite\Excel\ExcelServiceProvider';

        if ( class_exists($serviceProvider) )
        {
            if (!$this->app->getProvider($serviceProvider))
            {
                $this->app->register($serviceProvider);
            }
        }

        if ( class_exists('Maatwebsite\Excel\Facades\Excel') )
        {
            AliasLoader::getInstance()->alias('Excel', 'Maatwebsite\Excel\Facades\Excel');
        }

    }

    /**
     * Function used for integrity checks
     */
    public static function checkExcel()
    {
        $class = 'Maatwebsite\Excel\Facades\Excel';

        /**
         * Dependency is not available
         */
        if ( !class_exists($class) )
            return false;

        return true;
    }

    /**
     * Function used for integrity checks
     */
    public static function checkPDF()
    {
        $class = 'Barryvdh\DomPDF\Facade';

        /**
         * Dependency is not available
         */
        if ( !class_exists($class) )
            return false;

        return true;
    }

}
