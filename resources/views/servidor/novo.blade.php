@extends('layout.main')
@section('conteudo')
<section class="container-fluid">
    <form id="form" class="form-horizontal" method="Post" action="{{url('servidor/store')}}" onsubmit="oController.salvar(e)">
        <h3>Cadastro de Servidor</h3>
        <div class="panel panel-default">
            <div class="panel-body col-md-offset-2">
                {{csrf_field()}}
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 mr-5">
                            <label for="matricula">Matrícula</label>
                            <input type="text" id="matricula" name="matricula" class="form-control" placeholder="xxxxxxxx">
                        </div>
                        <div class="col-md-3 mr-5">
                            <label for="cpf">CPF</label>
                            <input type="text" id="cpf" name="cpf" class="form-control" placeholder="xxxxxxxx">
                        </div>
                        <div class="col-md-2 mr-5">
                            <label for="data_nasc">Data de Nascimento</label>
                            <input type="date" class="form-control" id="data_nasc" name="data_nasc" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 mr-5">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" class="form-control" placeholder="Insira seu nome...">
                        </div>
                        <div class="col-md-3 mr-5">
                            <label for="email">E-mail</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Insira seu email...">
                        </div>
                        <div class="col-md-2 mr-5">
                            <label for="data_entra">Data de Entrada</label>
                            <input type="date" class="form-control" id="data_entra" name="data_entra" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
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
                            <label for="setor">Setor</label>
                                <select name="setor" id="setor" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    @foreach($setor as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="col-md-2 mr-5">
                            <label for="cargo">Cargo</label>
                                <select name="cargo" id="cargo" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    @foreach($cargo as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>
                <!-- Botão Salvar -->
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-7 mr-5">
                            <div class="col-mr-1">
                                <button type="submit" class="btn btn-primary" id="adicionar" onclick="oController.adicionarEquipamento()">
                                <i class="glyphicon glyphicon-floppy-disk"></i> Salvar</button>
                            </div>
                        </div>
                        <div class="col-md-1 mr-5">
                            <div class="col-mr-1">
                                <button type="reset" class="btn btn-primary">Limpar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Descricao-->
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
<script src="{{asset('js/app/controllers/ServidorController.js')}}"></script>
<script>
    var oController = new ServidorController();
</script>
@endsection