@extends('layout.default')

@section('content')
        <div class="row">

            <div class="col-lg-4 col-xxl-4 order-1 order-xxl-1">
                @include('pages.widgets.grafico_atividades', ['class' => 'card-stretch gutter-b'])
            </div>
            
            <div class="col-lg-8 col-xxl-8 order-2 order-xxl-2">
                @include('pages.widgets.atividades_recentes_perfil', ['class' => 'card-stretch gutter-b'])
            </div>

            @role('administrador|super-user') 
                <div class="col-lg-4 col-xxl-4 order-3 order-xxl-3">
                    @include('pages.widgets.usuarios_ativos', ['class' => 'card-stretch gutter-b'])
                </div>
            @endrole

            @role('administrador|super-user')  
                <div class="col-lg-8 col-xxl-8 order-4 order-xxl-4">
                    @include('pages.widgets.atividades_recentes', ['class' => 'card-stretch gutter-b'])
                </div>
            @endrole

        </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
@endsection