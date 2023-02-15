@extends('layout.default')
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Cadastrar Permissão
                    <div class="text-muted pt-2 font-size-sm">Cadastro de permissões do sistema</div>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ url('permissions') }}" class="btn btn-success font-weight-bolder"><i class="fa fa-table"></i> Permissões</a>
            </div>
        </div>
        {!! Form::open(['id' => 'basic-form', 'class' => 'form', 'url' => ['permissions', $permission], 'method' => 'patch']) !!}
            <div class="card-body">
                @include('layout.mensagens')
                <div class="form-group row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="cd_sistema_sis">Sistema</label>
                            <select class="form-control" name="cd_sistema_sis" id="cd_sistema_sis">
                                <option value="0">Selecione um sistema</option>
                                @foreach($sistemas as $s)
                                    <option {{ ($permission->cd_sistema_sis == $s->cd_sistema_sis) ? 'selected' : '' }} value="{{ $s->cd_sistema_sis }}" data-sigla="{{ strtolower($s->ds_sigla_sis) }}">{{ $s->ds_sistema_sis }}</option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted">Sistema que recebe a permissão</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="cd_controle_con">Controle</label>
                            <select class="form-control" name="cd_controle_con" id="cd_controle_con">
                                <option value="0">Selecione um controle</option>
                                @foreach($controles as $c)
                                    <option {{ ($permission->cd_controle_con == $c->cd_controle_con) ? 'selected' : '' }} value="{{ $c->cd_controle_con }}" data-chave="{{ $c->ds_chave_con }}"">{{ $c->ds_controle_con }}</option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted">Controle vinculado a permissão</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="display_name">Permissão</label>
                        <input type="text" name="display_name" id="display_name" class="form-control" value="{{ $permission->display_name }}" placeholder="Permissão"/>
                        <span class="form-text text-muted">Digite o nome da permissão</span>
                    </div>
                    <div class="col-lg-2">
                        <label for="name">Chave</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $permission->name }}" placeholder="Chave"/>
                        <span class="form-text text-muted">Digite o identificar da permissão</span>
                    </div>
                    <div class="col-lg-12">
                        <label for="description">Descrição</label>
                        <input type="text" name="description" id="description" class="form-control" value="{{ $permission->description }}" placeholder="Descrição"/>
                        <span class="form-text text-muted">Descrição da permissão</span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-8">
                        <button type="submit" class="btn btn-success mr-2"><i class="fa fa-save"></i> Salvar</button>
                        <button type="reset" class="btn btn-danger"><i class="fa fa-times"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        {!! Form::close() !!} 
    </div>
@endsection

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection


{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    {{-- page scripts --}}
    <script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/crud/forms/validation/form-controls.js') }}" type="text/javascript"></script>

    <script>
        $(function() {

            $("#display_name").keyup(function(){
                geraChave();
            });

            $("#cd_sistema_sis").change(function(){
                geraChave();
            });

            $("#cd_controle_con").change(function(){
                geraChave();
            });

            function geraChave(){
                sigla_sistema = $("#cd_sistema_sis").find(':selected').data("sigla");
                chave_controle = $("#cd_controle_con").find(':selected').data("chave");
                valor_campo = $("#display_name").val();

                chave = sigla_sistema+'-'+chave_controle+'-'+valor_campo;
                $("#name").val(chave);
            }

            FormValidation.formValidation(
                document.getElementById('form-create-permission'),
                {
                    fields: {

                        name: {
                            validators: {
                                notEmpty: {
                                    message: 'Campo obrigatório'
                                }
                            }
                        },
                        display_name: {
                            validators: {
                                notEmpty: {
                                    message: 'Campo obrigatório'
                                }
                            }
                        },
                        cd_sistema_sis: {
                            validators: {
                            notEmpty: {
                            message: 'Campo obrigatório'
                            }
                            }
                        },
                        cd_controle_con: {
                            validators: {
                            notEmpty: {
                            message: 'Campo obrigatório'
                            }
                            }
                        },
                        
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap(),
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    },
                }
            );

        });
    </script>
@endsection
