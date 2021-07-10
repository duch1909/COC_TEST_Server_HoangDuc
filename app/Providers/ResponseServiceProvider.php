<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseServiceProvider extends ServiceProvider
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
        Response::macro('success', function ($data) {
            return response()->json($data, 200);
        });
        
        Response::macro('created', function ($data) {
            return response()->json($data, 201);
        });

        Response::macro('successWithoutData', function () {
            return response()->json(['success' => true], 200);
        });

        Response::macro('notModified', function ($data) {
            return response()->json($data, 304);
        });

        Response::macro('error', function ($data, $statusCode = 400) {
            return response()->json($data, $statusCode);
        });

        Response::macro('notFound', function ($data) {
            return response()->json($data, 404);
        });

        Response::macro('invalid', function ($data) {
            return response()->json($data, 422);
        });
    }
}
