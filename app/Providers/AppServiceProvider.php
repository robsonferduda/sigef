<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Response::macro('downloadArquivoTXT', function ($content, $nomeArquivo) {

            $headers = [
            'Content-type'        => 'text/txt',
            'Content-Disposition' => "attachment; filename=".$nomeArquivo,
            ];

            return \Response::make($content, 200, $headers);

        });

        Validator::extend('criticaDigitoPIS', 'App\Utils@criticaDigitoPIS');

        \Response::macro('downloadArquivoCSV', function ($content, $nomeArquivo) {

            $headers = [
            'Content-type'        => 'application/csv',
            'Content-Disposition' => "attachment;filename=".$nomeArquivo,
            "Pragma"              => "no-cache"
            ];

            return \Response::make($content, 200, $headers);

        });
    }
}
