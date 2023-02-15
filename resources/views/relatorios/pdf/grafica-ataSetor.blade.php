
  @php
	$total = 0;
 	$contoleLocal = ""; 
 	$contoleSetor = ""; 
 	$flag = 0; 
 @endphp
<head>
<title>UFSC</title>
	<link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>	
	@forelse($candidatos as $key => $d)
        @php 
            $local = str_pad($d->local,2,'0',STR_PAD_LEFT);
            $setor = str_pad($d->setor/*cd_unico_sel*/,3,'0',STR_PAD_LEFT);
        @endphp
		@if($contoleLocal != $d->local or $contoleSetor != $d->setor)
			@if($flag == 1)
				<div style="margin-top: -10px;" class="page-break"></div>
    			@include('relatorios.pdf.partes.footer')

				@php $flag = 0; $total = 0; @endphp
			@endif
			
			@include('relatorios.pdf.partes.cabecalho-vertical')

			<div id="corpo" style="margin-top: 10px;font-size:  10px">
                <div style="text-align: center">
                    @if($emBranco != 'S')
                        <barcode code="*{{$local.$setor}}1*" type="C39" class="barcode" height="1" text="1"></barcode>
                        <br>L{{$local}}-S{{$setor}}-P1 de 2
                    @else
                        <br><br><br>
                    @endif
                    <h2><strong>ATA DA COORDENAÇÃO DO SETOR</h2>
                    <table style="font-size: 12px; font-weight: bold;" border="1" cellspacing="0" width="100%">
                        <tr><td  style="padding: 10px;">
                            <p>Local: {{ $local }} &nbsp; {{ $d->nm_local_prova_lop}}
                            <br>Setor: {{ ($emBranco != 'S')?  $setor  .'   '.  $d->nm_setor_sel : '' }}
                            <br>Prova: {{ $provas->nu_prova_pro }}  ( {{ date('d/m/Y', strtotime($provas->dt_inicio_pro)) }} )
                            </p>
                        </td></tr>
                    </table>
                </div>
                <br>
                <strong>1. Testemunhas da integridade dos lacres e dos malotes de provas:</strong>
                <table style="font-size: 12px;text-align: center;" border="1" cellspacing="0" width="100%">
                    <tr bgcolor="#DDD">
                        <td width="34%">Nome Completo</td>
                        <td width="33%">Assinatura</td>
                        <td width="33%">Função</td>
                    </tr>
                    <tr><td style="padding: 4px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 4px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 4px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                </table>
                <br>
                <strong>2. Candidatos testemunhas do fechamento do portão </strong>
                <table style="font-size: 12px;text-align: center;" border="1" cellspacing="0" width="100%">
                    <tr><td style="padding: 10px;" colspan="3">Declaramos ter presenciado o fechamento do portão de acesso dos candidatos, pelo coordenador deste setor, precisamente às &nbsp; &nbsp; _______h ________min
                    </td></tr>
                    <tr bgcolor="#DDD">
                        <td width="20%">Nº. Inscrição</td>
                        <td width="40%">Nome do candidato</td>
                        <td width="40%">Assinatura</td>
                    </tr>
                    <tr><td style="padding: 4px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 4px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 4px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                </table>
                <br>
                <strong>3. Relação dos fiscais ausentes por categoria:</strong>
                <table style="font-size: 12px;" border="1" cellspacing="0" width="100%">
                    <tr bgcolor="#DDD"><td align="center" style="padding: 2px;" colspan="2">Docentes da UFSC</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr bgcolor="#DDD"><td align="center" style="padding: 2px;" colspan="2">Técnicos Administrativos da UFSC</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr bgcolor="#DDD"><td align="center" style="padding: 2px;" colspan="2">Alunos da UFSC</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr bgcolor="#DDD"><td align="center" style="padding: 2px;" colspan="2">Outros</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td style="padding: 2px;">&nbsp;</td></tr>
                </table>
                @include('relatorios.pdf.partes.footer')
                <div style="margin-top: -10px;" class="page-break"></div>
                @include('relatorios.pdf.partes.cabecalho-vertical-reduzido')
                <div style="text-align: center;">
                    @if($emBranco != 'S')
                        <barcode code="*{{$local.$setor}}2*" type="C39" class="barcode" height="1" text="1"></barcode>
                        <br>L{{$local}}-S{{$setor}}-P2 de 2
                    @else
                        <br><br><br>
                    @endif
                </div>
                <br>
                <table style="font-size: 12px;" border="1" cellspacing="0" width="100%">
                    <tr bgcolor="#DDD"><td style="padding: 10px; font-weight: bold;">Nº de candidatos no setor: {{($emBranco != 'S')? $d->total : ''}} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Nº de candidatos ausentes no setor: __________
                    </td></tr>
                </table>
                <br>
                <table style="font-size: 12px;" border="1" cellspacing="0" width="100%">
                    <tr bgcolor="#DDD"><td style="padding: 3px;font-weight: bold;text-align: center;">Ocorrências
                    </td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                </table>
                <br>
                <table style="font-size: 12px;" border="1" cellspacing="0" width="100%">
                    <tr bgcolor="#DDD"><td style="padding: 3px;font-weight: bold;text-align: center;">Observações e/ou sugestões
                    </td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td></tr>
                </table>
                <br>
                <table style="font-size: 12px;text-align: center;" border="1" cellspacing="0" width="100%">
                    <tr bgcolor="#DDD"><td style="padding: 3px;font-weight: bold;text-align: center;" colspan="2">Nome e Assinatura dos Coordenadores do Setor
                    </td></tr>
                    <tr>
                        <td width="50%">Nome</td>
                        <td width="50%">Assinatura</td>
                    </tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td></tr>
                </table>
            @php $flag = 1; @endphp
        @else
        	<div style="margin-top: -10px;" class="page-break"></div>
            @include('relatorios.pdf.partes.footer')	
		@endif
		@php
			$contoleLocal = $d->local; 
	 		$contoleSetor = $d->setor; 
 		@endphp
	@empty
		<h4 style="text-align: center;">Não existem dados para a consulta realizada</h4>
	@endforelse

</body>