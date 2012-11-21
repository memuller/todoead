<?php

		/**
		* Widget para exibir a lista de links de postagens de qualquer tipo de post do wordpress
		*
		*@author Tiago A. Rafael <lordtiago@msn.com>
		*@link http://www.tiago.rmsti.com
		*/

		class ArquivosWidget extends WP_Widget{

				public function ArquivosWidget(){
						parent::WP_Widget(false, $name = __('Custom Post Archive'),
							array('description'=>__('An archive grouped by years of custom posts on your site')));
				}

				public function widget ($argumentos, $instancia){

						$post_types=get_post_types('','names'); 
						foreach ($post_types as $type ) {
						  	if(is_post_type_archive($type)){
								$post_type = $type;							
							}
						}
						require_once (dirname(__FILE__) . '/../Views/Arquivos/view.php');
				}

				public function update ($nova_instancia, $instancia_antiga){}

				public function form ($instancia){}

				public function arquivos_ajax(){
					$agenda = mysql_query("SELECT id, post_date, post_title FROM wp_posts WHERE post_status='publish' AND post_type='".$_POST['post_type']."' AND date_format(post_date,'%Y')=".$_POST['ano']." ORDER BY post_date ASC");
					$counter = mysql_query("SELECT count(*) as numeros, date_format(post_date,'%m') as mes FROM wp_posts WHERE post_status='publish' AND post_type='".$_POST['post_type']."' AND date_format(post_date,'%Y')=".$_POST['ano']." GROUP BY date_format(post_date,'%m') ORDER BY post_date ASC");
					while($r=mysql_fetch_array($agenda)){
			            if($r){
			                $materia[] = $r;
			            }                        
			        }
			        while($r=mysql_fetch_array($counter)){
			            if($r){
			                $c[] = $r;
			            }                        
			        }
			        $i = 0;
			        require_once (dirname(__FILE__) . '/../Views/Arquivos/ajax.php');
					exit;
				}

				public static function converte_mes($mes){
		                if($mes==1) return "Janeiro"; if($mes==2) return "Fevereiro";if($mes==3) return "Março";
		                if($mes==4) return "Abril"; if($mes==5) return "Maio"; if($mes==6) return "Junho"; if($mes==7) return "Julho";
		                if($mes==8) return "Agosto"; if($mes==9) return "Setembro"; if($mes==10) return "Outubro";
		                if($mes==11) return "Novembro";  if($mes==12) return "Dezembro";
		        }

				public static function conexao(){

						
				}



		}

		add_action('widgets_init', create_function('', 'return register_widget("ArquivosWidget");'));
		add_action( 'wp_ajax_nopriv_arquivos-ajax', array('ArquivosWidget','arquivos_ajax'), 99 );
        add_action( 'wp_ajax_arquivos-ajax', array('ArquivosWidget','arquivos_ajax'), 99 );
?>