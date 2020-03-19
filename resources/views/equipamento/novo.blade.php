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
                    <div class="col-md-3 mr-5">
                        <label for="tipo">Tipo de Equipamento</label>
                        <div class="input-group">
                            <select name="tipo" id="tipo" class="form-control custom-select" required>
                                <option value="">Selecione...</option>
                                @foreach($tipo as $p)
                                <option value="{{$p->id}}">{{$p->nome}}</option>
                                @endforeach
                            </select>
                            <span class="input-group-btn">
                                <a class="btn btn-default" data-toggle="modal" data-target="#modalTipoEquipamento">
                                <i class="glyphicon glyphicon-plus"></i></a>
                            </span>
                        </div> 
                    </div> 
                        <div class="col-md-3 mr-5">
                            <label for="patrimonio">Patrimônio</label>
                            <input type="text" id="patrimonio" name="patrimonio" class="form-control" placeholder="xxxxxx-xxxxxx">
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
                            <div class="input-group">
                                <select name="marca" id="marca" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    @foreach($marca as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-btn">
                                    <a class="btn btn-default" data-toggle="modal" data-target="#modalMarca">
                                    <i class="glyphicon glyphicon-plus"></i></a>
                                </span>
                            </div> 
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
                            <div class="input-group">
                                <select name="modelo" id="modelo" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    @foreach($modelo as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-btn">
                                    <a class="btn btn-default" data-toggle="modal" data-target="#modalModelo">
                                    <i class="glyphicon glyphicon-plus"></i></a>
                                </span>
                            </div>
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
                <!-- Botão Salvar -->
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-7 mr-5">
                            <div class="col-mr-1">
                                <button type="submit" class="btn btn-primary" id="adicionar" onclick="oController.adicionarEquipamento()">
                                <i class="glyphicon glyphicon-plus"></i> Adicionar</button>
                            </div>
                        </div>
                        <div class="col-md-1 mr-5">
                            <div class="col-mr-1">
                                <button type="reset" class="btn btn-primary">Limpar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Tipo de equipamento-->
                <div class="modal fade" id="modalTipoEquipamento" tabindex="-1" role="dialog" aria-labelledby="TipoTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <a class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </a>
                                <h4 class="modal-title" id="TipoTitle">Novo - Tipo de Equipamento</h4>
                            </div>
                        <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mr-5">
                                <!-- <label for="novo_tipo">Tipo</label>
                                <input type="text" class="form-control" id="novo_tipo" name="novo_tipo" required> -->
                            </div>
                        </div>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-primary">Salvar</button>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Marca-->
                <div class="modal fade" id="modalMarca" tabindex="-1" role="dialog" aria-labelledby="MarcaTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </a>
                                <h4 class="modal-title" id="MarcaTitle">Novo - Marca</h4>
                            </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mr-5">
                                    <!-- <label for="novo_marca">Marca</label>
                                    <input type="text" class="form-control" id="novo_marca" name="novo_marca" required> -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Salvar</button>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Modelo-->
                <div class="modal fade" id="modalModelo" tabindex="-1" role="dialog" aria-labelledby="ModeloTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </a>
                                <h4 class="modal-title" id="ModeloTitle">Novo - Modelo</h4>
                            </div>
                        <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mr-5">
                                <!-- <label for="novo_modelo">Modelo</label>
                                <input type="text" class="form-control" id="novo_modelo" name="novo_modelo" required> -->
                            </div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Salvar</button>
                        </div>
                        </div>
                    </div>
                </div>

            </div>
        </div> 

        <!-- Grid + botoes -->
        <!-- <div class="row">
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
        </div> -->
        <div class="col-md-12 mr-5">
            <div class="form-group">
                <div id="equipamento">
                    <table id="grid" class="table table-bordered table-hover">
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
                </div>
            </div>
        </div>
        <br>
</form>
</section>

@endsection

@section('scripts')
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/jquery.form.js')}}"></script>
<script src="{{asset('js/app/models/Ajax.js')}}"></script>
<script src="{{asset('js/app/helpers/Utils.js')}}"></script>
<script src="{{asset('js/app/models/ValidaForm.js')}}"></script>
<script src="{{asset('js/app/views/MensagemView.js')}}"></script>
<script src="{{asset('js/app/helpers/GenericModalForm.js')}}"></script>
<script src="{{asset('js/app/controllers/EquipamentoController.js')}}"></script>
@include('layout.datatables', ['carregamento_inicial' => true, 'colunas' => ['id', 'tipo', 'modelo', 'marca', 'num_serie', 'patrimonio']])
<script>
    var oController = new EquipamentoController();
</script>
@endsection