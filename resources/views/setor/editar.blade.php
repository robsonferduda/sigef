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
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group col-sm-12">
                                <label>Nome do Setor</label>
                                <input type="text" name="nome" value="{{ $setor->nm_setor_set }}" class="form-control" placeholder="Nome do Setor"/>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Nome Abreviado do Setor</label>
                                <input type="text" name="nome_abrev" value="{{ $setor->nm_abrev_setor_set }}" class="form-control" placeholder="Nome Abreviado do Setor"/>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="select2">Local</label>
                                <select name="local" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <option value="">Selecione o Local</option>
                                    @foreach($locais as $local)
                                        <option {!! $local->cd_local_prova_lop == $setor->cd_local_prova_lop ? 'selected' : '' !!} value="{{ $local->cd_local_prova_lop }}">{{ $local->cd_local_prova_lop }} - {{ $local->nm_local_prova_lop }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="select2">Rede de Ensino</label>
                                <select name="rede" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                    <option value="">Selecione a Rede de Ensino</option>
                                    @foreach($redes as $rede)
                                        <option {!! $rede->cd_rede_ensino_ree == $setor->cd_rede_ensino_ree ? 'selected' : '' !!} value="{{ $rede->cd_rede_ensino_ree }}">{{ $rede->nm_rede_ensino_ree }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if(!isset($setor->contatos))
                            <div class="col-lg-6">
                            <div id="kt_repeater_1">
                                <div class="row" id="kt_repeater_1">
                                    <div data-repeater-list="contato" class="col-lg-10">
                                        <div data-repeater-item class="form-group row align-items-center">
                                            <div class="form-group col-sm-12">
                                                <label>Nome do Contato:</label>
                                                <input type="text" name="nome_contato" class="form-control" placeholder="Nome do Contato"/>
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label>E-mail do Contato:</label>
                                                <input type="email" name="email_contato"  class="form-control"
                                                       placeholder="E-mail do Contato"/>
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label>Telefone do Contato:</label>
                                                <input type="text" name="telefone_contato"  class="form-control"
                                                       placeholder="Telefone do Contato"/>
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <a href="javascript:;" data-repeater-delete=""
                                                   class="btn btn-sm font-weight-bolder btn-light-danger">
                                                    <i class="la la-trash-o"></i>Excluir
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-center">
                                        <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                                            <i class="la la-plus"></i>Adicionar Contato
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            <div class="col-lg-6">
                                <div id="kt_repeater_1">
                                    <div class="row" id="kt_repeater_1">
                                        <div data-repeater-list="contato" class="col-lg-10">
                                            @foreach($setor->contatos as $contato)
                                                <div data-repeater-item class="form-group row align-items-center">
                                                    <div class="form-group col-sm-12">
                                                        <label>Nome do Contato:</label>
                                                        <input type="text" name="nome_contato" value="{{ $contato->nm_contato_con }}" class="form-control" placeholder="Nome do Contato"/>
                                                         <div class="d-md-none mb-2"></div>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <label>E-mail do Contato:</label>
                                                        <input type="email" name="email_contato" value="{{ $contato->dc_email_con }}" class="form-control" placeholder="E-mail do Contato"/>
                                                        <div class="d-md-none mb-2"></div>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <label>Telefone do Contato:</label>
                                                        <input type="text" name="telefone_contato" value="{{ $contato->nu_fone_con }}" class="form-control" placeholder="Telefone do Contato"/>
                                                        <div class="d-md-none mb-2"></div>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
                                                            <i class="la la-trash-o"></i>Excluir
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 text-center">
                                            <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                                                <i class="la la-plus"></i>Adicionar Contato
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
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
    <script src="{{ asset('assets/js/pages/crud/forms/widgets/form-repeater.js') }}"></script>
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
