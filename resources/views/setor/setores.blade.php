@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Setores
                        <span class="d-block text-muted pt-2 font-size-sm">Listagem de Setores</span></h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ url('setor/novo') }}" class="btn btn-primary font-weight-bolder"><i class="fa fa-plus"></i> Novo</a>
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
                                    <label>Nome do Setor</label>
                                    <input type="text" name="nome_setor" id="nome" class="form-control" placeholder="Nome ou parte do nome"/>
                                </div>
                                <div class="col-md-4">
                                    <label for="select2">Local</label>
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
                                <div class="col-md-4">
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
                        <th>Código Único</th>
                        <th>Local</th>
                        <th>Setor Abreviado</th>
                        <th>Setor</th>
                        <th>Rede de Ensino</th>
                        <th class="box-btn-acoes">Ações</th>
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

            $('#kt_datatable').on("click", '[data-toggle="popover"]', function (){
                if ($(this).prop('popShown') == undefined) {
                    $(this).prop('popShown', true).popover('show');
                }
            });

            var table = $('#kt_datatable').DataTable({
                "processing": true,
                "paginate": true,
                "serverSide": true,
                "order": [[ 2, "asc" ],[ 3, "asc" ]],
                "bFilter": false,
                "ajax":{
                    "url": "{{ url('setores') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": function (d) {
                        d._token   =  "{{csrf_token()}}",
                        d.nome     = $('input[name="nome_setor"]').val()
                        d.local    = $('select[name="local"]').val(),
                        d.rede     = $('select[name="rede"]').val()
                    }
                },
                "columns": [
                    { data: "codigo" },
                    { data: "codigo_unico" },
                    { data: "local" },
                    { data: "setor_abrev" },
                    { data: "setor" },
                    { data: "rede_ensino" },
                    { data: "acoes" },
                ]
            });

            $('.btn-limpar').click(function (){
                $('input[name="nome_setor"]').val('');
                $('select[name="local"]').val('').trigger('change');
                $('select[name="rede"]').val('').trigger('change');

                table.draw();
            })

            $('.btn-buscar').click(function (){
                table.draw();
            })


        });
    </script>
@endsection
