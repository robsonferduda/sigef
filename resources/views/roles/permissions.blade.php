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
                <a href="{{ url('roles') }}" class="btn btn-success font-weight-bolder"><i class="fa fa-table"></i> Perfis</a>
            </div>
        </div>
        <div class="card-body">
            @include('layout.mensagens')
            {!! Form::open(['id' => 'form-add-permission', 'class' => 'form', 'method' => 'POST', 'url' => ['permissions-buscar', $role]]) !!}
            
                <h5><i class="fa fa-user-tag mb-1"></i> {{ $role->display_name }}</h5>
                <div class="form-group row mt-5">
                    <div class="col-lg-4">
                        <label for="cd_sistema_sis">Sistema <small class="text-danger">Campo obrigatório</small></label>
                        <select class="form-control" name="cd_sistema_sis" id="cd_sistema_sis">
                            <option value="">Selecione um sistema</option>
                            @foreach($sistemas as $s)
                                <option value="{{ $s->cd_sistema_sis }}">{{ $s->ds_sistema_sis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label for="cd_controle_con">Controle</label>
                        <select class="form-control" name="cd_controle_con" id="cd_controle_con">
                            <option>Selecione um controle</option>
                        </select>
                    </div>
                    <div class="col-lg-4 mt-8">
                        <button type="submit" class="btn btn-success mr-2"><i class="flaticon2-search-1"></i> Buscar</button>
                    </div>
                </div>
            {!! Form::close() !!}

            @php
                $ctrl = "";
            @endphp

            @if(Session::has('permissions'))
                @if(count(Session::get('permissions')))
                    <span class="text-primary mb-5"><i class="fa fa-check"></i> Marque as permissões que deseja adicionar e desmarque as que deseja remover</span>
                    <div class="mt-3">
                        {!! Form::open(['id' => 'basic-form', 'url' => ['role/permission', $role->id]]) !!}
                                                        
                            @foreach(Session::get('permissions') as $key => $p)
                                            
                                <label class="fancy-checkbox parsley-success">
                                    <input type="checkbox" name="permission[]" value="{{ $p->id }}" {{ (in_array($p->id, old('permission', [])) || isset($role) && $role->permissions->contains($p->id)) ? 'checked' : '' }}>
                                    <span>{{ $p->controle->ds_controle_con }} > {{ $p->display_name }} ({{ $p->name }})</span>
                                </label><br/>
                                        
                            @endforeach

                            <div class="mt-2">
                                <hr/>
                                <a href="{{ url('roles') }}" class="btn btn-danger" title="Cancelar"><i class="fa fa-times"></i> Cancelar</a>
                                <button type="submit" class="btn btn-success" title="Salvar"><i class="fa fa-save"></i> Salvar</button>
                            </div>
                                    
                        {!! Form::close() !!}
                    </div>
                @else
                    <span class="text-danger mb-5"><i class="fa fa-check"></i> Não existem permissões cadastradas para a busca</span>
                @endif
            @endif
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

    <script>
        $(function() {

            var host = document.location.origin;

            $("#cd_sistema_sis").change(function(){

                id = $(this).val();

                $.ajax({
                    url: host+"/perfil/api/controles/sistema/"+id,
                    type: 'GET',
                    dataType: "JSON",
                    success: function(response)
                    {          
                        $("#cd_controle_con").find('option').remove().end().append("<option>Selecione um Controle</option>");     
                        $.each(response, function(i, data) {
                            $("#cd_controle_con").append(new Option(data.ds_controle_con, data.cd_controle_con));
                        });    
                    },
                    error: function(response)
                    {
                    
                    }
                });

            });

            FormValidation.formValidation(
                document.getElementById('form-add-permission'),
                {
                    fields: {

                        cd_sistema_sis: {
                            validators: {
                            notEmpty: {
                            message: 'Campo obrigatório'
                            }
                            }
                        },                        
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap(),
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    },
                }
            );

        });
    </script>

@endsection