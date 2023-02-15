<head>
    <title>Gabarito Oficial</title>
    <link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('relatorios.pdf.partes.cabecalho-vertical')
    @php $zebra = true; $controleDisciplina = ''; @endphp
    <div id="corpo" style="margin-top: 0px; padding-top: 0px;">    
        <h4 style="text-align: center; margin-bottom: 5px; font-weight: 300; text-transform: uppercase; ">Gabarito {{ $titulo }}</h4>
                <table id="tabelaDados" border="1" cellspacing="0" cellpadding="3" width="100%" style="border-collapse: collapse;text-align: center;">
                    <thead>
                        <tr>
                            <th rowspan="2">Questão</th>
                            <th rowspan="2">Disciplina</th>
                            <th rowspan="2">Nº de Proposições</th>
                            <th colspan="7">Proposições corretas</th>
                            <th rowspan="2">Gabarito</th>
                        </tr>
                        <tr>
                                <th style="width:5%">01</th>
                                <th style="width:5%">02</th>
                                <th style="width:5%">04</th>
                                <th style="width:5%">08</th>
                                <th style="width:5%">16</th>
                                <th style="width:5%">32</th>
                                <th style="width:5%">64</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gabaritos as $key => $gab)	
                            @php 
                                $prop = App\Utils::decompoesGabarito($gab->nu_resposta_gab ); 

                                if($disciplinas->where('nu_questao_inicial_dis','=', $gab->nu_questao_gab)->first())
                                    $nm_disciplina = $disciplinas->where('nu_questao_inicial_dis','=', $gab->nu_questao_gab)->first()->nm_disciplina_dis;
                            @endphp
                            <tr style="background: {{ ($zebra) ? '#DDD;' : '#FFFFFF;' }}">
                                <td>{{ $gab->nu_questao_gab }}</td>
                                <td>
                                    @if($controleDisciplina != $nm_disciplina)
                                        {{$nm_disciplina}}
                                    @endif
                                </td>
                                <td>{{ ($gab->nu_proposicoes_gab==0)?"ABERTA": $gab->nu_proposicoes_gab }}</td>
                                <td>{{ ($gab->nu_proposicoes_gab!=0 and isset($prop[1]))? 'X':'' }}</td>
                                <td>{{ ($gab->nu_proposicoes_gab!=0 and isset($prop[2]))? 'X':'' }}</td>
                                <td>{{ ($gab->nu_proposicoes_gab!=0 and isset($prop[4]))? 'X':'' }}</td>
                                <td>{{ ($gab->nu_proposicoes_gab!=0 and isset($prop[8]))? 'X':'' }}</td>
                                <td>{{ ($gab->nu_proposicoes_gab!=0 and isset($prop[16]))? 'X':'' }}</td>
                                <td>{{ ($gab->nu_proposicoes_gab!=0 and isset($prop[32]))? 'X':'' }}</td>
                                <td>{{ ($gab->nu_proposicoes_gab!=0 and isset($prop[64]))? 'X':'' }}</td>
                                <td>{{ str_pad($gab->nu_resposta_gab,2,'0',STR_PAD_LEFT) }}</td>
                            </tr>	
                
                        @php 
                            $zebra = !$zebra; 
                            $controleDisciplina = $nm_disciplina;
                        @endphp
                
                        @empty
                            <tr><td colspan="3"><h4 class="center">Nenhum dado para ser exibido</h4></td></tr>
                        @endforelse
                    </tbody>
                </table>
    </div>
</body>