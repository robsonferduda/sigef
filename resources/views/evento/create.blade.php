@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Eventos > Cadastro de Evento
                    <span class="d-block text-muted pt-2 font-size-sm">Cadastro de Eventos</span></h3>
                </div>
                <div class="card-toolbar">                   
                    <a href="{{ url('eventos') }}" class="btn btn-info font-weight-bolder"><i class="fas fa-table"></i> Eventos</a>
                </div>
            </div>
            <div class="card-body">
                <form class="form" method="post" action="{{ url('evento') }}" id="form_bloco">
                    @csrf                    
                    <div class="row">
                        <div class="col-md-12">
                            @include('layouts.mensagens')
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="select2">Tipo de Evento <span class="text-danger">Obrigatório</span></label>
                            <select name="cd_tipo_evento_tie" class="form-control select2" required>
                                <option value="">Tipo de Evento</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->cd_tipo_evento_tie }}">{{ $tipo->nm_tipo_evento_tie  }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Ano <span class="text-danger">Obrigatório</span></label>
                            <input type="text" name="nu_ano_eef" class="form-control inteiro" required placeholder="Ano"/>
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Código <span class="text-danger">Obrigatório</span></label>
                            <input type="text" name="cd_evento_eve" class="form-control inteiro" required placeholder="Código"/>
                        </div>
                        <div class="form-group col-sm-8">
                            <label>Nome do Evento <span class="text-danger">Obrigatório</span></label>
                            <input type="text" name="nm_evento_eef" class="form-control" required placeholder="Nome do Evento"/>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-light-success mr-2"><i class="fas fa-save"></i> Salvar</button>
                        <a href="{{ url('locais') }}" class="btn btn-light-danger"><i class="fas fa-times"></i> Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')   
    <script type="text/javascript">
        $(document).ready(function () {

            $('.select2').select2({
                dropdownPosition: 'below',
            });

        });
    </script>
@endsection