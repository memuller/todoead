<?php $this_mes = substr($agenda[post_date],5,2); $check_mes = true; $numeros = $c[$i][numeros];$tmp_mes = $c[$i][mes]; $i++;?>
            <li class="titulo">
            <a href="#" class="open" title="Arquivos do mês de <?php echo ArquivosWidget::converte_mes($this_mes);?>"><?php echo ArquivosWidget::converte_mes($this_mes);?> (<?php echo $numeros; ?>) <span class="arrowdown"></span></a>
            <ul>