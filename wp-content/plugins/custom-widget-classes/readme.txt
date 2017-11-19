=== Custom Widget Classes ===
Contributors: wellwisher
Donate link: http://wp-knowledge.com/donate/plugin/custom-widget-classes/?ref=readme
Tags: widget class,custom widget classes,list classes
Requires at least: 3.0.0
Tested up to: 3.5
Stable tag: 1.1
License: GPLv2 or later 
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Custom Widget Classes helps to set different css class or styles for widgets,the css class or styles can show in a dropdown list to be choosed

== Description ==
Custom Widget Classes helps to set different css class or styles for widgets,the css class or styles can show in a dropdown list to be choosed  . the list of css classes can be added from backend and also can code with theme.

 see the options at settings>>widget classes and add classes.

If you are a theme developer you can add the classes in theme itself
add this code

	add_filter('cWCdeveloperClasses','widgetclasses');
	
	function widgetclasses(){
			 $clsses['classes']= array(
				array(
					'class'=>'with-border',
					'desc'=>'With Border'
	
				),
				array(
					'class'=>'white-bg',
					'desc'=>'white background'
				)
			);              
	
		return $clsses;         
	}
 
if you want to set a default one for all the newly added widgets,add the default class too as shown below

	add_filter('cWCdeveloperClasses','widgetclasses');
	
	function widgetclasses(){
			 $clsses['classes']=array(
				array(
					'class'=>'with-border',
					'desc'=>'With Border'
	
				),
				array(
					'class'=>'white-bg',
					'desc'=>'white background'
				)
			);   
           
			$clsses['default']=array(		
					'class'=>'widget',		
					'desc'=>'Widget'
					);	
	
		return $clsses;         
	}


== Installation ==

This section describes how to install the plugin and get it working.


1. Download and install the plg-in

see the options at settings>>widget classes and add classes .

If you are a theme developer you can add the classes in theme itself
add this code
add_filter('cWCdeveloperClasses','widgetclasses');
	
	function widgetclasses(){
			 $clsses['classes']=array(
				array(
					'class'=>'with-border',
					'desc'=>'With Border'
	
				),
				array(
					'class'=>'white-bg',
					'desc'=>'white background'
				)
			);              
	
		return $clsses;         
	}
 
if you want to set a default one for all the newly added widgets,add the default class too as shown below

	add_filter('cWCdeveloperClasses','widgetclasses');
	
	function widgetclasses(){
			 $clsses['classes']=array(
				array(
					'class'=>'with-border',
					'desc'=>'With Border'
	
				),
				array(
					'class'=>'white-bg',
					'desc'=>'white background'
				)
			);   
           
			$clsses['default']=array(		
					'class'=>'widget',		
					'desc'=>'Widget'
					);	
	
		return $clsses;         
	}

then you can see the classes in a droplist under each widgets, user can choose the class from the list


== Changelog ==

= 1.1 =
* Fixed some faluts in version 1.0.
= 1.0 =
* first version.

== Upgrade Notice ==

= 1.0 =
The first version.