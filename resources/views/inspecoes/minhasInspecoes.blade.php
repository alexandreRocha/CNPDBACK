@extends('layouts.master')
@section('title', 'Minhas Inspeções')

@section('content')


     <!-- Breadcrumbs -->
     {{ Breadcrumbs::render('Minhas Inspeções') }}

     <link href="{{ asset('admin/css/styleDatatable.css') }}" rel="stylesheet" type="text/css">
    
    <div class="row">
        <div class="col-md-12 col-md-12"> 
            <div class="card shadow mb-4">

                <!-- ALERT-->
                @if(session('message')) 
                    <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Success!</h4>
                    <p>{{ session('message')}}</p>
                    </div>  
                    
                @endif
                

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"> Minhas Inspeções</h6>
                </div> 
                <div class="card-body">  
                 <!--end Large modal -->
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="display dataTable cell-border" id="nhatabela" width="100%" cellspacing="0">
                                <thead>
                                    <tr> 
                                        <th>Id</th> 
                                        <th>Entidade</th>
                                        <th>Data</th>  
                                        <th>Tipo</th> 
                                        <th>Estado</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($minhasinsp)
                                        @foreach ($minhasinsp as $inspecao)
                                            <tr> 
                                                <td>{{ $inspecao->id  }}</td> 
                                                <td>{{ $inspecao->entidade  }}</td> 
                                                <td>{{ $inspecao->created_at  }}</td> 
                                                <td>{{ $inspecao->tipo_insp  }}</td>  
                                                <td>
                                                    @if($inspecao->estado=="Realizada") 
                                                        <label class="badge badge-info">{{ $inspecao->estado}}</label>
                                                    @elseif($inspecao->estado=="Concluido") 
                                                        <label class="badge badge-success">{{ $inspecao->estado}}</label>
                                                    @endif
                                                </td> 
                                                <td>
                                                    <a href="{{ url('/inspecoes/' . $inspecao->id) }}"
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
        #my-modal{      
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
        }, 5000)
    </script>
@endsection