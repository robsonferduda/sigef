<head>
    <title>Relação candiato/vaga</title>
    <link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('relatorios.pdf.partes.cabecalho-vertical')

@php $ctrl = ""; $flag = 0; @endphp
<div id="corpo">
	@if($dados)
		@if($quebra)
			@foreach($dados as $key => $d)

				@if($ctrl != $d->nm_campus_cam and $flag == 1)
				
						</tbody>
					</table>
					<span style="font-weight: bold; font-size: 11px;">Legenda: CV = Proporção Candidato/Vagas</span>
					<div class="page-break"></div>
					@php $flag == 0; @endphp
				@endif

				@if($ctrl != $d->nm_campus_cam)
					<h4 style="text-align: center; margin-bottom: 1px;">Relação Candidatos/Vaga</h4>
					<h5 style="text-align: center; margin-bottom: 5px; margin-top: 3px;">{{ $categoria }}</h5>
					<h4 style="text-align: center; margin-bottom: 5px; margin-top: 3px;">{{ $d->nm_campus_cam }}</h4>
					<table id="tabelaDados1" border='1' cellspacing="0" width="100%">
						<thead>
							<tr>
								<th style="text-align: center; width: 9%;" rowspan="2">Código</th>
								<th style="text-align: left; width: 54%;" rowspan="2">Curso</th>
								<th style="text-align: center; width: 9%;" rowspan="2">Total Vagas</th>
								<th style="text-align: center; width: 9%;" colspan="2">Opção 1</th>
								<th style="text-align: center; width: 9%;">Opçao 1A</th>

							</tr>
							<tr>
								<th style="text-align: center;">Inscritos</th>
								<th style="text-align: center;">CV</th>
								<th style="text-align: center;">Inscritos</th>
							</tr>
						</thead>
						<tbody>
					@php $flag = 1; @endphp
				@endif			
							<tr style="background: {{ ($key % 2) ? '#FFFFFF;' : '#ddd;' }}">
								<td style="text-align: center;">{{ $d->cod_curso }}</td>
								<td style="padding: 1px 3px;">{{ \App\Utils::upperCase($d->curso) }}</td>
								<td style="text-align: center;">
									{{ $d->vagas }}
								</td>
								<td style="text-align: center;">
									{{ $d->opcao1 }} 
								</td>
								<td style="text-align: center;">
										{{ ($d->vagas > 0) ? number_format($d->opcao1/$d->vagas,2) : 0 }} 
								</td>
								<td style="text-align: center;">
									{{ ($d->opcao1a > 0) ? $d->opcao1a : "--" }} 
								</td>
							</tr>

				@php if($ctrl != $d->nm_campus_cam){ $ctrl = $d->nm_campus_cam; } @endphp
						
			@endforeach
				</tbody>
			</table>
			<span style="font-weight: bold; font-size: 11px;">Legenda: CV = Proporção Candidato/Vagas</span>
		@else
			<h4 style="text-align: center; margin-bottom: 1px;">{{ $universidade }}</h4>
			<h4 style="text-align: center; margin-bottom: 1px;">Relação Candidatos/Vaga {{ $preliminar }}</h4>
			<h4 style="text-align: center; margin-bottom: 5px; margin-top: 3px;">{{ $categoria }}</h4>
			<table id="tabelaDados2" border='1' cellspacing="0" width="100%">
				<thead>
					<tr>
						<th style="text-align: center; width: 9%;" rowspan="2">Código</th>
						<th style="text-align: left; width: 54%;" rowspan="2">Curso</th>
						<th style="text-align: center; width: 9%;" rowspan="2">Total Vagas</th>
						<th style="text-align: center; width: 9%;" colspan="2">Opção 1</th>
						<th style="text-align: center; width: 9%;">Opçao 1A</th>
					</tr>
					<tr>
						<th style="text-align: center;">Inscritos</th>
						<th style="text-align: center;">CV</th>
						<th style="text-align: center;">Inscritos</th>
					</tr>
				</thead>
				<tbody>
					@foreach($dados as $key => $d)
						<tr style="background: {{ ($key % 2) ? '#FFFFFF;' : '#ddd;' }}">
							<td style="text-align: center;">{{ $d->cod_curso }}</td>
							<td style="padding: 1px 3px;">{{ \App\Utils::upperCase($d->curso) }}</td>
							<td style="text-align: center;">
								{{ $d->vagas }} 
							</td>
							<td style="text-align: center;">
								{{ $d->opcao1 }} 
							</td>
							<td style="text-align: center;">
								{{ ($d->vagas > 0) ? number_format($d->opcao1/$d->vagas,2) : 0 }} 
							</td>
							<td style="text-align: center;">
								{{ ($d->opcao1a > 0)? $d->opcao1a : "--" }}
							</td>
							
						</tr>
					@endforeach
				</tbody>
			</table>
			<span style="font-weight: bold; font-size: 11px;">Legenda: CV = Proporção Candidato/Vagas</span>
		@endif		
	@else
		<h4 style="text-align: center;">Não existem dados para a consulta realizada</h4>
	@endif
</div>
    @include('relatorios.pdf.partes.footer')
</body>