@extends('layout.default')
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Usuários
                    <div class="text-muted pt-2 font-size-sm">Listagem de usuários do sistema </div>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('users.create') }}" class="btn btn-success font-weight-bolder"><i class="fa fa-plus"></i> Cadastrar</a>
            </div>
        </div>

        <div class="card-body">

            <!--begin::Search Form-->
            <div class="mt-2 mb-5 mt-lg-5 mb-lg-10">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="input">
                                    <input type="text" class="form-control" placeholder="Nome"/>
                                </div>
                            </div>

                            <div class="col-md-4 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <select class="form-control" id="kt_datatable_search_status">
                                        <option value="">Perfil</option>
                                        <option value="1">Pending</option>
                                        <option value="2">Delivered</option>
                                        <option value="3">Canceled</option>
                                        <option value="4">Success</option>
                                        <option value="5">Info</option>
                                        <option value="6">Danger</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <select class="form-control" id="kt_datatable_search_type">
                                        <option value="">Departamento</option>
                                        <option value="1">Online</option>
                                        <option value="2">Retail</option>
                                        <option value="3">Direct</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
                        <a href="#" class="btn btn-light-primary px-6 font-weight-bold">
                            <i class="flaticon2-search-1"></i> Buscar
                        </a>
                    </div>
                </div>
            </div>

			<div class="example-preview">
				<button type="button" class="btn btn-light-primary font-weight-bold" id="alerta">Show me</button>
			</div>
													
            <table class="table table-separate table-head-custom table-checkable dataTable no-footer dtr-inline" id="kt_datatable" role="grid" aria-describedby="kt_datatable_info">
                <thead>
                <tr>
                    <th>Record ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Perfil</th>
                    <th>Situação</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                                <tr data-status="@foreach($user->roles as $role) {{trim($role->name)}} @endforeach">
                                    <td class="text-center">{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @forelse($user->roles as $role)
                                            <span class="badge badge-primary" style="background: ">{{ $role->display_name }}</span>
                                        @empty
                                            Nenhum perfil associado
                                        @endforelse
                                    </td>
                                    <td>
                                        @if($user->fl_active == 'S')
                                            <span class="label label-lg font-weight-bold label-light-primary label-inline">ATIVO</span>
                                        @else
                                            <span class="label label-lg font-weight-bold label-light-danger label-inline">INATIVO</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a title="Permissões" class="btn btn-sm btn-clean btn-icon" href="{{ url('users/permissions/'.$user->id) }}"><i class="fa fa-lock"></i></a>
                                        <a title="Perfis" class="btn btn-sm btn-clean btn-icon" href="{{ url('usuario/perfil/'.$user->id) }}"><i class="fa fa-user"></i></a>
                                        <a title="Editar" class="btn btn-sm btn-clean btn-icon" href="{{ route('users.edit',$user->id) }}"><i class="fa fa-edit"></i></a>
                                        
                                        <form class="inline" style="display: inline;" action="{{ route('users.destroy',$user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-clean btn-icon btn-excluir" title="Delete">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </form>                                        
                                    </td>
                                </tr>  
                    @empty
                        <tr>
                            <td colspan="4">Nenhum usuário cadastrado</td>
                        </tr>
                    @endforelse     
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
    <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
@endsection
