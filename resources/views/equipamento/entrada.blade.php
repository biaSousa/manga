@extends('layout.main')
@section('conteudo')
<section class="container-fluid">
    <form id="form" class="form-horizontal" method="POST" action="{{url('entrada/store')}}" onsubmit="oController.salvar(event)">
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
                        <div class="col-md-3 mr-5">
                        <label for="nome">Tipo de Equipamento</label>
                            <select name="tipo" id="tipo" class="form-control">
                                <option value="">Selecione...</option>
                               
                            </select>
                        </div>
                        <div class="col-md-3 mr-5">
                            <label for="modelo">Modelo</label>
                                <select name="modelo" id="modelo" class="form-control">
                                    <option value="">SELECTION...</option>
                                </select>
                        </div>
                        <div class="col-md-3 mr-5">
                        <label for="email">Marca</label>
                            <select name="marca" id="marca" class="form-control">
                                <option value="">Selecione...</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 mr-5">
                            <label for="patrimonio">Patrimônio</label>
                            <input type="patrimonio" id="patrimonio" name="patrimonio" class="form-control">
                        </div>
                        <div class="col-md-3 mr-5">
                            <label for="numero">Numero de Série</label>
                            <input type="numero" id="numero" name="numero" class="form-control">
                        </div>
                        <div class="col-md-3 mr-5">
                            <label for="nota">Nota Fiscal</label>
                            <input type="nota" id="nota" name="nota" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 mr-5">
                            <label for="data_compra">Data da Compra</label>
                            <input type="date" class="form-control" id="data_compra" name="data_compra">
                        </div>
                        <div class="col-md-3 mr-5">
                            <label for="garantia">Garantia</label>
                                <select name="garantia" id="garantia" class="form-control">
                                    <option value="">SELECTION...</option>
                                </select>
                        </div>
                        <div class="col-md-3 mr-5">
                            <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">SELECTION...</option>
                                </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 mr-8">
                            <textarea id="descricao" rows="8" cols="111" placeholder="Descreva a observação..."></textarea>
                        </div>
                    </div>
                </div>
                    <!-- BOTÃO ADICIONAR -->
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-1 mr-5">
                            <label class="col-md-2">&nbsp;</label>
                            <div class="col-mr-1">
                                <button type="submit" onclick="oController.salvar()" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Salvar</button>
                            </div>
                        </div>
                        <div class="col-md-1 mr-5">
                            <label class="col-md-2">&nbsp;</label>
                            <div class="col-mr-1">
                                <button type="reset" onclick="oController.salvar()" class="btn btn-primary">Limpar</button>
                            </div>
                        </div>
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