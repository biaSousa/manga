@extends('layout.main')
@section('conteudo')
<section class="container-fluid">
    <form id="form" class="form-horizontal" method="POST" action="{{url('equipamento/store')}}" onsubmit="oController.salvar(event)">
        <h3>Novo Equipamento</h3>
        <div class="panel panel-default">
            <div class="panel-body col-md-offset-2">
                {{csrf_field()}}
                <div class="row">
                    <div class="form-group">
                <!-- barra de pesquisa -->
                        <div class="col-md-3 mr-8">
                            <!-- <div class="input-group">
                                <input type="text" class="form-control" placeholder="Pesquisar...">
                                <span class="input-group-btn">
                                        <button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </span>
                            </div> -->
                        </div>
                <!-- codigo do equipamento -->
                        <div class="col-md-9 mr-2">
                            <!-- <label class="col-md-2 control-label">Cod.</label>
                            <div class="col-md-2">
                                <input type="text" name="codigo" id="codigo" class="form-control" required>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 mr-5">
                            <label for="nome">Tipo de Equipamento</label>
                                <select name="tipo" id="tipo" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    @foreach($tipo as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="col-md-2 mr-5">
                            <label for="data_compra">Data da Compra</label>
                            <input type="date" class="form-control" id="data_compra" name="data_compra" required>
                        </div> 
                        <div class="col-md-3 mr-5">
                            <label for="patrimonio">Patrimônio</label>
                            <input type="text" id="patrimonio" name="patrimonio" class="form-control" list="patrimonios"  placeholder="xxxxxx-xxxxxx">
                            <datalist id= "patrimonios">
                            </datalist>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 mr-5">
                            <label for="email">Marca</label>
                                <select name="marca" id="marca" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    @foreach($marca as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach
                                </select>
                        </div> 
                        <div class="col-md-3 mr-5">
                            <label for="garantia">Garantia</label>
                                <select name="garantia" id="garantia" class="form-control">
                                    <option value="">Selecione...</option>
                                    @foreach($garantia as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="col-md-3 mr-5">
                            <label for="num_serie">Num. de Série</label>
                            <input type="text" id="num_serie" name="num_serie" class="form-control" placeholder="xxxxxx-xxxxxx" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 mr-5">
                            <label for="modelo">Modelo</label>
                                <select name="modelo" id="modelo" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    @foreach($modelo as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach
                                </select>
                        </div>
                          <div class="col-md-3 mr-5">
                            <label for="unidade">Unidade</label>
                                <select name="unidade" id="unidade" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    @foreach($unidade as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="col-md-3 mr-5">
                            <label for="nota_fiscal">Nota Fiscal</label>
                            <input type="text" id="nota_fiscal" name="nota_fiscal" class="form-control"placeholder="xxxxxx-xxxxxx">
                        </div>                       
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 mr-8">
                            <textarea id="descricao" name="descricao" rows="8" cols="90" placeholder=" Descreva a observação..."></textarea>
                        </div>
                    </div>
                </div>
                    <!-- BOTÃO ADICIONAR -->
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-20 mr-5">
                            <label class="col-md-2">&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Salvar</button>
                                <button type="reset" class="btn btn-primary">Limpar</button>
                            </div>
                        </div>
                        <!-- <div class="col-md-1 mr-5">
                            <label class="col-md-2">&nbsp;</label>
                            <div class="col-mr-1">
                                <button type="reset" onclick="oController.salvar()" class="btn btn-primary">Limpar</button>
                            </div>
                        </div> -->
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