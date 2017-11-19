<?php
/*
Plugin Name: Custom Widget Classes
Plugin URI: http://wp-knowledge.com
Description: Add Custom Classes for each widgets.
Author: wellwisher
Author URI:http://profiles.wordpress.org/wellwisher/
Version: 1.1
*/



function cWc_my_admin_head() {
        echo '<link rel="stylesheet" type="text/css" href="' .plugins_url('wp-admin.css', __FILE__). '">';

}
function my_plugin_menu() {
	add_options_page('Costom Widget Class Options', 'widget classes', 'manage_options', 'cwc_options', 'cwc_options');
}

add_action('admin_head', 'cWc_my_admin_head');
add_action('admin_menu', 'my_plugin_menu');
$cWc_plugin_file='custom-widget-classes/custom-widget-classes.php';
add_filter("plugin_action_links_$cWc_plugin_file","plugin_action_links_plugin_file_new");
function plugin_action_links_plugin_file_new($actions){
	$actions['settings']='<a href="options-general.php?page=cwc_options">Settings</a>';
	return $actions;
	}
function cWc_updateoption($agrgs){
		if(isset($agrgs['developer'])){
			unset($agrgs['developer']);
			}
		return update_option('cWCconfigs',$agrgs);
	}

function cwc_addnewClass($class,$desc=''){
		$cWCconfigs=cWC_configs();
		array_push($cWCconfigs['classes'],array('class'=>$class,'desc'=>$desc));
		cWc_updateoption($cWCconfigs);
	}
function cwc_validate_class($class){
	if(preg_match('/-?[_a-zA-Z]+[_a-zA-Z0-9-]*/',$class)){
		return true;
	}
	return false;
	}	
function cwc_options(){
	
	
	if(isset($_POST['cwc_add_new'])){
		if(!cwc_validate_class($_POST['cwc_class_name'])){
			$class_err ='Inavalid Classs';
		}else{
			cwc_addnewClass($_POST['cwc_class_name'],$_POST['cwc_class_desc']);	
			
			
	}
		
	}else if(isset($_GET['remove']) && $_GET['remove']!=''){
		$cWCconfigs=cWC_configs();
		if(isset($cWCconfigs['classes'][$_GET['remove']])){
		if($_GET['remove']==$cWCconfigs['configs']['defualt_class_key']){
			$cWCconfigs['configs']['defualt_class_key']=-1;
			
			}	
		unset($cWCconfigs['classes'][$_GET['remove']]);
		cWc_updateoption($cWCconfigs);
		}
	}else if(isset($_GET['setdef']) && $_GET['setdef']!=''){
		
		$cWCconfigs=cWC_configs();
		if(isset($cWCconfigs['classes'][$_GET['setdef']])){
		$cWCconfigs['configs']['defualt_class_key']=$_GET['setdef'];
		cWc_updateoption($cWCconfigs);
		}
		
	}else if(isset($_GET['unsetdef']) && $_GET['unsetdef']!=''){
		
		$cWCconfigs=cWC_configs();
		if($cWCconfigs['configs']['defualt_class_key']==$_GET['unsetdef']){
		$cWCconfigs['configs']['defualt_class_key']=-1;
		cWc_updateoption($cWCconfigs);
		}
		
	}
	
echo '<div class="wrap cWC_options"><form method="POST" action="'.$_SERVER['REQUEST_URI'].'">'.
		 '<h2>Manage custom widget classes</h2>'.
		 '<table class="widefat cwc_addclass" style="width:650px">'.
		 '<thead><tr><th colspan="3">Add Classes</th> </tr></thead>'.
		'<tbody>'.
		'<tr><td style="">'.
	 	'<label for="cwc_class_name">Class</label><br />'.
	 	'<input type="text" name="cwc_class_name" id="cwc_class_name" value="'.(isset($class_err)?$_POST['cwc_class_name']:'').'" />'.
		(isset($class_err)?('<br /><span style="color:red">'.$class_err.'</span>'):'').
		'</td><td>'.
	'<label for="cwc_class_desc">Description</label><br />'.
	 	'<input type="text" name="cwc_class_desc" id="cwc_class_desc" value="'.(isset($class_err)?$_POST['cwc_class_desc']:'').'"/>'.
	'</td>'.
	'<td style="padding:28px 0 0 5px;">'.
	'<input class="button-primary" type="submit" name="cwc_add_new" value="Add Class" id="cwc_add_button" />'.
	'</td></tr></table>'.
	
	'<table class="widefat cWc_classList" style="width:650px">'.
	'<thead><tr><th>Classes</th> <th>Description</th><th style="width:55px;">Remove</th> <th style="width:100px;">&nbsp;</th></tr><thead>';

$row ='';
	$cWCconfigs=cWC_configs();
	

$cWCdefaultset=0;	
if(!empty($cWCconfigs['classes'])){
	foreach($cWCconfigs['classes'] as $key=>$class){
		if($cWC_def=($cWCconfigs['configs']['defualt_class_key']==$key)){
			$cWCdefaultset=1;
			}
		$row .='<tr class="'.($cWC_def?"cWc_default":"").'"><td>'.$class['class'].'</td>';
		$row .=	'<td>'.$class['desc'].'</td>';
		$row.='<td><a href="'.admin_url('options-general.php?page=cwc_options').'&amp;remove='.$key.'">Remove</a></td>'.
			'<td><a href="'.admin_url('options-general.php?page=cwc_options').'&amp;'.($cWC_def?"unsetdef":"setdef").'='.$key.'"" class="setdefualt">'.($cWC_def?"Unset Deafult":"Set as Default").'</a></td></tr>';
			
		}
	}else {
	echo'<tr><td colspan=4>No classes added yet</td></tr>';
	}	
$row.='</tbody>
</table>';
	
if(!empty($cWCconfigs['developer'])){
	$row.='<h2>Classes defined in theme</h2>';
	$row.='<table class="widefat cWc_classList" style="width:650px">';
	
	$row.='<thead><tr><th>Classes</th> <th>Description</th><th style="width:100px"></th></tr><thead>';
	
	if(isset($cWCconfigs['developer']['default']) && !empty($cWCconfigs['developer']['default']['class'])){
		$row .='<tr class="'.(!$cWCdefaultset?"cWc_default":"").'"><td>'.$cWCconfigs['developer']['default']['class'].'</td>';
		$row .=	'<td>'.@$cWCconfigs['developer']['default']['desc'].'</td><td>'.(!$cWCdefaultset?"&laquo;Default Class":"").'</td></tr>';
		
		}
	if(isset($cWCconfigs['developer']['classes']) && !empty($cWCconfigs['developer']['classes'])){
	foreach($cWCconfigs['developer']['classes'] as $key=>$class){
	
		$row .='<tr><td>'.@$class['class'].'</td>';
		$row .=	'<td>'.@$class['desc'].'</td><td></td></tr>';
		}
	}


}		
echo $row.'
		
</tbody>
</table>'.
		 
		 '</form></div>';
	
	}



add_action('in_widget_form','cWCin_widget_form',10,3);
add_filter( 'widget_update_callback', 'cWCin_widget_update_callback', 10, 2 );
function cWCdeveloperClasses(){
	
	}
function cWC_configs(){
	
	$cWCconfigs=get_option("cWCconfigs");
	if(!isset($cWCconfigs['classes'])){
	$cWCconfigs = array(		
				'classes'=>array(
							),
						
				'configs'=>array(
							'defualt_class_key'=>-1
						)
	);
	
	}
	$cWCdeveloper=array();
	
	$cWCdeveloper=apply_filters("cWCdeveloperClasses",$cWCdeveloper);
	if(isset($cWCdeveloper['classes'])){
	foreach($cWCdeveloper['classes'] as $key=>$val){
		@$cWCdeveloper['classes'][$key]['class']=trim(@$cWCdeveloper['classes'][$key]['class']);
		}
	}
	if(isset($cWCdeveloper['default'])){	
	@$cWCdeveloper['default']['class']=trim(@$cWCdeveloper['default']['class']);
	}
	
	$cWCconfigs['developer']=$cWCdeveloper;
	return $cWCconfigs;
	}

function cWCin_widget_form($widget,$return,$instance){
	
	if(!isset($instance['cWC_class'])){
		$instance['cWC_class']=null;
		}
	$cWCconfigs=cWC_configs();
	
	
	$form ='<div class="cWC_start">';
	$form .='Choose a class(<a href="options-general.php?page=cwc_options" style="font-size:10px; text-decoration:none">Add Classes</a>)<br />'; 
	$form .='<p><select class="widefat" id="'.$widget->get_field_id('cWC_class').'" name="'.$widget->get_field_name('cWC_class').'">';
	$form .='<option value="-1">Choose a Class</option>';
	
	
	if(isset($cWCconfigs['configs']['defualt_class_key']) && $cWCconfigs['configs']['defualt_class_key']!=-1){
		$dflt_Class=$cWCconfigs['classes'][$cWCconfigs['configs']['defualt_class_key']]['class'];
		$dflt_Desc=$cWCconfigs['classes'][$cWCconfigs['configs']['defualt_class_key']]['desc'];
		$form .='<option value="'.$dflt_Class.'" '.((($dflt_Class==$instance['cWC_class']) || empty($instance['cWC_class']))?'selected="selected"':'').' ">';
		$form .=(empty($dflt_Desc)?$dflt_Class:$dflt_Desc).'</option>';	
	}else if(isset($cWCconfigs['developer']['default']['class']) && $cWCconfigs['developer']['default']['class']!=''){
		$dflt_Class=$cWCconfigs['developer']['default']['class'];
		$dflt_Desc=@$cWCconfigs['developer']['default']['desc'];
		$form .='<option value="'.$dflt_Class.'" '.((($dflt_Class==$instance['cWC_class']) || empty($instance['cWC_class']))?'selected="selected"':'').' ">';
		$form .=(empty($dflt_Desc)?$dflt_Class:$dflt_Desc).'</option>';	
	}
if(isset($cWCconfigs['classes'])){
	foreach($cWCconfigs['classes'] as $key=>$class){
				if($key==@$cWCconfigs['configs']['defualt_class_key']){
					continue;
					}
				$form .='<option value="'.$class['class'].'" '.(($class['class']==$instance['cWC_class'])?'selected="selected"':'').' >'.(empty($class['desc'])?$class['class']:$class['desc']).'</option>';
		}
	}

if(isset($cWCconfigs['developer']['classes'])){
	foreach($cWCconfigs['developer']['classes'] as $class){
		$form .='<option value="'.$class['class'].'" '.(($class['class']==$instance['cWC_class'])?'selected="selected"':'').' >'.(empty($class['desc'])?$class['class']:$class['desc']).'</option>';
		}
	}
	
	$form .='</select></p></div>';
	echo $form;
	}

function cWCin_widget_update_callback( $instance, $new_instance ) {
 $instance['cWC_class'] = $new_instance['cWC_class'];
 
 return $instance;
}

function cWC_dynamic_sidebar_params( $params ) {
 global $wp_registered_widgets;
 $widget_id    = $params[0]['widget_id'];
 $widget_obj    = $wp_registered_widgets[$widget_id];
 $widget_opt    = get_option($widget_obj['callback'][0]->option_name);
 $widget_num    = $widget_obj['params'][0]['number'];

preg_match( '/(\<[a-zA-Z]+)(.*?)(\>)/',  $params[0]['before_widget'],$mat );
 if ( isset($widget_opt[$widget_num]['cWC_class']) && !empty($widget_opt[$widget_num]['cWC_class']) && $widget_opt[$widget_num]['cWC_class']!=-1)

 if(preg_match( '/class="/', $params[0]['before_widget'])){
$params[0]['before_widget'] =  preg_replace( '/class="/', "class=\"{$widget_opt[$widget_num]['cWC_class']} ", $params[0]['before_widget'], 1 );
}else{
$params[0]['before_widget'] = preg_replace( '/(\<[a-zA-Z]+)(.*?)(\>)/', "$1 $2  class=\"{$widget_opt[$widget_num]['cWC_class']}\" $3", $params[0]['before_widget'], 1 );
 }

 return $params;
}
add_filter( 'dynamic_sidebar_params', 'cWC_dynamic_sidebar_params' );
?>