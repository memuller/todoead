<?php 
        $conn = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
                    if (!$conn) {
                        die('Falha na conexão: ' . mysql_error());
                    }
                    $db_selected = mysql_select_db(DB_NAME, $conn);
                    if(!$post_type){
                        $post_type = 'post';
                    }
        $year = date("Y");
        $agenda = mysql_query("SELECT id, post_date, post_title FROM wp_posts WHERE post_status='publish' AND post_type='".$post_type."' AND date_format(post_date,'%Y')=".$year." ORDER BY post_date ASC");
        $result = mysql_query("SELECT date_format(post_date,'%Y') as post_date FROM wp_posts WHERE post_status='publish' AND post_type='".$post_type."' GROUP BY date_format(post_date,'%Y') ORDER BY post_date ASC ");
        $counter = mysql_query("SELECT count(*) as numeros, date_format(post_date,'%m') as mes FROM wp_posts WHERE post_status='publish' AND post_type='".$post_type."' AND date_format(post_date,'%Y')=".$year." GROUP BY date_format(post_date,'%m') ORDER BY post_date ASC");
        while($r=mysql_fetch_array($result)){
            if($r){
                $results[] = $r;
            }                        
        }
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
        
        wp_enqueue_script( 'simple-custom-post-archive', plugins_url('simple-custom-post-archive/static/js/controller.js'), array( 'jquery' ));
?>

<li class="itens">
    <h2>Calendário</h2>
    <form id="choose-year">
        <input type="hidden" value="<?php echo  admin_url( 'admin-ajax.php' )?>" id="ajax-url" />
        <input type="hidden" value="<?php echo $post_type?>" id="post_type" />
        <select name="" id="year">
            <?php foreach($results as $agenda): ?>                
                <option value="<?php echo $agenda[post_date]; ?>" 
                    <?php
                        if($agenda[post_date]==$year){
                            echo "selected";
                        } 
                    ?>><?php echo $agenda[post_date]; ?></option>
            <?php endforeach ?>
        </select>
    </form>
    <ul id="sub-itens">
        <?php foreach($materia as $agenda): ?>
        <?php
                if(!$check_mes){
                    //abre a primveira div para conter os meses
                    require (dirname(__FILE__) . '/mes.php');
                }else if($my_mes!=substr($agenda[post_date],5,2)){
                    //fecha a div do último mes
                    echo "</ul></li>";
                    require (dirname(__FILE__) . '/mes.php');
                }
        ?>
        <li><a href="<?php echo get_permalink($agenda[id]); ?>" title="<?php echo $agenda[post_title]; ?>"><?php echo $agenda[post_title]; ?></a></li>
        <?php $my_mes = substr($agenda[post_date],5,2); ?>
        <input type="hidden" value="<?php echo $my_mes?>" class="my_mes" />        
        <?php endforeach; ?>
    </ul>
</li>
</li>
<?php do_action( 'wp_ajax_nopriv_' . $_REQUEST['action'] );?>