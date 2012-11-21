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