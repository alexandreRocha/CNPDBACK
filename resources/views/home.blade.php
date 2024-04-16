@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid" id="corpo">


 
    <!-- Content BACK -->
    <div class="row" >  
        @can('fullMenu')
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total de Formulário</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$countForms}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a href="processos" id="linkRoute">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                      Total de Processos
                                    </div>
                                </a>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countP }}</div>
                            </div> 
                        <div class="col-auto">
                            <i class="fas fa-book-open fa-2x text-gray-300"></i>
                        </div>
                        </div>
                    </div>
                </div>
            </div>   
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                               Processos Concluidos neste Ano
                            </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">xx</div>
                            </div>
                            <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                               Autorizações emitidas este Ano
                            </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countAutoAnual }}</div>
                            </div>
                            <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center"> 
                                <div class="col mr-2"> 
                                    <a href="pareceres" id="linkRoute">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                           Total de Parecer
                                        </div>
                                    </a>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">xx</div>
                                        </div>
                                    </div>
                                </div> 
                            <div class="col-auto">
                                <i class="fas fa-file-pdf fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center"> 
                                <div class="col mr-2">
                                     <a href="estatisticas" id="linkRoute">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Estatísticas
                                        </div>
                                    </a>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">xx</div>
                                        </div>
                                    </div>
                                </div> 
                            <div class="col-auto">
                                <i class="fas fa-chart-pie fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
             
             
             
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a href="pedidoInformacao" id="linkRoute">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Pedidos informação no site
                                    </div>
                                </a>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $countPE }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Queixas recebidas este Ano    
                            </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countQ }}</div>
                            </div>
                            <div class="col-auto">
                            <i class="fas fa-bullhorn fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        @else
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <a href="meusProcessos" id="linkRoute">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Meus Processos</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><b id="negrito">{{ $countMeusprocessos }}</b></div>
                                </div>
                            </a>
                            <div class="col-auto">
                                <i class="fas fa-solid fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <a href="minhasAuto" id="linkRoute">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Minhas Autorizações</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><b id="negrito">{{ $minhasAutos }}</b></div>
                                </div>
                            </a>
                            <div class="col-auto">
                                <i class="fas fa-solid fa-file fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan 
    </div>

      
<!--
    <div class="row">  
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4"> 
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Taxa Anual de Notificações </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div> 
                <div class="card-body">
                    <div class="chart-area"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="myAreaChart" style="display: block; height: 320px; width: 387px;" width="774" height="640" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div> 
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4"> 
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Taxas por Notificação</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div> 
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="myPieChart" style="display: block; height: 245px; width: 257px;" width="514" height="490" class="chartjs-render-monitor"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Direct
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Social
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Referral
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>
<style>
#linkRoute {
    text-decoration: none; 
}
#negrito{
    text-weight: bold;
}
</style>
@endsection