<?php 


	class User extends Control
	{
		public function Home()
		{
			parent::Control();
		}
		
		public function load_js()
		{
			$js = array('jquery','bootstrap.min','all_plugins','user_reg');
			return Control::js($js);	
		}

		public function load_css()
		{
			$css = array('bootstrap','elements','myelements','common');
			return Control::css($css);	
		}	
		
		public function load_meta()
		{
			return '';
		}

		public function load_header()
		{
			$header = array();
			$header['title'] = SITE_NAME;
			$header['js'] = self::load_js();
			$header['css'] = self::load_css();
			$header['keywords'] = Control::meta_tag('keyword','');
			$header['description'] = Control::meta_tag('description','');
 			return $header;
		}

		public function load_footer()
		{
			$footer = array();
			$footer['ip'] = $_SERVER['REMOTE_ADDR'];
			return $footer;	
		}
		
		public function render()
		{
			$header = self::load_header();
			$footer = self::load_footer();
			Control::get_header($header);
			 /*Control::get_page('sidebar');
			Control::get_page('home/content');*/
			Control::get_page('user/login');
			Control::get_footer($footer);	
		}
		
	}
$user = new User;
?>