@extends('layout.default')
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Perfis
                    <div class="text-muted pt-2 font-size-sm">Perfis de usuários do sistema</div>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('roles.create') }}" class="btn btn-success font-weight-bolder"><i class="fa fa-plus"></i> Cadastrar</a>
            </div>
        </div>

        <div class="card-body">
            @include('layout.mensagens')
            <table class="table table-separate table-head-custom table-checkable table-hover no-footer dtr-inline" id="kt_datatable">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Perfil</th>
                        <th>Chave</th>
                        <th>Descrição</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->display_name }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->description }}</td>
                        <td class="text-center">
                            <a title="Perfil {{ $role->display_name }}" class="btn btn-sm btn-clean btn-icon" href="{{ url('roles/'.$role->id) }}"><i class="fa fa-user-tag"></i></a>
                            <a title="Permissões" class="btn btn-sm btn-clean btn-icon" href="{{ url('role/permissions/'.$role->id) }}"><i class="fa fa-lock"></i></a>
                            <a title="Editar" class="btn btn-sm btn-clean btn-icon" href="{{ route('roles.edit',$role->id) }}"><i class="fa fa-edit"></i></a>

                            <form class="form-delete" style="display: inline;" action="{{ route('roles.destroy',$role->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-clean btn-icon button-remove" title="Delete">
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
@endsection

{{-- Styles Section --}}
@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" type="text/css"/>
@endsection


{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    {{-- page scripts --}}
    <script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/features/miscellaneous/sweetalert2.js') }}"></script>

    <script>
        $(function() {
            
            $('body').on("click", ".button-remove", function(e) {
                e.preventDefault();
                var form = $(this).closest("form");
                Swal.fire({
                    title: "Tem certeza que deseja excluir?",
                    text: "Você não poderá recuperar o registro excluído",
                    type: "warning",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#28a745",
                    confirmButtonText: "Sim, excluir!",
                    cancelButtonText: "Cancelar"
                }).then(function(result) {
                    if (result.value) {
                        form.submit();
                    }
                });
            });

        });
    </script>
@endsection