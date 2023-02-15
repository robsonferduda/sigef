
  @php
	$total = 0;
 	$contoleLocal = ""; 
 	$contoleSetor = ""; 
 	$contoleGrupo = ""; 
 	$flag = 0; 
 @endphp
<head>
<title>UFSC</title>
	<link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>	
	@forelse($candidatos as $key => $d)
		@if($contoleLocal != $d->local or $contoleSetor != $d->setor or $contoleGrupo != $d->grupo)
			@if($flag == 1)
				<tr style="background: #FFF;">
                    <td style="text-align: left; padding: 4px; font-weight: bold;" colspan='4'>Total de Candidatos Homônimos no Grupo: {{ $total }}</td>
                </tr>	
					</tbody>
				</table>
				</div>
				<div class="page-break"></div>
    			@include('relatorios.pdf.partes.footer-com-data')

				@php $flag = 0; $total = 0; @endphp
			@endif
			
			@include('relatorios.pdf.partes.cabecalho-vertical')

			<div id="corpo"><p style="text-align: right;">Prova: {{ $provas->nu_prova_pro }}  ( {{ date('d/m/Y', strtotime($provas->dt_inicio_pro)) }} )</p>
                <p style="padding-top: -10px;"><strong>Relação de Homônimos por Grupo</strong>
                <br>Local: {{ str_pad($d->local,2,'0',STR_PAD_LEFT) }} &nbsp; {{ $d->nm_local_prova_lop}}
                <br>Setor: {{ str_pad($d->setor/*cd_unico_sel*/,2,'0',STR_PAD_LEFT)  }} &nbsp; {{ $d->nm_setor_sel}} 
				<br>Grupo: {{ str_pad($d->nu_grupo_gru,3,'0',STR_PAD_LEFT)}}
                </p>
				
				<table id="tabelaDados1" style="font-size: 12px;" border="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:5%; padding: 4px; text-align: center;">Ordem</th>
                            <th style="text-align: left; padding: 4px;width:10%;">Inscrição</th>
                            <th style="text-align: left; padding: 4px;width:40%;">Nome</th>
                            <th style="width:15%; padding: 4px; text-align: center;">CPF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="background: #DDD;">
                            <td style="text-align: center; padding: 4px;">{{ $d->cd_ordem_can }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $d->nu_inscricao_can }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $d->nm_candidato_can }}</td>
                            <td style="text-align: center; padding: 4px;">{{ $d->cpf }}</td>
                        </tr>	
            @php $flag = 1; $total++; @endphp
        @else
        				<tr style="background: {{ ($key % 2) ? '#DDD;' : '#FFF;' }}">
                            <td style="text-align: center; padding: 4px;">{{ $d->cd_ordem_can }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $d->nu_inscricao_can }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $d->nm_candidato_can }}</td>
                            <td style="text-align: center; padding: 4px;">{{ $d->cpf }}</td>
                        </tr>	
				@php $total++; @endphp
					
		@endif
		@php
			$contoleLocal = $d->local; 
	 		$contoleSetor = $d->setor; 
	 		$contoleGrupo = $d->grupo; 
 		@endphp
	@empty
		<h4 style="text-align: center;">Não existem dados para a consulta realizada</h4>
	@endforelse

@if($candidatos)
<tr style="background: #FFF;">
    <td style="text-align: left; padding: 4px; font-weight: bold;" colspan='4'>Total de Candidatos Homônimos no Grupo: {{ $total }}</td>
</tr>	
</tbody>
</table>
@endif
</div>
@include('relatorios.pdf.partes.footer-com-data')
</body>