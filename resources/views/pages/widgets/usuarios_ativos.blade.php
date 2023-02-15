{{-- List Widget 3 --}}

<div class="card card-custom {{ @$class }}">
    {{-- Header --}}
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bolder text-dark">Acessos Recentes</h3>
        <div class="card-toolbar">
            <div class="dropdown dropdown-inline">
                <a href="#" class="btn btn-light-primary btn-sm font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Cadastrar
                </a>
                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                    {{-- Navigation --}}
                    <ul class="navi navi-hover">
                        <li class="navi-header">
                            <span class="text-primary text-uppercase font-weight-bold">NOVO</span>
                        </li>
                        <li class="navi-item">
                            <a href="{{ route('users.create') }}" class="navi-link">
                                <span class="navi-text"><i class="fa fa-user"></i> Usuário</span>
                            </a>
                        </li>
                        <li class="navi-item">
                            <a href="{{ route('roles.create') }}" class="navi-link">
                                <span class="navi-text"><i class="fas fa-user-tag"></i> Perfil</span>
                            </a>
                        </li>
                        <li class="navi-item">
                            <a href="{{ route('permissions.create') }}" class="navi-link">
                                <span class="navi-text"><i class="fa fa-lock"></i> Permissão</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Body --}}
    <div class="card-body pt-2">
        {{-- Item --}}
        @foreach($users as $user)
            @php
                $user = App\User::find($user->user_id);
            @endphp

            @if($user)
                <div class="d-flex align-items-center mb-2">
                    {{-- Symbol --}}
                    <div class="symbol symbol-40 symbol-light-success mr-5">
                        <span class="symbol-label">
                            @if($user->cd_sexo_sex == 'M')
                                <img src="{{ asset('media/svg/avatars/016-boy-7.svg') }}" class="h-75 align-self-end"/>
                            @elseif($user->cd_sexo_sex == 'F')
                                <img src="{{ asset('media/svg/avatars/019-girl-10.svg') }}" class="h-75 align-self-end"/>
                            @else
                                <img src="{{ asset('media/svg/avatars/indefinido.svg') }}" class="h-75 align-self-end"/>
                            @endif
                        </span>
                    </div>

                    
                        <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                            <a href="{{ route('users.show',$user->id) }}" class="text-dark text-hover-primary mb-1 font-size-lg">{{ $user->name }}</a>
                            <span class="text-muted">{{ ($user->departamento) ? $user->departamento->ds_departamento_dep : 'Sem vínculo' }}</span>
                        </div>
                    

                    {{-- Dropdown --}}
                    <div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" data-placement="left">
                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
                            {{-- Navigation--}}
                            <ul class="navi navi-hover">
                                <li class="navi-header font-weight-bold">
                                    Opções para {{ $user->name }}
                                    <i class="fa fa-cogs"></i>
                                </li>
                                <li class="navi-separator mt-3"></li>
                                <li class="navi-footer">
                                    <a class="btn btn-light-primary font-weight-bolder btn-sm" href="{{ route('users_permissions', $user->id) }}"><i class="fa fa-lock"></i> Permissões</a>
                                    <a class="btn btn-light-primary font-weight-bolder btn-sm" href="{{ route('users.edit', $user->id) }}"><i class="fa fa-edit"></i> Editar</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
