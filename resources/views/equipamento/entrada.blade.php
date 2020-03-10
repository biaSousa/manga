@extends('layout.main')
@section('conteudo')
<section class="container-fluid">
    <form id="form" class="form-horizontal" method="POST" action="{{url('equipamento/storeEntrada')}}" onsubmit="oController.salvar(event)">
        <h3>Entrada de Equipamento</h3>
        <div class="panel panel-default">
            <div class="panel-body col-md-offset-2">
                {{csrf_field()}}
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 mr-8">
                            <div class="input-group">
                                <!-- <input type="text" class="form-control" placeholder="Pesquisar...">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </span> -->
                            </div>
                        </div>
                        <div class="col-md-9 mr-2">
                            <!-- <label class="col-md-2 control-label">Cod.</label>
                            <div class="col-md-2">
                                <input type="text" name="codigo" id="codigo" class="form-control" required> -->
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 mr-5">
                            <label for="data_movimentacao">Data da Movimentação</label>
                            <input type="date" id="data_movimentacao" name="data_movimentacao" class="form-control" required>
                        </div>
                        <div class="col-md-2 mr-5">
                            <label for="num_movimentacao">Num. da Movimentação</label>
                            <input type="text" id="num_movimentacao" name="num_movimentacao" class="form-control" placeholder="xxxxxxxxx-2020">
                        </div>
                        <div class="col-md-4 mr-5">
                            <label for="unidade">Unidade de Origem</label>
                                <select name="unidade" id="unidade" class="form-control">
                                    <option value="">Selecione...</option>
                                    @foreach($unidade as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                    <div class="col-md-4 mr-5">
                            <label for="tecnico">Tecnico Responsável Por Receber</label>
                                <select name="tecnico" id="tecnico" class="form-control" required> 
                                    <option value="">Selecione...</option>
                                    @foreach($tecnico as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="col-md-4 mr-5">
                            <label for="setor">Setor</label>
                            <div class="input-group">
                                <select name="setor" id="setor" class="form-control">
                                    <option value="">Selecione...</option>
                                    @foreach($setor as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalSetor">
                                    <i class="glyphicon glyphicon-plus"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                    <div class="col-md-4 mr-5">
                            <label for="servidor">Servidor Responsável Por Entregar</label>
                                <select name="servidor" id="servidor" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    @foreach($servidor as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="col-md-3 mr-5">
                            <label for="telefone">Telefone</label>
                            <input type="phone" id="telefone" name="telefone" class="form-control" placeholder="(xx) xxxxx-xxxx">
                        </div>
                    </div>
                </div>
                ADICIONAR GRID<br>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 mr-8">
                            <textarea id="descricao" name="descricao" rows="8" cols="90" placeholder="Descreva a observação..."></textarea>
                        </div>
                    </div>
                </div>
                <!-- BOTÃO ADICIONAR -->
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-7 mr-5">
                            <div class="col-mr-1">
                                <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Salvar</button>
                            </div>
                        </div>
                        <div class="col-md-1 mr-5">
                            <div class="col-mr-1">
                                <button type="reset" class="btn btn-primary">Limpar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Setor-->
        <div class="modal fade" id="modalSetor" tabindex="-1" role="dialog" aria-labelledby="setorTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="setorTitle">Novo - Setor</h4>
                    </div>
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mr-5">
                        <!-- <label for="novo_unidade">Unidade de Origem</label>
                            <select name="novo_unidade" id="novo_unidade" class="form-control">
                                <option value="">Selecione...</option>
                                @foreach($unidade as $p)
                                <option value="{{$p->id}}">{{$p->nome}}</option>
                                @endforeach
                            </select> -->
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 mr-5">
                        <!-- <label for="novo_setor">Setor</label>
                        <input type="text" class="form-control" id="novo_setor" name="novo_setor" required> -->
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
                </div>
            </div>
        </div>

    </form>
</section>

@endsection

@section('scripts')
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/jquery.form.js')}}"></script>
<script src="{{asset('js/app/helpers/Utils.js')}}"></script>
<script src="{{asset('js/app/models/Ajax.js')}}"></script>
<script src="{{asset('js/app/views/MensagemView.js')}}"></script>
<script src="{{asset('js/app/models/ValidaForm.js')}}"></script>
<script src="{{asset('js/app/helpers/GenericModalForm.js')}}"></script>
<script src="{{asset('js/app/controllers/EquipamentoController.js')}}"></script>
<script>
    var oController = new EquipamentoController();
</script>
@endsection