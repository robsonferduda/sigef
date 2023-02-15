@extends('layout.default')
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Cadastrar Usuário
                    <div class="text-muted pt-2 font-size-sm">Cadastro de usuários do sistema</div>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ url('users') }}" class="btn btn-success font-weight-bolder"><i class="fa fa-table"></i> Usuários</a>
            </div>
        </div>

        {!! Form::open(['id' => 'basic-form', 'class' => 'form', 'url' => 'users']) !!}
            <div class="card-body">
                @include('layout.mensagens')
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label for="name">Nome</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nome completo"/>
                        <span class="form-text text-muted">Digite o nome completo</span>
                    </div>
                    <div class="col-lg-4">
                        <label for="email_preview">Email</label>
                        <input type="email" name="email_preview" id="email_preview" class="form-control" placeholder="Email preferencial"/>
                        <span class="form-text text-muted">Digite o email preferencial</span>
                    </div>
                    <div class="col-lg-4">
                        <label for="email">Confirmação de Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email preferencial"/>
                        <span class="form-text text-muted">Repita o email preferencial</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label for="cpf">CPF</label>
                        <input type="text" name="cpf" id="cpf" class="form-control" placeholder="Nome completo"/>
                        <span class="form-text text-muted">CPF</span>
                    </div>
                    <div class="col-lg-4">
                        <label for="password_preview">Senha</label>
                        <input type="password" name="password_preview" id="password_preview" class="form-control" placeholder="Senha"/>
                        <span class="form-text text-muted">Digite a senha</span>
                    </div>
                    <div class="col-lg-4">
                        <label for="email">Confirmação de Senha</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Confirme a senha"/>
                        <span class="form-text text-muted">Confirmação de senha</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="cd_departamento_dep">Departamento</label>
                            <select class="form-control" name="cd_departamento_dep" id="cd_departamento_dep">
                                <option value="0">Selecione um departamento</option>
                                @foreach($dptos as $d)
                                    <option value="{{ $d->cd_departamento_dep }}">{{ $d->ds_departamento_dep }}</option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted">Departamento de lotação</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="cd_funcao_fun">Função</label>
                            <select class="form-control" name="cd_funcao_fun" id="cd_funcao_fun">
                                <option value="0">Selecione uma função</option>
                                @foreach($funcoes as $f)
                                    <option value="{{ $f->cd_funcao_fun }}">{{ $f->ds_funcao_fun }}</option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted">Função que exerce no departamento</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="role">Perfil</label>
                            <select class="form-control" name="role" id="role">
                                <option value="0">Selecione um perfil</option>
                                @foreach($perfis as $p)
                                    <option value="{{ $p->id }}">{{ $p->display_name }}</option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted">Perfil de acesso e permissões</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="cd_sexo_sex">Sexo</label>
                            <select class="form-control" name="cd_sexo_sex" id="cd_sexo_sex">
                                <option value="0">Selecione um sexo</option>
                                <option value="F">Feminino</option>
                                <option value="M">Masculino</option>
                            </select>
                            <span class="form-text text-muted">Perfil de acesso e permissões</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Situação</label>
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    <input type="checkbox" name="fl_active" value="S"/>
                                    <span></span>
                                    Usuário Ativo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-8">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
                        <button type="reset" class="btn btn-warning"><i class="fa fa-times"></i> Limpar</button>
                        <a href="{{ url('users') }}" class="btn btn-danger"><i class="fa fa-times"></i> Cancelar</a>
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
