@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Local > Cadastro de Local de Prova
                        <span class="d-block text-muted pt-2 font-size-sm">Cadastro de Local de Prova</span></h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ url('locais') }}" class="btn btn-info font-weight-bolder"><i class="fas fa-table"></i> Locais</a>
                </div>
            </div>
            <form class="form" method="post" action="{{ url('local') }}" id="form_bloco">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @include('layouts.mensagens')
                        </div>
                            <div class="form-group col-sm-12">
                                <label for="select2">Estado <span class="text-danger">Obrigatório</span></label>
                                <select name="cd_estado_est" class="form-control select2" required>
                                    <option value="">Selecione o Estado</option>
                                    @foreach($estados as $estado)
                                        <option value="{{ $estado->cd_estado_est }}">{{ $estado->nm_estado_est  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Código <span class="text-danger">Obrigatório</span></label>
                                <input type="text" name="cd_local_prova_lop" class="form-control inteiro" required placeholder="Código"/>
                            </div>
                            <div class="form-group col-sm-10">
                                <label>Nome do Local <span class="text-danger">Obrigatório</span></label>
                                <input type="text" name="nm_local_prova_lop" class="form-control" required placeholder="Nome"/>
                            </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-light-success mr-2"><i class="fas fa-save"></i> Salvar</button>
                        <a href="{{ url('locais') }}" class="btn btn-light-danger"><i class="fas fa-times"></i> Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')   
    <script type="text/javascript">
        $(document).ready(function () {

            $('.select2').select2({
                dropdownPosition: 'below',
            });

            $(".inteiro").inputmask('integer',{min:1, max:1000});

        });
    </script>
@endsection