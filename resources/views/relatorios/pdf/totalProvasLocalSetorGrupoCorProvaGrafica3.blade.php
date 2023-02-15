<head>
    <title>Total de Provas por Local, Setor, Grupo, Cor de Prova para Grafica</title>
    <link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('relatorios.pdf.partes.cabecalho-vertical')

    @php
		$totalSetorMarfim = 0;
		$totalSetorTotal = 0;

		$totalLocalMarfim = 0;
		$totalLocalTotal = 0;

		$totalGeralMarfim = 0;
		$totalGeralTotal = 0;
	@endphp

@php $contoleLocal = ""; $contoleSetor = ""; $flag = 0; @endphp
<div id="corpo">
	@if($candidatos)
			@foreach($candidatos as $key => $d)

				@if(($contoleLocal != $d['local'] or $contoleSetor != $d['setor']) and $flag == 1)
						<tr style="text-align: center; background:#FFFFFF; ">
							<td style="text-align: center;"><strong>Total Setor</strong></td>
							<td style="text-align: center;"><strong>{{ $totalSetorMarfim }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalSetorTotal }}</strong></td>
						</tr>
						@php
							$totalSetorMarfim = 0;
							$totalSetorTotal = 0;
						@endphp

					@if($contoleLocal !=  $d['local'])
						<tr style="text-align: center; background:#FFFFFF; ">
							<td style="text-align: center;"><strong>Total Local</strong></td>
							<td style="text-align: center;"><strong>{{ $totalLocalMarfim }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalLocalTotal }}</strong></td>
						</tr>
						@php
							$totalLocalMarfim = 0;
							$totalLocalTotal = 0;
						@endphp

					@endif
				
						</tbody>
					</table>
					<div class="page-break"></div>
					@php $flag == 0; @endphp
				@endif

				@if(($contoleLocal != $d['local'] or $contoleSetor != $d['setor']))
					<h4 style="text-align: center; margin-bottom: 1px;">Prova: {{ $d['prova'] }}</h4>
					<h5 style="text-align: center; margin-bottom: 5px; margin-top: 3px;">Local: {{ $d['local'] }} - {{ $d['nmLocal'] }}</h5>
					<h4 style="text-align: center; margin-bottom: 5px; margin-top: 3px;">Setor: {{ $d['setor'] }} - {{ $d['nmSetor'] }}</h4>
					<table class="tabelaDados" style="border-collapse: collapse;" border='1' cellspacing="0" cellpadding="4" width="100%">
						<thead>
							<tr>
								<th style="text-align: center; width: 9%;">GRUPO</th>
								<th style="text-align: center; width: 10%;">MARFIM</th>
								<th style="text-align: center; width: 9%;">TOTAL</th>
							</tr>
						</thead>
						<tbody>
					@php $flag = 1; @endphp
				@endif	

				<tr style="border: 1px solid #000000;text-align: center;background: {{ ($key % 2) ? '#FFFFFF;' : '#ddd;' }}">
					<td style="text-align: center;">{{ ($d['grupo'] == '00')? 'RESERVAS' : $d['grupo'] }}</td>
					<td style="text-align: center;">{{ $d['totalMarfim'] }}</td>
					<td style="text-align: center;">{{ $d['total'] }}</td>
				</tr>

				@php
					$totalSetorMarfim += $d['totalMarfim'];
					$totalSetorTotal += $d['total'];

					$totalLocalMarfim += $d['totalMarfim'];
					$totalLocalTotal += $d['total'];

					$totalGeralMarfim += $d['totalMarfim'];
					$totalGeralTotal += $d['total'];
				@endphp
				

				@php if($contoleLocal != $d['local']){ 
						$contoleLocal = $d['local']; 
					}
					if($contoleSetor != $d['setor']){ 
						$contoleSetor = $d['setor']; 
					}
				 @endphp
						
			@endforeach
				<tr style="text-align: center; background:#FFFFFF; ">
					<td style="text-align: center;"><strong>Total Setor</strong></td>
					<td style="text-align: center;"><strong>{{ $totalSetorMarfim }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalSetorTotal }}</strong></td>
				</tr>
				<tr style="text-align: center; background:#FFFFFF; ">
					<td style="text-align: center;"><strong>Total Local</strong></td>
					<td style="text-align: center;"><strong>{{ $totalLocalMarfim }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalLocalTotal }}</strong></td>
				</tr>
				<tr style="text-align: center; background:#FFFFFF; ">
					<td style="text-align: center;"><strong>Total Geral</strong></td>
					<td style="text-align: center;"><strong>{{ $totalGeralMarfim }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalGeralTotal }}</strong></td>
				</tr>
				</tbody>
			</table>	
	@else
		<h4 style="text-align: center;">Não existem dados para a consulta realizada</h4>
	@endif
</div>
    @include('relatorios.pdf.partes.footer')
</body>