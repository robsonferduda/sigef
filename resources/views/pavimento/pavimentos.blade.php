@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Pavimentos
                        <span class="d-block text-muted pt-2 font-size-sm">Listagem de Pavimentos</span></h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ url('pavimento/novo') }}" class="btn btn-primary font-weight-bolder"><i class="fa fa-plus"></i> Novo</a>
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
                                    <label>Nome do Pavimento</label>
                                    <input type="text" name="nome_pavimento" id="nome" class="form-control" placeholder="Nome ou parte do nome"/>
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
                                    <select name="setor" disabled class="form-control select2 select2-hidden-accessible setor" style="width: 100%;" tabindex="-1" aria-hidden="true" id="setor">
                                        <option value="">Selecione o setor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="select2">Bloco</label>
                                    <select name="bloco" disabled class="form-control select2 select2-hidden-accessible bloco" style="width: 100%;" tabindex="-1" aria-hidden="true" id="bloco">
                                        <option value="">Selecione o bloco</option>
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
                "paginate": true,
                "serverSide": true,
                "order": [[ 1, "asc" ],[ 2, "asc" ],[ 3, "asc" ],[ 4, "asc" ]],
                "bFilter": false,
                "ajax":{
                    "url": "{{ url('pavimentos') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": function (d) {
                        d._token   =  "{{csrf_token()}}";
                        d.nome     =  $('input[name="nome_pavimento"]').val();
                        d.local    = $('select[name="local"]').val();
                        d.setor    = $('select[name="setor"]').val();
                        d.bloco    = $('select[name="bloco"]').val();
                    }
                },
                "columns": [
                    { data: "codigo", className: "center" },
                    { data: "local" },
                    { data: "setor" },
                    { data: "bloco" },
                    { data: "pavimento" },
                    { data: "acoes" },
                ]
            });

            $('.btn-limpar').click(function (){
                $('input[name="nome_pavimento"]').val('');
                $('select[name="local"]').val('').trigger('change');
                $('select[name="setor"]').val('').trigger('change');
                $('select[name="bloco"]').val('').trigger('change');
                table.draw();
            });

            $('.btn-buscar').click(function (){
                table.draw();
            });
        });
    </script>
@endsection
