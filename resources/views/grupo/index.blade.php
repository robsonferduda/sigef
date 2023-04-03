@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Grupos
                    <span class="d-block text-muted pt-2 font-size-sm">Listagem de Grupos do Espaço Físico</span></h3>
                </div>
                <div class="card-toolbar">                   
                    <a href="{{ url('grupo/create') }}" class="btn btn-primary font-weight-bolder"><i class="fa fa-plus"></i> Novo</a>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    @include('layouts.mensagens')
                </div>
                <div class="row">
                    <div class="form w-100">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="select2">Local <span class="text-danger">Obrigatório</span></label>
                                    <select name="setor" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="local">
                                        <option value="">Selecione o local</option>
                                        @foreach($locais as $local)
                                            <option value="{{ $local->cd_local_prova_lop }}">{{ $local->nm_local_prova_lop }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="select2">Setor <span class="text-danger">Obrigatório</span></label>
                                    <select name="setor" disabled class="form-control select2 select2-hidden-accessible mostra-salas" style="width: 100%;" tabindex="-1" aria-hidden="true" id="setor">
                                        <option value="">Selecione o setor</option>
                                        @foreach($setores as $setor)
                                            <option value="{{ $setor->cd_setor_set }}">{{ $setor->nm_abrev_setor_set }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="select2">Bloco</label>
                                    <select name="bloco" disabled class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="bloco">
                                        <option value="">Selecione o bloco</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="select2">Pavimento</label>
                                    <select name="pavimento" disabled class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="pavimento">
                                        <option value="">Selecione o pavimento</option>
                                    </select>
                                </div>

                            </div>                            
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive" id="kt_blockui_card">
                                <div class="list list-hover min-w-500px" data-inbox="list">
                                    

                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
         
            $('.select2').select2({
                dropdownPosition: 'below',
            });

            $('.mostra-salas').on('select2:select',function (){

                let id_local = $("#local").val();
                let id_setor = $("#setor").val();

                fetch('sala/setor/'+id_setor+'/local/'+id_local)
                    .then(response => response.json())
                    .then(function(grupos){
                        grupos.forEach(grupo => {

                              
                            $('.list').append('<div class="d-flex align-items-start list-item card-spacer-x py-4" data-inbox="message">' +
                                        '<div class="d-flex align-items-center">' +
                                            '<div class="d-flex align-items-center mr-3" data-inbox="actions">' +
                                                '<label class="checkbox checkbox-inline checkbox-primary flex-shrink-0 mr-3">' +
                                                    '<input type="checkbox" class="seleciona">' +
                                                    '<span></span>' +
                                                '</label>' +
                                                '<span class="label label-lg label-light-primary label-inline">CANHOTO</span>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div class="flex-grow-1 mt-1 mr-2" data-toggle="view">' +
                                            '<div class="font-weight-bolder mr-2">'+grupo.bloco+' > '+grupo.pavimento+' > '+grupo.nome+'</div>' +
                                        '</div>' +
                                    '</div>');

                        });
                    });

            });

            $(document).on('click', '.seleciona', function(e) {

                check = $(this);
                if($(this).is(":checked")){                    
                    
                    KTApp.block('#kt_blockui_card', {
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Aguarde... Processo de alocação da sala em andamento'
                        });

                    setTimeout(function() {
                    KTApp.unblock('#kt_blockui_card');
                    }, 2000);

                }else{

                    Swal.fire({
                        title: "Tem certeza que deseja remover o grupo do evento corrente",
                        text: "O espaço será desalocado e o total de carteiras disponíveis alterado.",
                        icon: "warning",
                        confirmButtonColor: '#1BC5BD',
                        showCancelButton: true,
                        cancelButtonText: '<i class="fa fa-times text-white"></i> Cancelar',
                        confirmButtonText: '<i class="fa fa-check text-white"></i> Sim, remover'
                    }).then(function(result) {
                        
                        if(result.value){

                            KTApp.block('#kt_blockui_card', {
                                overlayColor: '#000000',
                                state: 'danger',
                                message: 'Aguarde... Removendo a sala do evento'
                                });

                            setTimeout(function() {
                            KTApp.unblock('#kt_blockui_card');
                            }, 2000);
                            
                        }else if(result.dismiss == 'cancel'){
                            check.prop("checked", true);
                        }
                        
                    });

                }

            });

            $('#local').on('select2:select',function (){

                let setor_elemento = document.getElementById('setor');

                setor_elemento.innerHTML = '';
                let option = document.createElement("option");
                option.text = 'Selecione o setor';
                option.value = '';
                setor_elemento.appendChild(option);

                fetch('setor/local/'+this.value)
                    .then(response => response.json())
                    .then(function(setores){
                        setores.forEach(setor => {

                            let option = document.createElement("option");
                            option.text = setor.nm_setor_set;
                            option.value = setor.cd_setor_set;
                            setor_elemento.appendChild(option);

                            $('#setor').prop('disabled', false);

                        });
                    });
            });

            $('#setor').on('select2:select',function (){

                let bloco_elemento = document.getElementById('bloco');

                bloco_elemento.innerHTML = '';
                let option = document.createElement("option");
                option.text = 'Selecione o bloco';
                option.value = '';
                bloco_elemento.appendChild(option);

                fetch('blocos/setor/'+this.value)
                    .then(response => response.json())
                    .then(function(blocos){
                        blocos.forEach(bloco => {

                            let option = document.createElement("option");
                            option.text = bloco.nm_bloco_bls;
                            option.value = bloco.cd_bloco_setor_bls;
                            bloco_elemento.appendChild(option);

                            $('#bloco').prop('disabled', false);

                        });
                    });
            });

                $('#bloco').on('select2:select',function (){

                let pavimento_elemento = document.getElementById('pavimento');

                pavimento_elemento.innerHTML = '';
                let option = document.createElement("option");
                option.text = 'Selecione o pavimento';
                option.value = '';
                pavimento_elemento.appendChild(option);

                fetch('pavimentos/bloco/'+this.value)
                    .then(response => response.json())
                    .then(function(pavimentos){
                        pavimentos.forEach(pavimento => {

                            let option = document.createElement("option");
                            option.text = pavimento.nm_pavimento_pav;
                            option.value = pavimento.cd_pavimento_pav;
                            pavimento_elemento.appendChild(option);

                            $('#pavimento').prop('disabled', false);

                        });
                    });
                });
        });
    </script>
@endsection