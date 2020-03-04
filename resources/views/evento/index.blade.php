@extends('layout.main')
@section('conteudo')
<link href="{{asset('css/AutocompleteJS.css')}}" rel="stylesheet">
<section class="container-fluid">
    <form id="form" class="form-horizontal" method="POST" action="{{url('bianca/store')}}">
        <h3>Cadastro de evento</h3>
        <div class="panel panel-default">

            <div class="panel-body col-md-offset-2">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Nome do evento</label>
                            <div class="col-md-6">
                                <input type="text" name="" id="nome" class="form-control" placeholder="Digite o nome do evento..." required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Categoria Evento</label>
                            <div class="col-md-6">
                                <select name="CEvento" id="CEvento" class="form-control">
                                    <option value="">SELECTION...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Instituição</label>
                            <div class="col-md-6">
                                <select name="instituicao" id="instituicao" class="form-control">
                                <option value="">Selecione</option>
                                    @foreach($tipoEquipamento as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Realizadores</label>
                            <div class="col-md-6">
                                <select name="realizadores" id="realizadores" class="form-control">
                                    <option value="">SELECTION...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Data inicio</label>
                            <div class="col-lg-4 col-md-4">
                                <input type="date" name="dt_inicio" id="dt_inicio" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Data termino</label>
                            <div class="col-lg-4 col-md-4">
                                <input type="date" name="dt_termino" id="dt_termino" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- BOTÃO ADICIONAR -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-2">&nbsp;</label>
                            <div class="col-md-8">
                                <button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-plus" onclick="oController.salvar()"></i> Adicionar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form><br>
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
<script src="{{asset('js/app/controllers/BiancaController.js')}}"></script>

<script>
    var oController = new BiancaController();
</script>
@endsection