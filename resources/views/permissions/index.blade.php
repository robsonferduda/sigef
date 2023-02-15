@extends('layout.default')
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Permissões
                    <div class="text-muted pt-2 font-size-sm">Permissões de usuários do sistema</div>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('permissions.create') }}" class="btn btn-success font-weight-bolder"><i class="fa fa-plus"></i> Cadastrar</a>
            </div>
        </div>

        <div class="card-body">
            @include('layout.mensagens')
            <table class="table table-separate table-head-custom table-checkable table-hover no-footer dtr-inline" id="kt_datatable">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Sistema</th>
                        <th>Controle</th>
                        <th>Permissão</th>
                        <th>Chave</th>
                        <th>Descrição</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ ($p->sistema) ? $p->sistema->ds_sistema_sis : 'Não cadastrado' }}</td>
                        <td>{{ ($p->controle) ? $p->controle->ds_controle_con : 'Não cadastrado' }}</td>
                        <td>{{ $p->display_name }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->description }}</td>
                        <td class="text-center">
                            <a title="Editar" class="btn btn-sm btn-clean btn-icon" href="{{ route('permissions.edit',$p->id) }}"><i class="fa fa-edit"></i></a>
                            <form class="form-delete" style="display: inline;" action="{{ route('permissions.destroy',$p->id) }}" method="POST">
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
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
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