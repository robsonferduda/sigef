@extends('layouts.guest')

@section('content')
<div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
				<div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url({{ asset('media/bg/bg-3.jpg') }});">
					<div class="login-form text-center p-7 position-relative overflow-hidden">
						<!--begin::Login Header-->
						<div class="d-flex flex-center mb-15">
							<a href="#">
								<img src="{{ asset('media/logos/coperve.png') }}" class="max-h-100px" alt="" />
							</a>
						</div>
						<!--end::Login Header-->
						<!--begin::Login Sign in form-->
						<div class="login-signin">
							<div class="mb-5">
								<h3>Atualização de Senha</h3>
								<div class="text-muted font-weight-bold">Preencha os campos abaixo e clique em "Atualizar Senha"</div>
							</div>
							@include('layout.mensagens')
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

								<div class="form-group mb-5">
									<span class="mb-2 text-info">A senha informada deve ter no mínimo 8 caracteres, podendo ser letras, números ou caracteres especiais</span>
								</div>

								<div class="form-group mb-5">
									<input class="form-control h-auto form-control-solid py-4 px-8" visible="false" type="email" name="email" id="email" value="{{ $email ?? old('email') }}" placeholder="Email" required autocomplete="off" autofocus/>
								</div>

								<div class="form-group mb-5">
									<input class="form-control h-auto form-control-solid py-4 px-8" type="password" name="password" id="password" required placeholder="Senha"/>
								</div>
								
                                <div class="form-group mb-5">
									<input class="form-control h-auto form-control-solid py-4 px-8" type="password" name="password_confirmation" id="password_confirmation" required  placeholder="Confirmação de Senha"/>
								</div>
								
								<button id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Atualizar Senha</button>
							</form>
						</div>
					</div>
				</div>
			</div>
@endsection