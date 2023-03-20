@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Sala > Cadastro de Sala
                        <span class="d-block text-muted pt-2 font-size-sm">Cadastro Sala</span></h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ url('salas') }}" class="btn btn-info font-weight-bolder"><i class="fas fa-table"></i> Salas</a>
                </div>
            </div>
            <form class="form" method="post" action="{{ url('sala/'. $sala->cd_sala_sal .'/editar') }}" id="form_bloco" >
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Nome da Sala <span class="text-danger">Obrigatório</span></label>
                            <input type="text" name="nome" value="{{ $sala->nm_sala_sal }}" class="form-control" placeholder="Nome da Sala"/>
                        </div>
                        <div class="col-lg-6">
                            <label for="select2">Setor <span class="text-danger">Obrigatório</span></label>
                            <select name="setor" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  id="setor">
                                <option value="">Selecione o setor</option>
                                @foreach($setores as $setor)
                                    <option {!!  $setor->cd_setor_set == $sala->pavimento->bloco->cd_setor_set ? 'selected': '' !!} value="{{ $setor->cd_setor_set }}">{{ $setor->nm_abrev_setor_set }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="select2">Bloco <span class="text-danger">Obrigatório</span></label>
                            <select name="bloco" disabled class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="bloco">
                                <option value="">Selecione o bloco</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="select2">Pavimento <span class="text-danger">Obrigatório</span></label>
                            <select name="pavimento" disabled class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="pavimento">
                                <option value="">Selecione o pavimento</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="select2">Tipo de Carteira <span class="text-danger">Obrigatório</span></label>
                            <select name="tipo_carteira" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="tipo_carteira">
                                <option value="">Selecione o Tipo de Carteira</option>
                                @foreach($tiposCarteira as $tipo)
                                    <option  {!!  $tipo->cd_tipo_carteira_tic == $sala->cd_tipo_carteira_tic ? 'selected': '' !!}  value="{{ $tipo->cd_tipo_carteira_tic }}">{{ $tipo->nm_tipo_tic }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="select2">Tipo de Sala <span class="text-danger">Obrigatório</span></label>
                            <select name="tipo_sala" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="tipo_sala">
                                <option value="">Selecione o Tipo de Sala</option>
                                @foreach($tiposSala as $tipo)
                                    <option {!!  $tipo->cd_tipo_sala_tis == $sala->cd_tipo_sala_tis ? 'selected': '' !!} value="{{ $tipo->cd_tipo_sala_tis }}">{{ $tipo->nm_tipo_tis }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Número de Carteiras</label>
                            <input type="number" name="qtd_cardeiras" value="{{ $sala->nu_carteiras_sal }}" class="form-control" placeholder="Número de Carteiras"/>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-light-success mr-2"><i class="fas fa-save"></i> Salvar</button>
                    <a href="{{ url('salas') }}" class="btn btn-light-danger"><i class="fas fa-times"></i> Cancelar</a>
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
                                    message: 'O campo "Nome da Sala" é obrigatório.'
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
                        tipo_carteira: {
                            validators: {
                                notEmpty: {
                                    message: 'O campo "Tipo de Carteira" é obrigatório.'
                                }
                            }
                        },
                        tipo_sala: {
                            validators: {
                                notEmpty: {
                                    message: 'O campo "Tipo de Sala" é obrigatório.'
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

            $('#setor').on('select2:select',function (){

                buscarBloco(this.value);

            });


            var buscarBloco = function (setor) {

                let bloco_elemento = document.getElementById('bloco');

                bloco_elemento.innerHTML = '';
                let option = document.createElement("option");
                option.text = 'Selecione o bloco';
                option.value = '';
                bloco_elemento.appendChild(option);

                fetch('../../blocos/setor/'+setor)
                    .then(response => response.json())
                    .then(function(blocos){
                        blocos.forEach(bloco => {

                            let option = document.createElement("option");
                            option.text = bloco.nm_bloco_bls;
                            option.value = bloco.cd_bloco_setor_bls;
                            bloco_elemento.appendChild(option);

                            if(bloco.cd_bloco_setor_bls == {!! $sala->pavimento->cd_bloco_setor_bls !!}) {
                                option.selected = true;
                                buscarPavimento(bloco.cd_bloco_setor_bls);
                            }

                            $('#bloco').prop('disabled', false);

                        });
                    });
            }

            buscarBloco($("#setor").val());

            $('#bloco').on('select2:select',function (){
                buscarBloco(this.value);
            });

            var buscarPavimento = function (bloco) {
                let pavimento_elemento = document.getElementById('pavimento');

                pavimento_elemento.innerHTML = '';
                let option = document.createElement("option");
                option.text = 'Selecione o pavimento';
                option.value = '';
                pavimento_elemento.appendChild(option);

                fetch('../../pavimentos/bloco/'+bloco)
                    .then(response => response.json())
                    .then(function(pavimentos){
                        pavimentos.forEach(pavimento => {

                            let option = document.createElement("option");
                            option.text = pavimento.nm_pavimento_pav;
                            option.value = pavimento.cd_pavimento_pav;
                            pavimento_elemento.appendChild(option);

                            if(pavimento.cd_pavimento_pav == {!! $sala->pavimento->cd_pavimento_pav !!}) {
                                option.selected = true;
                            }

                            $('#pavimento').prop('disabled', false);

                        });
                    });
            }

        });
    </script>
@endsection
