<head>
    <title>Total de Provas por Local, Setor, Grupo, Cor de Prova para Grafica</title>
    <link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('relatorios.pdf.partes.cabecalho-vertical')

    @php
		$totalSetorCinza = 0;
		$totalSetorMarfim = 0;
		$totalSetorRosa = 0;
		$totalSetorAmarela = 0;
		$totalSetorAzul = 0;
		$totalSetorVerde = 0;
		$totalSetorVioleta = 0;
		$totalSetorLaranja = 0;
		$totalSetorMarrom = 0;
		$totalSetorTotal = 0;

		$totalLocalCinza = 0;
		$totalLocalMarfim = 0;
		$totalLocalRosa = 0;
		$totalLocalAmarela = 0;
		$totalLocalAzul = 0;
		$totalLocalVerde = 0;
		$totalLocalVioleta = 0;
		$totalLocalLaranja = 0;
		$totalLocalMarrom = 0;
		$totalLocalTotal = 0;

		$totalGeralCinza = 0;
		$totalGeralMarfim = 0;
		$totalGeralRosa = 0;
		$totalGeralAmarela = 0;
		$totalGeralAzul = 0;
		$totalGeralVerde = 0;
		$totalGeralVioleta = 0;
		$totalGeralLaranja = 0;
		$totalGeralMarrom = 0;
		$totalGeralTotal = 0;
	@endphp

@php $contoleLocal = ""; $contoleSetor = ""; $flag = 0; @endphp
<div id="corpo">
	@if($candidatos)
			@foreach($candidatos as $key => $d)

				@if(($contoleLocal != $d['local'] or $contoleSetor != $d['setor']) and $flag == 1)
						<tr style="text-align: center; background:#FFFFFF; ">
							<td style="text-align: center;"><strong>Total Setor</strong></td>
							<td style="text-align: center;"><strong>{{ $totalSetorCinza }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalSetorMarfim }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalSetorRosa }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalSetorAmarela }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalSetorAzul }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalSetorVerde }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalSetorVioleta }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalSetorLaranja }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalSetorMarrom }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalSetorTotal }}</strong></td>
						</tr>
						@php
							$totalSetorCinza = 0;
							$totalSetorMarfim = 0;
							$totalSetorRosa = 0;
							$totalSetorAmarela = 0;
							$totalSetorAzul = 0;
							$totalSetorVerde = 0;
							$totalSetorVioleta = 0;
							$totalSetorLaranja = 0;
							$totalSetorMarrom = 0;
							$totalSetorTotal = 0;
						@endphp

					@if($contoleLocal !=  $d['local'])
						<tr style="text-align: center; background:#FFFFFF; ">
							<td style="text-align: center;"><strong>Total Local</strong></td>
							<td style="text-align: center;"><strong>{{ $totalLocalCinza }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalLocalMarfim }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalLocalRosa }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalLocalAmarela }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalLocalAzul }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalLocalVerde }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalLocalVioleta }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalLocalLaranja }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalLocalMarrom }}</strong></td>
							<td style="text-align: center;"><strong>{{ $totalLocalTotal }}</strong></td>
						</tr>
						@php
							$totalLocalCinza = 0;
							$totalLocalMarfim = 0;
							$totalLocalRosa = 0;
							$totalLocalAmarela = 0;
							$totalLocalAzul = 0;
							$totalLocalVerde = 0;
							$totalLocalVioleta = 0;
							$totalLocalLaranja = 0;
							$totalLocalMarrom = 0;
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
								<th style="text-align: center; width: 9%;">CINZA</th>
								<th style="text-align: center; width: 9%;">MARFIM</th>
								<th style="text-align: center; width: 9%;">ROSA</th>
								<th style="text-align: center; width: 10%;">AMARELA</th>
								<th style="text-align: center; width: 9%;">AZUL</th>
								<th style="text-align: center; width: 9%;">VERDE</th>
								<th style="text-align: center; width: 9%;">VIOLETA</th>
								<th style="text-align: center; width: 9%;">LARANJA</th>
								<th style="text-align: center; width: 9%;">MARROM</th>
								<th style="text-align: center; width: 9%;">TOTAL</th>
							</tr>
						</thead>
						<tbody>
					@php $flag = 1; @endphp
				@endif	

				<tr style="border: 1px solid #000000;text-align: center;background: {{ ($key % 2) ? '#FFFFFF;' : '#ddd;' }}">
					<td style="text-align: center;">{{ ($d['grupo'] == '00')? 'RESERVAS' : $d['grupo'] }}</td>
					<td style="text-align: center;">{{ $d['totalCinza'] }}</td>
					<td style="text-align: center;">{{ $d['totalMarfim'] }}</td>
					<td style="text-align: center;">{{ $d['totalRosa'] }}</td>
					<td style="text-align: center;">{{ $d['totalAmarela'] }}</td>
					<td style="text-align: center;">{{ $d['totalAzul'] }}</td>
					<td style="text-align: center;">{{ $d['totalVerde'] }}</td>
					<td style="text-align: center;">{{ $d['totalVioleta'] }}</td>
					<td style="text-align: center;">{{ $d['totalLaranja'] }}</td>
					<td style="text-align: center;">{{ $d['totalMarrom'] }}</td>
					<td style="text-align: center;">{{ $d['total'] }}</td>
				</tr>

				@php
					$totalSetorCinza += $d['totalCinza'];
					$totalSetorMarfim += $d['totalMarfim'];
					$totalSetorRosa += $d['totalRosa'];
					$totalSetorAmarela += $d['totalAmarela'];
					$totalSetorAzul += $d['totalAzul'];
					$totalSetorVerde += $d['totalVerde'];
					$totalSetorVioleta += $d['totalVioleta'];
					$totalSetorLaranja += $d['totalLaranja'];
					$totalSetorMarrom += $d['totalMarrom'];
					$totalSetorTotal += $d['total'];

					$totalLocalCinza += $d['totalCinza'];
					$totalLocalMarfim += $d['totalMarfim'];
					$totalLocalRosa += $d['totalRosa'];
					$totalLocalAmarela += $d['totalAmarela'];
					$totalLocalAzul += $d['totalAzul'];
					$totalLocalVerde += $d['totalVerde'];
					$totalLocalVioleta += $d['totalVioleta'];
					$totalLocalLaranja += $d['totalLaranja'];
					$totalLocalMarrom += $d['totalMarrom'];
					$totalLocalTotal += $d['total'];

					$totalGeralCinza += $d['totalCinza'];
					$totalGeralMarfim += $d['totalMarfim'];
					$totalGeralRosa += $d['totalRosa'];
					$totalGeralAmarela += $d['totalAmarela'];
					$totalGeralAzul += $d['totalAzul'];
					$totalGeralVerde += $d['totalVerde'];
					$totalGeralVioleta += $d['totalVioleta'];
					$totalGeralLaranja += $d['totalLaranja'];
					$totalGeralMarrom += $d['totalMarrom'];
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
					<td style="text-align: center;"><strong>{{ $totalSetorCinza }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalSetorMarfim }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalSetorRosa }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalSetorAmarela }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalSetorAzul }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalSetorVerde }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalSetorVioleta }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalSetorLaranja }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalSetorMarrom }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalSetorTotal }}</strong></td>
				</tr>
				<tr style="text-align: center; background:#FFFFFF; ">
					<td style="text-align: center;"><strong>Total Local</strong></td>
					<td style="text-align: center;"><strong>{{ $totalLocalCinza }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalLocalMarfim }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalLocalRosa }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalLocalAmarela }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalLocalAzul }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalLocalVerde }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalLocalVioleta }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalLocalLaranja }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalLocalMarrom }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalLocalTotal }}</strong></td>
				</tr>
				<tr style="text-align: center; background:#FFFFFF; ">
					<td style="text-align: center;"><strong>Total Geral</strong></td>
					<td style="text-align: center;"><strong>{{ $totalGeralCinza }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalGeralMarfim }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalGeralRosa }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalGeralAmarela }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalGeralAzul }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalGeralVerde }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalGeralVioleta }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalGeralLaranja }}</strong></td>
					<td style="text-align: center;"><strong>{{ $totalGeralMarrom }}</strong></td>
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