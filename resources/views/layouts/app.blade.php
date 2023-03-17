<!DOCTYPE html>
<html lang="pt-br">
	<head><base href="">
		<meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ env('APP_URL') }}">
		<title>SIGEF</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="stylesheet" type="text/css" href="{{ asset('fonts/css.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.bundle.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/layout/header/base/light.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/layout/header/menu/light.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/layout/brand/dark.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/layout/aside/dark.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.loader.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}" />
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
	</head>
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
			<a href="{{ url("/") }}">

			</a>
			<div class="d-flex align-items-center">
				<button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
					<span></span>
				</button>
				<button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
					<span></span>
				</button>
				<button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg>
					</span>
				</button>
			</div>
		</div>
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">
				<!--begin::Aside-->
				<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
					<!--begin::Brand-->
					<div class="brand flex-column-auto" id="kt_brand">
						<!--begin::Logo-->
						<a href="{{ url("/") }}" class="brand-logo">
							<img alt="Logo Coperve" src="{{ asset('media/logos/logo-light.png') }}" />
						</a>
						<!--end::Logo-->
						<!--begin::Toggle-->
						<button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
							<span class="svg-icon svg-icon svg-icon-xl">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24" />
										<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
										<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
									</g>
								</svg>
								<!--end::Svg Icon-->
							</span>
						</button>
						<!--end::Toolbar-->
					</div>
					<!--end::Brand-->
					<!--begin::Aside Menu-->
					<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
						<!--begin::Menu Container-->
						<div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
							<!--begin::Menu Nav-->
							<ul class="menu-nav">
                                <li class="menu-item {{ (Session::get('menu_pai') == 'dashboard') ? 'menu-item-open' : '' }}" aria-haspopup="true">
                                    <a href="{{ url('/') }}" class="menu-link">
                                        <span class="svg-icon menu-icon">
                                            <i class="fas fa-chart-pie"></i>
                                        </span>
                                        <span class="menu-text">Dashboard</span>
                                    </a>
                                </li>
								<li class="menu-section">
									<h4 class="menu-text">ESPAÇO FÍSICO</h4>
									<i class="menu-icon ki ki-bold-more-hor icon-md"></i>
								</li>
								<li class="menu-item {{ (Session::get('menu_pai') == 'local') ? 'menu-item-open' : '' }}" aria-haspopup="true">
                                    <a href="javascript:;"  class="menu-link menu-toggle">
                                        <span class="svg-icon menu-icon">
                                            <i class="fas fa-map-marker"></i>
                                        </span>
                                        <span class="menu-text">Local</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item {{ (Session::get('menu_item') == 'locais') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                                <a href="{{ url('locais') }}" class="menu-link">
                                                    <i class="menu-bullet menu-bullet-line">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Listar</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
								<li class="menu-item menu-item-submenu {{ (Session::get('menu_pai') == 'setor') ? 'menu-item-open' : '' }}" aria-haspopup="true">
									<a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<i class="fas fa-building"></i>
										</span>
										<span class="menu-text">Setor</span>
										<i class="menu-arrow"></i>
									</a>
									<div class="menu-submenu">
										<i class="menu-arrow"></i>
										<ul class="menu-subnav">
											<li class="menu-item {{ (Session::get('menu_item') == 'setores') ? 'menu-item-active' : '' }}" aria-haspopup="true">
												<a href="{{ url('setores') }}" class="menu-link">
													<i class="menu-bullet menu-bullet-line">
														<span></span>
													</i>
													<span class="menu-text">Setores</span>
												</a>
											</li>
                                            <li class="menu-item {{ (Session::get('menu_item') == 'blocos') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                                <a href="{{ url('blocos') }}" class="menu-link">
                                                    <i class="menu-bullet menu-bullet-line">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Blocos</span>
                                                </a>
                                            </li>
                                            <li class="menu-item {{ (Session::get('menu_item') == 'pavimentos') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                                <a href="{{ url('pavimentos') }}" class="menu-link">
                                                    <i class="menu-bullet menu-bullet-line">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Pavimentos</span>
                                                </a>
                                            </li>
                                            <li class="menu-item {{ (Session::get('menu_item') == 'salas') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                                <a href="{{ url('salas') }}" class="menu-link">
                                                    <i class="menu-bullet menu-bullet-line">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Salas</span>
                                                </a>
                                            </li>
										</ul>
									</div>
								</li>
								<li class="menu-section">
									<h4 class="menu-text">ESPAÇO ALOCADO</h4>
									<i class="menu-icon ki ki-bold-more-hor icon-md"></i>
								</li>
								<li class="menu-item {{ (Session::get('menu_pai') == 'local') ? 'menu-item-open' : '' }}" aria-haspopup="true">
                                    <a href="{{ url('eventos') }}"  class="menu-link menu-toggle">
                                        <span class="svg-icon menu-icon">
                                            <i class="fas fa-ticket-alt"></i>
                                        </span>
                                        <span class="menu-text">Eventos</span>
                                    </a>
                                </li>
								<li class="menu-item {{ (Session::get('menu_pai') == 'local') ? 'menu-item-open' : '' }}" aria-haspopup="true">
                                    <a href="{{ url('evento/locais') }}"  class="menu-link menu-toggle">
                                        <span class="svg-icon menu-icon">
                                            <i class="fas fa-map-marker"></i>
                                        </span>
                                        <span class="menu-text">Locais</span>
                                    </a>                                   
                                </li>
								<li class="menu-item {{ (Session::get('menu_pai') == 'local') ? 'menu-item-open' : '' }}" aria-haspopup="true">
                                    <a href="{{ url('evento/setores') }}"  class="menu-link menu-toggle">
                                        <span class="svg-icon menu-icon">
                                            <i class="fas fa-building"></i>
                                        </span>
                                        <span class="menu-text">Setores</span>
                                    </a>
                                </li>
								<li class="menu-item {{ (Session::get('menu_pai') == 'local') ? 'menu-item-open' : '' }}" aria-haspopup="true">
                                    <a href="{{ url('alas') }}"  class="menu-link menu-toggle">
                                        <span class="svg-icon menu-icon">
                                            <i class="fas fa-list-alt"></i>
                                        </span>
                                        <span class="menu-text">Alas</span>
                                    </a>
                                </li>
								<li class="menu-item {{ (Session::get('menu_pai') == 'local') ? 'menu-item-open' : '' }}" aria-haspopup="true">
                                    <a href="{{ url('grupo/evento') }}"  class="menu-link menu-toggle">
                                        <span class="svg-icon menu-icon">
                                            <i class="fas fa-users"></i>
                                        </span>
                                        <span class="menu-text">Grupos</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu" aria-haspopup="true">
                                    <a href="{{ route('logout') }}" class="menu-link menu-toggle" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <span class="svg-icon menu-icon">
                                            <i class="fas fa-power-off"></i>
                                        </span>
                                        <span class="menu-text">Sair</span>
                                    </a>
                                </li>
							</ul>
							<!--end::Menu Nav-->
						</div>
						<!--end::Menu Container-->
					</div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
					<!--end::Aside Menu-->
				</div>
				<!--end::Aside-->
				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header header-fixed">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between">
							<!--begin::Header Menu Wrapper-->
							<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
								<h6 class="mt-5 py-3">Sistema de Gerenciamento do Espaço Físico > {{ Session::get('evento_cod') }} - {{ Session::get('evento_nome') }}
                                    <span class="reload_evento" data-toggle="modal" data-target="#alterar-evento"><i class="fas fa-sync-alt text-primary"></i></span>
                                </h6>
							</div>
							<!--end::Header Menu Wrapper-->
							<!--begin::Topbar-->
							<div class="topbar">
                                @permission('sigeve-topo-cursos')
                                    <div class="topbar-item">
                                        <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
                                            <a href="{{ url('cursos/dashboard') }}">
                                                <i class="fas fa-university text-primary mt-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endpermission
                                @permission('sigeve-topo-dashboard')
                                    <div class="topbar-item">
                                        <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
                                            <a href="{{ url('painel') }}">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                            <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5"></rect>
                                                            <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5"></rect>
                                                            <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5"></rect>
                                                            <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5"></rect>
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                @endpermission

                                    <div class="topbar-item">
                                        <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1" id="kt_quick_cart_toggle">
                                            <a title="Sair" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Electric\Shutdown.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M7.62302337,5.30262097 C8.08508802,5.000107 8.70490146,5.12944838 9.00741543,5.59151303 C9.3099294,6.05357769 9.18058801,6.67339112 8.71852336,6.97590509 C7.03468892,8.07831239 6,9.95030239 6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,9.99549229 17.0108275,8.15969002 15.3875704,7.04698597 C14.9320347,6.73472706 14.8158858,6.11230651 15.1281448,5.65677076 C15.4404037,5.20123501 16.0628242,5.08508618 16.51836,5.39734508 C18.6800181,6.87911023 20,9.32886071 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 C4,9.26852332 5.38056879,6.77075716 7.62302337,5.30262097 Z" fill="#000000" fill-rule="nonzero"/>
                                                            <rect fill="#000000" opacity="0.3" x="11" y="3" width="2" height="10" rx="1"/>
                                                        </g>
                                                    </svg><!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </div>
                                    </div>

								<!--begin::User-->
                                <div class="topbar-item">
                                    <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2" id="">
                                        <a href="{{ url('meu-perfil') }}">
                                            <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Olá,</span>
                                            <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ (Auth::user()) ? Auth::user()->name : 'Não logado' }}</span>
                                            <span class="symbol symbol-35 symbol-light-success">
                                                <span class="symbol-label font-size-h5 font-weight-bold">{{ (Auth::user()) ? substr(Auth::user()->name,0,1) : "?" }}</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
								<!--end::User-->
							</div>
							<!--end::Topbar-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<div class="d-flex align-items-center flex-wrap mr-2">
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">
										<i class="fas {{ $breadcrumb['icone'] }} text-dark mr-2"></i> {{ $breadcrumb['titulo'] }}
									</h5>
                                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-3 mt-4">
                                        @for ($i = 0; $i < count($breadcrumb['itens']); $i++)
                                            <li class="breadcrumb-item">
                                                <a href="{{ url($breadcrumb['itens'][$i]['url']) }}" class="text-muted">{{ $breadcrumb['itens'][$i]['descricao'] }}</a>
                                            </li>
                                        @endfor
                                    </ul>
								</div>
                                @permission('sigeve-candidato-busca-rapida')
                                    <div class="d-flex align-items-center" id="kt_subheader_search">
                                        <form method="POST" action="{{ url('candidatos') }}" class="ml-5">
                                            @csrf
                                            <div class="input-group input-group-sm input-group-solid" style="max-width: 275px">
                                                <input type="text" name="nome" id="nome" class="form-control" placeholder="Busca Rápida Por Nome"/>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <button type="submit" class="btn-busca-rapida">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endpermission
							</div>
						</div>
						<div class="d-flex flex-column-fluid">
							<div class="container-fluid">
								@yield('content')
							</div>
						</div>
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
					<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted font-weight-bold mr-2">2023©</span>
								<a href="http://coperve.ufsc.br" target="_blank" class="text-dark-75 text-hover-primary">Coperve</a>
							</div>
							<!--end::Copyright-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Main-->
		<div id="kt_scrolltop" class="scrolltop">
			<span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
					</g>
				</svg>
			</span>
		</div>
        @include('layouts.modal')
        <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
	    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/pages/crud/datatables/basic/paginations.js') }}"></script>
        <script src="{{ asset('js/pages/features/miscellaneous/sweetalert2.js') }}"></script>
        <script src="{{ asset('assets/js/pages/crud/forms/widgets/select2.js') }}"></script>
        <script src="{{ asset('assets/js/pages/crud/forms/widgets/form-repeater.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>

        @yield('scripts')
	</body>
</html>
