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
                <div class="col-md-12">
                    @include('layouts.mensagens')
                </div>
                <table class="table table-separate table-head-custom table-checkable dataTable no-footer" id="kt_datatable">
                    <thead>
                    <tr>
                        <th class="col col-1 text-center">Código</th>
                        <th>Estado</th>
                        <th>Local</th>
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

                    }
                },
                "columns": [
                    { data: "codigo", className: "center" },
                    { data: "estado" },
                    { data: "local" },
                    { data: "acoes" },
                ]
            });
        });
    </script>
@endsection
