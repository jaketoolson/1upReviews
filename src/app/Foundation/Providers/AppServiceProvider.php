<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Foundation\Providers;

use DB;
use DateTime;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('logging.queries') === true) {
            DB::listen(function($query) {
                // Iterate over all the bindings and parse them to correct string values in order to generate
                // a complete raw sql query.
                foreach ($query->bindings as $i => $binding) {
                    if ($binding instanceof DateTime) {
                        $query->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                    } else {
                        if (is_string($binding)) {
                            $query->bindings[$i] = "'$binding'";
                        }
                    }
                }

                $sqlQuery = str_replace(array('%', '?'), array('%%', '%s'), $query->sql);
                $sqlQuery = vsprintf($sqlQuery, $query->bindings);

                $dbLog = new Logger('query');
                $dbLog->pushHandler(
                    new RotatingFileHandler(
                        storage_path('logs/queries.log'),
                        5,
                        Logger::DEBUG
                    )
                );
                $dbLog->info($sqlQuery, ['Bindings' => $query->bindings, 'Time' => $query->time]);
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
