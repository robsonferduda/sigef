@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Eventos
                    <span class="d-block text-muted pt-2 font-size-sm">Listagem de Eventos do Espaço Físico</span></h3>
                </div>
                <div class="card-toolbar">                   
                    <a href="{{ url('evento/create') }}" class="btn btn-primary font-weight-bolder"><i class="fa fa-plus"></i> Novo</a>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    @include('layouts.mensagens')
                </div>
                <table class="table table-separate table-head-custom table-checkable dataTable no-footer" id="kt_datatable">
                    <thead>
                        <tr>
                            <th class="center">Código SIGEF</th>
                            <th class="center">Código Evento</th>
                            <th class="center">Ano</th>
                            <th>Tipo</th>
                            <th>Evento</th>
                            <th class="center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($eventos as $evento)
                            <tr>
                                <td class="center">{{ $evento->cd_evento_eef }}</td>
                                <td class="center">{{ $evento->cd_evento_eve }}</td>
                                <td class="center">{{ $evento->nu_ano_eef }}</td>
                                <td>{{ $evento->tipo->nm_tipo_evento_tie }}</td>
                                <td>{{ $evento->nm_evento_eef }}</td>
                                <td class="center">
                                    <a title="Trocar Evento" class="btn btn-sm btn-clean btn-icon" href="{{ url('usuario/perfil/'.$evento->cd_evento_eef) }}"><i class="fa fa-check"></i></a>
                                    <a title="Editar" class="btn btn-sm btn-clean btn-icon" href="{{ route('evento.edit',$evento->cd_evento_eef) }}"><i class="fa fa-edit"></i></a>
                                    
                                    <form class="inline" style="display: inline;" action="{{ route('evento.destroy',$evento->cd_evento_eef) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-clean btn-icon btn-frm-excluir" title="Delete">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </form> 
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
         
        });
    </script>
@endsection