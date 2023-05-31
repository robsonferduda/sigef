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
                    <a href="{{ url('setores') }}" class="btn btn-info font-weight-bolder"><i class="fas fa-table"></i>
                        Setores</a>
                </div>
            </div>
            <form class="form" method="post" action="{{ url('setor/salvar') }}" id="form_bloco">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <label>Código do Setor <span class="text-danger">Obrigatório</span></label>
                            <input type="number" name="codigo" class="form-control" placeholder="Código do Setor"/>
                        </div>
                        <div class="form-group col-sm-5">
                            <label>Nome do Setor <span class="text-danger">Obrigatório</span></label>
                            <input type="text" name="nome" class="form-control" placeholder="Nome do Setor"/>
                        </div>
                        <div class="form-group col-sm-5">
                            <label>Nome Abreviado do Setor <span class="text-danger">Obrigatório</span></label>
                            <input type="text" name="nome_abrev" class="form-control"
                                   placeholder="Nome Abreviado do Setor"/>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="select2">Local <span class="text-danger">Obrigatório</span></label>
                            <select name="local" class="form-control select2 select2-hidden-accessible"
                                    style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Selecione o Local</option>
                                @foreach($locais as $local)
                                    <option
                                        value="{{ $local->cd_local_prova_lop }}">{{ $local->cd_local_prova_lop }}
                                        - {{ $local->nm_local_prova_lop }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="select2">Rede de Ensino</label>
                            <select name="rede" class="form-control select2 select2-hidden-accessible"
                                    style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Selecione a Rede de Ensino</option>
                                @foreach($redes as $rede)
                                    <option
                                        value="{{ $rede->cd_rede_ensino_ree }}">{{ $rede->nm_rede_ensino_ree }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Bairro</label>
                            <input type="text" name="bairro" class="form-control"
                                   placeholder="Nome do Bairro"/>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Endereço</label>
                            <input type="text" name="endereco" class="form-control"
                                   placeholder="Endereço"/>
                        </div>
                        <div class="form-group col-sm-4">
                            <label>Complemento</label>
                            <input type="text" name="complemento" class="form-control"
                                   placeholder="Complemento"/>
                        </div>
                        <div class="form-group col-sm-4">
                            <label>Cep</label>
                            <input type="text" name="cep" class="form-control"
                                   placeholder="Cep"/>
                        </div>
                        <div class="form-group col-sm-4">
                            <label>Município</label>
                            <input type="text" name="municipio" class="form-control"
                                   placeholder="Município"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <p><i class="fas fa-book text-dark"></i> Contatos do Setor</p>
                        </div>
                        <div class="col-lg-12">
                            <div id="kt_repeater_1">
                                <div class="row" id="kt_repeater_1">
                                    <div data-repeater-list="contato" class="col-lg-10">
                                        <div data-repeater-item class="form-group row align-items-center">
                                            <div class="form-group col-sm-5">
                                                <label>Nome do Contato:</label>
                                                <input type="text" name="nome_contato" class="form-control" placeholder="Nome do Contato"/>
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label>E-mail do Contato:</label>
                                                <input type="email" name="email_contato"  class="form-control"
                                                       placeholder="E-mail do Contato"/>
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <label>Telefone do Contato:</label>
                                                <input type="text" name="telefone_contato"  class="form-control"
                                                       placeholder="Telefone do Contato"/>
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                            <div class="form-group col-sm-1">
                                                <a href="javascript:;" data-repeater-delete=""
                                                   class="btn btn-sm font-weight-bolder btn-light-danger mt-6">
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
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-light-success mr-2"><i class="fas fa-save"></i> Salvar</button>
                        <a href="{{ url('setores') }}" class="btn btn-light-danger"><i class="fas fa-times"></i> Cancelar</a>
                    </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2({
                dropdownPosition: 'below',
            });

            validator = FormValidation.formValidation(
                document.getElementById('form_bloco'),
                {
                    fields: {
                        codigo: {
                            validators: {
                                notEmpty: {
                                    message: 'O campo "Código do Seto" é obrigatório.'
                                }
                            }
                        },
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
