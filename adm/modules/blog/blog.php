<?php 

include_once(MODEL_DOC_PATH.'blog/blog_function.php');

	class Blog extends Control
	{
		public function Blog()
		{
			parent::Control();
			//Control::no_auth();
			$this->post =  new Blog_Function;
			$this->b = $this->fn->get('b');
			$this->a = $this->fn->get('a');
			$this->action = $this->fn->req('action');
			$this->p = $this->fn->get('p');
			if($this->p === false) $this->p=1;
		}
		
		public function load_js()
		{
			$js = array('jquery','jquery-ui-min','bootstrap.min','all_plugins','elrte.min','blog');
			return Control::js($js);	
		}

		public function load_css()
		{
			$css = array('bootstrap','elrte.min','jquery-ui','elements','myelements','common');
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
			Control::get_page('sidebar');
			if($this->action == 'addpost')
			{
				Control::get_page('blog/addpost');
			}
			elseif($this->action == 'list')
			{
				Control::get_page('blog/managepost');
			}
			/*Control::get_page('home/login');*/
			Control::get_footer($footer);	
		}
		
	}
$blog = new Blog;
?>