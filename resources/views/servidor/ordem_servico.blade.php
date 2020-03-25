@extends('layout.main')
@section('conteudo')
<section class="container-fluid">
    <form id="form" class="form-horizontal" method="post" action="{{url('servidor/store_os')}}" onsubmit="oController.salvar(e)">
        <h3>Abertura de Ordem de Serviço</h3>
        <div class="panel panel-default">
            <div class="panel-body col-md-offset-2">
                {{csrf_field()}}
              
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 mr-5">
                            <label for="numero_ordem">Num. OS</label>
                            <input type="text" id="numero_ordem" name="numero_ordem" placeholder="xxxxxx" class="form-control" required>
                        </div>
                        <div class="col-md-2 mr-5">
                            <label for="data_chamado">Data do Chamado</label>
                            <input type="date" id="data_chamado" name="data_chamado" class="form-control" required>
                        </div>
                        <div class="col-md-4 mr-5">
                            <label for="tecnico">Aberto por </label>
                                <select name="tecnico" id="tecnico" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    @foreach($tecnico as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2 mr-5">
                            <label for="patrimonio">Patrimônio</label>
                            <input type="text" id="patrimonio" name="patrimonio" placeholder="xxxxxx" class="form-control" required>
                        </div>
                        <div class="col-md-2 mr-5">
                            <label for="patrimonio">Num. de Série</label>
                            <input type="text" id="patrimonio" name="patrimonio" placeholder="xxxxxx" class="form-control" required>
                        </div>
                        <div class="col-md-4 mr-5">
                            <label for="unidade">Local do Atendimento</label>
                                <select name="unidade" id="unidade" class="form-control" required> 
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
                        <div class="col-md-2 mr-5">
                            <label for="tipo">Tipo de Equipamento</label>
                                <select name="tipo" id="tipo" class="form-control" required>
                                <option value="">Selecione...</option>
                                    @foreach($tipo as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach                                           
                                </select>
                        </div>
                        <div class="col-md-2 mr-5">
                            <label for="situacao">Situação</label>
                                <select name="situacao" id="situacao" class="form-control" required>
                                <option value="">Selecione...</option>
                                    @foreach($situacao as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach                                            
                                </select>
                        </div>
                        <div class="col-md-4 mr-5">
                            <label for="setor">Setor</label>
                                <select name="setor" id="setor" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    @foreach($setor as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4 mr-5">
                            <label for="servidor">Servidor</label>
                                <select name="servidor" id="servidor" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    @foreach($servidor as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach                                   
                                </select>
                        </div>
                        <div class="col-md-4 mr-5">
                        <label for="problema">Problema</label>
                                <select name="problema" id="problema" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    @foreach($problema as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach                                   
                                </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4 mr-5">
                            <label for="email">E-mail</label>
                            <input type="text" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-2 mr-5">
                            <label for="telefone">Telefone</label>
                            <input type="text" id="telefone" name="telefone" placeholder="(xx) xxxxx-xxxx" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 mr-8">
                            <textarea id="descricao" name="descricao" rows="4" cols="50" placeholder="Descreva a observação..."></textarea>
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
<script src="{{asset('js/app/controllers/EntradaController.js')}}"></script>
<script>
    var oController = new EntradaController();
</script>
@endsection