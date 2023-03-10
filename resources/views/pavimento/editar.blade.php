@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Pavimento > Cadastro de Pavimento
                        <span class="d-block text-muted pt-2 font-size-sm">Cadastro Bloco</span></h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ url('pavimentos') }}" class="btn btn-info font-weight-bolder"><i class="fas fa-table"></i> Pavimentos</a>
                </div>
            </div>
            <form class="form" method="post" action="{{ url('pavimento/'. $pavimento->cd_pavimento_pav .'/editar') }}" id="form_bloco" >
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Nome do Pavimento</label>
                            <input type="text" name="nome" value="{{ $pavimento->nm_pavimento_pav }}" class="form-control" placeholder="Nome do Pavimento"/>
                        </div>
                        <div class="col-lg-6">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="select2">Setor</label>
                            <select name="setor" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  id="setor">
                                <option value="">Selecione o setor</option>
                                @foreach($setores as $setor)
                                    <option  {!! $setor->cd_setor_set == $pavimento->bloco->cd_setor_set ? 'selected' : '' !!} value="{{ $setor->cd_setor_set }}">{{ $setor->nm_abrev_setor_set }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="select2">Bloco</label>
                            <select name="bloco" disabled class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="bloco">
                                <option value="">Selecione o bloco</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary mr-2">Save</button>
                            <a href="{{ url('pavimentos') }}" class="btn btn-secondary">Cancel</a>
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
                                    message: 'O campo "Nome do Pavimento" ?? obrigat??rio.'
                                }
                            }
                        },
                        bloco: {
                            validators: {
                                notEmpty: {
                                    message: 'O campo "Bloco" ?? obrigat??rio.'
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

                            if(bloco.cd_bloco_setor_bls == {!! $pavimento->cd_bloco_setor_bls !!}) {
                                option.selected = true;
                            }

                            $('#bloco').prop('disabled', false);

                        });
                    });
            }

            buscarBloco($("#setor").val());

        });
    </script>
@endsection
