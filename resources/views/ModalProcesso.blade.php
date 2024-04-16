@section('content')
<div id="exampleModalCenter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Gerar Processo</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="was-validated" method="post"
                    action="{{ route('processos.create', ['id' => $pedido->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row row-cols-1">
                        <div class="col">
                            <input disabled class="form-control" value="{{ $pedido->nome_denominacao }}">
                            <input type="text" id="entidade" name="entidade" hidden class="form-control"
                                value="{{ $pedido->nome_denominacao }}">
                            <input type="text" id="descricao_processo" name="descricao_processo" hidden
                                class="form-control"
                                value="Processo Autorização de Videovigilância - {{ $pedido->nome_denominacao }}">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Campo obrigatório.</div>
                        </div>
                    </div>
                    <div class="col-md-12"><br></div>
                    <div class="row row-cols-1">
                        <div class="col">
                            <div class="input-group flex-nowrap">
                                <input class="form-control" type="number" id="preco_pago" required
                                    placeholder="Valor do processo emn CVE" name="preco_pago">
                                <span class="input-group-text" id="addon-wrapping">CVE</span>
                            </div>
                            <div class="va id-feedback"></div>
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
                    <hr>
                    <div id="modal-footer">
                        <button type="submit" class="btn btn-primary"> <i class="fas fa-fw fa-save"></i>
                            Gerar Processo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection