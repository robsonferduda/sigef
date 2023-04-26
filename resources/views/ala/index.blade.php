@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Alas
                    <span class="d-block text-muted pt-2 font-size-sm">Listagem de Alas do Espaço Físico</span></h3>
                </div>
                <div class="card-toolbar">                   
                    <a href="{{ url('ala/create') }}" class="btn btn-primary font-weight-bolder"><i class="fa fa-plus"></i> Novo</a>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    @include('layouts.mensagens')
                </div>
                <div class="row">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <input type="hidden" value="{{ (Session::get('id_local')) ? Session::get('id_local') : "0" }}" id="local_session">
                                <label for="select2">Local <span class="text-warning">Selecione para habilitar o setor</span></label>
                                <select name="setor" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="local">
                                    <option value="0">Selecione o local</option>
                                    @foreach($locais as $local)
                                        <option value="{{ $local->cd_local_prova_lop }}" {{ ( Session::get('id_local') == $local->cd_local_prova_lop) ? 'selected' : '' }}>{{ $local->nm_local_prova_lop }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="select2">Setor <span class="text-danger">Obrigatório</span></label>
                                <select name="setor" disabled class="form-control select2 select2-hidden-accessible mostra-salas" style="width: 100%;" tabindex="-1" aria-hidden="true" id="setor">
                                    <option value="">Selecione o setor</option>
                                    @foreach($setores as $setor)
                                        <option value="{{ $setor->cd_setor_set }}">{{ $setor->nm_abrev_setor_set }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary btn-buscar" style="margin-top: 25px;"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-separate table-head-custom table-checkable dataTable no-footer" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>Local</th>
                        <th>Setor</th>
                        <th>Ala</th>
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

            $('.btn-buscar').click(function (){
                table.draw();
            })

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

            });

            var table = $('#kt_datatable').DataTable({
                "processing": true,
                "paginate": true,
                "serverSide": true,
                "order": [[ 0, "asc" ],[ 2, "asc" ]],
                "bFilter": false,
                "ajax":{
                    "url": "{{ url('alas') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": function (d) {
                        d._token   =  "{{csrf_token()}}",
                        d.local    = $('select[name="local"]').val(),
                        d.setor    = $('select[name="setor"]').val()
                    }
                },
                "columns": [
                    { data: "local" },
                    { data: "setor" },
                    { data: "ala" },
                    { data: "acoes" },
                ]
            });
         
        });
    </script>
@endsection