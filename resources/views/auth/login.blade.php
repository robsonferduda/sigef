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
								<h3>Acesso Restrito</h3>
								<div class="text-muted font-weight-bold">Utilize seu email e senha para entrar</div>
							</div>
							@include('layouts.mensagens')
                            <form method="POST" action="{{ route('login') }}" class="form" id="kt_login_signin_form">
                                @csrf
								<div class="form-group mb-5">
									<input class="form-control h-auto form-control-solid py-4 px-8" type="email" name="email" id="email" placeholder="Email" autocomplete="off" />
								</div>
								<div class="form-group mb-5">
									<input class="form-control h-auto form-control-solid py-4 px-8" type="password" name="password" id="password"  placeholder="Senha"/>
								</div>
								<div class="form-group d-flex flex-wrap justify-content-between align-items-center">
									<div class="checkbox-inline">
										<label class="checkbox m-0 text-muted">
										<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>
										<span></span>Lembrar-me</label>
									</div>
									<a href="javascript:;" id="kt_login_forgot" class="text-muted text-hover-primary">Esqueceu sua senha?</a>
								</div>
								<button id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4"><i class="fa fa-lock"></i> Entrar</button>
							</form>
						</div>
						
						<div class="login-forgot">
							<div class="mb-5">
								<h3>Esqueceu sua senha?</h3>
								<div class="text-muted font-weight-bold">Digite seu email para redefinir sua senha</div>
							</div>
                            <form method="POST" action="{{ route('password.email') }}" class="form" id="kt_login_forgot_form">
                                @csrf
								<div class="form-group mb-10">
									<input class="form-control form-control-solid h-auto py-4 px-8" type="text" placeholder="Email" name="email" autocomplete="off" />
								</div>
								<div class="form-group d-flex flex-wrap flex-center mt-10">
									<button id="kt_login_forgot_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Enviar</button>
									<button id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancelar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
@endsection