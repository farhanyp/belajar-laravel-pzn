<?php

namespace App\Providers;

use App\Services\SayHello;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Person;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SayHello::class, function(){
            return new SayHello();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('hello', function ($expression) {
            return "<?php echo 'Hello' . $expression; ?>";
        });

        Blade::stringable(function (Person $person) {
            return "$person->name : $person->address" ;
        });
    }
}
