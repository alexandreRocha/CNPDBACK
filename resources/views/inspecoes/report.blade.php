<!DOCTYPE html>
 <html>

 <head> 
     <title> 
        Relatório Inspeção {{ $report->entidade }} 
    </title> 
 </head>
 
 <body>

     <img class="img-profile " width="60" height="40" src="admin/img/logo.png">

     <footer>
         <hr>
         <p> Contribuinte Nº 370636406, Av. da China, Rampa da Terra Branca, Apartado 1002, C.P. 7600, Praia, Tel:</b>
             (238) 5340390<br>cnpd@cnpd.cv, <u style="color:</b>blue">www.cnpd.cv</u></p> 
     </footer>
     <main>
         <div class="row" id="geral"> 
            <p id="paragrafo"><b>
            Entidade inspecionada:</b>   {{ $report->entidade }} 
            </p>   
            <p id="paragrafo"><b>
            Equipa inspetiva:</b>   {{ $report->equipa_insp }} 
            </p> 
            <p id="paragrafo"><b>
            Hora de início:</b>   {{ $report->horai }}h 
            </p> 
            <p id="paragrafo"><b>
            Hora de término:</b>   {{ $report->horaf }}h 
            </p>  
            <p id="paragrafo"><b>
            Recebidos por:</b>   {{ $report->receb_por_funcao }} 
            </p> 
            <p id="paragrafo"><b>
            Tipo de inspeção:</b>   {{ $report->tipo_insp }} 
            </p>
            <p id="paragrafo"><b>
            Finalidade de tratamento:</b>   {{ $report->finalidade }} 
            </p> 
            
            @if($report->tipo_insp == 'CCTV')
                 
                <p id="paragrafo"><b>N.º de câmaras:</b>   {{ $report->num_camara }} </p>
                <p id="paragrafo"><b>As câmaras estão funcionais:</b>  {{ $report->cam_funcio }} </p>
                <p id="paragrafo"><b>Quais as zonas abrangidas:</b>   {{ $report->localiz_cam }} </p>
                <p id="paragrafo"><b>Modelo de aviso:</b>   {{ $report->aviso }} </p>
                <p id="paragrafo"><b>Existe captação de som:</b>   {{ $report->som }} </p>
                <p id="paragrafo"><b>
                Visualização das imagens em tempo real:</b>  {{ $report->quem_visualtemp }} 
                </p>
                <p id="paragrafo"><b>
                Transmissão de imagens para o exterior:</b>  {{ $report->transm_fora }} 
                </p> 
                <br>
                <label for=""> <b>Medidas de segurança</b></label> 
                <br>
                <br>
                <p id="paragrafo"><b>Física:</b>  {{ $report->serv_grav }} </p>
                <p id="paragrafo"><b>Lógica:</b>  {{ $report->medid_log }} </p>
                <p id="paragrafo"><b>Tempo conservação das imagens:</b>  {{ $report->tempo_conserv }} </p> 
                
                @if($report->entidd_extern)
                    <p id="paragrafo"><b>Existe subcontratante:</b>  {{ $report->entidd_extern }} </p> 
                @endif
            @endif 
            <p id="paragrafo"><b>Mais observações:</b>  {{ $report->mais_obs }} </p>
            <div class="col-md-12"><br></div>
            <br>
                <label for=""> <b>Anexos</b></label> 
            <br>
            <div class="col-md-12"><br></div>
             
            @foreach($fotos as $foto)
                <div class="col-md-6"> 
                    <div class="card">
                        <div class="card-body">    
                        <img src="{{ public_path('inspecoesProcesso/' . $foto['anexo']) }}" style="max-width: 100%; height: auto;"> 
                        <div class="col-md-12"><br></div>
                        </div>
                    </div> 
                </div>
            @endforeach
            <br>
            <div class="col-md-12"><br></div>  
        </div> 
        <p id="center">
            <img src="{{ public_path('images/assinatura.png') }}" style="max-width: 100%; height: auto;"> 
        </p>  
        <div class="col-md-12"><br></div> 
        <p id="center">/- Técnico Inspetor -/ </p>
     </main>
<!-- Numeração da página -->
 
 </body>

 </html>
 <style>
    #pupu{
        color:</b>red
    }
    #paragrafo{
        text-align:</b> justify;
        text-justify:</b> inter-word;
        font-family:</b> 'Times New Roman', Times, serif;
        color:</b>black;
    }
    #paragrafo1{
        text-align:</b> justify;
        text-justify:</b> inter-word;
        font-family:</b> 'Times New Roman', Times, serif;
        color:</b>black;
        padding-left:</b> 50px;
    }
    #center {
        font-weight:</b> bold;
        text-align:</b> center;
    }

    #negritoLeft {
        font-weight:</b> bold;
        text-align:</b> left;
    }

    footer {
        position:</b> fixed;
        left:</b> 0px;
        right:</b> 0px;
        height:</b> 150px;
        bottom:</b> 0px;
        margin-bottom:</b> -130px;
        text-align:</b> center;
        font-size:</b> 10px;
        color:</b> #061536;
        font-family:</b> "Times New Roman", Times, serif;
    }

    header {
        position:</b> fixed;
        left:</b> 0px;
        right:</b> 0px;
        height:</b> 150px;
        margin-top:</b> -150px;
    }

    #notFound {
        color:</b> #ffffff;
        border-style:</b> ridge;
        border-radius:</b> 10px;
        background-color:</b> #990000;
        text-align:</b> center;
    }

    #geral {
        font-size:</b> 14px;
        background-color:</b> #fff;
        color:</b> #061536;
        font-family:</b> "Times New Roman", Times, serif;
        margin-left:</b> 5px;
        margin-right:</b> 10px
    }

    #cabecalho {
        color:</b> #ffffff;
        border-style:</b> ridge;
        border-radius:</b> 5px;
        background:</b> #061536;
    }

    #name {
        font-weight:</b> bold;
        color:</b> #061536;
    }

    #right {
        text-align:</b> right;
    }

    #nameCenter {
        text-align:</b> center;
    }

    #descricao {
        color:</b> #061536;
        border-style:</b> ridge;
    }

    #reptrab {
        height:</b> auto;
        z-index:</b> 10000000;
    }

    #borderStyle {
        color:</b> #061536;
        border-style:</b> ridge;
    }

    td, th {
    font-weight:</b> normal;
    }
    table {
        font-family:</b> "Times New Roman", Times, serif;
        border-collapse:</b> collapse;
        width:</b> 100%;
    }

    td,
    th {
        text-align:</b> left;
        padding:</b> 8px;
    }

    th {
        width:</b> 40%
    }

    table,
    th,
    td {
        border:</b> 1px solid #061536;
    }
 </style>