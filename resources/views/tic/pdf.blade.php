 
<!DOCTYPE html>
<html>

<head>
    <title>PDF {{ $pedido->id }}</title>
</head>

<body>

    <img class="img-profile " width="60" height="40" src="admin/img/logo.png">

    <footer>
        <hr>
        <p> Contribuinte Nº: 370636406, Av. da China, Rampa da Terra Branca, Apartado 1002, C.P. 7600, Praia, Tel:
            (238) 5340390, cnpd@cnpd.cv, www.cnpd.cv</p>
    </footer>
    <main>
        <div class="row" id="geral">

            <div class="col-md-12"><br></div>
            <div class="col-md-12"><br></div>
            <div class="col-md-12" id="cabecalho">
                <b> Notificação de Tratamento de Controlo da Utilização de TIC</b>
            </div>
            <div class="col-md-12"><br></div>
            <div class="col-md-12" id="right"><b>Criado em:</b> {{ $pedido->created_at }}
                <div class="col-md-12"><br></div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card-body">
                    Tipo Notificação : <input type="checkbox" checked disabled> {{ $pedido->tipo_notificacao }}
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card-body">
                    Nº Processo:
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card-body">
                    Ano:
                </div>
            </div>
            <div class="col-md-12"><br></div>
            <div class="col-md-12" id="cabecalho">
                1. Responsável pelo Tratamento
            </div>
            <div class="col-md-12"><br></div>
            <div class="col-md-12" id="nameCenter"><b>Pessoa:</b> {{ $pedido->tipo_pessoa }}</td>

                <div class="col-md-12"><br></div>
                <table>
                    <tr>
                        <th>Nome Denominação:</th>
                        <td>{{ $pedido->nome_denominacao }}</td>
                    </tr>
                    <tr>
                        <th>Nome Comercial:</th>
                        <td>{{ $pedido->nome_comercial }}</td>
                    </tr>
                    <tr>
                        <th>Actividade Desenvolvida:</th>
                        <td>{{ $pedido->atividade_desenvolvida }}</td>
                    </tr>
                    <tr>
                        <th>Nif:</th>
                        <td>{{ $pedido->numero_nif }}</td>
                    </tr>
                    <tr>
                        <th>Rua:</th>
                        <td>{{ $pedido->rua_responsavel_tratamento }}</td>
                    </tr>
                    <tr>
                        <th>Caixa Postal:</th>
                        <td>{{ $pedido->caixapostal_responsavel_tratamento }}</td>
                    <tr>
                        <th>Cidade/Vila/Zona/Lugar:</th>
                        <td>{{ $pedido->local_responsavel_tratamento }}</td>
                    </tr>
                    <tr>
                        <th>Ilha:</th>
                        <td>{{ $pedido->ilha_responsavel_tratamento }}</td>
                    <tr>
                        <th>Concelho:</th>
                        <td>{{ $pedido->concelho_responsavel_tratamento }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $pedido->email_responsavel_tratamento }}</td>
                    <tr>
                        <th>Telefone:</th>
                        <td>{{ $pedido->telefone_responsavel_tratamento }}</td>
                    </tr>
                    <tr>
                        <th>País:</th>
                        <td>{{ $pedido->pais_responsavel_tratamento }}</td </tr>
                </table>

                <div class="col-md-12"><br></div>
                <div class="col-md-12" id="cabecalho">
                    Processamento de Informação
                </div>
                <div class="col-md-12"><br></div>
                <table>
                    <tr>
                        <th> Entidade Subcontratada:</th>
                        <td>{{ $pedido->entidade_processamento_informacao  }}</td>
                    </tr>
                    <tr>
                        <th> Rua:</th>
                        <td>{{ $pedido->rua_processamento_informacao  }}</td>
                    </tr>
                    <tr>
                        <th> Caixa Postal:</th>
                        <td>{{ $pedido->caixapostal_processamento_informacao  }}</td>
                    </tr>
                    <tr>
                        <th> Cidade/Vila/Zona/Lugar:</th>
                        <td>{{ $pedido->local_processamento_informacao  }}</td>
                    </tr>
                    <tr>
                        <th> Ilha:</th>
                        <td>{{ $pedido->ilha_processamento_informacao }}</td>
                    </tr>
                    <tr>
                        <th> Concelho:</th>
                        <td>{{ $pedido->concelho_processamento_informacao }}</td>
                    </tr>
                </table>
                <div class="col-md-12"><br></div>
                <div class="col-md-12" id="cabecalho">
                    2. Finalidades do Tratamento
                </div>
                <div class="col-md-12"><br></div>
                <table>
                    <tr>
                        <th> Finalidades do tratamento:</th>
                        <td>
                            @if ($pedido->finalidade_tratamento)
                            @foreach ($pedido->finalidade_tratamento as $fintratamento)
                            {{ $fintratamento }}<b> | </b>
                            @endforeach
                            @endif
                        </td>
                    </tr>
                </table>
                <div class="col-md-12"><br>
                </div>
                <div class="col-md-12" id="cabecalho">
                    3. Dados pessoais contidos em cada registro
                </div>
                <div class="col-md-12"><br></div>

                <table>
                    <tr>
                        <th id="thstyle">Categorias:</th>
                        <th>Dados pessoais tratados:</th>
                    </tr>
                    <?php  
                        if ($dadoscontidos){
                            foreach ($dadoscontidos as $dadoscontido){?>
                    <tr>
                        <td>{{ $dadoscontido['categorias'] }}</td>
                        <td>
                            @foreach ($dadoscontido['finalidades'] as $fin)
                            {{ $fin['value'] }} <b>|</b>
                            @endforeach

                        </td>
                    </tr>
                    <?php  
                        }
                    }
                ?>
                </table>


                <div class="col-md-12"><br></div>
                <div class="col-md-12" id="cabecalho">
                    4. Trabalhadores abrangidos por especial obrigação de sigilo
                </div>
                <div class="col-md-12"><br></div>
                <table>
                    <tr>
                        <th> Forma de registro:</th>
                        <td>
                            @if ($pedido->trabalhadores_abrangido_obrigacao_sigilo)
                            @foreach ($pedido->trabalhadores_abrangido_obrigacao_sigilo as $trabalhadoressigilo)
                            {{ $trabalhadoressigilo }}<b> | </b>
                            @endforeach
                            @endif
                        </td>
                    </tr>
                </table>
                <div class="col-md-12"><br></div>

                <div class="col-md-12" id="cabecalho">
                    6. Exercicio do direito de acesso
                </div>
                <div class="col-md-12"><br></div>

                <table>
                    <tr>
                        <th> Rua:</th>
                        <td>{{ $pedido->rua_direito_acesso }}</td>
                    </tr>
                    <tr>
                        <th> Caixa Postal:</th>
                        <td>{{ $pedido->caixapostal_direito_acesso }}</td>
                    </tr>
                    <tr>
                        <th> Local para exercer direito de acesso:</th>
                        <td>{{ $pedido->local_direito_acesso }}</td>
                    </tr>
                    <tr>
                        <th> Ilha:</th>
                        <td>{{ $pedido->ilha_direito_acesso }}</td>
                    <tr>
                        <th> Concelho:</th>
                        <td>{{ $pedido->concelho_direito_acesso }}</td>
                    </tr>
                    <tr>
                        <th> Email:</th>
                        <td>{{ $pedido->email_direito_acesso }}</td>
                    <tr>
                        <th> Telefone:</th>
                        <td>{{ $pedido->telefone_direito_acesso }}</td>
                    </tr>
                </table>
                <div class="col-md-12"><br></div>
                <div class="col-md-12" id="cabecalho">
                    De que forma e exercido o direito de acesso?
                </div>
                <div class="col-md-12"><br></div>
                <table>
                    <tr>
                        <th> Forma de direito de acesso:</th>
                        <td> @if ($pedido->forma_direito_acesso)
                            @foreach ($pedido->forma_direito_acesso as $forma)
                            {{ $forma }},
                            @endforeach
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th> Outra forma:</th>
                        <td>
                            {{ $pedido->outrasformas_direito_acesso }}
                        </td>
                    </tr>
                </table>

                <div class="col-md-12"><br></div>
                <div class="col-md-12" id="cabecalho">
                    7. Medidas de segurança a implementar.
                </div>
                <div class="col-md-12"><br></div>
                <table>
                    <tr>
                        <th> Medidas Físicas:</th>
                        <td>{{ $pedido->medidade_seguranca_fisica }}</td>
                    </tr>
                    <tr>
                        <th> Medidas Lógicas:</th>
                        <td>{{ $pedido->medidas_seguranca_logica }}</td>
                    </tr>
                </table>
                <div class="col-md-12"><br></div>
                <div class="col-md-12" id="cabecalho">
                    8. Representante dos Trabalhadores
                </div>

                <div class="col-md-12"><br></div>
                <table>
                    <tr>
                        <th> Representante dos Trabalhadores:</th>
                        <td>
                            @if ($pedido->parecer_representante_trabalhadore)
                            <p>Existe representante dos trabalhadores</p>
                            @elseif (!$pedido->parecer_representante_trabalhadore)
                            <p>Não existe representante dos Trabalhadores</p>
                            @endif
                        </td>
                    </tr>
                </table>
                <div class="col-md-12"><br></div>
                <div class="col-md-12" id="cabecalho">
                    9. Regulamento interno
                </div>

                <div class="col-md-12"><br></div>
                <table>
                    <tr>
                        <th> Regulamento interno:</th>
                        <td>
                            @if ($pedido->regulamento_interno)
                            <p>Existe regulamento interno</p>
                            @elseif (!$pedido->regulamento_interno)
                            <p>Não existe regulamento interno</p>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
    </main>

</body>

</html>
<style>
footer {
    position: fixed;
    left: 0px;
    right: 0px;
    height: 150px;
    bottom: 0px;
    margin-bottom: -150px;
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
#thstyle {
    width: 27%
}
</style>