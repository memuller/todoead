<?php
$nzshpcrt_gateways[$num]['name'] = 'moip 0.1';
$nzshpcrt_gateways[$num]['internalname'] = 'Moip';
$nzshpcrt_gateways[$num]['function'] = 'gateway_moip';
$nzshpcrt_gateways[$num]['form'] = "form_moip";
$nzshpcrt_gateways[$num]['submit_function'] = "submit_moip";
$nzshpcrt_gateways[$num]['payment_type'] = "credit_card";

function gateway_moip($seperator, $sessionid)
{
	global $wpdb, $wpsc_cart;
	$purchase_log_sql = "SELECT * FROM `".WPSC_TABLE_PURCHASE_LOGS."` WHERE `sessionid`= ".$sessionid." LIMIT 1";
	$purchase_log = $wpdb->get_results($purchase_log_sql,ARRAY_A) ;

	$cart_sql = "SELECT * FROM `".WPSC_TABLE_CART_CONTENTS."` WHERE `purchaseid`='".$purchase_log[0]['id']."'";
	$cart = $wpdb->get_results($cart_sql,ARRAY_A) ; 
  
	// Variaveis do ambiente do moip
	
	if (get_option("moip_ambiente") == 1) {
									
		$token_moip = "5WY4W17IO8YULCV6PEIIB0MVPMSQRD4G";
		$chave = "0R2EPFUQIGHVAGNXJKQAJFNNP8NUGERYDAXCKRC9";
		$moip_url = "https://www.moip.com.br/ws/alpha/EnviarInstrucao/Unica";
	
	} else {
		$token_moip = "QWLVHGDSIINXALZJSHCPYF1AEUQYIZAV";
		$chave = "KDFHDBSNW5HSNGUM1SY4WYNVZOFCIQJT096A5RL9";
		$moip_url = "https://desenvolvedor.moip.com.br/sandbox/ws/alpha/EnviarInstrucao/Unica";
	
	
	}
	
	$id_pedido = $sessionid;
	
	$url_retorno_site = get_option('siteurl');
	
	if (stripos( $url_retorno_site,"?")) {
		$moip_retorno = $url_retorno_site."&amp;moip_callback=true&amp;sessionid=" . $sessionid;
	} else {
		$moip_retorno = $url_retorno_site."/?moip_callback=true&amp;sessionid=" . $sessionid;
	}
	
	$mail_moip = get_option('moip_email');
	
		
	
	// Detalhes do usuario   
	if($_POST['collected_data'][get_option('moip_form_first_name')] != '')
    {  
		if($_POST['collected_data'][get_option('moip_form_last_name')] != "")
   		    {   
    			$nome_cliente = $_POST['collected_data'][get_option('moip_form_first_name')] . " " . $_POST['collected_data'][get_option('moip_form_last_name')];
   			} else { 
    			$nome_cliente = $_POST['collected_data'][get_option('moip_form_first_name')];
			}
    }
	
  	if($_POST['collected_data'][get_option('moip_form_address')] != '')
    {   
    	$endereco_cliente = $_POST['collected_data'][get_option('moip_form_address')]; 
    }
   	if($_POST['collected_data'][get_option('moip_form_city')] != '')
    {
    	$cidade_cliente = $_POST['collected_data'][get_option('moip_form_city')]; 
    }
  	  
	if($_POST['collected_data'][get_option('moip_form_post_code')] != '')
    {
    	$cep_cliente = $_POST['collected_data'][get_option('moip_form_post_code')]; 
    }
	
	if($_POST['collected_data'][get_option('moip_form_email')] != '')
    {
    	$email_cliente = $_POST['collected_data'][get_option('moip_form_email')]; 
    }
	
 
	$currency_code = $wpdb->get_results("SELECT `code` FROM `".WPSC_TABLE_CURRENCY_LIST."` WHERE `id`='".get_option('currency_type')."' LIMIT 1",ARRAY_A);
	$local_currency_code = $currency_code[0]['code'];
	$moip_currency_code = get_option('moip_curcode');
  
	
	$curr=new CURRENCYCONVERTER();
	$decimal_places = 2;
	$total_price = 0;
  
	$i = 1;
  
	$all_donations = true;
	$all_no_shipping = true;
	$produtos_moip = "";
	foreach($cart as $item)
	{
		$product_data = $wpdb->get_results("SELECT * FROM `".WPSC_TABLE_PRODUCT_LIST."` WHERE `id`='".$item['prodid']."' LIMIT 1",ARRAY_A);
		$product_data = $product_data[0];
		$variation_count = count($product_variations);
    
		$variation_sql = "SELECT * FROM `".WPSC_TABLE_CART_ITEM_VARIATIONS."` WHERE `cart_id`='".$item['id']."'";
		$variation_data = $wpdb->get_results($variation_sql,ARRAY_A);
		$variation_count = count($variation_data);

		if($variation_count >= 1)
      	{
      		$variation_list = " (";
      		$j = 0;
      		foreach($variation_data as $variation)
        	{
        		if($j > 0)
          		{
          			$variation_list .= ", ";
          		}
        		$value_id = $variation['venue_id'];
        		$value_data = $wpdb->get_results("SELECT * FROM `".WPSC_TABLE_VARIATION_VALUES."` WHERE `id`='".$value_id."' LIMIT 1",ARRAY_A);
        		$variation_list .= $value_data[0]['name'];              
        		$j++;
        	}
      		$variation_list .= ")";
      	}
      	else
        {
        	$variation_list = '';
        }
    
    	$local_currency_productprice = $item['price'];

			$local_currency_shipping = $item['pnp'] * $item['quantity'];
    	

			$moip_currency_productprice = $local_currency_productprice;
			$moip_currency_shipping = $local_currency_shipping;
			
    	$produtos_moip = $produtos_moip . "<Mensagem>" . $item['prodid'] . " - " . retira_acentos_moip($item['name'].$variation_list) . " - Quantidade: " . $item['quantity'] . " - Preco: " . number_format(sprintf("%01.2f", $moip_currency_productprice),$decimal_places,'.','') . "</Mensagem>";
    	
    	$i++;
	}
	
	$base_shipping = $wpsc_cart->base_shipping;
	if(($base_shipping > 0) && ($all_donations == false) && ($all_no_shipping == false))
    {
		$frete_moip = number_format($base_shipping,$decimal_places,'.','');
		
    }

	$desconto_cupom = $wpsc_cart->coupons_amount;

	if(($desconto_cupom > 0)){
		$desconto_moip = " <Deducao moeda=\"BRL\">" . number_format($desconto_cupom,$decimal_places,'.',''). "</Deducao>";
		
    }
	
	$total_carrinho = $wpsc_cart->calculate_total_price();
	
	if(($total_carrinho > 0)){
		$total_moip = " <Valor moeda=\"BRL\">" . number_format($total_carrinho,$decimal_places,'.',''). "</Valor>";
		
    }
	
	//$mail_moip 
	$id_unico_loja = substr($mail_moip,0,20-strlen($id_pedido));
   	$id_unico_loja = $id_unico_loja . "[" . $id_pedido ."]";
$output = "<EnviarInstrucao>
			   <InstrucaoUnica>
				  <Razao>Carrinho de compras Loja Modelo</Razao>
				  <IdProprio>".$id_unico_loja."</IdProprio>
				  <FormasPagamento>
					 <FormaPagamento>BoletoBancario</FormaPagamento>
					 <FormaPagamento>CarteiraMoIP</FormaPagamento>
					 <FormaPagamento>CartaoCredito</FormaPagamento>
					 <FormaPagamento>DebitoBancario</FormaPagamento>
					 <FormaPagamento>FinanciamentoBancario</FormaPagamento>
				  </FormasPagamento>
				  <Valores>
					 ".$total_moip."
					 ".$desconto_moip."
				  </Valores>
				  <Mensagens>
					 ".retira_acentos_moip($produtos_moip)."
				  </Mensagens>
				  <Pagador>
				  	<Nome>".$nome_cliente."</Nome>
					<Email>".$email_cliente."</Email>
					
					<EnderecoCobranca>	
						<Logradouro>".$endereco_cliente."</Logradouro>
						<CEP>".$cep_cliente."</CEP>
						<Cidade>".$cidade_cliente."</Cidade>
						<Pais>BRA</Pais>
						
					</EnderecoCobranca>
				 </Pagador>
				  <Recebedor>
				  	<LoginMoIP>".$mail_moip." </LoginMoIP>
				  </Recebedor>
				  <URLRetorno>".$moip_retorno."</URLRetorno>	
				  <URLNotificacao>".$moip_retorno."</URLNotificacao>
			   </InstrucaoUnica>
			</EnviarInstrucao>";  
	$token = $token_moip;
	$key = $chave;
	$base = $token . ":" . $key;
	$auth = base64_encode($base);

	$header[] = "Authorization: Basic " . $auth;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL,$moip_url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	curl_setopt($curl, CURLOPT_USERPWD, $user . ":" . $passwd);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0");
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $output);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$retorno_moip = curl_exec($curl);
	$retorno_moip_erro = curl_error($curl);
	curl_close($curl);
	

	$dom = new DOMDocument;
	$dom->loadXML($retorno_moip);
	if (!$dom) {
		echo 'Error while parsing the document';
		exit;
		}
	$retorno_moip_carregado =  simplexml_import_dom($dom);
	
	

	if ($retorno_moip_carregado->Resposta->Status == "Sucesso") { 
	
		$token_redirecionamento = $retorno_moip_carregado->Resposta->Token;
		if (get_option("moip_ambiente") == 1) {
			$url_redirecionamento = "https://www.moip.com.br/Instrucao.do?token=" . $token_redirecionamento;
		} else {
			$url_redirecionamento = "https://desenvolvedor.moip.com.br/sandbox/Instrucao.do?token=" . $token_redirecionamento;
		}
	
	  
	
	} else {
		
		echo $retorno_moip;
		exit();
		
	}
	
	
	

	//print_r($retorno_moip_carregado);	

	// echo form.. 
	if( get_option('moip_debug') == 1)
	{
		echo ("DEBUG MODE ON!!<br/>");
		echo("O formulario abaixo sera enviado para o moip para o processo de pagamento. Pressione enviar para continuar:<br/>");
		echo("<pre>".htmlspecialchars($output)."</pre>");
		
		echo("<br><a href=".$url_redirecionamento.">".$url_redirecionamento."</a>");
	}
	
	
	if(get_option('moip_debug') == 0)
	{
		header("location:".$url_redirecionamento);
		
	}

  	exit();
}
 

function nzshpcrt_moip_results()
{

	if ($_REQUEST['moip_callback'] ==true)	{
			
$id_quebrado =  explode("[",$_POST['id_transacao']);
$id_trasacao_limpo = substr($id_quebrado[1],0,strlen($id_quebrado[1])-1);
$_GET['sessionid'] = $id_trasacao_limpo;


/* Montando as variáveis de retorno */

$id_transacao = $id_trasacao_limpo;
$valor = $_POST['valor'];
$status_pagamento = $_POST['status_pagamento'];
$cod_moip = $_POST['cod_moip'];
$forma_pagamento = $_POST['forma_pagamento'];
$tipo_pagamento = $_POST['tipo_pagamento'];
$parcelas = $_POST['parcelas'];
$email_consumidor = $_POST['email_consumidor'];



switch ($status_pagamento) {
    case 1:
        $status = "autorizado";
        break;
    case 2:
        $status = "iniciado";
        break;
    case 3:
        $status = "boleto impresso";
        break;
	case 4:
        $status = "concluido";
        break;
	case 5:
       $status = "cancelado";
        break;
	case 6:
        $status = "em analise";
        break;
	case 7:
        $status = "estornado";
        break;
	case 8:
        $status = "em revisao";
	case 9:
        $status = "Reembolsado";
        break;
}


global $wpdb;
	
$info_transaca = "- Data retorno: " . date("d/m/y h:i:s A"); 
$info_transaca .= "\n\r- Codigo Moip: " . $cod_moip; 
$info_transaca .= "\n\r- Status: " . retira_acentos_moip($status);
$info_transaca .= "\n\r- Cliente Mail: " . $email_consumidor; 
$info_transaca .= "\n\r- Valor Total: " . "R$ " . $valor/100; 
$info_transaca .= "\n\r- Tipo Pagamento: " . retira_acentos_moip($tipo_pagamento); 
$info_transaca .= "\n\r- Parcelas: " . $parcelas; 
 
$info_transaca .= "\n\r----------------------------------------\n\r";




	$purchase_log_sql = "UPDATE `".WPSC_TABLE_PURCHASE_LOGS."` SET transactid = ".$cod_moip.", notes = CONCAT('".$info_transaca."',IFNULL(notes,'')) WHERE `sessionid`= '".$id_trasacao_limpo."' LIMIT 1";
	
	
	$purchase_log = $wpdb->get_results($purchase_log_sql,ARRAY_A) ;

	if ( $status_pagamento == 4) {
		$status_pedido = 3;
		$purchase_log_sql = "UPDATE `".WPSC_TABLE_PURCHASE_LOGS."` SET processed =".$status_pedido." WHERE `sessionid`= '".$id_trasacao_limpo."' LIMIT 1";
		
		$purchase_log = $wpdb->get_results($purchase_log_sql,ARRAY_A) ;
		transaction_results( $id_trasacao_limpo, $display_to_screen = false, $transaction_id = null );
	}  else {
				$status_pedido = 2;
				$purchase_log_sql = "UPDATE `".WPSC_TABLE_PURCHASE_LOGS."` SET processed =".$status_pedido." WHERE `sessionid`= '".$id_trasacao_limpo."' LIMIT 1";
			
				$purchase_log = $wpdb->get_results($purchase_log_sql,ARRAY_A) ;
				transaction_results( $id_trasacao_limpo, $display_to_screen = false, $transaction_id = null );
			} 
	
	
	$url_retorno_site = get_option('transact_url');
	
	if (stripos( $url_retorno_site,"?")) {
		$moip_retorno = $url_retorno_site."&sessionid=" . $id_trasacao_limpo;
	} else {
		$moip_retorno = $url_retorno_site."?sessionid=" . $id_trasacao_limpo;
	}
	

		
		header("location:".$moip_retorno);
		echo $moip_retorno;
	}
}


function retira_acentos_moip( $var )
{
	
	$var= utf8_decode($var);
	$var = ereg_replace("[ÁÀÂÃ]","A",$var);
	$var = ereg_replace("[áàâãª]","a",$var);
	$var = ereg_replace("[ÉÈÊ]","E",$var);
	$var = ereg_replace("[éèê]","e",$var);
	$var = ereg_replace("[ÓÒÔÕ]","O",$var);
	$var = ereg_replace("[óòôõº]","o",$var);
	$var = ereg_replace("[ÚÙÛ]","U",$var);
	$var = ereg_replace("[úùû]","u",$var);
	$var = str_replace("Ç","C",$var);
	$var = str_replace("ç","c",$var);
	
	
	
  return $var;
} 

function envia_post_moip($parametrospost,$urlpost)
{

$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $urlpost);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $parametrospost);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		//curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$resposta = trim(curl_exec($curl));
		curl_close($curl);
		
return $resposta;
} 


function submit_moip()
{  

	if($_POST['moip_email'] != null)
	{
		update_option('moip_email', $_POST['moip_email']);
	}
	if($_POST['moip_token'] != null)
	{
		update_option('moip_token', $_POST['moip_token']);
	}
	
		if($_POST['moip_debug'] != null)
	{
		update_option('moip_debug', $_POST['moip_debug']);
	}
	
	if($_POST['moip_ambiente'] != null)
	{
		update_option('moip_ambiente', $_POST['moip_ambiente']);
	}
	
	
	foreach((array)$_POST['moip_form'] as $form => $value)
	{
		update_option(('moip_form_'.$form), $value);
	}
			
	return true;
}

function form_moip()
{	
	$moip_debug = get_option('moip_debug');
	$moip_ambiente = get_option('moip_ambiente');

	$moip_debug1 = "";
	$moip_debug2 = "";
	$moip_ambiente1 = "";
	$moip_ambiente2 = "";
	switch($moip_debug)
	{
		case 0:
			$moip_debug2 = "checked ='checked'";
			break;
		case 1:
			$moip_debug1 = "checked ='checked'";
			break;
	}
	
	if ($moip_ambiente == false )
	{
		$moip_ambiente2 = "checked ='checked'";
	} else {
		
		$moip_ambiente1 = "checked ='checked'";
			
	}
	

		$output ="<tr>
			<td>Usuario moip</td>
			<td><input type='text' size='40' value='".get_option('moip_email')."' name='moip_email' /></td>
		</tr>
		<!--
		<tr>
			<td>Sua Chave acesso</td>
			<td><input type='text' size='40' value='".get_option('moip_token')."' name='moip_token' /></td>
		</tr>
		-->
		 <tr>
			<td>Ambiente:</td>
			<td>
				<input type='radio' value='1' name='moip_ambiente' id='moip_ambiente1' ".$moip_ambiente1." /> <label for='moip_ambiente1'>Produ&ccedil;&atilde;o</label> &nbsp;
				<input type='radio' value='0' name='moip_ambiente' id='moip_ambiente2' ".$moip_ambiente2." /> <label for='moip_ambiente2'>Desenvolvimento</label>
			</td>
		</tr>
        <tr>
			<td>Debug Mode</td>
			<td>
				<input type='radio' value='1' name='moip_debug' id='moip_debug1' ".$moip_debug1." /> <label for='moip_debug1'>".__('Yes', 'wpsc')."</label> &nbsp;
				<input type='radio' value='0' name='moip_debug' id='moip_debug2' ".$moip_debug2." /> <label for='moip_debug2'>".__('No', 'wpsc')."</label>
			</td>
		</tr>
        <tr class='firstrowth'>
		<td style='border-bottom: medium none;' colspan='2'>
			<strong class='form_group'>Parametriza&ccedil;&atilde;o de Campos</strong>
		</td>
	</tr>
	<tr>
			<td>E-mail</td>
			<td><select name='moip_form[email]'>
				".nzshpcrt_form_field_list(get_option('moip_form_email'))."
				</select>
			</td>
		</tr>
	
		<tr>
			<td>Nome</td>
			<td><select name='moip_form[first_name]'>
				".nzshpcrt_form_field_list(get_option('moip_form_first_name'))."
				</select>
			</td>
		</tr>
		<tr>
			<td>Sobrenome</td>
			<td><select name='moip_form[last_name]'>
				".nzshpcrt_form_field_list(get_option('moip_form_last_name'))."
				</select>
			</td>
		</tr>
		<tr>
			<td>Endere&ccedil;o</td>
			<td><select name='moip_form[address]'>
				".nzshpcrt_form_field_list(get_option('moip_form_address'))."
				</select>
			</td>
		</tr>
		<tr>
			<td>Cidade</td>
			<td><select name='moip_form[city]'>
				".nzshpcrt_form_field_list(get_option('moip_form_city'))."
				</select>
			</td>
		</tr>
		<tr>
			<td>Estado</td>
			<td><select name='moip_form[state]'>
				".nzshpcrt_form_field_list(get_option('moip_form_state'))."
				</select>
			</td>
		</tr>
		<tr>
			<td>CEP</td>
			<td><select name='moip_form[post_code]'>
				".nzshpcrt_form_field_list(get_option('moip_form_post_code'))."
				</select>
			</td>
		</tr>";
		
	return $output;
}
  
  

add_action('init', 'nzshpcrt_moip_results');
	
?>