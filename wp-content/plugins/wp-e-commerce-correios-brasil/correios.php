<?php
/*
Plugin Name: wpsc-correios
Plugin URI: http://www.dlojavirtual.com
Description: Permite o calculo de frete atraves dos Correios com varias forma de frete como Sedex, Esedex, Pac.
Version: 1.5
Author: D Loja Virtual .
Author URI: http://www.dlojavirtual.com
License: GPL2
*/

/*  Copyright 2010  Instinct ent.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class wpsc_correios {
	var $internal_name, $name;
	
	function wpsc_correios () {
		$this->internal_name = "correios";
		$this->name="correios";
		$this->is_external=true;
		$this->requires_curl=true;
		$this->requirements = array(
		 /// so that you can restrict merchant modules to PHP 5, if you use PHP 5 features
		'php_version' => 5.0,
		 /// for modules that may not be present, like curl
		'extra_modules' => array('soap')
	);

		$this->requires_weight=true;
		$this->needs_zipcode=true;
		return true;
	}
	
		
	function getName() {
		return $this->name;
	}
	
	
	function getInternalName() {
		return $this->internal_name;
	}
	
	function getForm() {
		$wpsc_correios_settings = get_option("wpsc_correios_settings");	
		
		/*
		* TIPOS DE FRETE
		*
			 41106 = PAC sem contrato
			 41068 = PAC com contrato
			 40010 = SEDEX sem contrato
			 40096 = SEDEX com contrato
			 40436 = SEDEX com contrato
			 40444 = SEDEX com contrato
			 40045 = SEDEX a Cobrar, sem contrato
			 40215 = SEDEX 10, sem contrato
			 40290 = SEDEX Hoje, sem contrato
			 81019 = e-SEDEX, com contrato
			 
		*
		*
		*/
		
		$pac_options['41106'] = __('41106 - PAC sem contrato', 'wpsc');
		$pac_options['41068'] = __('41068 - PAC com contrato', 'wpsc');
		$sedex_options['40010'] = __('40010 - SEDEX sem contrato', 'wpsc');
		$sedex_options['40096'] = __('40096 - SEDEX com contrato', 'wpsc');
		$sedex_options['40436'] = __('40436 - SEDEX com contrato', 'wpsc');
		$sedex_options['40444'] = __('40444 - SEDEX com contrato', 'wpsc');
		$sedexacobrar_options['40045'] = __('40045 - SEDEX A Cobrar, sem contrato', 'wpsc');
		$sedex10_options['40215'] = __('40215 - SEDEX 10, sem contrato', 'wpsc');
		$sedexhoje_options['40290'] = __('40290 - SEDEX Hoje, sem contrato', 'wpsc');
		$esedex_options['81019'] = __('81019 - eSEDEX, com contrato', 'wpsc');

		  $output = ("<b>Configura&ccedil;&otilde;es Gerais</b><br><tr>\n\r
                             <td>".__('Correios Usuario', 'wpsc')." :</td>
                             <td>
                                 <input type=\"text\" name='wpsc_correios_settings[correiosusuario]' value=\"".$wpsc_correios_settings[correiosusuario]."\" />
                             </td>
                         </tr>");
            $output .= ("<tr>
                            <td>".__('Correios Senha', 'wpsc')." :</td>
                            <td>
                                <input type=\"password\" name='wpsc_correios_settings[correiossenha]' value=\"".$wpsc_correios_settings[correiossenha]."\" />
                            </td>
                        </tr>");
		$output .= "<tr>\n\r";
		$output .= "	<td>M&atilde;o pr&oacute;pria?</td>\n\r";
		$output .= "	<td>\n\r";
		switch($wpsc_correios_settings['MaoPropria']) {
		  case '0':
		  $checked[0] = "checked='checked'";
		  $checked[1] = "";
		  break;		  
		  
		  case '1':
		  default:
		  $checked[0] = "";
		  $checked[1] = "checked='checked'";
		  break;
		}
		$output .= "		<label><input type='radio' {$checked[1]} value='1' name='wpsc_correios_settings[MaoPropria]'/>Sim</label>\n\r";
		$output .= "		<label><input type='radio' {$checked[0]} value='0' name='wpsc_correios_settings[MaoPropria]'/>N&atilde;o</label>\n\r";
		
		$output .= "	</td>\n\r";
		$output .= "</tr>\n\r";
				
				
		$output .= "<tr>\n\r";
		$output .= "	<td>Aviso de recebimento?</td>\n\r";
		$output .= "	<td>\n\r";
		switch($wpsc_correios_settings['avisoRecebimento']) {
		  case '0':
		  $checked[0] = "checked='checked'";
		  $checked[1] = "";
		  break;		  
		  
		  case '1':
		  default:
		  $checked[0] = "";
		  $checked[1] = "checked='checked'";
		  break;
		}
		$output .= "		<label><input type='radio' {$checked[1]} value='1' name='wpsc_correios_settings[avisoRecebimento]'/>Sim</label>\n\r";
		$output .= "		<label><input type='radio' {$checked[0]} value='0' name='wpsc_correios_settings[avisoRecebimento]'/>N&atilde;o</label>\n\r";
		
		$output .= "	</td>\n\r";
		$output .= "</tr>\n\r";
		$output .= "<tr>\n\r";
		$output .= "	<td><b>Dimens&otilde;es Padr&atilde;o<b></td>\n\r";
		$output .= "	<td>\n\r";
		$output .= ("<tr>
                            <td>".__('Comprimento', 'wpsc')." :</td>
                            <td>
                                <input type=\"text\" name='wpsc_correios_settings[correios_comprimento]' value=\"".$wpsc_correios_settings[correios_comprimento]."\" />
                            </td>
                        </tr>");
		$output .= ("<tr>
                            <td>".__('Altura', 'wpsc')." :</td>
                            <td>
                                <input type=\"text\" name='wpsc_correios_settings[correios_altura]' value=\"".$wpsc_correios_settings[correios_altura]."\" />
                            </td>
                        </tr>");
		$output .= ("<tr>
                            <td>".__('Largura', 'wpsc')." :</td>
                            <td>
                                <input type=\"text\" name='wpsc_correios_settings[correios_largura]' value=\"".$wpsc_correios_settings[correios_largura]."\" />
                            </td>
                        </tr>");
		$output .= "<tr>\n\r";
		$output .= "	<td><b>Servi&ccedil;os dispon&iacute;veis<b></td>\n\r";
		$output .= "	<td>\n\r";
 		

		if((!empty($wpsc_correios_settings['Servicos'])) && ($wpsc_correios_settings['Servicos']['pac']['ativo']==1)) {
			$checkedpac_sim = "checked='checked'";
			$style_pac = "style='display:'';'";
		} else {
			$checkedpac_nao = "checked='checked'";
			$style_pac = "style='display:none;'";
		}
		
		if((!empty($wpsc_correios_settings['Servicos'])) && ($wpsc_correios_settings['Servicos']['sedex']['ativo']==1)) {
			$checkedsedex_sim = "checked='checked'";
			$style_sedex = "style='display:'';'";
		} else {
			$checkedsedex_nao = "checked='checked'";
			$style_sedex = "style='display:none;'";
		}
		
		if((!empty($wpsc_correios_settings['Servicos'])) && ($wpsc_correios_settings['Servicos']['esedex']['ativo']==1)) {
			$checkedesedex_sim = "checked='checked'";
			$style_esedex = "style='display:'';'";
		} else {
			$checkedesedex_nao = "checked='checked'";
			$style_esedex = "style='display:none;'";
		}
		
		if((!empty($wpsc_correios_settings['Servicos'])) && ($wpsc_correios_settings['Servicos']['sedex10']['ativo']==1)) {
			$checkedsedex10_sim = "checked='checked'";
			$style_sedex10 = "style='display:'';'";
		} else {
			$checkedsedex10_nao = "checked='checked'";
			$style_sedex10 = "style='display:none;'";
		}
		if((!empty($wpsc_correios_settings['Servicos'])) && ($wpsc_correios_settings['Servicos']['sedexhoje']['ativo']==1)) {
			$checkedsedexhoje_sim = "checked='checked'";
			$style_sedexhoje = "style='display:'';'";
		} else {
			$checkedsedexhoje_nao = "checked='checked'";
			$style_sedexhoje = "style='display:none;'";
		}
		
		if((!empty($wpsc_correios_settings['Servicos'])) && ($wpsc_correios_settings['Servicos']['sedexacobrar']['ativo']==1)) {
			$checkedsedexacobrar_sim = "checked='checked'";
			$style_sedexacobrar = "style='display:'';'";
		} else {
			$checkedsedexacobrar_nao = "checked='checked'";
			$style_sedexacobrar = "style='display:none;'";
		}
		

				 
		$output .= "<tr>
		  				<th scope=\"row\">
							PAC
						</th>
					   	<td>
							<input type='radio' onclick='jQuery(\"#pac\").show()' value='1' name='wpsc_correios_settings[Servicos][pac][ativo]' id='wpsc_correios_settings[Servicos][pac][ativo]' ". $checkedpac_sim ." /> <label for='wpsc_correios_settings[Servicos][pac]_sim'>Sim</label> &nbsp;
							<input type='radio' onclick='jQuery(\"#pac\").hide()' value='0' name='wpsc_correios_settings[Servicos][pac][ativo]' id='wpsc_correios_settings[Servicos][pac][ativo]' ".$checkedpac_nao." /> <label for='wpsc_correios_settings[Servicos][pac]_nao'>N&acirc;o</label>
	   				   	</td>
				   	</tr>
				   						<tr>
					   	<td colspan=\"2\">
   							<div  id='pac' ".$style_pac.">
								Codigo PAC: ";
			$output .= "		<select name='wpsc_correios_settings[Servicos][pac][codigo]'>\n\r";
            foreach($pac_options as $key => $name) {
              $selected = '';
                    if($key == $wpsc_correios_settings['Servicos']['pac']['codigo']) {
                            $selected = "selected='true' ";
                    }
                    $output .= "			<option value='{$key}' {$selected}>{$name}</option>\n\r";
            }
            $output .= "		</select>\n\r						
						</div>
					   	</td>
				   </tr>";
	
		
		$output .= "<tr>
		  				<th scope=\"row\">
							SEDEX
						</th>
					   	<td>
							<input type='radio' onclick='jQuery(\"#sedex\").show()' value='1' name='wpsc_correios_settings[Servicos][sedex][ativo]' id='wpsc_correios_settings[Servicos][sedex][ativo]' ". $checkedsedex_sim ." /> <label for='wpsc_correios_settings[Servicos][sedex]_sim'>Sim</label> &nbsp;
							<input type='radio' onclick='jQuery(\"#sedex\").hide()' value='0' name='wpsc_correios_settings[Servicos][sedex][ativo]' id='wpsc_correios_settings[Servicos][sedex][ativo]' ".$checkedsedex_nao." /> <label for='wpsc_correios_settings[Servicos][sedex]_nao'>N&acirc;o</label>
	   				   	</td>
				   	</tr>
				   	<tr>
					   	<td colspan=\"2\">
   							<div  id='sedex' ".$style_sedex.">
								Codigo SEDEX: ";
			$output .= "		<select name='wpsc_correios_settings[Servicos][sedex][codigo]'>\n\r";
            foreach($sedex_options as $key => $name) {
              $selected = '';
                    if($key == $wpsc_correios_settings['Servicos']['sedex']['codigo']) {
                            $selected = "selected='true' ";
                    }
                    $output .= "			<option value='{$key}' {$selected}>{$name}</option>\n\r";
            }
            $output .= "		</select>\n\r						
						</div>
					   	</td>
				   </tr>";
		
		$output .= "<tr>
		  				<th scope=\"row\">
							eSEDEX
						</th>
					   	<td>
							<input type='radio' onclick='jQuery(\"#esedex\").show()' value='1' name='wpsc_correios_settings[Servicos][esedex][ativo]' id='wpsc_correios_settings[Servicos][esedex][ativo]' ". $checkedesedex_sim ." /> <label for='wpsc_correios_settings[Servicos][esedex]_sim'>Sim</label> &nbsp;
							<input type='radio' onclick='jQuery(\"#esedex\").hide()' value='0' name='wpsc_correios_settings[Servicos][esedex][ativo]' id='wpsc_correios_settings[Servicos][esedex][ativo]' ".$checkedesedex_nao." /> <label for='wpsc_correios_settings[Servicos][esedex]_nao'>N&acirc;o</label>
	   				   	</td>
				   	</tr>
				   	<tr>
					   	<td colspan=\"2\">
   							<div  id='esedex' ".$style_esedex.">
								Codigo eSEDEX: ";
			$output .= "		<select name='wpsc_correios_settings[Servicos][esedex][codigo]'>\n\r";
            foreach($esedex_options as $key => $name) {
              $selected = '';
                    if($key == $wpsc_correios_settings['Servicos']['esedex']['codigo']) {
                            $selected = "selected='true' ";
                    }
                    $output .= "			<option value='{$key}' {$selected}>{$name}</option>\n\r";
            }
            $output .= "		</select>\n\r						
						</div>
					   	</td>
				   </tr>";
		
		$output .= "<tr>
		  				<th scope=\"row\">
							SEDEX 10
						</th>
					   	<td>
							<input type='radio' onclick='jQuery(\"#sedex10\").show()' value='1' name='wpsc_correios_settings[Servicos][sedex10][ativo]' id='wpsc_correios_settings[Servicos][sedex10][ativo]' ". $checkedsedex10_sim ." /> <label for='wpsc_correios_settings[Servicos][sedex10]_sim'>Sim</label> &nbsp;
							<input type='radio' onclick='jQuery(\"#sedex10\").hide()' value='0' name='wpsc_correios_settings[Servicos][sedex10][ativo]' id='wpsc_correios_settings[Servicos][sedex10][ativo]' ".$checkedsedex10_nao." /> <label for='wpsc_correios_settings[Servicos][sedex10]_nao'>N&acirc;o</label>
	   				   	</td>
				   	</tr>
				   	<tr>
					   	<td colspan=\"2\">
   							<div  id='sedex10' ".$style_sedex10.">
								Codigo SEDEX 10: ";
			$output .= "		<select name='wpsc_correios_settings[Servicos][sedex10][codigo]'>\n\r";
            foreach($sedex10_options as $key => $name) {
              $selected = '';
                    if($key == $wpsc_correios_settings['Servicos']['sedex10']['codigo']) {
                            $selected = "selected='true' ";
                    }
                    $output .= "			<option value='{$key}' {$selected}>{$name}</option>\n\r";
            }
            $output .= "		</select>\n\r						
						</div>
					   	</td>
				   </tr>";
		 $output .= "<tr>
		  				<th scope=\"row\">
							SEDEX HOJE
						</th>
					   	<td>
							<input type='radio' onclick='jQuery(\"#sedexhoje\").show()' value='1' name='wpsc_correios_settings[Servicos][sedexhoje][ativo]' id='wpsc_correios_settings[Servicos][sedexhoje][ativo]' ". $checkedsedexhoje_sim ." /> <label for='wpsc_correios_settings[Servicos][sedexhoje]_sim'>Sim</label> &nbsp;
							<input type='radio' onclick='jQuery(\"#sedexhoje\").hide()' value='0' name='wpsc_correios_settings[Servicos][sedexhoje][ativo]' id='wpsc_correios_settings[Servicos][sedexhoje][ativo]' ".$checkedsedexhoje_nao." /> <label for='wpsc_correios_settings[Servicos][sedexhoje]_nao'>N&acirc;o</label>
	   				   	</td>
				   	</tr>
				   	<tr>
					   	<td colspan=\"2\">
   							<div  id='sedexhoje' ".$style_sedexhoje.">
								Codigo SEDEX HOJE: ";
			$output .= "		<select name='wpsc_correios_settings[Servicos][sedexhoje][codigo]'>\n\r";
            foreach($sedexhoje_options as $key => $name) {
              $selected = '';
                    if($key == $wpsc_correios_settings['Servicos']['sedexhoje']['codigo']) {
                            $selected = "selected='true' ";
                    }
                    $output .= "			<option value='{$key}' {$selected}>{$name}</option>\n\r";
            }
            $output .= "		</select>\n\r						
						</div>
					   	</td>
				   </tr>";
		$output .= "<tr>
		  				<th scope=\"row\">
							SEDEX A COBRAR
						</th>
					   	<td>
							<input type='radio' onclick='jQuery(\"#sedexacobrar\").show()' value='1' name='wpsc_correios_settings[Servicos][sedexacobrar][ativo]' id='wpsc_correios_settings[Servicos][sedexacobrar][ativo]' ". $checkedsedexacobrar_sim ." /> <label for='wpsc_correios_settings[Servicos][sedexacobrar]_sim'>Sim</label> &nbsp;
							<input type='radio' onclick='jQuery(\"#sedexacobrar\").hide()' value='0' name='wpsc_correios_settings[Servicos][sedexacobrar][ativo]' id='wpsc_correios_settings[Servicos][sedexacobrar][ativo]' ".$checkedsedexacobrar_nao." /> <label for='wpsc_correios_settings[Servicos][sedexacobrar]_nao'>N&acirc;o</label>
	   				   	</td>
				   	</tr>
				   	<tr>
					   	<td colspan=\"2\">
   							<div  id='sedexacobrar' ".$style_sedexacobrar.">
								Codigo SEDEX A COBRAR: ";
			$output .= "		<select name='wpsc_correios_settings[Servicos][sedexacobrar][codigo]'>\n\r";
            foreach($sedexacobrar_options as $key => $name) {
              $selected = '';
                    if($key == $wpsc_correios_settings['Servicos']['sedexacobrar']['codigo']) {
                            $selected = "selected='true' ";
                    }
                    $output .= "			<option value='{$key}' {$selected}>{$name}</option>\n\r";
            }
            $output .= "		</select>\n\r						
						</div>
					   	</td>
				   </tr>";
		
		 
		
		
		return $output;
	}
	
	function submit_form() {
		if ($_POST['wpsc_correios_settings'] != '') {	
			update_option('wpsc_correios_settings', $_POST['wpsc_correios_settings']);
		}
		return true;
	}
	
	function valida_codigo_servico($codigo_servico) {
		
		
		
		if ($codigo_servico == 'pac') {
			
			$retorno_codigo_servico = '41106';
			
			} elseif ($codigo_servico == 'sedex') {
			
			$retorno_codigo_servico = '40010';
			
			} elseif ($codigo_servico == 'sedexacobrar') {
			
			$retorno_codigo_servico = '40045';
			
			} elseif ($codigo_servico == 'sedex10') {
			
			$retorno_codigo_servico = '40215';
			
			} elseif ($codigo_servico == 'sedexhoje') {
			
			$retorno_codigo_servico = '40290';
			
			}
		
		
		
		return $retorno_codigo_servico;
	}
	
	
	function frete_correios($cep_destino, $peso, $retorno = 'array', $codigo, $wpsc_correios_settings)
	{
		
		
	   // TRATA OS CEP'S
	   $cep_destino = eregi_replace("([^0-9])",'',$cep_destino);
	   $cep_origem = get_option('base_zipcode');
	 
	   //$webservice = 'http://shopping.correios.com.br/wbm/shopping/script/CalcPrecoPrazo.asmx?WSDL';// URL ANTIGA
	   $webservice = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?WSDL';
	  if ($wpsc_correios_settings['MaoPropria']==1) {
		   	$mao_propria = 'S';
		} else {
			$mao_propria = 'N';
		}
		
		 if ($wpsc_correios_settings['avisoRecebimento']==1) {
		   	$aviso_recebimento = 'S';
		} else {
			$aviso_recebimento = 'N';
		}

		 $comprimento = (!empty($wpsc_correios_settings['correios_comprimento']) ? $wpsc_correios_settings['correios_comprimento'] : '18');
		 $altura = (!empty($wpsc_correios_settings['correios_altura']) ? $wpsc_correios_settings['correios_altura'] : '2'); 
		 $largura = (!empty($wpsc_correios_settings['correios_largura']) ? $wpsc_correios_settings['correios_largura'] : '11');	

	   $parms_array = array(
	   'nCdServico' => $codigo,// 
	   'nCdEmpresa' => (!empty($wpsc_correios_settings['correiosusuario']) ? $wpsc_correios_settings['correiosusuario'] : ''),// <- LOGIN DO CADASTRO NO CORREIOS (OPCIONAL)
	   'sDsSenha' => (!empty($wpsc_correios_settings['correiossenha']) ? $wpsc_correios_settings['correiossenha'] : ''),// <- SENHA DO CADASTRO NO CORREIOS (OPCIONAL)
	   'StrRetorno' => 'xml',
	 	   // DADOS DINAMICOS
	   'sCepDestino' => $cep_destino,// CEP CLIENTE
	   'sCepOrigem' => $cep_origem,// CEP DA LOJA (BD)
	   'nVlPeso' => number_format($peso/2.2, 3, '.', ''),
	   'nVlComprimento' => $comprimento,
	   'nVlDiametro' => 5,
	   'nVlAltura' =>  $altura,
	   'nVlLargura' => $largura,
	   'nCdFormato' => 1,
	   'sCdMaoPropria' => $mao_propria,
	   'nVlValorDeclarado' => 0,
	   'sCdAvisoRecebimento' => $aviso_recebimento
	   );
	   
	   $parms = new stdClass;
	   $parms->nCdServico = $codigo;// 
	   $parms->nCdEmpresa = (!empty($wpsc_correios_settings['correiosusuario']) ? $wpsc_correios_settings['correiosusuario'] : '');// <- LOGIN DO CADASTRO NO CORREIOS (OPCIONAL)
	   $parms->sDsSenha = (!empty($wpsc_correios_settings['correiossenha']) ? $wpsc_correios_settings['correiossenha'] : '');// <- SENHA DO CADASTRO NO CORREIOS (OPCIONAL)
	   $parms->StrRetorno = 'xml';
	 
	   // DADOS DINAMICOS
	   $parms->sCepDestino = $cep_destino;// CEP CLIENTE
	   $parms->sCepOrigem = $cep_origem;// CEP DA LOJA (BD)
	   $parms->nVlPeso = number_format($peso/2.2, 3, '.', '');
	 
	   // VALORES MINIMOS DO PAC (SE VC PRECISAR ESPECIFICAR OUTROS FAÇA ISSO AQUI)
	   $parms->nVlComprimento = $comprimento;
	   $parms->nVlDiametro = 5;
	   $parms->nVlAltura = $altura;
	   $parms->nVlLargura = $largura;
	 
	   // OUTROS OBRIGATORIOS (MESMO VAZIO)
	   $parms->nCdFormato = 1;
	   $parms->sCdMaoPropria = $mao_propria;
	   $parms->nVlValorDeclarado = 0;
	   $parms->sCdAvisoRecebimento = $aviso_recebimento;
	 
 	
	 
	 if(@extension_loaded('soap')) { // Check to see if PHP-SOAP is loaded, if so, use that
	 
		  if(($this->soap_client == null) || !is_a($this->soap_client, 'SoapClient')) {
				$soap = @ new SoapClient($webservice, array('trace' => true,
														   'exceptions' => true,
														   'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
														   'connection_timeout' => 1000
												   ));
			}
			
			$resposta = $soap->CalcPrecoPrazo($parms);
		} else { // otherwise include and use nusoap
			
		  if(($this->soap_client == null) || !is_a($this->soap_client, 'soapclient')) {
				include_once(WPSC_FILE_PATH.'/wpsc-includes/nusoap/nusoap.php');
				$this->soap_client = new soapclient($webservice, true);
			}
			$this->soap_client->setEndpoint($webservice);
			$resposta = $this->soap_client->call('CalcPrecoPrazo',  $parms_array);
		}
	 
	 
	 	
	   // Resgata o valor calculado
		if (is_array($resposta)) {
		 
			$resposta['CalcPrecoPrazoResult'];
			$objeto = $resposta['CalcPrecoPrazoResult']['Servicos']['cServico'];
			$array = array();
			if ($objeto['Valor'] > 0) {
				$valor_total = str_replace(',','.',$objeto['Valor'])+str_replace(',','.',$objeto['ValorMaoPropria'])+str_replace(',','.',$objeto['ValorAvisoRecebimento']);
			} else {
				$valor_total = 0;
			}
	
			$array= array('Codigo'=>$objeto['Codigo'],'valor'=>$valor_total,'prazo'=>$objeto['PrazoEntrega'],'erro'=>$objeto['Erro'],'msg'=>$objeto['MsgErro']);
	} else {
		
		$objeto = $resposta->CalcPrecoPrazoResult->Servicos->cServico;
		$array = array();
	  
		if ($objeto->Valor > 0) {
			$valor_total = str_replace(',','.',$objeto->Valor)+str_replace(',','.',$objeto->ValorMaoPropria)+str_replace(',','.',$objeto->ValorAvisoRecebimento);
		} else {
			$valor_total = 0;
		}
	
		$array= array('Codigo'=>$objeto->Codigo,'valor'=>$valor_total,'prazo'=>$objeto->PrazoEntrega,'erro'=>$objeto->Erro,'msg'=>$objeto->MsgErro);

		
		
	}
		
	return $array;
	   
	}
	
	
	
	function getQuote() {
		global $wpdb, $wpsc_cart;
		$dest = $_SESSION['delivery_country'];
		$wpsc_correios_settings = get_option("wpsc_correios_settings");
		$weight = wpsc_cart_weight_total();

		
		if(is_object($wpsc_cart)) {
			$price = $wpsc_cart->calculate_subtotal(true);
		}
		
		if(isset($_POST['zipcode'])) {
		  $zipcode = $_POST['zipcode'];      
		  $_SESSION['wpsc_zipcode'] = $_POST['zipcode'];
		} else if(isset($_SESSION['wpsc_zipcode'])) {
		  $zipcode = $_SESSION['wpsc_zipcode'];
		}

		if($_GET['debug'] == 'true') {
 			echo('<pre>'.print_r($wpsc_correios_settings,true).'</pre>');
 		}
		
		
		
		$shipping_cache_check['zipcode'] = $zipcode;
		$shipping_cache_check['weight'] = $weight;
 		//$_SESSION['wpsc_shipping_cache_check']
		//this is where shipping breaks out of correios if weight is higher than 150 LBS
		//$shipping_cache_check = null;
 		if(($_SESSION['wpsc_shipping_cache_check'] === $shipping_cache_check) && ($_SESSION['wpsc_shipping_cache'][$this->internal_name] != null)) {
			$shipping_list = $_SESSION['wpsc_shipping_cache'][$this->internal_name];
 		} else {
			//$services = $this->getMethod($_SESSION['wpsc_delivery_country']);
			
			$services = $wpsc_correios_settings['Servicos'];
				
				foreach ($services as $key => $service) {
						
					if($service['ativo']==1) {
						
						
						if (empty($service['codigo'])) {
							$codigo = $this->valida_codigo_servico($key);
						} else {
							
							$codigo = $service['codigo'];
						}
						
						$valor_frete = $this->frete_correios($zipcode, $weight, $retorno = 'array', $codigo, $wpsc_correios_settings);
						
						if(($valor_frete['valor'])>0) {
							$shipping_list[$key. " (Prazo de entrega " . $valor_frete['prazo'] . " dia(s) uteis)"] = $valor_frete['valor'];	
						}						
					}
					
					
				
				}
				
				$_SESSION['wpsc_shipping_cache_check']['zipcode'] = $zipcode;
				$_SESSION['wpsc_shipping_cache_check']['weight'] = $weight;
				$_SESSION['wpsc_shipping_cache'][$this->internal_name] = $shipping_list;
			
		}
		return $shipping_list;
	}
	
	function get_item_shipping() {
	}
}
//$correios = new correios();
//$wpsc_shipping_modules[$correios->getInternalName()] = $correios;


function wpsc_correios_setup() {
	global $wpsc_shipping_modules;
	$correios = new wpsc_correios();
	$wpsc_shipping_modules[$correios->getInternalName()] = $correios;
}

add_action('plugins_loaded', 'wpsc_correios_setup');

?>