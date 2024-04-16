<ul class="navbar-nav sidebar sidebar-dark accordion " >

    
    <div id="accordionSidebar">
        <!--  
          <a id="logotipo" class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
             
        </a>-->
        <a id="logotipo" class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
            <div class="sidebar-brand-icon">
                <img class="img-profile " width="60" height="40"
                src="{{ asset('admin/img/logo.png') }}">
            </div>
            <div class="sidebar-brand-text mx-3">SGD <sup>V1.0</sup></div>
        </a>
        
       <hr class="sidebar-divider my-0"> 
        <br><br><br> 
        <hr class="sidebar-divider d-none d-md-block">
 
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard </span></a>
        </li>

        <!-- MENU GERAL DE SISTEMA SOMENTE PARA OS UTILIZADORES COM PERMISSAO DE ACESSAR A TUDO - FULL ACCESS -->
         
        @can('fullMenu')
            <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#formulario"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Formulários</span>
                </a>
                <div id="formulario" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded"> 
                        @foreach ($menusF as $menuF) 
                            <a class="collapse-item" href="{{ route("$menuF->url") }}">
                                <i class="{{ $menuF->icon }}"></i> {{ $menuF->titulo }}
                            </a> 
                        @endforeach
                    </div>
                </div> 
            </li>
            @foreach ($menusN as $menuN) 
                @if($menuN->titulo == 'Pedidos de Informação')
                    @can('pedidos-informacao')
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route("$menuN->url") }}"> 
                            <i class="{{ $menuN->icon }}"></i>
                            <span>{{$menuN->titulo }}</span>
                        </a> 
                    </li>
                    @endcan
                @elseif($menuN->titulo == 'Processos')
                    <li class="nav-item active">
                        <a class="nav-link" href="#" data-toggle="collapse" data-target="#processos"
                            aria-expanded="true" aria-controls="collapsePages">
                            <i class="{{ $menuN->icon }}"></i>
                            <span>Processos</span>
                        </a>
                        <div id="processos" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">  
                                <a class="collapse-item" href="{{ route("$menuN->url") }}">
                                    <i class="{{ $menuN->icon }}"></i> Todos os Processos
                                </a>  
                                @if(Auth::user()->typeUser=="Secretario")
                                    <a class="collapse-item" href="/aguardarNotaD">
                                        <i class="fas fa-file-pdf"></i>  Para Gerar Nota
                                    </a>  
                                    <a class="collapse-item" href="/prontoEnvioAN">
                                        <i class="fas fa-envelope"></i>  Para Envio
                                    </a>  
                                    <a class="collapse-item" href="{{ route('paprovacao') }}">
                                        <i class="fas fa-check"></i>  Para Aprovação
                                    </a> 
                                @endif
                                @if(Auth::user()->typeUser!="Secretario" && Auth::user()->typeUser!="Assistente")
                                    <a class="collapse-item" href="/meusProcessos">
                                        <i class="fas fa-book-open"></i> Meus Processos
                                    </a>  
                                @endif
                            </div>
                        </div> 
                    </li>
                @else
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route("$menuN->url") }}">
                            <i class="{{ $menuN->icon }}"></i>
                            <span>{{ $menuN->titulo }}</span>
                        </a>
                    </li>
                @endif 
            @endforeach
        @else
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('meusProcessos') }}">
                    <i class="fas fa-book-open"></i> Meus Processos  
                </a>
            </li> 
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('minhasAuto') }}">
                    <i class="fas fa-file-pdf"></i> Minhas Autorizações
                </a>
            </li> 
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('minhasInspecoes') }}">
                    <i class="fas fa-file-pdf"></i> Minhas Inspeções
                </a>
            </li> 
        @endcan
                 
           
        
        
        <!-- CASO USER LOGADO TIVER PERMISSAO DE GERIR SITE E TAMBEM PERMISSAO
         PARA GERIR PERMISSOES NO DASHBOARD TERA ESSES MENUS PARA ADMINISTRAR O SITE CNPD.CV -->
         
        @can('admin-manager')  
            <hr class="sidebar-divider"> 
            <!-- SOMENTE ADMIN -->
            <div class="sidebar-heading">
                Administrator
            </div> 
            <!-- GESTAO DE DASHBOARD -->
            <li class="nav-item"> 
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Admin Manager</span> 
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded"> 
                        @foreach ($menusG as $menuG) 
                            <a class="collapse-item" href="{{ route("$menuG->url") }}">
                                <i class="{{ $menuG->icon }}"></i>
                                {{ $menuG->titulo }}
                            </a> 
                        @endforeach
                    </div>
                </div>
            </li>  
                <!-- ACL LARAVEL -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Permissão ACL</span>
                </a>
                <div id="collapsePages2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded"> 
                        @foreach ($menusGACL as $menuGACL) 
                            <a class="collapse-item" href="{{ route("$menuGACL->url") }}">
                            <i class="{{ $menuGACL->icon }}"></i> 
                                {{ $menuGACL->titulo }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </li>      
        @endcan
        <hr class="sidebar-divider d-none d-md-block">  
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div> 
    </div>

</ul>
<style> 
#showColor{ 
    color: #fff;
    margin-left: 90px;
    display: block;
}
#accordionSidebar{
        background-color: #061536; 
        z-index: 10000;  
        position: fixed;
        top: 0; 
        width: 100;
        overflow-y: scroll; 
        bottom: 0;
    }
#logotipo{
    position: fixed;  
    background:#061536; 
    z-index: 20; 
    width: 100;
    color: white; 
    /*background-image: url("{{ asset('admin/img/logodash.png') }}");
    background-repeat: no-repeat;
    background-size: 100% 100%;*/
    
}
#sidebarToggle{
     margin-left:45%
}
  
  
</style>
