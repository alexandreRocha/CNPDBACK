<!DOCTYPE html>
 <html>

 <head> 
     <title>
        Ordem de Trabalho - Reunião CNPD
    </title> 
 </head>
 
 <body id="corpo">

     <img class="img-profile " width="60" height="40" src="admin/img/logo.png">

     <footer>
         <hr>
         <p> Contribuinte Nº: 370636406, Av. da China, Rampa da Terra Branca, Apartado 1002, C.P. 7600, Praia, Tel:
             (238) 5340390<br>cnpd@cnpd.cv, <u style="color:blue">www.cnpd.cv</u></p> 
     </footer>
     <main>
         <div class="row" id="geral">

            <div class="col-md-12"><br></div>
            <div class="col-md-12"><br></div> 
                <p id="center">
                    <?php
                        $data = explode("-", $reuniao->data_reuniao); 
                        setlocale(LC_TIME, 'pt_PT'); // Definir localidade para português  

                    ?>

                    <b id="sublinhado">
                        REUNIÃO DE <?php echo $data[2] . " de " . strftime('%B', mktime(0, 0, 0, $data[1], 1)) . " de " . $data[0] ?>
                    </b> 
                     <br><br><br>
                    <b>ORDEM DE TRABALHOS </b>
                </p>  
            <div class="col-md-12"><br></div>
            <div class="col-md-12"><br></div> 
            <b id="sublinhado"> <?php echo $reuniao->hora_reuniao ?></b> 
            <div class="col-md-12"><br></div>
            
            <p id="negritoLeft">
                <b>I</b> - Informações Gerais
            </p> 
            <br>
            <p id="negritoLeft">
                <b>II</b> - Apreciação e deliberação dos seguintes Processos:
            </p>
            <div class="col-md-12"><br></div>
            <?php 
                if($processosProntos){
                    $letra = 'a';
                    foreach($processosProntos as $pronto){
                        ?>
                        <p id="paragrafo"> 
                        <?php echo $letra.") - " . $pronto->entidade ." - " . $pronto->tipo ?>;
                            <br>
                        </p>  
                        <?php
                    $letra++; 
                    }
                }

                if($reuniao->processo_parecer){?> 
                <div class="col-md-12"><br></div>
                    <p id="negritoLeft">
                        <b>II</b> - Apreciação dos seguintes Processos de Parecer:
                    </p>
                    <p id="paragrafo"> 
                        <?php 
                            echo $reuniao->processo_parecer 
                        ?>
                    </p>
                <?php 
                }
                if($reuniao->processo_queixa){
                    ?> 
                <div class="col-md-12"><br></div>
                    <p id="negritoLeft">
                        <b>III</b> - Apreciação dos seguintes Processos de Queixa:
                    </p> 
                    <p id="paragrafo"> 
                        <?php 
                            echo $reuniao->processo_queixa
                        ?>
                    </p>
                <?php  
                }  
                if($reuniao->outros_assuntos){
                    ?>
                <div class="col-md-12"><br></div>
                    <p id="negritoLeft">
                        <b>IV</b> - Outros assuntos:
                    </p> 
                    <p id="paragrafo"> 
                        <?php 
                            echo $reuniao->outros_assuntos
                        ?>
                    </p>
                <?php  
                } 
                ?>
            <br> <br>
            <p id="nameCenter"> 
                <b id="negritoLeft"> Comissão Nacional de Protecção de Dados, 
                    <?php
                        setlocale(LC_TIME, 'pt_BR');
                        $dataAtual = strftime('%d de %B de %Y');
                        echo strtolower($dataAtual); 
                    ?> 
                </b> 
                <br> <br>
                Presidente da Comissão Nacional de Protecção de Dados <br><br>
                Faustino Varela Monteiro 
            </p>
        </div> 
    </main> 
 </body>

 </html>
 <style>
    #sublinhado{
        text-transform: uppercase;
       text-decoration: underline;
    }
    #pupu{
        color:red
    }
    #paragrafo{
        text-align: justify;
        text-justify: inter-word;
        font-family: 'Times New Roman', Times, serif;
        color:black;
    }
    #paragrafo1{
        text-align: justify;
        text-justify: inter-word;
        font-family: 'Times New Roman', Times, serif;
        color:black;
        padding-left: 50px;
    }
    #center {
        font-weight: bold;
        text-align: center;
    }

    #negritoLeft {
        font-weight: bold;
        text-align: left;
    }

    footer {
        position: fixed;
        left: 0px;
        right: 0px;
        height: 150px;
        bottom: 0px;
        margin-bottom: -130px;
        text-align: center;
        font-size: 10px;
        color: #061536;
        font-family: "Times New Roman", Times, serif;
    }

    header {
        position: fixed;
        left: 0px;
        right: 0px;
        height: 150px;
        margin-top: -150px;
    }

    #notFound {
        color: #ffffff;
        border-style: ridge;
        border-radius: 10px;
        background-color: #990000;
        text-align: center;
    }

    #geral {
        font-size: 14px;
        background-color: #fff;
        color: #061536;
        font-family: "Times New Roman", Times, serif;
        margin-left: 5px;
        margin-right: 10px
    }

    #cabecalho {
        color: #ffffff;
        border-style: ridge;
        border-radius: 5px;
        background: #061536;
    }

    #name {
        font-weight: bold;
        color: #061536;
    }

    #right {
        text-align: right;
    }

    #nameCenter {
        text-align: center;
    }

    #descricao {
        color: #061536;
        border-style: ridge;
    }

    #reptrab {
        height: auto;
        z-index: 10000000;
    }

    #borderStyle {
        color: #061536;
        border-style: ridge;
    }

    td, th {
    font-weight: normal;
    }
    table {
        font-family: "Times New Roman", Times, serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        text-align: left;
        padding: 8px;
    }

    th {
        width: 40%
    }

    table,
    th,
    td {
        border: 1px solid #061536;
    }
 </style>