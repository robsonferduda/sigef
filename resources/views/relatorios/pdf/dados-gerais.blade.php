<head>
    <title>Dados Gerais do Vestibular</title>
    <link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('relatorios.pdf.partes.cabecalho-vertical')
    <div id="corpo">    
        <br><br>
        <h4 style="text-align: center; margin-bottom: 5px;">Dados Gerais do Vestibular</h4>

                <table id="tabelaDados" border="0" cellspacing="2" width="100%">
                    <thead>
                        <tr bgcolor="#DDDDDD">
                            <th style="text-align: left;" colspan="2">I - INSCRITOS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 10px;">Número de Candidados Inscritos:</td>
                            <td width="30%" style="text-align: center; padding-top: 10px;">{{ $dados['inscritos'] }} </td>
                        </tr>
                        <tr>
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 5px;">Número de Candidatos por Experiência:</td>
                            <td width="30%" style="text-align: center;padding-top: 5px;">{{ $dados['experiencia'] }} </td>
                        </tr>
                        <tr style="padding-top: 20px;">
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 5px;">Número de Candidatos Concorrentes:</td>
                            <td width="30%" style="text-align: center; padding-top: 5px;">{{ $dados['concorrentes'] }} </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table id="tabelaDados" border="0" cellspacing="2" width="100%">
                    <thead>
                        <tr bgcolor="#DDDDDD">
                            <th style="text-align: left;" colspan="2">II - ABSTENÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="padding-top: 20px;">
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 10px;">Indice de Abstenção na Prova 1:</td>
                            <td width="30%" style="text-align: center; padding-top: 10px;">{{ $dados['abstencao1'] }}% </td>
                        </tr>
                        <tr>
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 5px;">Indice de Abstenção na Prova 2:</td>
                            <td width="30%" style="text-align: center; padding-top: 5px;">{{ $dados['abstencao2'] }}% </td>
                        </tr>
                        <tr style="padding-top: 20px;">
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 5px;">Indice Geral de Abstenção:</td>
                            <td width="30%" style="text-align: center; padding-top: 5px;">{{ $dados['abstencaoGeral'] }}% </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table id="tabelaDados" border="0" cellspacing="2" width="100%">
                    <thead>
                        <tr bgcolor="#DDDDDD">
                            <th style="text-align: left;" colspan="2">III - DESEMPENHO DOS CANDIDATOS NO VESTIBULAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="padding-top: 20px;">
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 10px;">Total de Candidatos Classificados:</td>
                            <td width="30%" style="text-align: center; padding-top: 10px;">{{ $dados['classificados'] }} </td>
                        </tr>
                        <tr>
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 5px;">Total de Candidatos Aprovados e não Classificados:</td>
                            <td width="30%" style="text-align: center; padding-top: 5px;">{{ $dados['aprovados'] }} </td>
                        </tr>
                        <tr style="padding-top: 20px;">
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 5px;">Total de Candidatos Reprovados:</td>
                            <td width="30%" style="text-align: center; padding-top: 5px;">{{ $dados['reprovados'] }} </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table id="tabelaDados" border="0" cellspacing="2" width="100%">
                    <thead>
                        <tr bgcolor="#DDDDDD">
                            <th style="text-align: left;" colspan="2">IV - MOTIVO DAS REPROVAÇÕES DOS CONCORRENTES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="padding-top: 20px;">
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 10px;">Reprovados por falta:</td>
                            <td width="30%" style="text-align: center; padding-top: 10px;">{{ $dados['reprovadosFalta'] }} </td>
                        </tr>
                        <tr>
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 5px;">Reprovados por insuficiência de acertos na Opção 1 - Pontos de Corte:</td>
                            <td width="30%" style="text-align: center; padding-top: 5px;">{{ $dados['reprovadosCorteOpcao1'] }} </td>
                        </tr>
                        <tr style="padding-top: 20px;">
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 5px;">Reprovados por insuficiência de acertos na Opção 1A - Pontos de Corte:</td>
                            <td width="30%" style="text-align: center; padding-top: 5px;">{{ $dados['reprovadosCorteOpcao1A'] }} </td>
                        </tr>
                        <tr style="padding-top: 20px;">
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 5px;">Reprovados na Redação:</td>
                            <td width="30%" style="text-align: center; padding-top: 5px;">{{ $dados['reprovadosRedacao'] }} </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table id="tabelaDados" border="0" cellspacing="2" width="100%">
                    <thead>
                        <tr bgcolor="#DDDDDD">
                            <th style="text-align: left;" colspan="2">V - VAGAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="padding-top: 20px;">
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 10px;">Total de Vagas Oferecidas:</td>
                            <td width="30%" style="text-align: center; padding-top: 10px;">{{ $dados['vagasOferecidas'] }} </td>
                        </tr>
                        <tr>
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 5px;">Vagas Ocupadas na Opção 1:</td>
                            <td width="30%" style="text-align: center; padding-top: 5px;">{{ $dados['vagasOcupadasOpcao1'] }} </td>
                        </tr>
                        <tr style="padding-top: 20px;">
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 5px;">Vagas Ocupadas na Opção 1A:</td>
                            <td width="30%" style="text-align: center; padding-top: 5px;">{{ $dados['vagasOcupadasOpcao1A'] }} </td>
                        </tr>
                        <tr style="padding-top: 20px;">
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 5px;">Total de Vagas Ocupadas:</td>
                            <td width="30%" style="text-align: center; padding-top: 5px;">{{ $dados['vagasOcupadasTotal'] }} </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table id="tabelaDados" border="0" cellspacing="2" width="100%">
                    <thead>
                        <tr bgcolor="#DDDDDD">
                            <th style="text-align: left;" colspan="2">VI - ISENÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="padding-top: 20px;">
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 10px;">Total de Isenções Requeridas:</td>
                            <td width="30%" style="text-align: center; padding-top: 10px;">{{ $dados['isencoesRequeridas'] }} </td>
                        </tr>
                        <tr>
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 5px;">Total de Isenções Concedidas:</td>
                            <td width="30%" style="text-align: center; padding-top: 5px;">{{ $dados['isencoesConcedidas'] }} </td>
                        </tr>
                        <tr style="padding-top: 20px;">
                            <td width="70%" style="text-align: left; padding-left: 30px;padding-top: 5px;">Total de Isentos Classificados:</td>
                            <td width="30%" style="text-align: center; padding-top: 5px;">{{ $dados['isentosClassificados'] }} </td>
                        </tr>
                    </tbody>
                </table>
    </div>
    @include('relatorios.pdf.partes.footer')    
</body>