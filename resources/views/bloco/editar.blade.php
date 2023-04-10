@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Bloco > Cadastro de Bloco
                        <span class="d-block text-muted pt-2 font-size-sm">Cadastro Bloco</span></h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ url('blocos') }}" class="btn btn-info font-weight-bolder"><i class="fas fa-table"></i> Blocos</a>
                </div>
            </div>
            <form class="form" method="post" action="{{ url('bloco/'. $bloco->cd_bloco_setor_bls .'/editar') }}" id="form_bloco" >
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Nome do Bloco <span class="text-danger">Obrigatório</span></label>
                            <input type="text" name="nome" value="{{ $bloco->nm_bloco_bls }}" class="form-control" placeholder="Nome do Bloco"/>
                        </div>
                        <div class="col-lg-6">
                            <br />
                            <br />
                            <div class="checkbox-inline">
                                <label class="checkbox">
                                    <input type="checkbox" {!! ($bloco->fl_muro_bls) ? 'checked' : '' !!} name="muro"/>
                                    <span></span>
                                    Muro
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" {!! ($bloco->fl_guarita_bls) ? 'checked' : '' !!}  name="guarita"/>
                                    <span></span>
                                    Guarita
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" {!! ($bloco->fl_elevador_bls) ? 'checked' : '' !!} name="elevador"/>
                                    <span></span>
                                    Elevador
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" {!! ($bloco->fl_portao_bls) ? 'checked' : '' !!} name="portao"/>
                                    <span></span>
                                    Portão
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" {!! ($bloco->fl_rampa_bls) ? 'checked' : '' !!} name="rampa"/>
                                    <span></span>
                                    Rampa
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" {!! ($bloco->fl_vigilancia_bls) ? 'checked' : '' !!} name="vigilancia"/>
                                    <span></span>
                                    Vigilância
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" {!! ($bloco->fl_monitoramento_bls) ? 'checked' : '' !!} name="monitoramento"/>
                                    <span></span>
                                    Monitoramento
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" {!! ($bloco->fl_estacionamento_bls) ? 'checked' : '' !!} name="estacionamento"/>
                                    <span></span>
                                    Estacionamento
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" {!! ($bloco->fl_wifi_bls) ? 'checked' : '' !!} name="wifi"/>
                                    <span></span>
                                    Wifi
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Endereço de Acesso <span class="text-danger">Obrigatório</span></label>
                            <input type="text" value="{{ $bloco->nm_endereco_acesso_bls }}" name="endereco" class="form-control" placeholder="Endereço de Acesso"/>
                        </div>
                        <div class="col-lg-6">
                            <br />
                            <br />

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="select2">Local <span class="text-danger">Obrigatório</span></label>
                            <select name="local" class="form-control select2 select2-hidden-accessible local" style="width: 100%;" tabindex="-1" aria-hidden="true" id="local">
                                <option value="">Selecione o local</option>
                                @foreach($locais as $local)
                                    <option {!! $local->cd_local_prova_lop == $bloco->setor->cd_local_prova_lop ? 'selected' : '' !!} value="{{ $local->cd_local_prova_lop }}">{{ $local->nm_local_prova_lop }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="select2">Setor <span class="text-danger">Obrigatório</span></label>
                            <select name="setor" class="form-control select2 select2-hidden-accessible setor" style="width: 100%;" tabindex="-1" aria-hidden="true"  id="setor">
                                <option value="">Selecione o setor</option>
                                @foreach($setores as $setor)
                                    <option {!! $setor->cd_setor_set == $bloco->cd_setor_set ? 'selected' : '' !!} value="{{ $setor->cd_setor_set }}">{{ $setor->nm_abrev_setor_set }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-light-success mr-2"><i class="fas fa-save"></i> Salvar</button>
                    <a href="{{ url('blocos') }}" class="btn btn-light-danger"><i class="fas fa-times"></i> Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/pages/crud/forms/widgets/select2.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.select2').select2({
                dropdownPosition: 'below',
            });

            validator = FormValidation.formValidation(
                document.getElementById('form_bloco'),
                {
                    fields: {
                        nome: {
                            validators: {
                                notEmpty: {
                                    message: 'O campo "Nome do Bloco" é obrigatório.'
                                }
                            }
                        },
                        endereco: {
                            validators: {
                                notEmpty: {
                                    message: 'O campo "Endereço de Acesso" é obrigatório.'
                                }
                            }
                        },
                        local: {
                            validators: {
                                notEmpty: {
                                    message: 'O campo "Local" é obrigatório.'
                                }
                            }
                        },
                        setor: {
                            validators: {
                                notEmpty: {
                                    message: 'O campo "Setor" é obrigatório.'
                                }
                            }
                        },
                    },

                    plugins: { //Learn more: https://formvalidation.io/guide/plugins
                        trigger: new FormValidation.plugins.Trigger(),
                        // Bootstrap Framework Integration
                        bootstrap: new FormValidation.plugins.Bootstrap(),
                        // Validate fields when clicking the Submit button
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        // Submit the form when all fields are valid
                        defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    }
                }
            );

        });
    </script>
@endsection
