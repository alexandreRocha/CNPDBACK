<?php 


namespace App\Http\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Processo;
use App\Models\Sidebar;

class SidebarComposer
{
    public function compose(View $view)
    {
        //TOTAL DE MENUS FORMULARIOS
        $menusF = Sidebar::where('estado', '=', 'Ativo')->where('type', '=', 'Formulario')->get();

        //TOTAL DE MENUS NORMAIS
        $menusN = Sidebar::where('estado', '=', 'Ativo')->where('type', '=', 'Normal')->get();
        
        //TOTAL DE MENUS GESTAO DE SITE
        $menusG = Sidebar::where(['estado'=>'Ativo','type'=>'Gestao'])->orderBy('titulo', 'ASC')->get();

        //TOTAL DE MENUS GESTAO DE PERMISSAO DASHBOARD
        $menusGACL = Sidebar::where(['estado'=>'Ativo','type'=>'Gestao ACL'])->orderBy('titulo', 'ASC')->get();
                
  

        $view->with('menusN', $menusN)
        ->with('menusF', $menusF)
        ->with('menusG', $menusG)
        ->with('menusGACL', $menusGACL);
    }
}