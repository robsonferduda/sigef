@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Locais
                        <span class="d-block text-muted pt-2 font-size-sm">Listagem de Locais</span></h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ url('local/novo') }}" class="btn btn-primary font-weight-bolder"><i class="fa fa-plus"></i> Novo</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form w-100">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Nome do Local</label>
                                    <input type="text" name="nome_local" id="nome" class="form-control" placeholder="Nome ou parte do nome"/>
                                </div>
                                <div class="col-md-4">
                                    <label for="select2">Estado</label>
                                    <select name="estado" class="form-control select2" required>
                                        <option value="">Selecione o Estado</option>
                                        @foreach($estados as $estado)
                                            <option value="{{ $estado->cd_estado_est }}">{{ $estado->nm_estado_est  }}</option>
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
                        <th>Estado</th>
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
                "order": [[ 1, "asc" ]],
                "bFilter": false,
                "ajax":{
                    "url": "{{ url('locais') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": function (d) {
                        d._token   =  "{{csrf_token()}}",
                        d.nome     = $('input[name="nome_local"]').val()
                        d.estado    = $('select[name="estado"]').val()
                    }
                },
                "columns": [
                    { data: "codigo", className: "center" },
                    { data: "local" },
                    { data: "estado" },
                    { data: "acoes" },
                ]
            });

            $('.btn-limpar').click(function (){
                $('input[name="nome_local"]').val('');
                $('select[name="estado"]').val('').trigger('change');
                table.draw();
            })

            $('.btn-buscar').click(function (){
                table.draw();
            })
        });
    </script>
@endsection
