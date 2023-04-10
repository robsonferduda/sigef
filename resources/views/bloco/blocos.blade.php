@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Blocos
                        <span class="d-block text-muted pt-2 font-size-sm">Listagem de Blocos</span></h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ url('bloco/novo') }}" class="btn btn-primary font-weight-bolder"><i class="fa fa-plus"></i> Novo</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('layouts.mensagens')
                    </div>
                    <div class="form w-100">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Nome do Bloco</label>
                                    <input type="text" name="nome_bloco" id="nome" class="form-control" placeholder="Nome ou parte do nome"/>
                                </div>
                                <div class="col-md-4">
                                    <label for="select2">Local</label>
                                    <select name="local" class="form-control select2 select2-hidden-accessible local" style="width: 100%;" tabindex="-1" aria-hidden="true" id="local">
                                        <option value="">Selecione o local</option>
                                        @foreach($locais as $local)
                                            <option value="{{ $local->cd_local_prova_lop }}">{{ $local->nm_local_prova_lop }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="select2">Setor</label>
                                    <select name="setor" disabled class="form-control select2 select2-hidden-accessible setor" style="width: 100%;" tabindex="-1" aria-hidden="true"  id="setor">
                                        <option value="">Selecione o setor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <br>
                                    <div class="checkbox-inline">
                                        <label class="checkbox">
                                            <input type="checkbox"  name="muro"/>
                                            <span></span>
                                            Muro
                                        </label>
                                        <label class="checkbox">
                                            <input type="checkbox"  name="guarita"/>
                                            <span></span>
                                            Guarita
                                        </label>
                                        <label class="checkbox">
                                            <input type="checkbox"  name="elevador"/>
                                            <span></span>
                                            Elevador
                                        </label>
                                        <label class="checkbox">
                                            <input type="checkbox"  name="portao"/>
                                            <span></span>
                                            Portão
                                        </label>
                                        <label class="checkbox">
                                            <input type="checkbox"  name="rampa"/>
                                            <span></span>
                                            Rampa
                                        </label>
                                        <label class="checkbox">
                                            <input type="checkbox"  name="vigilancia"/>
                                            <span></span>
                                            Vigilância
                                        </label>
                                        <label class="checkbox">
                                            <input type="checkbox"  name="monitoramento"/>
                                            <span></span>
                                            Monitoramento
                                        </label>
                                        <label class="checkbox">
                                            <input type="checkbox"  name="estacionamento"/>
                                            <span></span>
                                            Estacionamento
                                        </label>
                                        <label class="checkbox">
                                            <input type="checkbox"  name="wifi"/>
                                            <span></span>
                                            Wifi
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer center">
                            <button type="button" class="btn btn-primary mr-2 btn-buscar"><i class="fa fa-search"></i> Buscar</button>
                            <button type="button" class="btn btn-warning mr-2 btn-limpar"><i class="fa fa-broom"></i> Limpar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-separate table-head-custom table-checkable dataTable no-footer" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Local</th>
                        <th>Setor</th>
                        <th>Bloco</th>
                        <th>Endereço de Acesso</th>
                        <th>Muro?</th>
                        <th>Guarita?</th>
                        <th>Elevador?</th>
                        <th>Portão?</th>
                        <th>Rampa?</th>
                        <th>Vigilância?</th>
                        <th>Monitoramento?</th>
                        <th>Estacionamento?</th>
                        <th>Wifi?</th>
                        <th class="box-btn-acoes-col2">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>

                    </tr>
                    </tbody>
                </table>
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

            $('#kt_datatable').on("click", '[data-toggle="popover"]', function (){ $(this).popover({}) });

            //$('[data-toggle="popover"]').on('popover', function (){ });
            var table = $('#kt_datatable').DataTable({
                "processing": true,
                "paginate": false,
                "serverSide": true,
                "order": [[ 1, "asc"], [ 2, "asc" ],[ 3, "asc" ]],
                "bFilter": false,
                "ajax":{
                    "url": "{{ url('blocos') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": function (d) {
                        d._token   =  "{{csrf_token()}}",
                        d.nome     = $('input[name="nome_bloco"]').val();
                        d.local    = $('select[name="local"]').val();
                        d.setor    = $('select[name="setor"]').val();
                        d.muro = $('input[name="muro"]').is(":checked");
                        d.guarita = $('input[name="guarita"]').is(":checked");
                        d.elevador = $('input[name="elevador"]').is(":checked");
                        d.portao = $('input[name="portao"]').is(":checked");
                        d.rampa = $('input[name="rampa"]').is(":checked");
                        d.vigilancia = $('input[name="vigilancia"]').is(":checked");
                        d.monitoramento = $('input[name="monitoramento"]').is(":checked");
                        d.estacionamento = $('input[name="estacionamento"]').is(":checked");
                        d.wifi = $('input[name="wifi"]').is(":checked");
                    }
                },
                "columns": [
                    { data: "codigo" },
                    { data: "local" },
                    { data: "setor" },
                    { data: "bloco" },
                    { data: "endereco" },
                    { data: "muro" },
                    { data: "guarita" },
                    { data: "elevador" },
                    { data: "portao" },
                    { data: "rampa" },
                    { data: "vigilancia" },
                    { data: "monitoramento" },
                    { data: "estacionamento" },
                    { data: "wifi"},
                    { data: "acoes" },
                ]
            });

            $('.btn-limpar').click(function (){
                $('input[name="nome_bloco"]').val('');
                $('select[name="setor"]').val('').trigger('change');
                $('select[name="local"]').val('').trigger('change');

                $('input[name="muro"]').prop("checked", false);
                $('input[name="guarita"]').prop("checked", false);
                $('input[name="elevador"]').prop("checked", false);
                $('input[name="portao"]').prop("checked", false);
                $('input[name="rampa"]').prop("checked", false);
                $('input[name="vigilancia"]').prop("checked", false);
                $('input[name="monitoramento"]').prop("checked", false);
                $('input[name="estacionamento"]').prop("checked", false);
                $('input[name="wifi"]').prop("checked", false);

                table.draw();
            })

            $('.btn-buscar').click(function (){
                table.draw();
            })
        });
    </script>
@endsection
