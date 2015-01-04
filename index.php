<?php
/*
 * Plugin Name: Class-Based Plugin
 * Author: Ghulam Kibria Ali
 * Author URI: http://www.kibriaali.com
 * Description: This plugin shows off how to create a class-based plugin. 
 */

class ClassBasedPlugin {
	
	public function __construct() {
		require_once('post-types/projects-post-type.php');
		$projectsPostType = new ProjectsPostType();
	}
	
	public static function activate(){
		
	}
	
	public static function deactivate(){
		
	}
	
}

if(class_exists('ClassBasedPlugin')){
	register_activation_hook(__FILE__, array('ClassBasedPlugin', 'activate'));
	register_deactivation_hook(__FILE__, array('ClassBasedPlugin', 'deactivate'));
	
	$projects = new ClassBasedPlugin();
}