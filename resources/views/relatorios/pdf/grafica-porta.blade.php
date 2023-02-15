
  @php
	$total = 0;
 	$contoleLocal = ""; 
 	$contoleSetor = ""; 
 	$contoleGrupo = ""; 
 	$flag = 0; 
    $zebra = true;
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
                    <td style="text-align: left; padding: 4px; font-weight: bold;" colspan='5'>Total de Candidatos no Grupo: {{ $total }}</td>
                </tr>	
					</tbody>
				</table>
				</div>
				<div class="page-break"></div>
    			@include('relatorios.pdf.partes.footer')

				@php $flag = 0; $total = 0; $zebra = true; @endphp
			@endif
			
			@include('relatorios.pdf.partes.cabecalho-vertical')

			<div id="corpo" style="padding-top:-40px;">
				<h1 class="center">Grupo: <span style="font-size: 200px;">{{ str_pad($d->nu_grupo_gru,3,'0',STR_PAD_LEFT)}}</span></h1>
				<h6 style="padding-top:-60px; padding-bottom:-15px">Local: {{ str_pad($d->local,2,'0',STR_PAD_LEFT) }} &nbsp; {{ $d->nm_local_prova_lop}}<br>
					Setor: {{ str_pad($d->setor/*cd_unico_sel*/,2,'0',STR_PAD_LEFT)  }} &nbsp; {{ $d->nm_setor_sel}} </h6>
				<table id="tabelaDados1" style="font-size: 13px;" border="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align: left; padding: 4px;width:15%;">Inscrição</th>
                            <th style="text-align: left; padding: 4px;width:45%;">Nome</th>
                            <th style="width:5%; padding: 4px; text-align: center;">Carteira</th>
                            <th style="width:15%; padding: 4px; text-align: center;">CPF</th>
                            <th style="width:20%; padding: 4px; text-align: center;">Obs.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="background: #DDD;">
                            <td style="text-align: left; padding: 4px;">{{ $d->nu_inscricao_can }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $d->nm_candidato_can }}</td>
                            <td style="text-align: center; padding: 4px;">{{ $d->cd_ordem_can }}</td>
                            <td style="text-align: center; padding: 4px;">{{ $d->cpf }}</td>
                            <td style="text-align: center; padding: 4px;">{{ ($d->fl_canhoto_pes == 'S')? 'CANHOTO':'' }}</td>
                        </tr>	
            @php $flag = 1; $total++; @endphp
        @else
        				<tr style="background: {{ ($zebra) ? '#DDD;' : '#FFF;' }}">
                            <td style="text-align: left; padding: 4px;">{{ $d->nu_inscricao_can }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $d->nm_candidato_can }}</td>
                            <td style="text-align: center; padding: 4px;">{{ $d->cd_ordem_can }}</td>
                            <td style="text-align: center; padding: 4px;">{{ $d->cpf }}</td>
                            <td style="text-align: center; padding: 4px;">{{ ($d->fl_canhoto_pes == 'S')? 'CANHOTO':''  }}</td>
                        </tr>	
				@php $total++; @endphp
					
		@endif
		@php
			$contoleLocal = $d->local; 
	 		$contoleSetor = $d->setor; 
	 		$contoleGrupo = $d->grupo; 
            $zebra = !$zebra;
 		@endphp
	@empty
		<h4 style="text-align: center;">Não existem dados para a consulta realizada</h4>
	@endforelse
@if($candidatos)
<tr style="background: #FFF;">
    <td style="text-align: left; padding: 4px; font-weight: bold;" colspan='5'>Total de Candidatos no Grupo: {{ $total }}</td>
</tr>	
</tbody>
</table>
@endif
</div>
@include('relatorios.pdf.partes.footer')
</body>