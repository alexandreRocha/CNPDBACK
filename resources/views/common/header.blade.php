<nav class="navbar navbar-expand navbar-light topbar mb-4 shadow " id="backcolor">


    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none bg-danger rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    @if (Auth::check())  
        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                    aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                placeholder="Search for..." aria-label="Search"
                                aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw" id="iconcolor"></i>
                    <!-- Counter - Alerts --> 
                    <span class="badge badge-danger badge-counter">
                        <!-- SE USER LOGADO FOR DO TIPO TECNICOS ENTAO MOSTRA A CONTAGEM -->
                        @if(Auth::user()->typeUser == 'Informatico' || Auth::user()->typeUser == 'Jurista')
                            {{$countTotalTecnico}}
                        @elseif(Auth::user()->typeUser == 'Secretario')
                            {{$countTotalSec}}
                        @elseif(Auth::user()->typeUser == 'Assistente')
                            {{$countTotalAssist}}
                        @elseif(Auth::user()->typeUser == 'Membro')
                            {{$countTotalMembro}}
                        @endif
                    </span>
                </a>
                <!-- Dropdown - Alerts -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Alertas de eventos
                    </h6>
                    <!-- SE EXISTIR NOVOS FORMULARIOS NO SISTEMA DEVE NOTIFICAR O SECRETARIO E A ASSISTENTE-->
                    
                    @can('gerar-processo-gerar-duc')
                        @if($novoCCTV)
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('/videonovos') }}">
                                <div>   
                                    <p class="font-weight-bold"> 
                                        <i class="fas fa-bell fa-fw text-black"></i>
                                        Deram entradas <span style="color:red">{{$novoCCTV}}</span> novo(s) Formulário(s) de Videovigilância.
                                    </p>
                                </div> 
                            </a>
                        @endif
                        @if($novoInter)
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('/internovos') }}">
                                <div>   
                                    <p class="font-weight-bold"> 
                                        <i class="fas fa-bell fa-fw text-black"></i>
                                        Deram entradas <span style="color:red">{{$novoInter}}</span> novo(s) Formulário(s) de Interconexão.
                                    </p>
                                </div> 
                            </a>
                        @endif
                        @if($novoBio)
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('/bionovos') }}">
                                <div>   
                                    <p class="font-weight-bold"> 
                                        <i class="fas fa-bell fa-fw text-black"></i>
                                        Deram entradas <span style="color:red">{{$novoBio}}</span> novo(s) Formulário(s) de Biometria.
                                    </p>
                                </div> 
                            </a>
                        @endif
                        @if($novoGeral)
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('/geralnovos') }}">
                                <div>   
                                    <p class="font-weight-bold"> 
                                        <i class="fas fa-bell fa-fw text-black"></i>
                                        Deram entradas <span style="color:red">{{$novoGeral}}</span> novo(s) Formulário(s) de Tratamento de Dados Geral.
                                    </p>
                                </div> 
                            </a> 
                        @endif
                        @if($novoGeo)
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('/geonovos') }}">
                                <div>   
                                    <p class="font-weight-bold"> 
                                        <i class="fas fa-bell fa-fw text-black"></i>
                                        Deram entradas <span style="color:red">{{$novoGeo}}</span> novo(s) Formulário(s) de Geolocalizção.
                                    </p>
                                </div> 
                            </a>
                        @endif
                        @if($novoTic)
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('/ticnovos') }}">
                                <div>   
                                    <p class="font-weight-bold"> 
                                        <i class="fas fa-bell fa-fw text-black"></i>
                                        Deram entradas <span style="color:red">{{$novoTic}}</span> novo(s) Formulário(s) de de TIC.
                                    </p>
                                </div> 
                            </a>
                        @endif 
                        @if($countParaAprovacao) 
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('paprovacao') }}"> 
                                <div>   
                                    <p class="font-weight-bold"> 
                                        <i class="fas fa-bell fa-fw text-black"></i>
                                        <span style="color:red">{{$countParaAprovacao}}</span> Nova(s) Autorização(ões) para aprovação.
                                    </p>
                                </div> 
                            </a>
                        @endif
                    
                    @endcan

                    @can('gerir-processo') 
                        @if($countAguardarNotas)
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('aguardarNotas') }}"> 
                                <div>   
                                    <p class="font-weight-bold"> 
                                        <i class="fas fa-bell fa-fw text-black"></i>
                                        <span style="color:red">{{$countAguardarNotas}}</span> Processo(s) estão aguardando a emissão de Nota Despacho.
                                    </p>
                                </div> 
                            </a>
                        @endif
                        @if($countProntosEnvio)
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('prontoEnvio') }}"> 
                                <div>   
                                    <p class="font-weight-bold"> 
                                        <i class="fas fa-bell fa-fw text-black"></i>
                                        <span style="color:red">{{$countProntosEnvio}}</span> Processos estão prontos para o envio ao Notificante.
                                    </p>
                                </div> 
                            </a>
                        @endif
                        @if($countPedidos)
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('novosPedido') }}"> 
                                <div>   
                                    <p class="font-weight-bold"> 
                                        <i class="fas fa-bell fa-fw text-black"></i>
                                        <span style="color:red">{{$countPedidos}}</span> Novos pedidos de informação/esclarecimentos vindos do site. 
                                    </p>
                                </div> 
                            </a>
                        @endif
                    @endcan
                    




                    <!-- SE USER LOGADO FOR DO TIPO TECNICOS ENTAO MOSTRA O {{$countProcessAtribuidosTec}}-->
                    @if($countProcessAtribuidosTec)
                        <a class="dropdown-item d-flex align-items-center" href="{{ url('/enviadosaMim') }}">
                            <div>   
                                <p class="font-weight-bold"> 
                                    <i class="fas fa-bell fa-fw text-black"></i>
                                    Foram atribuidos <span style="color:red">{{$countProcessAtribuidosTec}}</span> Processos a vocé.
                                </p>
                            </div> 
                        </a>
                    @endif 
                    <!-- SE USER LOGADO FOR DO TIPO TECNICOS ENTAO MOSTRA O QUANTOS PROCESSOS ESTAO TRABALHADOS AGUARDANDO PARA NOTIFICAR SECRETARIO-->
                    @if($countNotificarSec)
                        <a class="dropdown-item d-flex align-items-center" href="{{ url('/notificarSecPaprov') }}">
                            <div>   
                                <p class="font-weight-bold"> 
                                    <i class="fas fa-bell fa-fw text-black"></i>
                                    <span style="color:red">{{$countNotificarSec}}</span> Processo(s) está(ão) pronto(s) para ser(em) enviado(s) ao Secretário.
                                </p>
                            </div> 
                        </a>
                    @endif 
                    





                    <!-- SE USER LOGADO FOR DO TIPO MEMBRO ENTAO MOSTRA O {{$countProcessAtribuidosMembro}}-->
                    @if($countProcessAtribuidosMembro)
                        <a class="dropdown-item d-flex align-items-center" href="{{ url('/enviadosaMim') }}">
                            <div>   
                                <p class="font-weight-bold"> 
                                    <i class="fas fa-bell fa-fw text-black"></i>
                                    Foram atribuidos <span style="color:red">{{$countProcessAtribuidosMembro}}</span> Processos a vocé.
                                </p>
                            </div> 
                        </a>
                    @endif 
                    <!-- SE USER LOGADO FOR DO TIPO MEMBROS ENTAO MOSTRA O QUANTOS PROCESSOS ESTAO TRABALHADOS AGUARDANDO PARA NOTIFICAR SECRETARIO-->
                    @if($countNotificarSecM)
                        <a class="dropdown-item d-flex align-items-center" href="{{ url('/notificarSecPaprov') }}">
                            <div>   
                                <p class="font-weight-bold"> 
                                    <i class="fas fa-bell fa-fw text-black"></i>
                                    <span style="color:red">{{$countNotificarSecM}}</span> Processos estão prontos para serem enviados ao Secretário.
                                </p>
                            </div> 
                        </a>
                    @endif  

                    <!-- SE USER LOGADO FOR DO TIPO MEMBROS ENTAO MOSTRA O QUANTOS REUNIOES ESTAO AGENDADAS-->
                    @if($ProcessosReuniaoCount)
                        <a class="dropdown-item d-flex align-items-center" href="{{ url('/reunioesAgenda') }}">
                            <div>   
                                <p class="font-weight-bold"> 
                                    <i class="fas fa-bell fa-fw text-black"></i>
                                    Foram agendadas <span style="color:red"> {{$ProcessosReuniaoCount}}</span> novas reuniões de apreciação de Processos.
                                </p>
                            </div> 
                        </a>
                    @endif  
                </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-envelope fa-fw" id="iconcolor"></i>
                    <!-- Counter - Messages -->
                    <span class="badge badge-danger badge-counter"></span>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">
                        Message Center
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{{ asset('admin/img/undraw_profile_1.svg') }}"
                                alt="...">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                problem I've been having.</div>
                            <div class="small text-gray-500">Emily Fowler · 58m</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{{ asset('admin/img/undraw_profile_2.svg') }}"
                                alt="...">
                            <div class="status-indicator"></div>
                        </div>
                        <div>
                            <div class="text-truncate">I have the photos that you ordered last month, how
                                would you like them sent to you?</div>
                            <div class="small text-gray-500">Jae Chun · 1d</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{{ asset('admin/img/undraw_profile_3.svg') }}"
                                alt="...">
                            <div class="status-indicator bg-warning"></div>
                        </div>
                        <div>
                            <div class="text-truncate">Last month's report looks great, I am very happy with
                                the progress so far, keep up the good work!</div>
                            <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                alt="...">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div>
                            <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                told me that people say this to all dogs, even if they aren't good...</div>
                            <div class="small text-gray-500">Chicken the Dog · 2w</div>
                        </div>
                    </a>
                    <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <b>{{ Auth::user()->name }} </b></span>
                    <img class="img-profile rounded-circle"
                    src="{{ asset('storage/users/'.Auth::user()->foto) }}">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown"> 
                    <a class="dropdown-item" href="{{ route('users.profile', ["profile" => Auth::user()->id]) }}">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a>  
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>

        </ul>
    @endif

</nav>
<style>
    #backcolor{
    background-color: #fff;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 9000;  
    }
    #iconcolor{
        color: #061536;
    }
</style>
