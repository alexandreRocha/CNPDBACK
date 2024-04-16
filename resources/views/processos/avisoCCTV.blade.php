<!DOCTYPE html>
 <html>

 <head> 
     <title>
         <p>Modelo de Aviso de CCTV</p>
    </title> 
 </head>
 
 <body>

     <main>
        <div class="row" id="geral"> 
            <img class="aviso" width="auto" height="auto" src="qrcodes/MODELOAVISO.png">
            <br> 
            <div class="container"> 

                 
                <div class="col-md-12"> <br> </div>
                   <div id="qrcode1">
                    <p>
                    Para garantir a autenticidade desta Autorização, escaneie o <b>QR CODE </b> abaixo, 
                    que foi emitido e validado pela Autoridade competente em matéria de Protecção de Dados, 
                    <b>Comissão Nacional de Protecção de Dados - CNPD</b>, isso assegura a autenticidade e a 
                    confiabilidade deste documento.
                    </p>
                   </div>
                <div class="col-md-12"> <br> </div> 
            
                <div id="qrcode">  
                    <img class="img-profile" width="auto" height="auto" src="qrcodes/{{$processo->qrcode}}"> 
                </div>
                         

                
            </div>
            
            
        </div> 
     </main>
<!-- Numeração da página -->
 
 </body>

 </html>
 <style>
    body {
    margin: 0;
}
#qrcode{
    margin-left:300px;
}
#qrcode1{
    margin-left:100px; 
    margin-right:100px; 
    text-align: justify;
}
.container{
    display: flex; 
}
#geral { 
    font-size: 14px;
    background-color: #fff;
    color: #061536;
    font-family: "Times New Roman", Times, serif; 
}

.aviso{ 
    margin-left:20px
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