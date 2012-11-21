<?php
/************************************
//FUNCTION NAME : DDBWP_template_include
//ARGUMENTS : None
//RETURNS : Site page template file as per desing settings
***************************************/
add_filter('template_include','DDBWP_template_include');
function DDBWP_template_include($template)
{
	return apply_filters('DDBWP_add_template_page_filter',$template);
}


///-----------------------------------------------------------------
	  //  SIDEBAR 1  //
///----------------------------------------------------------------

function DDBWP_sidebar1_st($class='')
{
	$class = apply_filters('DDBWP_sidebar1_css_filter',$class);
	if($class){ $class = 'class="'.$class.'"';}
	return apply_filters('DDBWP_sidebar1_st_filter',"<div  $class >");
}

function DDBWP_sidebar1_end()
{
	return apply_filters('DDBWP_sidebar1_end_filter','</div>');
}

function DDBWP_sidebar1($class='sidebar left')
{
	echo DDBWP_sidebar1_st($class);
	$widget = apply_filters('sidebar1_widget_filter','sidebar1');
	if (function_exists('dynamic_sidebar') && $widget){ dynamic_sidebar($widget); }
	do_action('DDBWP_sidebar2');
	echo DDBWP_sidebar1_end();
}

function DDBWP_sidebar_2col_merge()
{
	$widget = apply_filters('sidebar_2col_merge_widget_filter','sidebar_2col_merge');
	if (function_exists('dynamic_sidebar') && $widget){ dynamic_sidebar($widget); }
}


///-----------------------------------------------------------------
	  //  SIDEBAR 2  //
///----------------------------------------------------------------

function DDBWP_sidebar2_st($class='')
{
	$class = apply_filters('DDBWP_sidebar2_css_filter',$class);
	if($class){ $class = 'class="'.$class.'"';}
	return apply_filters('DDBWP_sidebar2_st_filter',"<div  $class >");
}

function DDBWP_sidebar2_end()
{
	return apply_filters('DDBWP_sidebar2_end_filter','</div>');
}
function DDBWP_sidebar2($class='sidebar right')
{
	echo DDBWP_sidebar2_st($class);
	$widget = apply_filters('sidebar2_widget_filter','sidebar2');
	if (function_exists('dynamic_sidebar') && $widget){ dynamic_sidebar($widget); }
	do_action('DDBWP_sidebar2');
	echo DDBWP_sidebar2_end();
}


///-----------------------------------------------------------------
	  //  Content Area  //
///----------------------------------------------------------------

function DDBWP_content_css($class='')
{
	if(DDBWP_is_layout('3_col_fix'))  ////Sidebar 3 column fixed
	{
		$class .= 'deals_content content_3col column_spacer left';
	}else
	if(DDBWP_is_layout('3_col_left'))  ////Sidebar 3 column left
	{
		$class .= 'deals_content content_3col_right right';
	}else
	if(DDBWP_is_layout('3_col_right'))  ////Sidebar 3 column right
	{
		$class .= 'deals_content content_3col_left left';
	}else
	if(DDBWP_is_layout('full_width'))  ////Sidebar Full width page
	{
		$class .= 'deals_content content_full';
	}else
	if(DDBWP_is_layout('2_col_right'))  ////Sidebar 2 column right
	{
		$class .= 'deals_content left';
	}
	else  ////Sidebar 2 column left as default setting
	{
		$class .= 'deals_content right';
	}		
	$class = apply_filters('DDBWP_content_css_filter',$class);
	echo $class;
}



/************************************
//FUNCTION NAME : DDBWP_page_layout_options
//ARGUMENTS : None
//RETURNS : page layout options array
***************************************/
function DDBWP_page_layout_options()
{
	return $layout_arr = 
			array(
				'3_col_fix'		=> 'Page 3 column - Fixed',
				'3_col_left'	=> 'Page 3 column - Left Sidebar',
				'3_col_right'	=> 'Page 3 column - Right Sidebar',
				'full_width'	=> 'Full Page',
				'2_col_right'	=> 'Page 2 column - Right Sidebar',
				'2_col_left'	=> 'Page 2 column - Left Sidebar',
				);	
}

/************************************
//FUNCTION NAME : DDBWP_get_page_layout
//ARGUMENTS : None
//RETURNS : page layout set as per from <br />
wp-admin desing settings, default is "left sidebar'
***************************************/
function DDBWP_get_page_layout()
{
	if(get_option('ddbwpthemes_page_layout')){
		$layout = get_option('ddbwpthemes_page_layout');
	}else{
		$layout = 'Page 2 column - Left Sidebar';
	}
	$layout =  apply_filters('DDBWP_current_page_layout_filter',$layout);
	$layout_opts = DDBWP_page_layout_options();
	$opt_key = array_keys($layout_opts,$layout);
	return $opt_key[0];
}

/************************************
//FUNCTION NAME : DDBWP_is_layout
//ARGUMENTS : page layout code
//RETURNS : true/false as per conditon
***************************************/
function DDBWP_is_layout($type)
{
	if(DDBWP_get_page_layout()==$type)
	{
		return true;
	}
	return false;
}
?>