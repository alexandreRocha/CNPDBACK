@extends('layouts.master')
@section('title', 'Ver Tratamento Geral')
@include('processos.Modal')
@section('content')

@if($pedido)
<!-- Breadcrumbs -->
{{ Breadcrumbs::render('Ver Geral', $pedido) }}
@if(session('message'))
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Success!</h4>
    <p>{{ session('message')}}</p>
</div>
@endif
<div class="row" id="geral">
    <div class="col-md-12" id="cabecalho">
        Notificação de Tratamento de Dados <b> - Geral</b>
    </div>
    <div class="col-md-12" id="right"><b>Criado em:</b> {{ $pedido->created_at }} 
        <div class="col-md-12"><br></div> 
        @can('servico-administrativo')
            @if($pedido->estado == 'Novo')
                <button type="button" class="btn btn-primary" data-formulario-id="{{ $pedido->id }}" data-toggle="modal" data-target="#processar-formulario-modal">
                <i class="fas fa-fw fa-book"></i> Gerar Processo
                </button>
            @endif
        @endcan 
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
    <div class="col-md-12" id="cabecalho">
        1. Responsável pelo Tratamento
    </div>
    <div class="col-md-12"><br></div>
    <div class="col-md-12" id="nameCenter"><b>Pessoa:</b> {{ $pedido->tipo_pessoa }}</div>
    <div class="col-md-3" id="name">Nome Denominação: </div>
    <div class="col-md-9" id="descricao">{{ $pedido->nome_denominacao }}</div>
    <div class="col-md-3" id="name">Nome Comercial: </div>
    <div class="col-md-9" id="descricao">{{ $pedido->nome_comercial }}</div>
    <div class="col-md-3" id="name">Actividade Desenvolvida: </div>
    <div class="col-md-9" id="descricao">{{ $pedido->atividade_desenvolvida }}</div>
    <div class="col-md-3" id="name">Nif: </div>
    <div class="col-md-9" id="descricao">{{ $pedido->numero_nif }}</div>
    <div class="col-md-3" id="name"> Rua: </div>
    <div class="col-md-9" id="descricao">{{ $pedido->rua_responsavel_tratamento }}</div>
    <div class="col-md-3" id="name">Caixa Postal:</div>
    <div class="col-md-9" id="descricao">{{ $pedido->caixapostal_responsavel_tratamento }}</div>
    <div class="col-md-3" id="name"> Cidade/Vila/Zona/Lugar: </div>
    <div class="col-md-9" id="descricao">{{ $pedido->local_responsavel_tratamento }}</div>
    <div class="col-md-3" id="name"> Ilha: </div>
    <div class="col-md-3" id="descricao">{{ $pedido->ilha_responsavel_tratamento }}</div>
    <div class="col-md-3" id="name" style="text-align: right"> Concelho:</div>
    <div class="col-md-3" id="descricao">{{ $pedido->concelho_responsavel_tratamento }}<br></div>
    <div class="col-md-3" id="name"> Email: </div>
    <div class="col-md-3" id="descricao">{{ $pedido->email_responsavel_tratamento }}</div>
    <div class="col-md-3" id="name" style="text-align: right"> Telefone:</div>
    <div class="col-md-3" id="descricao">{{ $pedido->telefone_responsavel_tratamento }}<br></div>
    <div class="col-md-12">
        <b>País</b> <input type="checkbox" checked disabled> {{ $pedido->pais_responsavel_tratamento }}
    </div>
    <div class="col-md-12"><br></div>
    <div class="col-md-12" id="cabecalho">
        Processamento da informação
    </div>
    <div class="col-md-12"><br></div>

    <div class="col-md-3" id="name"> Processamento da informação:</div>
    <div class="col-md-9" id="descricao">{{ $pedido->nome_representante_tratamento}}<br></div>
    <div class="col-md-3" id="name"> Rua:</div>
    <div class="col-md-9" id="descricao">{{ $pedido->rua_representante_tratamento }}<br></div>
    <div class="col-md-3" id="name"> Caixa Postal:</div>
    <div class="col-md-9" id="descricao">{{ $pedido->caixapostal_representante_tratamento}}<br></div>
    <div class="col-md-3" id="name"> Cidade/Vila/Zona/Lugar:</div>
    <div class="col-md-9" id="descricao">{{ $pedido->local_representante_tratamento }}<br></div>
    <div class="col-md-3" id="name"> Ilha: </div>
    <div class="col-md-3" id="descricao">{{ $pedido->ilha_representante_tratamento }}</div>
    <div class="col-md-3" id="name" style="text-align: right"> Concelho:</div>
    <div class="col-md-3" id="descricao">{{ $pedido->concelho_representante_tratamento }}<br></div>
    <div class="col-md-12"><br></div>
    <div class="col-md-12" id="cabecalho">
        2. Finalidade do tratamento
    </div>
    <div class="col-md-12"><br></div>
    <div class="col-md-6" id="name"> <br>Categorias:</div>
    <div class="col-md-6" id="name"> <br>Finalidades de Tratamento:</div>
    <p><br><br></p>

    @if ($finalidades)
    @foreach ($finalidades as $cat)
    <div class="col-md-3" id="descricao">
        <li>{{ $cat['categorias_finalidade'] }}</li><br>
    </div>
    <div class="col-md-9" id="descricao">
        @foreach ($cat['finalidades'] as $fin)
        {{ $fin['value'] }} <b>|</b>
        @endforeach
    </div>
    @endforeach
    @endif
    <div class="col-md-12"><br></div>
    <div class="col-md-3" id="name"> Outras Finalidades:</div>
    <div class="col-md-9" id="descricao">{{ $pedido->outraFinalidadeTratamento }}<br></div>
    <div class="col-md-12"><br></div>
    <div class="col-md-12" id="cabecalho">
        3. Dados pessoais contidos em cada registro
    </div>
    <div class="col-md-12"><br></div>
    <div class="col-md-3" id="name"> Dados Pessoais Tratados:</div>
    <div class="col-md-9" id="descricao">
        @if ($pedido->dados_pessoais_contidos)
        @foreach ($pedido->dados_pessoais_contidos as $dadosPessoais)
        {{ $dadosPessoais['value'] }} <b>|</b>
        @endforeach
        @endif
    </div>
    <div class="col-md-12"><br></div>
    <div class="col-md-3" id="name"> Que outros dados referentes aos artigos 8º e 11º</div>
    <div class="col-md-9" id="descricao">
        {{ $pedido->outros_dados_tratados_8_11 }}
    </div>
    <div class="col-md-12"><br></div>
    <div class="col-md-3" id="name"> Lista de dados pessoais tratados</div>
    <div class="col-md-9" id="descricao">
        {{ $pedido->lista_dados_pessoais_tratados }}
    </div>
    <div class="col-md-12"><br></div>


    <div class="col-md-12"><br></div>
    <div class="col-md-12" id="cabecalho">
        4. Recolha de Dados
    </div>
    <div class="col-md-12"><br></div>
    <div class="col-md-3" id="name"> Recolha direta:</div>

    <div class="col-md-9" id="descricao">
        @if ($pedido->recolha_direta)
        @foreach ($pedido->recolha_direta as $recdir)
        {{ $recdir['value'] }} <b>|</b>
        @endforeach
        @endif
    </div>
    <div class="col-md-3" id="name"> URL:</div>
    <div class="col-md-9" id="descricao">{{ $pedido->url_recolha }}<br></div>
    <div class="col-md-3" id="name"> Descreve a outra forma de recolha direta:</div>
    <div class="col-md-9" id="descricao">{{ $pedido->descricao_outra_forma_recolhadireta }}<br></div>
    <div class="col-md-12"><br></div>
    <div class="col-md-12"><br></div>
    <div class="col-md-3" id="name"> Recolha Indireta: </div>
    <div class="col-md-3" id="descricao">{{ $pedido->recolha_indireta }}</div>

    <div class="col-md-12" id="cabecalho">
        5. Comunicação dos Dados a terceiros
    </div>
    <div class="col-md-12"><br></div>
    <div class="col-md-3" id="name"> <br>Entidades Comunicadas:</div>
    <div class="col-md-9" id="name"> <br>Dados Transferidos:</div>
    <p><br><br></p>

    @if ($comunicacao)
    @foreach ($comunicacao as $comunic)
    <div class="col-md-3" id="descricao">
        {{ $comunic['entidades_comunicadas'] }}<br><br>
    </div>
    <div class="col-md-9" id="descricao">
        {{ $comunic['condicoes_comunicacao'] }}
    </div>
    @endforeach
    @endif
    <div class="col-md-12"><br></div>
    <div class="col-md-12" id="cabecalho">
        6. Interconexões
    </div>
    <div class="col-md-12"><br></div>
    <div class="col-md-3" id="name"> Qual a finalidade e quais os dados de obejto de interconexão?</div>
    <div class="col-md-9" id="descricao">{{ $pedido->descricao_finalidade_interconexao }}<br></div>
    <div class="col-md-12"><br></div>
    <div class="col-md-12" id="cabecalho">
        7. Fluxos internacionais de dados para outros países
    </div>
    <div class="col-md-12"><br></div>
    <div class="col-md-3" id="name"> <br>Entidades:</div>
    <div class="col-md-3" id="name"> <br>País:</div>
    <div class="col-md-6" id="name"> <br>Dados Transferidos:</div>
    <p><br><br></p>

    @if ($transferencia)
    @foreach ($transferencia as $transf)
    <div class="col-md-3" id="descricao">
        {{ $transf['entidades'] }}<br><br>
    </div>
    <div class="col-md-3" id="descricao">
        {{ $transf['pais'] }}
    </div>
    <div class="col-md-6" id="descricao">
        {{ $transf['dados_transferidos'] }}
    </div>
    @endforeach
    @endif

    <div class="col-md-12"><br></div>
    <div class="col-md-12" id="cabecalho">
        8. Prazo máximo de conservação dos Dados pessoais
    </div>
    <div class="col-md-12"><br></div>
    <div class="col-md-3" id="name"> Qual o prazo máximo de conservação dos dados?</div>
    <div class="col-md-9" id="descricao">{{ $pedido->prazo_maximo_conservacao }}<br></div>
    <div class="col-md-12"><br></div>
    <div class="col-md-12" id="cabecalho">
        9. Exercicio do direito de acesso
    </div>
    <div class="col-md-12"><br></div>
    <div class="col-md-3" id="name"> Rua:</div>
    <div class="col-md-9" id="descricao">{{ $pedido->rua_direito_acesso }}<br></div>
    <div class="col-md-3" id="name"> Caixa Postal:</div>
    <div class="col-md-9" id="descricao">{{ $pedido->caixapostal_direito_acesso }}<br></div>
    <div class="col-md-3" id="name"> Local para exercer direito de acesso:</div>
    <div class="col-md-9" id="descricao">{{ $pedido->local_direito_acesso }}<br></div>
    <div class="col-md-3" id="name"> Ilha: </div>
    <div class="col-md-3" id="descricao">{{ $pedido->ilha_direito_acesso }}</div>
    <div class="col-md-3" id="name" style="text-align: right"> Concelho:</div>
    <div class="col-md-3" id="descricao">{{ $pedido->concelho_direito_acesso }}<br></div>
    <div class="col-md-3" id="name"> Email: </div>
    <div class="col-md-3" id="descricao">{{ $pedido->email_direito_acesso }}</div>
    <div class="col-md-3" id="name" style="text-align: right"> Telefone:</div>
    <div class="col-md-3" id="descricao">{{ $pedido->contato_direito_acesso }}<br></div>
    <div class="col-md-12"><br></div>
    <div class="col-md-12" id="cabecalho">
        De que forma e exercido o direito de acesso?
    </div>
    <div class="col-md-12"><br></div>
    <div class="col-md-3" id="name"> Forma de direito de acesso:</div>
    <div class="col-md-9" id="descricao">
        @if ($pedido->forma_direito_acesso)
        @foreach ($pedido->forma_direito_acesso as $forma)
        {{ $forma }},
        @endforeach
        @endif
    </div>
    <div class="col-md-3" id="name"> Outra forma de direito de acesso:</div>
    <div class="col-md-9" id="descricao">{{ $pedido->outraforma_direito_acesso }}<br></div>



    <div class="col-md-12"><br></div>
    <div class="col-md-12" id="cabecalho">
        10. Medidas de segurança a implementar.
    </div>
    <div class="col-md-12"><br></div>
    <div class="col-md-3" id="name"> Medidas Físicas:</div>
    <div class="col-md-9" id="descricao">{{ $pedido->medidade_seguranca_fisica }}<br></div>
    <div class="col-md-12"><br></div>
    <div class="col-md-3" id="name"> Medidas Lógicas:</div>
    <div class="col-md-9" id="descricao">{{ $pedido->medidas_seguranca_logica }}<br></div>
    <div class="col-md-12"><br></div>
    <div class="col-md-12" id="cabecalho">
        11. Representante dos Trabalhadores
    </div>
    <div class="col-md-12"><br></div>
    @if ($pedido->parecer_representante_trabalhadore)
    <a class="col-md-12" href="" data-toggle="modal" data-target="#reptrab"> Ver Anexo Representante Trabalhadores</a>
    @elseif (!$pedido->parecer_representante_trabalhadore)
    <p>Não existe representante dos Trabalhadores.</p>
    @endif

    <div id="reptrab" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Ver Anexo Representante Trabalhadores</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row row-cols-1">
                        <embed
                            src="{{ url("storage/parecerTrabalhadores/{$pedido->parecer_representante_trabalhadore}")}}"
                            width="100%" height="800px" />
                    </div>
                </div>
            </div>
        </div>
    </div>



    @else
    <!-- Breadcrumbs -->
    {{ Breadcrumbs::render('Formulários Biometria') }}
    <div class="col-md-12" id="notFound">
        <br>
        <p>ID não encontrado.</p>
    </div>

    @endif



    <style>
    table,
    th,
    td {
        border: 1px solid black;
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
        border-radius: 10px;
        background: #061536;
    }

    #name {
        font-weight: bold;
        color: #061536;
    }

    #nameCenter {
        text-align: center;
    }

    #right {
        text-align: right;
    }

    #descricao {
        color: #061536;
        border-style: ridge;
    }

    #reptrab {
        height: auto;
        z-index: 10000000;
    }
    </style>

<script>
setTimeout(function() {
    $(".alert").slideUp(500, function() {
        $(this).remove();
    });
    //  window.location.reload();
}, 5000);

$(document).ready(function() {
            $('#myModal').modal('show');
        });
</script>
    @endsection