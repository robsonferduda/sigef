@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Banheiro > Cadastro de Banheiro
                        <span class="d-block text-muted pt-2 font-size-sm">Cadastro Banheiro</span></h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ url('banheiros') }}" class="btn btn-info font-weight-bolder"><i class="fas fa-table"></i> Banheiros</a>
                </div>
            </div>
            <form class="form" method="post" action="{{ url('banheiro/salvar') }}" id="form_bloco" >
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Nome do Banheiro <span class="text-danger">Obrigatório</span></label>
                            <input type="text" name="nome" class="form-control" placeholder="Nome do Banheiro"/>
                        </div>
                        <div class="col-lg-6">
                            <label for="select2">Local <span class="text-danger">Obrigatório</span></label>
                            <select name="local" class="form-control select2 select2-hidden-accessible local" style="width: 100%;" tabindex="-1" aria-hidden="true" id="local">
                                <option value="">Selecione o local</option>
                                @foreach($locais as $local)
                                    <option  value="{{ $local->cd_local_prova_lop }}">{{ $local->nm_local_prova_lop }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="select2">Setor <span class="text-danger">Obrigatório</span></label>
                            <select name="setor" disabled class="form-control select2 select2-hidden-accessible setor" style="width: 100%;" tabindex="-1" aria-hidden="true"  id="setor">
                                <option value="">Selecione o setor</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="select2">Bloco <span class="text-danger">Obrigatório</span></label>
                            <select name="bloco" disabled class="form-control select2 select2-hidden-accessible bloco" style="width: 100%;" tabindex="-1" aria-hidden="true" id="bloco">
                                <option value="">Selecione o bloco</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="select2">Pavimento <span class="text-danger">Obrigatório</span></label>
                            <select name="pavimento" disabled class="form-control select2 select2-hidden-accessible pavimento" style="width: 100%;" tabindex="-1" aria-hidden="true" id="pavimento">
                                <option value="">Selecione o pavimento</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label>Número de Cabines</label>
                            <input type="number" name="qtd_cabines" class="form-control" placeholder="Número de Cabines"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="checkbox-inline">
                                <label class="checkbox">
                                    <input type="checkbox"  name="adaptado"/>
                                    <span></span>
                                    Adaptado
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-light-success mr-2"><i class="fas fa-save"></i> Salvar</button>
                    <a href="{{ url('banheiros') }}" class="btn btn-light-danger"><i class="fas fa-times"></i> Cancelar</a>
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
                                    message: 'O campo "Nome do Banheiro" é obrigatório.'
                                }
                            }
                        },
                        bloco: {
                            validators: {
                                notEmpty: {
                                    message: 'O campo "Bloco" é obrigatório.'
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
                        pavimento: {
                            validators: {
                                notEmpty: {
                                    message: 'O campo "Pavimento" é obrigatório.'
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

