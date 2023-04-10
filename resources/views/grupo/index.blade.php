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
                    <a href="{{ url('salas') }}" class="btn btn-info font-weight-bolder"><i class="fas fa-list"></i> Salas</a>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    @include('layouts.mensagens')
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form w-100">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <input type="hidden" value="{{ (Session::get('id_local')) ? Session::get('id_local') : "0" }}" id="local_session">
                                        <label for="select2">Local <span class="text-danger">Obrigatório</span></label>
                                        <select name="setor" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="local">
                                            <option value="0">Selecione o local</option>
                                            @foreach($locais as $local)
                                                <option value="{{ $local->cd_local_prova_lop }}" {{ ( Session::get('id_local') == $local->cd_local_prova_lop) ? 'selected' : '' }}>{{ $local->nm_local_prova_lop }}</option>
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
                                    <div class="col-md-12 mt-3">
                                        <p><span class="label label-lg label-light-primary label-inline">A taxa de ocupação padrão para os grupos neste evento é de 80%</span></p>
                                    </div>
                                </div>                            
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" id="kt_blockui_card">
                                    <div class="list list-hover min-w-500px" data-inbox="list"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div id="kt_mixed_widget_18_chart" style="height: 250px"></div>
                            
                            <div class="col bg-light-primary px-6 py-8 rounded-xl mr-7 mb-7" style="margin-top: -80px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5"></rect>
                                                    <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5"></rect>
                                                    <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5"></rect>
                                                    <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5"></rect>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <span class="text-primary mr-3 mt-5 total_carteiras" style="font-size: 35px;">--</span>
                                    </div>
                                    <div class="col-md-12">
                                        <p class="text-primary font-weight-bold font-size-h6">CARTEIRAS DISPONÍVEIS</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col bg-light-success px-6 py-8 rounded-xl mr-7 mb-7">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5"></rect>
                                                    <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5"></rect>
                                                    <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5"></rect>
                                                    <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5"></rect>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <span class="text-success mr-3 mt-5 total_utilizado" style="font-size: 35px;">--</span>
                                    </div>
                                    <div class="col-md-12">
                                        <p class="text-success font-weight-bold font-size-h6">CARTEIRAS SELECIONADAS</p>
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

            var percentual_local = 0;    
            var token = $('meta[name="csrf-token"]').attr('content');  
            var local = $("#local_session").val();
            
            atualizaCarteiras(local);
         
            $('.select2').select2({
                dropdownPosition: 'below',
            });

            $('.mostra-salas').on('select2:select',function (){

                let id_local = $("#local").val();
                let id_setor = $("#setor").val();
                let flag_canhoto = "";

                $('.list').empty();

                fetch('sala/setor/'+id_setor+'/local/'+id_local)
                    .then(response => response.json())
                    .then(function(grupos){
                        grupos.forEach(grupo => {

                            if(grupo.flag_canhoto){

                                canhoto = '<span class="label label-lg label-light-primary label-inline">CANHOTO</span>';

                            }else{
                                canhoto = "";
                            }

                            if(grupo.flag_alocado){
                                checado = 'checked';
                            }else{
                                checado = '';
                            }
                              
                            $('.list').append('<div class="d-flex align-items-start list-item card-spacer-x py-4" data-inbox="message">' +
                                        '<div class="d-flex align-items-center">' +
                                            '<div class="d-flex align-items-center mr-3" data-inbox="actions">' +
                                                '<label class="checkbox checkbox-inline checkbox-primary flex-shrink-0 mr-3">' +
                                                    '<input type="checkbox" class="seleciona" '+checado+' value="'+grupo.id+'">' +
                                                    '<span></span>' +
                                                '</label>' +
                                                '' +
                                            '</div>' +
                                        '</div>' +
                                        '<div class="flex-grow-1 mt-1 mr-2" data-toggle="view">' +
                                            '<div class="font-weight-bolder mr-2">'+grupo.bloco+' > '+grupo.pavimento+' > '+
                                                '<a href="sala/'+grupo.id+'/editar" target="_BLANK">'+grupo.nome+'</a>'+
                                            ' - '+grupo.carteiras+' lugares '+canhoto+'</div>' +
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

                    $.ajax({
                        url: '../grupos/alocar',
                        type: 'POST',
                        data: { "_token": token,
                                "id_grupo": check.val() },
                        success: function(response) {
                            KTApp.unblock('#kt_blockui_card');
                            atualizaCarteiras($("#local").val());
                        }
                    });

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

                                $.ajax({
                                    url: '../grupos/desalocar',
                                    type: 'POST',
                                    data: { "_token": token,
                                            "id_grupo": check.val() },
                                    success: function(response) {
                                        atualizaCarteiras($("#local").val());
                                    },
                                    error: function(response) {
                                        alert("Erro");
                                    },
                                    complete: function(response) {
                                        KTApp.unblock('#kt_blockui_card');
                                    }
                                });
                            
                        }else if(result.dismiss == 'cancel'){
                            check.prop("checked", true);
                        }
                        
                    });

                }

            });

            function atualizaCarteiras(local){

                fetch('local/'+local+'/salas/ocupacao')
                    .then(response => response.json())
                    .then(function(dados){

                        var total_utilizado = (dados.total_utilizado) ? dados.total_utilizado : 0;
                        var total_carteiras = (dados.total_carteiras) ? dados.total_carteiras : 0;
                        var percentual_local = (total_carteiras) ? Math.ceil((total_utilizado/total_carteiras)*100) : 0; 
                        var label = (percentual_local) ? 'Ocupado' : 'Aguardando Dados'

                        $(".total_utilizado").text(total_utilizado);
                        $(".total_carteiras").text(total_carteiras);

                        chart.updateSeries([percentual_local]);
                        chart.updateOptions({labels: [label],});

                    });
            }

            $('#local').on('change',function (){

                let setor_elemento = document.getElementById('setor');
                setor_elemento.innerHTML = '';
                let option = document.createElement("option");
                option.text = 'Selecione o setor';
                option.value = '';
                setor_elemento.appendChild(option);

                $('.list').empty();

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

                atualizaCarteiras(this.value);
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

               // var _initMixedWidget18 = function () {
                var element = document.getElementById("kt_mixed_widget_18_chart");
                var height = parseInt(KTUtil.css(element, 'height'));

                //if (!element) {
                    //return;
                //}

                var options = {
                    series: [percentual_local],
                    chart: {
                        height: height,
                        type: 'radialBar',
                        offsetY: 0
                    },
                    plotOptions: {
                        radialBar: {
                            startAngle: -90,
                            endAngle: 90,

                            hollow: {
                                margin: 0,
                                size: "70%"
                            },
                            dataLabels: {
                                showOn: "always",
                                name: {
                                    show: true,
                                    fontSize: "13px",
                                    fontWeight: "700",
                                    offsetY: -5,
                                    color: KTApp.getSettings()['colors']['gray']['gray-500']
                                },
                                value: {
                                    color: KTApp.getSettings()['colors']['gray']['gray-700'],
                                    fontSize: "30px",
                                    fontWeight: "700",
                                    offsetY: -40,
                                    show: true
                                }
                            },
                            track: {
                                background: KTApp.getSettings()['colors']['theme']['light']['primary'],
                                strokeWidth: '100%'
                            }
                        }
                    },
                    colors: [KTApp.getSettings()['colors']['theme']['base']['primary']],
                    stroke: {
                        lineCap: "round",
                    },
                    labels: ["Aguardando Dados"]
                };

                var chart = new ApexCharts(element, options);
                chart.render();
            //}

            //_initMixedWidget18();

            $("#local").val(local).trigger('change');

        });
    </script>
@endsection