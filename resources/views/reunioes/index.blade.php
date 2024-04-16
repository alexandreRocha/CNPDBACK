@extends('layouts.master')
@section('title', 'Reuniões CNPD')

@section('content')


     <!-- Breadcrumbs -->
     {{ Breadcrumbs::render('Reuniões') }}

    <link href="{{ asset('admin/css/styleDatatable.css') }}" rel="stylesheet" type="text/css">
     
    <div class="row">
        <div class="col-md-12 col-md-12"> 
            <div class="card shadow mb-4">

                <!-- ALERT-->
                @if(session('message'))
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Success!</h4>
                    <p id="alerta">{{ session('message')}}</p>
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger" role="alert"> 
                    <h4 class="alert-heading">Upss!</h4>
                    <p id="alerta">{{ session('error')}}</p>
                </div>
                @endif
                

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"> Reuniões CNPD</h6>
                </div> 
                <div class="card-body">  
                
                    <div class="nova">
                        @can('gerir-processo')
                            <a class="btn btn-primary" data-toggle="modal" data-target="#agendar">
                                <i class="fas fa-fw fa-edit"></i>
                                Nova Agenda
                            </a> 
                        @endcan 
                    </div>
                    <div id="agendar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="my-modal-title">Agendar Reunião </h5>
                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                
                                <div class="modal-body">
                                    <form class="was-validated" method="post"
                                        action="{{ route('agendarReuniao') }}"
                                        enctype="multipart/form-data">
                                        @csrf  
                                        <div class="row row-cols-1">
                                            <div class="col">   
                                                <div class="form-group">
                                                    <label for="categorias">Processos para serem apreciados:</label>
                                                    <div class="row">
                                                        @foreach ($processosParaAprovacao as $categoria)
                                                            <div class="col-md-6">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="categorias[]" value="{{ $categoria->id }}___{{ $categoria->descricao_processo }}">
                                                                        {{ $categoria->entidade }} - {{ $categoria->descricao_processo }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @if($loop->iteration % 4 == 0)
                                                                </div><div class="row">
                                                            @endif

                                                        <input type="text" name="tipo" value="{{ $categoria->descricao_processo }}" hidden>
                                                        @endforeach
                                                    </div>
                                                </div> 

                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback">Campo obrigatório.</div>
                                            </div>
                                        </div> 
                                        <div class="col-md-12"><br></div> 
                                        <div class="row row-cols-1">
                                            <div class="col">
                                                <div class="input-group flex-nowrap"> 
                                                <textarea class="form-control" type="text" placeholder="Algum Processo de Parecer para ser analisado ..." name="processo_parecer" rows="2"></textarea>
                                                </div>
                                                <div class="va id-feedback"></div> 
                                            </div>
                                        </div> 
                                        <div class="col-md-12"><br></div> 
                                        <div class="row row-cols-1">
                                            <div class="col">
                                                <div class="input-group flex-nowrap"> 
                                                <textarea class="form-control" type="text" placeholder="Algum Processo de Queixa para ser analisado ..." name="processo_queixa" rows="2"></textarea>
                                                </div>
                                                <div class="va id-feedback"></div> 
                                            </div>
                                        </div> 
                                        <hr>

                                        <div id="modal-footer">
                                            <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-edit"></i>
                                                Agendar Reunião </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="display dataTable cell-border" id="nhatabela" width="100%" cellspacing="0">
                                <thead>
                                    <tr> 
                                        <th>Id</th>
                                        <th>Nº Reunião.</th> 
                                        <th>Data Reunião</th>
                                        <th>Nº. Ata</th>  
                                        <th>Estado</th> 
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($reunioes)
                                        @foreach ($reunioes as $reuniao)
                                            <tr> 
                                                <td>{{ $reuniao->id  }}</td> 
                                                <td>{{ $reuniao->num_reuniao  }}</td> 
                                                <td>{{ $reuniao->data_reuniao}}</td>  
                                                <td>{{ $reuniao->num_ata  }}</td> 
                                                <td>
                                                @if($reuniao->estadoR=="Agendada") 
                                                    <label class="badge badge-info">{{ $reuniao->estadoR}}</label>
                                                @elseif($reuniao->estadoR=="Confirmada") 
                                                    <label class="badge badge-primary">{{ $reuniao->estadoR}}</label>
                                                @elseif($reuniao->estadoR=="Finalizada") 
                                                    <label class="badge badge-success">{{ $reuniao->estadoR}}</label>
                                                @elseif($reuniao->estadoR=="Encerrada") 
                                                    <label class="badge badge-success">{{ $reuniao->estadoR}}</label>
                                                @endif
                                                </td> 
                                                <td>
                                                    <a href="{{ url('/reunioes/' . $reuniao->id) }}"
                                                        class="btn btn-primary btn-circle"> <i class="fas fa-eye"></i>
                                                    </a> 
                                                </td> 
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    
      <style>
        .select2-container .select2-selection .select2-selection--multiple .select2-selection__choice {
            display: inline-block;
            margin-right: 5px;
        }

         #foto{
            height:50px;
            width:50px;
        }
        #search{ 
            text-align:right;
        }
        #myInput{
            width:50%;
        }
        #modal-body{
            color: #061536;
            font-family: 'Times New Roman', Times, serif;
        }
        .nova {
            margin-bottom: 10px;
            margin-right: 20px;
            text-align: right;
        }
        .modal-title, label{
            color: #061536; 
            font-weight: bold; 
        }
        
        #modal-footer{
            text-align: center; 
        }
        #agendar{      
        z-index: 10000000;
        }
    </style> 
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
            crossorigin="anonymous">
    </script> 
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js">
    </script> 
    <script src="https://code.jquery.com/jquery-3.5.1.js">
    </script> 


    <script src="https://code.jquery.com/jquery-3.6.3.min.js" 
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" 
        crossorigin="anonymous">
    </script>
    <script src="{{ asset('admin/js/Datatable.js') }}"></script> 
        <script>
            
        let table = new DataTable('#nhatabela'); 
            
            setTimeout(function(){
                $(".alert").slideUp(500, function(){
                    $(this).remove(); 
                });
        //  window.location.reload();
            }, 5000); 
    </script>
@endsection