
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
        @php 
            $local = str_pad($d->local,2,'0',STR_PAD_LEFT);
            $setor = str_pad($d->setor/*cd_unico_sel*/,3,'0',STR_PAD_LEFT);
            $grupo = str_pad($d->nu_grupo_gru,3,'0',STR_PAD_LEFT);
        @endphp
		@if($contoleLocal != $d->local or $contoleSetor != $d->setor or $contoleGrupo != $d->grupo)
			@if($flag == 1)
				<div class="page-break"></div>
    			@include('relatorios.pdf.partes.footer')

				@php $flag = 0; $total = 0; @endphp
			@endif
			
			@include('relatorios.pdf.partes.cabecalho-vertical')

			<div id="corpo" style="padding-top: 15px;font-size:  10px">
                <div style="text-align: center">
                    <barcode code="*{{$local.$setor.$grupo}}1*" type="C39" class="barcode" height="1" text="1"></barcode>
                    <br>L{{$local}}-S{{$setor}}-G{{$grupo}}-P1 de 2
                
                    <table style="font-size: 12px; margin-top: 10px;" border="1" cellspacing="0" width="100%">
                        <tr><td style="padding: 3px 10px 3px 10px">
                            <p><strong>ATA do Grupo</strong>
                            <br>Local: {{ $local }} &nbsp; {{ $d->nm_local_prova_lop}}
                            <br>Setor: {{ $setor }} &nbsp; {{ $d->nm_setor_sel}} 
                            <br>Grupo: {{ $grupo }}
                            <br>Prova: {{ $provas->nu_prova_pro }}  ( {{ date('d/m/Y', strtotime($provas->dt_inicio_pro)) }} )
                            </p>
                        </td></tr>
                        <tr><td style="border: 1px solid;padding: 10px;text-align: justify;">
                            - Todos os candidatos devem assinar o <strong>cartão-resposta</strong> e o <strong>caderno de provas</strong>.<br>
                            - O PREENCHIMENTO do cartão-resposta deve ser feito somente com caneta esferográfica, fabricada em material <br> &nbsp; transparente, de tinta preta (preferencialmente) ou azul.<br>
                            - Você deve preencher os campos "USO DO FISCAL" em todos os cartões-resposta. De acordo com o seguinte:<br>
                             &nbsp; &nbsp; &nbsp; &nbsp; - <strong>TÉRMINO DA PROVA</strong>: Preencha, <strong>somente para os candidatos presentes</strong>, as bolhas correspondentes a hora <br> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; e minutos em que o candidato terminou a prova.<br>
                             &nbsp; &nbsp; &nbsp; &nbsp; - <strong>AUSENTE</strong>: Preencha a bolha do campo "AUSENTE? Sim", no cartão-resposta dos candidatos <strong>ausentes</strong>.<br>
                            - Registre nesta ata, nos campos apropriados, as ocorrências relevantes solicitadas. Se não houver ocorrência escreva: <br> &nbsp; "<strong>Nada a declarar</strong>".
                        </td></tr>
                    </table>
                </div>
                <br>
                <strong>1. Verificação do lacre do pacote de provas</strong>
                <table style="font-size: 12px;text-align: center;" border="1" cellspacing="0" width="100%">
                    <tr><td style="padding: 10px;" colspan="3">Declaro que o pacote de provas desde grupo estava lacrado, sendo aberto em seguida pelos fiscais.
                    </td></tr>
                    <tr bgcolor="#DDD">
                        <td width="20%">Nº. Inscrição</td>
                        <td width="50%">Nome do candidato</td>
                        <td width="30%">Assinatura</td>
                    </tr>
                    <tr><td style="padding: 4px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 4px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 4px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                </table>
                <br>
                <strong>2. Resumo da frequência:</strong>
                <table style="font-size: 12px;text-align: center;" border="1" cellspacing="0" width="100%">
                    <tr bgcolor="#DDD">
                        <td width="33%">Nº. de candidatos presentes</td>
                        <td width="33%">Nº. de candidatos ausentes</td>
                        <td width="34%">Nº. de candidatos em sala especial</td>
                    </tr>
                    <tr><td style="padding: 10px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                </table>
                <br>
                <strong>3. Relação de candidatos ausentes:</strong>
                <table style="font-size: 12px;text-align: center;" border="1" cellspacing="0" width="100%">
                    <tr bgcolor="#DDD">
                        <td style="border-right: 5px double ;" colspan="2">Candidatos</td>
                        <td style="border-right: 5px double ;border-left: none;" colspan="2">Candidatos</td>
                        <td style="border-left: none;" colspan="2">Candidatos</td>
                    </tr>
                    <tr bgcolor="#DDD">
                        <td width="23%">Nº. Inscrição</td>
                        <td style="border-right: 5px double;" width="10%">Ordem</td>
                        <td style="border-left: none;" width="23%">Nº. Inscrição</td>
                        <td style="border-right: 5px double;" width="10%">Ordem</td>
                        <td style="border-left: none;"width="23%">Nº. Inscrição</td>
                        <td width="10%">Ordem</td>
                    </tr>
                    <tr><td>&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td style="border-right: 5px double;">&nbsp;</td><td style="border-left: none;">&nbsp;</td><td>&nbsp;</td></tr>
                </table>
                <br>
                <strong>4. Relação de candidatos que usaram material reserva (assinale somente o(s) item(ns) que o candidato usou):</strong>
                <table style="font-size: 12px; text-align: center;" border="1" cellspacing="0" width="100%">
                    <tr bgcolor="#DDD">
                        <td width="20%">Nº. Inscrição</td>
                        <td width="10%">Ordem</td>
                        <td width="20%">Prova</td>
                        <td width="20%">Cartão-resposta</td>
                        <td width="30%">Folha Discursiva/Folha Redação</td>
                    </tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="checkbox" style="font-size: 18px;"></td><td><input type="checkbox" style="font-size: 20px;"></td><td><input type="checkbox" style="font-size: 20px;"></td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="checkbox" style="font-size: 18px;"></td><td><input type="checkbox" style="font-size: 20px;"></td><td><input type="checkbox" style="font-size: 20px;"></td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="checkbox" style="font-size: 18px;"></td><td><input type="checkbox" style="font-size: 20px;"></td><td><input type="checkbox" style="font-size: 20px;"></td></tr>
                </table>
                @include('relatorios.pdf.partes.footer')
                <div class="page-break"></div>
                @include('relatorios.pdf.partes.cabecalho-vertical-reduzido')
                <div style="text-align: center">
                    <barcode code="*{{$local.$setor.$grupo}}2*" type="C39" class="barcode" height="1" text="1"></barcode>
                    <br>L{{$local}}-S{{$setor}}-G{{$grupo}}-P2 de 2
                </div>
                <br>
                <strong>5. Correção do nome do candidato:</strong>
                <table style="font-size: 12px;text-align: center;" border="1" cellspacing="0" width="100%">
                    <tr bgcolor="#DDD">
                        <td width="20%">Nº. Inscrição</td>
                        <td width="40%">Nome que está no cadastro</td>
                        <td width="40%">Nome correto</td>
                    </tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                </table>
                <br>
                <strong>6. Identificação dos candidatos não alocados neste grupo, porém autorizados pela coordenação:</strong>
                <table style="font-size: 12px;text-align: center;" border="1" cellspacing="0" width="100%">
                    <tr bgcolor="#DDD">
                        <td width="20%">Nº. Inscrição</td>
                        <td width="40%">Nome do candidato</td>
                        <td width="40%">Motivo</td>
                    </tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                </table>
                <br>
                <strong>7. Candidatos que saíram para fazer prova em sala especial:</strong>
                <table style="font-size: 12px;text-align: center;" border="1" cellspacing="0" width="100%">
                    <tr bgcolor="#DDD">
                        <td width="20%">Nº. Inscrição</td>
                        <td width="40%">Nome do candidato</td>
                        <td width="40%">Motivo</td>
                    </tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td style="padding: 2px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                </table>
                <br>
                <strong>8. Três (3) últimos candidatos que permaneceram no grupo: &nbsp; &nbsp; &nbsp; &nbsp; Horário de saída: _____:_____</strong>
                <table style="font-size: 12px;text-align: center;" border="1" cellspacing="0" width="100%">
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
                <strong>9. Registre neste espaço outras ocorrências que julgar importante.</strong>
                <table style="font-size: 12px;" border="1" cellspacing="0" width="100%">
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
                <strong>Fiscais responsáveis pelo grupo:</strong>
                <table style="font-size: 12px;text-align: center;" border="0" cellspacing="0" width="100%">
                    <tr><td width="20%" style="padding: 15px;">Fiscal 1:</td><td width="40%">_____________________________________<br>Nome Completo</td><td width="40%">_____________________________________<br>Assinatura</td></tr>
                    <tr><td width="20%" style="padding: 15px;">Fiscal 2:</td><td width="40%">_____________________________________<br>Nome Completo</td><td width="40%">_____________________________________<br>Assinatura</td></tr>
                </table>

            </div>

                   	
            @php $flag = 1; @endphp
        @else
        	<div class="page-break"></div>
            @include('relatorios.pdf.partes.footer')	
		@endif
		@php
			$contoleLocal = $d->local; 
	 		$contoleSetor = $d->setor; 
	 		$contoleGrupo = $d->grupo; 
 		@endphp
	@empty
		<h4 style="text-align: center;">Não existem dados para a consulta realizada</h4>
	@endforelse

</body>