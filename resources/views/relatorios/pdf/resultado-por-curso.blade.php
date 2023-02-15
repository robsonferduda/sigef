<head>
    <title>Relação de Candidatos Classificados</title>
    <link href="{{ asset('css/relatorios-pdf-footer-maior.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('relatorios.pdf.partes.cabecalho-vertical')

@php $ctrl = ""; $flag = 0; @endphp
<div id="corpo">
	@if($classificados)
			@foreach($classificados as $key => $d)

				@if($ctrl != $d->cd_periodo_per and $flag == 1)
				
						</tbody>
					</table>
					<htmlpagefooter name="page-footer">
						<div id="text-footer">
							<table border=1 bgcolor="#E5E5E5" style="font-size:8px;" cellspacing="1" align="center" width="100%">
											<tbody>
												<tr><td rowspan="2">3 - Classificação Geral (Não Optantes pelo PAA)</td>
												<td>211 - Escola Pública - Renda até 1,5 SM - PPI Deficientes</td>
												<td>221 - Escola Pública - Renda até 1,5 SM - Outros Deficientes</td>
												<td>231 - Escola Pública - Renda acima de 1,5 SM - PPI Deficientes</td>
												<td>241 - Escola Pública - Renda acima de 1,5 SM - Outros Deficientes</td>
											</tr><tr>
												<td>212 - Escola Pública - Renda até 1,5 SM - PPI</td>
												<td>222 - Escola Pública - Renda até 1,5 SM - Outros</td>
												<td>232 - Escola Pública - Renda acima de 1,5 SM - PPI</td>
												<td>242 - Escola Pública - Renda acima de 1,5 SM - Outros</td></tr>
											</tbody>
										</table>
						</div>
					</htmlpagefooter>
					<div class="page-break"></div>
					@php $flag == 0; @endphp
				@endif

				@if($ctrl != $d->cd_periodo_per)
					<h4 style="text-align: center; margin-bottom: 1px;">{{ $curso->nm_abrev_curso_cur }} - {{ $curso->campus->nm_campus_cam }} ({{ $curso->instituicao->sg_instituicao_ies }})</h4>
					<h5 style="text-align: center; margin-bottom: 5px; margin-top: 3px;">{{ ($d->cd_periodo_per == 1)? 'Primeiro Semestre': 'Segundo Semestre' }}</h5>
					<table id="tabelaDados1" border='1' cellspacing="0" width="100%" align="center">
						<thead>
							<tr>
								<th bgcolor="darkblue" color="#FFFFFF" style="text-align: center; width: 10%;">Inscrição</th>
								<th bgcolor="darkblue" color="#FFFFFF" style="text-align: left; width: 50%;">Nome do Candidato</th>
								<th bgcolor="darkblue" color="#FFFFFF" style="text-align: center; width: 30%;">Categoria de Classificação</th>
								<th bgcolor="darkblue" color="#FFFFFF" style="text-align: center; width: 10%;">Classificação</th>

							</tr>
						</thead>
						<tbody>
					@php $flag = 1; @endphp
				@endif			
							<tr style="background: {{ ($key % 2) ? '#FFFFFF;' : '#ddd;' }}">
								<td style="padding: 3px; text-align: center;">{{ $d->nu_inscricao_can }}</td>
								<td style="padding: 3px">{{ \App\Utils::upperCase($d->nome) }}</td>
								<td style="padding: 3px; text-align: center;">
									{{ $d->cd_categoria_cat }}
								</td>
								<td style="padding: 3px; text-align: center;">
									{{ $d->nu_ordem_cac }} 
								</td>
							</tr>

				@php if($ctrl != $d->cd_periodo_per){ $ctrl = $d->cd_periodo_per; } @endphp
						
			@endforeach
				</tbody>
			</table>
			<htmlpagefooter name="page-footer">
				<div id="text-footer">
					<table border=1 bgcolor="#E5E5E5" style="font-size:8px;" cellspacing="1" width="100%" align="center">
									<tbody>
												<tr><td rowspan="2">3 - Classificação Geral (Não Optantes pelo PAA)</td>
												<td>211 - Escola Pública - Renda até 1,5 SM - PPI Deficientes</td>
												<td>221 - Escola Pública - Renda até 1,5 SM - Outros Deficientes</td>
												<td>231 - Escola Pública - Renda acima de 1,5 SM - PPI Deficientes</td>
												<td>241 - Escola Pública - Renda acima de 1,5 SM - Outros Deficientes</td>
											</tr><tr>
												<td>212 - Escola Pública - Renda até 1,5 SM - PPI</td>
												<td>222 - Escola Pública - Renda até 1,5 SM - Outros</td>
												<td>232 - Escola Pública - Renda acima de 1,5 SM - PPI</td>
												<td>242 - Escola Pública - Renda acima de 1,5 SM - Outros</td></tr>
											</tbody>
								</table>
				</div>
			</htmlpagefooter>

	@else
		<h4 style="text-align: center;">Não existem dados para a consulta realizada</h4>
	@endif
</div>

</body>