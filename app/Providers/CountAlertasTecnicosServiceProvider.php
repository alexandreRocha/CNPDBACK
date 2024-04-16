<?php

namespace App\Providers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Processo; 
use View;
class CountAlertasTecnicosServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
           
    }

    
    public function boot()
    {
         
       /* $countProcessAtribuidos = Processo::where('responsavel_processo', Auth::user()->name)->get();
        $countProcessAtri = count($countProcessAtribuidos);
        $countAlertasTecnicos = $countProcessAtri;

        View::share('countProcessAtribuidos', $countProcessAtribuidos);
        View::share('countProcessAtri', $countProcessAtri);
        View::share('countAlertasTecnicos', $countAlertasTecnicos);
        */
    }
    
}
