<?php

namespace App\Http\Middleware;
use App\Models\LandingPageSection;
use App\Models\Utility;
use Closure;
use Illuminate\Http\Request;

class XSS
{
    use \RachidLaasri\LaravelInstaller\Helpers\MigrationsHelper;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!file_exists(storage_path(). "/installed"))
        {
            return redirect()->route('LaravelUpdater::welcome');
        }
        if(\Auth::check())
        {
            \App::setLocale(\Auth::user()->currentLanguage());
            if(\Auth::user()->type == 'super admin')
            {
                $migrations             = $this->getMigrations();
                $dbMigrations           = $this->getExecutedMigrations();
                $numberOfUpdatesPending = count($migrations) - count($dbMigrations);

                if($numberOfUpdatesPending > 0)
                {
                    return redirect()->route('LaravelUpdater::welcome');
                }
            }
        }
       
        $RouteName = \Route::currentRouteName();  

        $input = $request->all();
        array_walk_recursive(
                $input, function (&$input,$RouteName){
                $input = ($RouteName != "business.update") ? $input : strip_tags($input) ;
        }
        );
        $request->merge($input);
        
        return $next($request);
    }
}
