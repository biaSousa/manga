@extends('layout.main')
@section('conteudo')
<section class="container-fluid">
    <form id="form" class="form-horizontal" method="POST" action="{{url('equipamento/store')}}" onsubmit="oController.salvar(e)">
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
                        <div class="col-md-3 mr-5">
                            <label for="patrimonio">Patrimônio</label>
                            <input type="text" id="patrimonio" name="patrimonio" class="form-control" placeholder="xxxxxx-xxxxxx" onkeypress="oController.eventoEnter()">
                         
                        </div> 
                        <div class="col-md-2 mr-5">
                            <label for="data_compra">Data da Compra</label>
                            <input type="date" class="form-control" id="data_compra" name="data_compra" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 mr-5">
                            <label for="marca">Marca</label>
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
                                <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>
                                <button type="reset" class="btn btn-primary">Limpar</button>
                            </div>
                        </div>
                     </div>
                </div>
                <!-- Button trigger modal -->
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                Launch demo modal
                </button> -->

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                    </div>
                </div>
                </div>

            </div>
        </div> 
        <div class="row">
            <div class="form-group">
             <div class="col-md-5 content-end mr-5">
                <div class="btn-group btn-group-sm" role="group">
                    <button id="novo" type="button" class="btn btn-secondary" onclick="oController.criar(this)" data-url="{{ url('') }}" title="Criar novo" data-toggle="tooltip" data-placement="top">
                        <i class="material-icons icone">add</i>
                    </button>
                    <button id="editar" type="button" class="btn btn-secondary" onclick="oController.editar(this)" data-url="{{ url('') }}" title="Edita" data-toggle="tooltip" data-placement="top">
                        <i class="material-icons icone">edit</i>
                    </button>
                </div>
            </div>
            </div>
        </div>
        <table id="grid" class="table table-striped table-bordered mb-3">
        <thead>
            <tr>
                <th width="3%">ID</th>
                <th width="8%">Tipo</th>
                <th width="8%">Modelo</th>
                <th width="8%">Marca</th>
                <th width="5%">Num. Série</th>
                <th width="5%">Patrimonio</th>
            </tr> 
            </thead> 
            <tbody>
            </tbody>
        </table>
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
@include('layout.datatables', ['carregamento_inicial' => true, 'colunas' => ['id', 'tipo', 'modelo', 'marca', 'num_serie', 'patrimonio']])
<script>
    var oController = new EquipamentoController();
</script>
@endsection