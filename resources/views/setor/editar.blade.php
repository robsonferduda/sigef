@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Setor > Cadastro de Setor
                        <span class="d-block text-muted pt-2 font-size-sm">Cadastro Setor</span></h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ url('setores') }}" class="btn btn-info font-weight-bolder"><i class="fas fa-table"></i> Setores</a>
                </div>
            </div>
            <form class="form" method="post" action="{{ url('setor/'. $setor->cd_setor_set .'/editar') }}" id="form_bloco" >
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Nome do Setor</label>
                            <input type="text" name="nome" value="{{ $setor->nm_setor_set }}" class="form-control" placeholder="Nome do Setor"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Nome Abreviado do Setor</label>
                            <input type="text" name="nome_abrev" value="{{ $setor->nm_abrev_setor_set }}" class="form-control" placeholder="Nome Abreviado do Setor"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="select2">Local</label>
                            <select name="local" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Selecione o Local</option>
                                @foreach($locais as $local)
                                    <option {!! $local->cd_local_prova_lop == $setor->cd_local_prova_lop ? 'selected' : '' !!} value="{{ $local->cd_local_prova_lop }}">{{ $local->cd_local_prova_lop }} - {{ $local->nm_local_prova_lop }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="select2">Rede de Ensino</label>
                            <select name="rede" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                <option value="">Selecione a Rede de Ensino</option>
                                @foreach($redes as $rede)
                                    <option {!! $rede->cd_rede_ensino_ree == $setor->cd_rede_ensino_ree ? 'selected' : '' !!} value="{{ $rede->cd_rede_ensino_ree }}">{{ $rede->nm_rede_ensino_ree }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary mr-2">Save</button>
                            <a href="{{ url('setores') }}" class="btn btn-secondary">Cancel</a>
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
                                    message: 'O campo "Nome do Setor" é obrigatório.'
                                }
                            }
                        },
                        nome_abrev: {
                            validators: {
                                notEmpty: {
                                    message: 'O campo "Nome Abreviado do Setor" é obrigatório.'
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
                        rede: {
                            validators: {
                                notEmpty: {
                                    message: 'O campo "Rede de Ensino" é obrigatório.'
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
