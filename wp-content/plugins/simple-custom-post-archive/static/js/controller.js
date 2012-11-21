/////controle sidebar
jQuery(document).ready(function($) {
  		// Handler for .ready() called.

		$(".itens #sub-itens li ul").hide();		
        display($);

        var post_type = $('#post_type').val();
        
        jQuery("#year").change(function($){
            var ano = jQuery("#year option:selected").val();
            var data = {
                    action: 'arquivos-ajax',
                    post_type: post_type,
                    ano: ano 
            };
            var url = jQuery('#ajax-url').val();
            
            jQuery.post(url, data, function(response) {
                if(response!="vazio"){
                    jQuery('#sub-itens li').remove();
                    jQuery("#sub-itens").append(response);
                    jQuery(".itens #sub-itens li ul").hide();
                    display(jQuery);
                }else{
                }
            });

        }); 
        
});

var display = function display($){
    $(".itens #sub-itens li .open").click(function(event){
            $(this).children("span").toggleClass("up");
            $(this).siblings().slideToggle("slow");
            event.preventDefault();
        });
}