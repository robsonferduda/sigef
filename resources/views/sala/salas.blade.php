@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Salas
                        <span class="d-block text-muted pt-2 font-size-sm">Listagem de Salas</span></h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ url('sala/novo') }}" class="btn btn-primary font-weight-bolder"><i class="fa fa-plus"></i> Novo</a>
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
                                    <select name="setor" disabled class="form-control select2 select2-hidden-accessible setor" style="width: 100%;" tabindex="-1" aria-hidden="true" id="setor">
                                        <option value="">Selecione o setor</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="select2">Bloco</label>
                                    <select name="bloco" disabled class="form-control select2 select2-hidden-accessible bloco" style="width: 100%;" tabindex="-1" aria-hidden="true" id="bloco">
                                        <option value="">Selecione o bloco</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="select2">Pavimento</label>
                                    <select name="pavimento" disabled class="form-control select2 select2-hidden-accessible pavimento" style="width: 100%;" tabindex="-1" aria-hidden="true" id="pavimento">
                                        <option value="">Selecione o pavimento</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Nome da Sala</label>
                                    <input type="text" name="nome_sala" id="nome" class="form-control" placeholder="Nome ou parte do nome"/>
                                </div>
                                <div class="col-md-4">
                                    <label for="select2">Tipo de Carteira</label>
                                    <select name="tipo_carteira" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="tipo_carteira">
                                        <option value="">Selecione o Tipo de Carteira</option>
                                        @foreach($tiposCarteira as $tipo)
                                            <option value="{{ $tipo->cd_tipo_carteira_tic }}">{{ $tipo->nm_tipo_tic }}</option>
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
                <div class="col-md-12">
                    @include('layouts.mensagens')
                </div>
                <table class="table table-separate table-head-custom table-checkable dataTable no-footer" id="kt_datatable">
                    <thead>
                    <tr>
                        <th class="col col-1 text-center">Código</th>
                        <th>Local</th>
                        <th>Setor</th>
                        <th>Bloco</th>
                        <th>Pavimento</th>
                        <th>Sala</th>
                        <th>Tipo Carteira</th>
                        <th>Nº Carteiras</th>
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

            var table = $('#kt_datatable').DataTable({
                "processing": true,
                "paginate": false,
                "serverSide": true,
                "order": [[ 1, "asc" ],[ 2, "asc" ],[ 3, "asc" ],[ 3, "asc" ], [ 4, "asc" ],[ 5, "asc" ]],
                "bFilter": false,
                "ajax":{
                    "url": "{{ url('salas') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": function (d) {
                        d._token   =  "{{csrf_token()}}";
                        d.nome     =  $('input[name="nome_sala"]').val();
                        d.setor    = $('select[name="setor"]').val();
                        d.bloco    = $('select[name="bloco"]').val();
                        d.pavimento    = $('select[name="pavimento"]').val();
                        d.local    = $('select[name="local"]').val();
                        d.tipo_carteira = $('select[name="tipo_carteira"]').val();
                    }
                },
                "columns": [
                    { data: "codigo", className: "center" },
                    { data: "local" },
                    { data: "setor" },
                    { data: "bloco" },
                    { data: "pavimento" },
                    { data: "sala" },
                    { data: "tipo_carteira" },
                    { data: "numero_carteiras" },
                    { data: "acoes" },
                ]
            });

            $('.btn-limpar').click(function (){
                $('input[name="nome_sala"]').val('');
                $('select[name="local"]').val('').trigger('change');
                $('select[name="setor"]').val('').trigger('change');
                $('select[name="bloco"]').val('').trigger('change');
                $('select[name="pavimento"]').val('').trigger('change');
                $('select[name="tipo_carteira"]').val('').trigger('change');
                table.draw();
            });

            $('.btn-buscar').click(function (){
                table.draw();
            });
        });
    </script>
@endsection
