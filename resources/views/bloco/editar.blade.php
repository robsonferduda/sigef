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
                            <label>Nome do Bloco</label>
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
                                    Port??o
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" {!! ($bloco->fl_rampa_bls) ? 'checked' : '' !!} name="rampa"/>
                                    <span></span>
                                    Rampa
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" {!! ($bloco->fl_vigilancia_bls) ? 'checked' : '' !!} name="vigilancia"/>
                                    <span></span>
                                    Vigil??ncia
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
                            <label>Endere??o de Acesso</label>
                            <input type="text" value="{{ $bloco->nm_endereco_acesso_bls }}" name="endereco" class="form-control" placeholder="Endere??o de Acesso"/>
                        </div>
                        <div class="col-lg-6">
                            <br />
                            <br />

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="select2">Setor</label>
                            <select name="setor" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  id="select2">
                                <option value="">Selecione o setor</option>
                                @foreach($setores as $setor)
                                    <option {!! $setor->cd_setor_set == $bloco->cd_setor_set ? 'selected' : '' !!} value="{{ $setor->cd_setor_set }}">{{ $setor->nm_abrev_setor_set }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary mr-2">Save</button>
                            <a href="{{ url('blocos') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
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
                                    message: 'O campo "Nome do Bloco" ?? obrigat??rio.'
                                }
                            }
                        },
                        endereco: {
                            validators: {
                                notEmpty: {
                                    message: 'O campo "Endere??o de Acesso" ?? obrigat??rio.'
                                }
                            }
                        },
                        setor: {
                            validators: {
                                notEmpty: {
                                    message: 'O campo "Setor" ?? obrigat??rio.'
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
