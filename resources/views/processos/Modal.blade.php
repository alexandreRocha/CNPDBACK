<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

    <div class="modal fade" id="processar-formulario-modal" tabindex="-1" role="dialog"
        aria-labelledby="processar-formulario-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="processar-formulario-modal-title">Gerar Processo -
                        {{$pedido->nome_denominacao}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <form class="was-validated" method="post" id="processar-formulario-form"
                            action="{{ route('createProcesso', ['id' => $pedido->id]) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row row-cols-1">
                                <div class="col">
                                    <input type="text" id="entidade" name="entidade" disabled class="form-control"
                                        value="{{ $pedido->nome_denominacao }}">
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback">Campo obrigatório.</div>
                                </div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="row row-cols-1">
                                <div class="col">
                                    <select name="preco_pago" id="preco_pago" class="form-control"
                                        aria-label="Default select example" required="">
                                        <option value="">- Escolha o valor a pagar -</option>
                                        <option value="5000">5000 $00</option>
                                        <option value="7000">7000 $00</option>
                                        <option value="7000">3000 $00</option>
                                    </select>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback">Campo obrigatório.</div>
                                </div>
                            </div>

                            <div class="col-md-12"><br></div>
                            <div class="row row-cols-1">
                                <div class="col">
                                    <select name="tipo_processo" id="tipo_processo" class="form-control"
                                        aria-label="Default select example" required="">
                                        <option value="">- Escolha o tipo de Processo -</option>
                                        <option value="Autorizacao">Autorização</option>
                                        <option value="Registo">Registo</option>
                                    </select>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback">Campo obrigatório.</div>
                                </div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="row row-cols-1">
                                <div class="col">
                                    <select name="tipo_entidade" id="tipo_entidade" class="form-control"
                                        aria-label="Default select example" required="">
                                        <option value="">- Escolha o tipo de entidade -</option>
                                        <option value="Particular">Particular</option>
                                        <option value="Estabelecimento Comercial">Estabelecimento Comercial</option>
                                        <option value="Instituicao">Instituição</option>
                                    </select>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback">Campo obrigatório.</div>
                                </div>
                            </div>
                            <hr>
                            <input type="text" name="entidade" hidden class="form-control"
                                value="{{ $pedido->nome_denominacao }}">
                            <input type="text" name="idForm" hidden class="form-control" value="{{ $pedido->id }}">
                            <input type="text" name="descricao_processo" hidden class="form-control"
                                value="{{$pedido->tipo}}">
                            <div id="modal-footer">
                                <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-save"></i>
                                    Gerar Processo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>