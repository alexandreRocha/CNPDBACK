<!DOCTYPE html>
 <html>

 <head> 
     <title>
        @if($processo->tipo_processo=="Autorizacao")
            Autorização {{ $processo->entidade }}
        @else
            Registo {{ $processo->entidade }}
        @endif 
    </title> 
 </head>
 
 <body>

     <img class="img-profile " width="60" height="40" src="admin/img/logo.png">

     <footer>
         <hr>
         <p> Contribuinte Nº: 370636406, Av. da China, Rampa da Terra Branca, Apartado 1002, C.P. 7600, Praia, Tel:
             (238) 5340390<br>cnpd@cnpd.cv, <u style="color:blue">www.cnpd.cv</u></p> 
     </footer>
     <main>
         <div class="row" id="geral">

            <div class="col-md-12"><br></div>
            <div class="col-md-12"><br></div> 
            <p id="center">
            @if($processo->tipo_processo=="Autorizacao")
                AUTORIZAÇÃO N.º {{$lastAutoSave->num_decisao}}/CNPD
            @else
                REGISTO N.º {{$lastAutoSave->num_decisao}}/CNPD
            @endif
            </p> 
            <br>

            <p id="negritoLeft">Processo nº. {{$processo->num_processo}}</p> 
            
            <p id="paragrafo">
                <b>I</b>
             </p> 
                @if($notificacao)
                        @foreach($notificacao as $notif) 
                            <div>
                                @if($processo->descricao_processo=="CCTV")
                                    <p id="paragrafo">
                                        <b>{{ $notif['nome_denominacao'] }}</b>, notificou à <b>Comissão Nacional de Protecção de Dados (CNPD)</b> um tratamento de dados pessoais
                                        resultante do sistema de videovigilância, com finalidade de <b>proteção de pessoas e bens</b> a realizar 
                                        @if($processo->tipo_entidade=="Particular") 
                                            na sua residência,
                                        @else
                                        no seu estabelecimento
                                        @endif
                                        sita em {{ $notif['local_responsavel_tratamento'] }}, Cidade da {{ $notif['local_responsavel_tratamento'] }},
                                        ilha de {{ $notif['ilha_responsavel_tratamento'] }}.
                                    </p>
                                    <p id="paragrafo">
                                        @if($notif['entidade_processamento_informacao']=="")
                                            O sistema, cuja responsabilidade de processamento da informação é do(a) próprio(a) notificante,
                                        @else
                                            O sistema, cuja responsabilidade de processamento da informação é da entidade <b>{{ $notif['entidade_processamento_informacao'] }}</b>,
                                        @endif 
                                    
                                        @php
                                            $formatter = new NumberFormatter('pt_PT', NumberFormatter::SPELLOUT);
                                        @endphp
                                        dispõe de  <b>{{ $notif['numero_camaras'] }} ({{ $formatter->format($notif['numero_camaras'])}}) câmaras</b>,
                                        abrangendo as seguintes áreas: 
                                       <!-- @if($notif['zonas_abrangidas']!="")
                                            @if ($notif['tipo_cctv'] == 'Formulário geral de videovigilância')
                                            <b>{{$notif['zonas_abrangidas']}}</b>,
                                            @else
                                                @foreach ($notif['zonas_abrangidas'] as $zona)
                                                <b>{{$zona}}</b>,
                                                @endforeach
                                            @endif
                                        @endif -->
                                        @if($notif['zonas_abrangidas']!="")
                                            @if ($notif['tipo_cctv'] == 'Formulário geral de videovigilância')
                                                <b>{{$notif['zonas_abrangidas']}}</b>
                                            @else
                                                @foreach ($notif['zonas_abrangidas'] as $index => $zona)
                                                    <b>{{$zona}}</b>@if ($index < count($notif['zonas_abrangidas']) - 1), @endif
                                                    @if ($index == count($notif['zonas_abrangidas']) - 1).@endif
                                                @endforeach
                                            @endif
                                        @endif

                                    </p>
                                    <p id="paragrafo">
                                        @if($notif['local_transmissao_imagens']!="")
                                            Há visualização das imagens em tempo real.
                                        @else
                                            Não há visualização das imagens em tempo real.
                                        @endif
                                    </p>
                                    <p id="paragrafo">
                                        @if($notif['quem_tem_acesso_imagens']!="")
                                            Há transmissão de imagens para fora do local de instalação.
                                        @else
                                            Não há transmissão de imagens para fora do local de instalação.
                                        @endif
                                    </p> 
                                    <p id="paragrafo">
                                        Os titulares dos dados podem exercer o direito de acesso de forma 
                                        @if ($notif['forma_direito_acesso'])
                                            @foreach ($notif['forma_direito_acesso'] as $forma)
                                            {{ $forma }},
                                            @endforeach
                                        @endif 
                                        @if($processo->tipo_entidade=="Particular")  
                                        junto do(a) notificante.   
                                        @else 
                                        junto do(a) <b>{{$notif['nome_denominacao']}}</b>.
                                        @endif
                                    </p>
                                    <p id="paragrafo">
                                        @if ($notif['parecer_representante_trabalhadores'])
                                            Existe representante dos trabalhadores.
                                        @else
                                            Não existe representante dos trabalhadores.
                                        @endif
                                    </p>
                                    <p id="paragrafo">
                                        @if ($notif['medidas_fisicas_seguranca']!="" || $notif['medidas_logicas_seguranca']!="")  
                                            Foram adotadas medidas de segurança no sistema.
                                        @else
                                            Não foram adotadas medidas de segurança.
                                        @endif
                                    </p> 
                                    <p id="negritoLeft">
                                    II
                                    <br>
                                    <br>
                                    Apreciando, 
                                    </p>
                                    
                                    <p id="paragrafo"><b>1-</b> A utilização do sistema de videovigilância que está regulada através da Lei n.º 86/VIII/2015, de 14 de abril, doravante designada por lei de videovigilância, visa proteger pessoas e bens e, por conseguinte, prevenir a criminalidade e auxiliar as autoridades policiais na tarefa primordial de garantir a segurança interna e a tranquilidade pública, conforme o estabelecido no n.º 1 do artigo 244.º da Constituição da República de Cabo Verde.</p>

                                    <p id="paragrafo">As gravações levadas a cabo por esse sistema de videovigilância implicam necessariamente a captação de imagens de pessoas singulares, que se deslocam à residência do(a) notificante, consubstanciando, assim, em tratamento de dados pessoais na medida em que identifiquem ou sejam passíveis de identificar pessoas singulares, nos termos das alíneas a) e b) do n.º 1 e n.º 2 do artigo 5.º da Lei n.º 133/V/2001, de 22 de janeiro, alterada pela Lei n.º 41/VIII/2013, de 17 de setembro e Lei n.º 121/IX/2021, de 17 de março, doravante designada por LPDP, que estabelece o regime jurídico geral de proteção de dados pessoais das pessoas singulares.</p>    

                                    <p id="paragrafo">É sabido que a imagem de uma pessoa singular corresponde a sua aparência ou configuração física , permitindo que a distinga das demais, pelo que está abrangida, como já se aludiu, pela definição de dado pessoal. </p>

                                    <p id="paragrafo"><b>2-</b> O tratamento de dados pessoais deve processar-se no estrito respeito pelos direitos, liberdades e garantias fundamentais das pessoas singulares, em especial pelo direito à reserva da intimidade da vida privada e familiar e pelo direito à proteção de dados pessoais, por força do artigo 4.º da LPDP. </p>

                                    <p id="paragrafo">Mais, estabelecem as alíneas a), b) e c) do n.º 1 do artigo 6.º da LPDP e artigo 4.º da lei de videovigilância, que os dados devem ser tratados de forma lícita, transparente e com respeito pelo princípio da boa-fé, recolhidos para finalidades determinadas, explícitas, legítimas não podendo ser tratados posteriormente de forma incompatível com essas finalidades. Devem ser ainda adequados, pertinentes e limitados ao mínimo necessário às finalidades para que são tratados.  </p>

                                    <p id="paragrafo"><b>3-</b> Atendendo às finalidades de proteção de pessoas e bens e prevenção da prática de crime ou identificação dos seus autores que subjazem à instalação do sistema de videovigilância em apreço, implicam que as imagens recolhidas sejam suscetíveis de ser utilizadas como provas de infração criminal ou contraordenacional. </p>

                                    <p id="paragrafo">Deste modo, estão em causa dados pessoais relativos a suspeitas de atividades ilícitas, infrações penais, contraordenações, cujo tratamento pode <b>ser autorizado pela CNPD</b>, observadas as normas de proteção de dados e de segurança da informação, quando tal tratamento for necessário à execução de finalidades legítimas do seu responsável, desde que não prevaleçam os direitos, liberdades e garantias do titular dos dados, de acordo com o n.º 2 do artigo 11.º e alínea a) do n.º 1 do artigo 40.º, ambos da LPDP.

                                    <p id="paragrafo"><b>4-</b> Dispõe o n.º 2 do artigo 46.º do Código Laboral que, a utilização do equipamento tecnológico como meio de vigilância à distância no local de trabalho é lícita sempre que tenha por finalidade a proteção e segurança de pessoas e bens.

                                    <p id="paragrafo">A finalidade do presente tratamento é exclusivamente a proteção de pessoas e bens, nos termos do n.º 1 do artigo 26.º da lei de videovigilância, estando na sua base a prevenção de infrações penais e a perseguição de eventuais suspeitos de atividades ilícitas, nomeadamente crimes contra as pessoas e contra a propriedade.</p>
                                        @if($processo->tipo_entidade=="Particular")  
                                        <p id="paragrafo">No caso em apreço, as câmaras de videovigilância colhem necessariamente imagens de pessoas singulares identificadas ou passíveis de identificação, porquanto abrangem espaços de circulação comuns e públicos. </p>
                                        @else 
                                        <p id="paragrafo">No caso em apreço, tendo em conta as atividades que o/a <b>{{$notif['nome_denominacao']}}</b> desenvolve diariamente, proporcionando movimentação de pessoas e bens, faz com que haja um especial risco de segurança não só para os seus trabalhadores e bens, como também para as pessoas que frequentam as suas instalações. </p>
                                        @endif
                                    
                                    <p id="paragrafo"><b>5-</b> As imagens coligidas pelo sistema de videovigilância instalado devem ser adequadas e <b>não excessivas</b> face à finalidade de proteção de pessoas e bens, não podendo haver <b>câmaras com o foco para a propriedade de terceiros e via pública</b>.
                                    
                                    <p id="paragrafo">A instalação do sistema de videovigilância não visou e nem visa investigar qualquer ilícito criminal ou contraordenacional em concreto, razão pela qual são colhidas imagens de todas as pessoas que estiverem na área abrangida pelas câmaras. Porém, se ocorrer tais ilícitos, o suporte original das gravações devem ser enviadas ao Ministério Público ou entidade administrativa competente, consoante o caso, devendo as gravações serem conservadas até ao termo do respetivo processo, findo o qual são eliminadas, nos termos dos artigos 20.º e 21.º do n.º 2 da lei de videovigilância.</p>
                                    <p id="paragrafo">No entanto, se não forem pertinentes e nem necessárias, <b>as imagens não podem ser vistas e nem conservadas, em registo codificado, por mais de 30 (trinta dias)</b>, nos termos do artigo 21.º da lei de videovigilância.</p>

                                    <p id="paragrafo"><b>6-</b> As pessoas que forem gravadas pelas câmaras têm direitos de acesso, retificação, apagamento e oposição, desde que o seu exercício não constitua perigo para a segurança pública, não ponha em causa direitos e liberdades fundamentais de terceiros e nem prejudique o bom andamento do processo judicial. Esses direitos podem ser exercidos diretamente de forma 
                                        @if ($notif['forma_direito_acesso'])
                                            @foreach ($notif['forma_direito_acesso'] as $forma)
                                            {{ $forma }},
                                            @endforeach
                                        @endif 
                                        @if($processo->tipo_entidade=="Particular")  
                                        junto do(a) responsável pelo tratamento
                                        @else 
                                        junto do(a) <b>{{$notif['nome_denominacao']}}</b>
                                        @endif
                                        ou através da CNPD, à luz do disposto no artigo 29.º da lei de videovigilância e artigos 14.º, 15.º, 16.º e 20.º da LPDP.</p>

                                    <p id="paragrafo">Ao disponibilizar a gravação ao titular de dados, 
                                        
                                        @if($processo->tipo_entidade=="Particular")  
                                        o/a notificante 
                                        @else 
                                        o/a {{$notif['nome_denominacao']}}
                                        @endif
                                        deve adotar medidas técnicas necessárias para ocultar as imagens de terceiros que possam ter sido abrangidos pela gravação.</p>

                                    <p id="paragrafo">Para que uma pessoa, cuja imagem tenha sido captada, exerça os direitos de acesso e de apagamento, ela tem de ser informada de que aquele local está a ser vigiado, fazendo justiça à finalidade basicamente preventiva e dissuasora da atividade criminosa com instalação do sistema de videovigilância. 
                                        Assim sendo, deve ser afixado 
                                        
                                        @if($processo->tipo_entidade=="Particular")  
                                        pelo responsável pelo tratamento
                                        @else 
                                        pelo(a) <b>{{$notif['nome_denominacao']}}</b>
                                        @endif
                                         em local bem visível, um aviso com os seguintes dizeres: <i><b>Para sua proteção, este lugar encontra-se sob vigilância de um circuito fechado de televisão, procedendo à gravação de imagem</b></i>, nos termos exigidos pelo n.º 3 do artigo 24.º da lei de videovigilância e pela Portaria n.º 56/2015, de 13 de novembro.  </p>

                                    <p id="paragrafo"><b>7-</b> Considerando a natureza especial das imagens, 
                                    
                                    @if($processo->tipo_entidade=="Particular")  
                                    o/a responsável pelo tratamento
                                        @else 
                                    o/a <b>{{$notif['nome_denominacao']}}</b>
                                        @endif
                                     deve pôr em prática medidas adequadas e acrescidas de segurança para controlar as entradas nas instalações, os suportes de dados, a inserção, a introdução, a utilização, o acesso, a transmissão e o transporte das imagens recolhidas, nos termos dos artigos 24.º e 25.º, ambos da LPDP. Por imposição do artigo 17.º da lei de videovigilância, deve-se ainda manter uma lista atualizada das pessoas autorizadas a aceder às imagens. </p>

                                    <p id="paragrafo"><b>8-</b> Tendo em consideração os princípios estabelecidos pela lei de videovigilância em conjugação com as disposições do Código Laboral Cabo-verdiano, resultam os seguintes <b><u>limites ao tratamento:</u></b></p>

                                    <p id="paragrafo1"><b><li></li> É proibida a captação de som;</b></p>
                                    <p id="paragrafo1"><b><li></li>As câmaras não podem ter o foco voltado para propriedade de terceiro e nem para a via pública;  </b></p>
                                    @if($processo->tipo_entidade=="Particular") 
                                            
                                    @else
                                        <p id="paragrafo1"><a><li></li>As imagens não devem ser utilizadas para controlar o desempenho profissional, a assiduidade e a pontualidade dos trabalhadores;</b></p>
                                        <p id="paragrafo1"><a><li></li>A recolha de imagens será feita apenas em relação aos locais declarados no presente pedido de autorização. Não podem ser captadas imagens de acesso ou interior de instalações reservadas ao uso privado dos trabalhadores ou que não se destinem ao cumprimento de tarefas relacionadas com o emprego, como <b>casas de banho, refeitório, cacifos e copa</b>.</p>
                                    @endif
                                    
                                    <p id="paragrafo1"><a><li></li>Deve ser afixado, em local bem visível, um aviso com os seguintes dizeres: <i><b>“Para sua proteção, este lugar encontra-se sob vigilância de um circuito fechado de televisão, procedendo à gravação de imagem”.</b></i></b></p>

                                    <br><br>
                                    <b>III</b> 
                                    <br><br>
                                    <table>
                                        <tr>
                                        <th colspan="2">
                                              Nestes termos, ao abrigo do n.º 2 do artigo 11.º, alínea a) do n.º 1 do artigo 40.º e n.º 1 do artigo 42.º, todos da LPDP e alínea a) do n.º 1 do artigo 10.º da Lei n.º 42/VIII/2017, de 17 de setembro, alterada pela Lei n.º 120/IX/2021, de 17 de março, a CNPD <b>autoriza</b> o tratamento notificado nos seguintes termos: 
                                        </th>
                                        </tr>

                                        <tr>
                                            <td id="negritoLeft">Responsável pelo tratamento</td>
                                            <td><b>{{ $notif['nome_denominacao'] }}</b></td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Categoria de dados pessoais tratados</td>
                                            <td>Imagens captadas pelo sistema de videovigilância</td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Finalidade</td>
                                            <td>Proteção de pessoas e bens</td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Comunicação de imagens</td>
                                            <td>Não podem ser comunicadas, exceto nos termos da lei, nomeadamente às autoridades judiciárias e policiais</td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Forma de exercício do direito de acesso</td>
                                            <td>
                                                Os titulares dos dados podem exercer o direito de acesso de forma 
                                                @if ($notif['forma_direito_acesso'])
                                                    @foreach ($notif['forma_direito_acesso'] as $forma)
                                                    {{ $forma }},
                                                    @endforeach
                                                @endif 
                                                @if($processo->tipo_entidade=="Particular")  
                                                junto do(a) notificante.   
                                                @else 
                                                junto do(a) <b>{{$notif['nome_denominacao']}}</b>.
                                                @endif
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Interconexão</td>
                                            <td>Não há</td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Transferência para o estrangeiro</td>
                                            <td>Não há</td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Tempo de conservação de dados</td>
                                            <td>30 (trinta) dias</td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Segurança</td>
                                            <td>Manter as medidas de segurança indicadas e implementar as previstas na lei</td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Hora</td>
                                            <td>
                                                @if($processo->tipo_entidade=="Particular")  
                                                O/A responsável pelo tratamento 
                                                @else 
                                                O(A) <b>{{$notif['nome_denominacao']}}</b>.
                                                @endif
                                                 deve manter sempre atualizada a data e a hora das gravações
                                            </td>
                                        </tr>
                                    </table>

                                    <br> <br>
                                    <p id="negritoLeft">Registe e notifique.</p> 
                                    <br>
                                    <p id="paragrafo">Praia, 
                                        @php
                                        setlocale(LC_TIME, 'pt_BR'); 
                                        echo $dataAtual = strftime('%d de %B de %Y'); 
                                        @endphp 
                                    </p> 
                                    
                                    <br>
                                    <p id="paragrafo">Faustino Varela Monteiro (Presidente)</p>









                                @elseif($processo->descricao_processo=="Biometria")

                                <p id="paragrafo">
                                    <b>{{ $notif['nome_denominacao'] }}</b>, notificou à  <b>Comissão Nacional de Protecção de Dados (CNPD)</b> 
                                    o tratamento de dados biométricos dos seus trabalhadores,
                                        tendo como finalidade o 
                                        @foreach ($notif['finalidade_tratamento'] as $finalidade)
                                            <b>{{ $finalidade }},</b>
                                        @endforeach 
                                    a realizar no seu estabelecimento, 
                                    situado em {{ $notif['local_responsavel_tratamento'] }}, Cidade da {{ $notif['local_responsavel_tratamento'] }},
                                        ilha de {{ $notif['ilha_responsavel_tratamento'] }}.
                                </p>

                                <p id="paragrafo">
                                    O tratamento notificado processa os dados relativos ao 
                                    @foreach ($notif['dados_registrados'] as $dadosRecolhidos)
                                        <b>{{ $dadosRecolhidos }},</b>
                                    @endforeach
                                </p>

                                <p id="paragrafo">
                                    Os Dados recolhidos estão armazenados no
                                    @foreach ($notif['forma_registro'] as $formaRegisto)
                                            <b>{{ $formaRegisto }},</b>
                                    @endforeach 
                                    e o tratamento é feito numa <b>{{$notif['forma_tratamento_informacao']}}</b>,
                                    e diariamente, os colaboradores fazem o registo biométrico de 
                                    @foreach ($notif['finalidade_tratamento'] as $finalidade)
                                        <b>{{ $finalidade }}</b>,
                                    @endforeach. 
                                </p>

                                <p id="paragrafo">
                                    O processamento das informações é da responsabilidade
                                    @if($notif['entidade_processamento_informacao']=="")
                                        do(a) próprio(a) notificante.
                                    @else
                                    O processamento das informações é da responsabilidade da entidade <b>{{ $notif['entidade_processamento_informacao'] }}.</b>
                                    @endif 
                                </p>
                                    
                                <p id="paragrafo">
                                Os trabalhadores, titulares dos dados, podem exercer o direito de acesso de forma 
                                    @if ($notif['forma_direito_acesso'])
                                        @foreach ($notif['forma_direito_acesso'] as $forma)
                                        {{ $forma }},
                                        @endforeach
                                    @endif
                                    @if($processo->tipo_entidade=="Particular")  
                                    junto do(a) notificante.   
                                    @else 
                                    junto do(a) <b>{{$notif['nome_denominacao']}}</b>.
                                    @endif
                                </p>
                                <p id="paragrafo">
                                    @if ($notif['parecer_representante_trabalhadores'])
                                        Existe representante dos trabalhadores.
                                    @else
                                        Não existe representante dos trabalhadores.
                                    @endif
                                </p> 
                                <p id="paragrafo">
                                O sistema biométrico abrange  
                                @php
                                    $formatter = new NumberFormatter('pt_PT', NumberFormatter::SPELLOUT);
                                @endphp
                                <b>{{ $notif['numero_funcionarios'] }} ({{ $formatter->format($notif['numero_funcionarios'])}})</b>
                                trabalhadores.
                                </p>

                                <p id="paragrafo">
                                    @if ($notif['medidade_seguranca_fisica']!="" || $notif['medidas_seguranca_logica']!="")  
                                        Foram adotadas medidas de segurança no sistema.
                                    @else
                                        Não foram adotadas medidas de segurança.
                                    @endif
                                </p>  
                                <p id="negritoLeft">
                                    II
                                    <br>
                                    <br>
                                    Apreciando, 
                                    </p>

                                    <p id="paragrafo"><b>1-</b> O desenvolvimento tecnológico tem contribuído para uma maior utilização dos sistemas biométricos para diferentes finalidades. Os sistemas biométricos têm outras vantagens em relação aos sistemas tradicionais, visto que a informação necessária para permitir controlar o acesso e a assiduidade não se perde e nem é suscetível de apropriação ilícita.
                                    </p>
                                    <p id="paragrafo">Por outro lado, deve-se ter em consideração que as caraterísticas biométricas não deixam de representar uma parte da individualidade das pessoas, estando ligadas intrinsecamente à própria pessoa. 
                                    </p>
                                    <p id="paragrafo"><b>2-</b> Entende-se por dados pessoais qualquer informação, de <i>qualquer natureza e independentemente do respetivo suporte, incluindo som e imagem relativa a uma pessoa singular identificada ou identificável, «titular dos dados». É considerada identificável a pessoa que possa ser identificada, direta ou indiretamente, em especial por referência a um identificador, como por exemplo, um nome, um número de identificação, dados de localização, identificadores por via eletrónica ou a um ou mais elementos específicos da identidade física, fisiológica, genética, mental, económica, cultural ou social dessa pessoa singular</i>, nos termos da alínea a) do n.º 1 e n.º 2 do artigo 5.º da Lei n.º 133/V/2001, de 22 de janeiro, alterada pela Lei n.º 41/VIII/2013, de 17 de setembro e pela Lei n.º 121/IX/2021, de 17 de março, doravante designada por LPDP, que estabelece o regime jurídico geral de proteção de dados pessoais das pessoas singulares.
                                    </p>
                                    <p id="paragrafo">Nos termos da alínea m) do n.º 1 do artigo 5.º da LPDP, dados biométricos <i>são dados pessoais resultantes de um tratamento técnico específico, relativos às caraterísticas físicas, fisiológicas ou comportamentais de uma pessoa singular, que permitam ou confirmem a sua identificação única, tais como imagens faciais ou dados dactiloscópicos. </i>
                                    </p>
                                    <p id="paragrafo">Sendo o dado biométrico elemento intrínseco de cada indivíduo, a sua ligação a uma pessoa concreta é única. Deste modo, o dado biométrico a identifica e, com este objetivo, é utilizado em diferentes dimensões sociais e económicas, consubstanciando em dado especial, nos termos do n.º 1 do artigo 8.º da LPDP. 
                                    </p>
                                    <p id="paragrafo"><b>3-</b> Em regra, o tratamento de dados especiais é proibido, conforme o disposto no n.º 1 do artigo 8.º da LPDP. Todavia, o tratamento é permitido mediante consentimento expresso do titular dos dados ou autorização legal, ambos com garantias de não discriminação e com medidas de segurança adequadas, ou, ainda, mediante autorização da CNPD, quando o tratamento tiver como fundamento um interesse público importante ou <b>for necessário para a prossecução de interesses legítimos do responsável pelo tratamento, com garantias de não discriminação e com as medidas de segurança adequadas</b>, nos termos das alienas a), b) e d) do n.º 1 do artigo 8.º da LPDP.
                                    </p>
                                    <p id="paragrafo">No caso em apreço, tendo em conta a assimetria de poderes entre o/a <b>{{ $notif['nome_denominacao'] }}</b> e os seus trabalhadores, o consentimento destes não constituirá condição de legitimidade de tratamento. Embora se reconheça a importância da colaboração dos trabalhadores para o bom funcionamento do sistema biométrico, impondo, deste modo, que a responsável pelo tratamento, procure a anuência dos mesmos na recolha de dados, bem como na sua apresentação posterior perante o sistema para a identificação.
                                    </p>
                                    <p id="paragrafo"><b>4-</b> É certo, porém, que o/a <b>{{ $notif['nome_denominacao'] }}</b> tem, neste particular, interesses legítimos a prosseguir, os quais consubstanciam em planear, organizar, coordenar, determinar a disciplina do trabalho e exigir do trabalhador todo e qualquer comportamento que seja objetivamente adequado ao cumprimento dos deveres a que se encontra vinculado pelo contrato, nomeadamente o dever de comparecer ao trabalho com pontualidade e assiduidade, conforme o disposto na alínea b) do n.º 1 do artigo 128.º e nos n.ºs 1 e 2 do artigo 131.º do Código Laboral, aprovado pelo Decreto-legislativo n.º 5/2007, de 16 de outubro e alterado pelo Decreto-legislativo n.º 1/2016, de 3 de fevereiro.
                                    </p>
                                    <p id="paragrafo">De todo o modo, o código laboral não constitui por si só fundamento de legitimidade do tratamento de dados, porquanto não dispõe de todas as indicações obrigatórias determinadas no n.º 1 do artigo 42.º da LPDP.
                                    </p>
                                    <p id="paragrafo">Assim, no caso em apreço, o fundamento jurídico do tratamento assenta-se na autorização da CNPD tendo em conta a necessidade desse tratamento para a prossecução de interesses legítimos do(a) <b>{{ $notif['nome_denominacao'] }}</b> nos termos antes referidos da alínea d) do n.º 1 do artigo 8.º da LPDP.
                                    </p>
                                    <p id="paragrafo">5-</b> A finalidade de controlo de assiduidade mostra-se legítima e determinada e os dados tratados para o efeito são proporcionais e não há violação inaceitável de liberdades e direitos fundamentais dos trabalhadores, nos termos das alíneas a), b) e c) do n.º 1 do artigo 6.º da LPDP.
                                    </p>
                                    <p id="paragrafo">O tratamento em causa divide-se em dois momentos, a saber: O primeiro momento corresponde o registo dos trabalhadores no sistema, possibilitando a captura das caraterísticas de dados biométricos que são convertidas em um modelo que as representa “matematicamente”; O segundo momento consiste na autenticação/verificação, na qual os trabalhadores apresentam as suas caraterísticas biométricas que são comparadas e validadas com o modelo armazenado. 
                                    </p>
                                    <p id="paragrafo">Este procedimento demonstra ser importante para a proteção da privacidade, pois o/a <b>{{ $notif['nome_denominacao'] }}</b> não dispõe de uma base de dados das caraterísticas do reconhecimento de cada trabalhador, mas de uma lista estruturada e digitalizada (codificada) dessas caraterísticas biométricas, não sendo, portanto, passível de ser reproduzida. Ou seja, haverá um processo de algoritmização, o qual gera um template que representa numericamente a caraterística biométrica captada, que não permite fazer a reversão e, por conseguinte, descodificar e reproduzir, de forma digitalizada, a imagem de caraterística biométrica. 
                                    </p>
                                    <p id="paragrafo">6-</b> O/A <b>{{ $notif['nome_denominacao'] }}</b> deve assegurar o direito de informação a cada trabalhador em relação à finalidade do tratamento, as categorias de dados pessoais tratados, a existência e as condições de exercício dos direitos de acesso, retificação, apagamento e oposição, as condições de utilização e conservação dos dados recolhidos, conforme dispõe o artigo 13.º do n.º 1 da LPDP. 
                                    </p>
                                    <p id="paragrafo">A informação é dada antes do início do tratamento de dados, mas igualmente posterior, enquanto durar o tratamento de dados.  
                                    </p>
                                    <p id="paragrafo">Do mesmo modo, dispõe o trabalhador do direito de oposição, a qualquer momento, por razões ponderosas e legítimas relacionadas com a sua situação particular, a que os dados que lhe digam respeito sejam objeto de tratamento, de acordo com o estabelecido na alínea a) do artigo 20.º da LPDP.
                                    </p>
                                    <p id="paragrafo">7-</b> No que tange à segurança dos dados, estabelece o n.º 1 do artigo 24.º da LPDP que, “o responsável pelo tratamento deve por em prática as medidas técnicas e organizativas adequadas para proteger os dados pessoais contra a destruição acidental ou ilícita, a perda, a alteração, a difusão ou o acesso não autorizado (…)”. 
                                    Não sendo possível a reversão da caraterística biométrica, o tratamento do template do impressão digital, da forma e para a finalidade supramencionada, não apresenta grandes riscos em relação aos direitos dos trabalhadores. 
                                    </p>
                                    <p id="paragrafo">8-</b> <b>{{ $notif['nome_denominacao'] }}</b> deve ter em atenção à seguinte observação:
                                    <p id="paragrafo1"><b><li></li> O/A <b>{{ $notif['nome_denominacao'] }}</b> deve conservar esses dados de caraterísticas biométricas dos seus trabalhadores, enquanto durar o seu vínculo laboral.
                                    </p>

                                    <br>
                                    <b>III</b> 
                                    <br><br>
                                    <table>
                                        <tr>
                                        <th colspan="2">
                                            <p> 
                                            De todo o exposto, ao abrigo das disposições conjugadas da alínea d) do n.º 1 do artigo 8.º, do n.º 1 do artigo 39.º, n.º 1 do artigo 42.º, todos da LPDP, e da alínea a) do n.º 1 do artigo 10.º da Lei n.º 42/VIII/2013, de 17 de setembro, alterada pela Lei n.º 120/IX72021, de 17 de março, a CNPD <b>autoriza</b> o tratamento de dados biométricos nos seguintes termos:
                                            <p> 
                                        </th>
                                        </tr>

                                        <tr>
                                            <td id="negritoLeft">Responsável pelo tratamento</td>
                                            <td><b>{{ $notif['nome_denominacao'] }}</b></td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Categoria de dados pessoais tratados</td>
                                            <td>
                                            @foreach ($notif['dados_registrados'] as $dadosRecolhidos)
                                                <b>{{ $dadosRecolhidos }},</b>
                                            @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Finalidade</td>
                                            <td>
                                            @foreach ($notif['finalidade_tratamento'] as $finalidade)
                                                <b>{{ $finalidade }},</b>
                                            @endforeach 
                                            A informação biométrica não pode ser utilizada para outra finalidade.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Entidades a quem podem ser transmitidos</td>
                                            <td>Não há comunicação de dados a terceiros</td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Forma de exercício do direito de acesso e retificação</td>
                                            <td>
                                                Os titulares dos dados podem exercer o direito de acesso de forma 
                                                @if ($notif['forma_direito_acesso'])
                                                    @foreach ($notif['forma_direito_acesso'] as $forma)
                                                    {{ $forma }},
                                                    @endforeach
                                                @endif 
                                                @if($processo->tipo_entidade=="Particular")  
                                                junto do(a) notificante.   
                                                @else 
                                                junto do(a) <b>{{$notif['nome_denominacao']}}</b>.
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Eventuais interconexões</td>
                                            <td>Não há</td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Transferência de dados para outros países</td>
                                            <td>Não há</td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Prazos de conservação</td>
                                            <td>Os dados deverão ser conservados enquanto durar o vínculo laboral</td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Segurança</td>
                                            <td>Manter as medidas de segurança indicadas e implementar as previstas na lei</td>
                                        </tr>
                                        <tr>
                                            <td id="negritoLeft">Hora</td>
                                            <td><b>{{ $notif['nome_denominacao'] }}</b> deve manter sempre atualizada a data e a hora no sistema</td>
                                        </tr>
                                    </table>

                                    <br> <br>
                                    <p id="negritoLeft">Registe e notifique.</p> 
                                    <br>
                                    <p id="paragrafo">Praia, 
                                        <?php
                                            setlocale(LC_TIME, 'pt_BR');
                                            $dataAtual = strftime('%d de %B de %Y');
                                            echo strtolower($dataAtual); 
                                        ?>
                                    </p> 
                                    
                                    <br>
                                    <p id="paragrafo">Faustino Varela Monteiro (Presidente)</p>



                                @endif
                            </div>
                        @endforeach
                @endif 
     </main>
<!-- Numeração da página -->
 
 </body>

 </html>
 <style>
    #pupu{
        color:red
    }
    #paragrafo{
        text-align: justify;
        text-justify: inter-word;
        font-family: 'Times New Roman', Times, serif;
        color:black;
    }
    #paragrafo1{
        text-align: justify;
        text-justify: inter-word;
        font-family: 'Times New Roman', Times, serif;
        color:black;
        padding-left: 50px;
    }
    #center {
        font-weight: bold;
        text-align: center;
    }

    #negritoLeft {
        font-weight: bold;
        text-align: left;
    }

    footer {
        position: fixed;
        left: 0px;
        right: 0px;
        height: 150px;
        bottom: 0px;
        margin-bottom: -130px;
        text-align: center;
        font-size: 10px;
        color: #061536;
        font-family: "Times New Roman", Times, serif;
    }

    header {
        position: fixed;
        left: 0px;
        right: 0px;
        height: 150px;
        margin-top: -150px;
    }

    #notFound {
        color: #ffffff;
        border-style: ridge;
        border-radius: 10px;
        background-color: #990000;
        text-align: center;
    }

    #geral {
        font-size: 14px;
        background-color: #fff;
        color: #061536;
        font-family: "Times New Roman", Times, serif;
        margin-left: 5px;
        margin-right: 10px
    }

    #cabecalho {
        color: #ffffff;
        border-style: ridge;
        border-radius: 5px;
        background: #061536;
    }

    #name {
        font-weight: bold;
        color: #061536;
    }

    #right {
        text-align: right;
    }

    #nameCenter {
        text-align: center;
    }

    #descricao {
        color: #061536;
        border-style: ridge;
    }

    #reptrab {
        height: auto;
        z-index: 10000000;
    }

    #borderStyle {
        color: #061536;
        border-style: ridge;
    }

    td, th {
    font-weight: normal;
    }
    table {
        font-family: "Times New Roman", Times, serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        text-align: left;
        padding: 8px;
    }

    th {
        width: 40%
    }

    table,
    th,
    td {
        border: 1px solid #061536;
    }
 </style>