@extends('layout.default')
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Cadastrar Perfil
                    <div class="text-muted pt-2 font-size-sm">Cadastro de perfis de usuários do sistema</div>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ url('roles') }}" class="btn btn-success font-weight-bolder"><i class="fa fa-table"></i> Perfis</a>
            </div>
        </div>
        {!! Form::open(['id' => 'basic-form', 'class' => 'form', 'url' => 'roles']) !!}
            <div class="card-body">
                @include('layout.mensagens')
                <div class="form-group row">
                    <div class="col-lg-3">
                        <label for="display_name">Perfil</label>
                        <input type="text" name="display_name" id="display_name" class="form-control" placeholder="Perfil"/>
                        <span class="form-text text-muted">Digite o nome do perfil</span>
                    </div>
                    <div class="col-lg-3">
                        <label for="name">Identificador</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Chave"/>
                        <span class="form-text text-muted">Digite um identificador textual único</span>
                    </div>
                    <div class="col-lg-6">
                        <label for="description">Descrição</label>
                        <input type="text" name="description" id="description" class="form-control" placeholder="Descrição"/>
                        <span class="form-text text-muted">Descrição das atribuições do perfil</span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-8">
                        <button type="submit" class="btn btn-success mr-2"><i class="fa fa-save"></i> Salvar</button>
                        <button type="reset" class="btn btn-danger"><i class="fa fa-times"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        {!! Form::close() !!} 
    </div>
@endsection

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection


{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    {{-- page scripts --}}
    <script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
@endsection
