<?php	
	class ProjectsPostType {
		const POST_TYPE = 'project';
		const TAXONOMY = 'project_cat';
		private $_meta = array(
			''
		);
		
		public function __construct() {
			add_action('init', array(&$this, 'init'));
			add_action('admin_init', array(&$this, 'admin_init'));
		}
		
		public function init(){
			$this->create_post_type();
			$this->create_taxonomy();
			add_action('save_post', array(&$this, 'save_post'));
		}
		
		public function create_post_type(){
			$labels = array(
				'name'                => _x( 'Projects', 'Post Type General Name', 'text_domain' ),
				'singular_name'       => _x( 'Project', 'Post Type Singular Name', 'text_domain' ),
				'menu_name'           => __( 'Projects', 'text_domain' ),
				'all_items'           => __( 'All Projects', 'text_domain' ),
				'view_item'           => __( 'View Project', 'text_domain' ),
				'add_new_item'        => __( 'Add New Project', 'text_domain' ),
				'add_new'             => __( 'New Project', 'text_domain' ),
				'edit_item'           => __( 'Edit Project', 'text_domain' ),
				'update_item'         => __( 'Update Project', 'text_domain' ),
				'search_items'        => __( 'Search Projects', 'text_domain' ),
				'not_found'           => __( 'No Projects found', 'text_domain' ),
				'not_found_in_trash'  => __( 'No Projects found in Trash', 'text_domain' ),
				);
			$args = array(
				'public'			=> true,
				'labels'			=> $labels,
				'has_archive'		=> true,
				'menu_position'		=> 3,
				'supports'			=> array('title', 'editor', 'thumbnail'),
				'rewrite' => array('slug' => 'projects'),
				'taxonomies' => array(self::TAXONOMY),
				);
			
			register_post_type(self::POST_TYPE, $args);
		}
		
		public function create_taxonomy(){
			register_taxonomy(self::TAXONOMY, self::POST_TYPE,  
				array(  
					'hierarchical' => true,  
					'label' => 'Project Categories',  
					'query_var' => true,  
					'rewrite' => array('slug' => 'project-categories')  
				)
			);
		}
		
		public function save_post($post_id){
			global $post;
			
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
				return;
			}
			
			if($_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id)){
				foreach($this->_meta as $field_name){
					$post_meta = get_post_meta($post->ID, $field_name, true);
					if(empty($post_meta)){
						add_post_meta($post->ID, $field_name, $_POST[$field_name]);
					} else {
						update_post_meta($post->ID, $field_name, $_POST[$field_name]);
					}
					if(!$post_meta || $post_meta == ''){
						add_post_meta($post->ID, $field_name, $_POST[$field_name]);
					} else {
						update_post_meta($post->ID, $field_name, $_POST[$field_name]);
					}
				}
			} else {
				return;
			}
		}
		
		public function admin_init(){
			add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
		}
		
		public function add_meta_boxes(){
			add_meta_box(sprintf('%s_section', self::POST_TYPE), __('Artwork Price'), array(&$this, 'add_inner_metabox'), self::POST_TYPE);
		}
		
		public function add_inner_metabox($post_id){
			include(sprintf('%s/../templates/inner_meta_box.php', dirname(__FILE__), self::POST_TYPE));
		}
	}