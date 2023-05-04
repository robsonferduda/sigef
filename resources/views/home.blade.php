@extends('layouts.app')
@section('content')
<div class="row mb-3">
    
    <div class="col-lg-4">
        <div class="card card-custom wave wave-danger mb-8 mb-lg-0">
            <div class="card-body">
                <div class="d-flex align-items-center p-5">
                    <div class="mr-6">
                        <i class="fas fa-map-marker fa-3x text-danger"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <a href="{{ url('evento/locais') }}" class="text-dark text-hover-danger font-weight-bold font-size-h4 mb-3">Locais</a>
                        <div class="text-dark-75">{{ $total_locais }} Locais Selecionados</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card card-custom wave wave-primary mb-8 mb-lg-0">
            <div class="card-body">
                <div class="d-flex align-items-center p-5">
                    <div class="mr-6">
                        <i class="fas fa-building fa-3x text-primary"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <a href="{{ url('evento/setores') }}" class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">Setores</a>
                        <div class="text-dark-75">{{ $total_setores }} Setores Selecionados</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-custom wave wave-success mb-8 mb-lg-0">
            <div class="card-body">
                <div class="d-flex align-items-center p-5">
                    <div class="mr-6">
                        <i class="fas fa-users fa-3x text-success"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <a href="{{ url('grupos') }}" class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">Grupos</a>
                        <div class="text-dark-75">{{ $total_grupos }} Grupos Utilizados</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection