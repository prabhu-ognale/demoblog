<?php 

	header("Content-type: text/html; charset=utf-8");
	include('common.php');
	$action = $_GET['action'];
	$page = $_GET['page'];
	$fn   = $_GET['fn'];
	if(!isset($_GET['page'])) $page='home'; 
	switch($page)
	{
		case 'user':
			if($action == 'login')
			{
				include_once(MODEL_DOC_PATH.'login.php');
				$login = new Login;
				if($fn == 'login')
				{
					$ans = $login->login_auth($_POST['username'],$_POST['password']);
					echo $ans;
				}
				elseif($fn=='logout')
				{
					$ans = $login->ajax_logout();
					echo $ans;
				}
			}
			elseif($action == 'signup')
			{
				include_once(MODEL_DOC_PATH.'user_reg.php');
				$user_reg = new User_Reg();
				if($fn == 'add_user')
				{
					$ans = $user_reg->add_edit_user($_POST);
					echo $ans;	
				}
				elseif($fn == 'check_username')
				{
					$ans = $user_reg->check_user_name($_REQUEST['name']);
					echo $ans;	
				}	
			}
		break;
		
		case 'pages':
		include_once(MODEL_DOC_PATH . '/pages/page_function.php');
		$pages = new Page_Function;
		if($action=='addpage')
		{
			if($fn == 'add_edit_page')
			{
				$ans = $pages->add_edit_page($_POST);
				echo $ans;
			}
		}
		elseif($action=='managepage')
		{
			if($fn == 'ajax_delete_page')
			{
				$ans = $pages->ajax_delete_page($_REQUEST);
				echo $ans;
			}
			elseif($fn == 'page_display_on_off')
			{
				$ans = $pages->page_display_on_off($_REQUEST);
				echo $ans;
			}
		}
		break;
	
		case 'blog':
		include_once(MODEL_DOC_PATH . '/blog/blog_function.php');
		$blog = new Blog_Function;
		if($action=='addpost')
		{
			if($fn == 'add_edit_post')
			{
				$ans = $blog->add_edit_post($_POST);
				echo $ans;
			}
		}
		elseif($action=='managepost')
		{
			if($fn == 'ajax_delete_post')
			{
				$ans = $blog->ajax_delete_post($_REQUEST);
				echo $ans;
			}
			elseif($fn == 'post_display_on_off')
			{
				$ans = $blog->post_display_on_off($_REQUEST);
				echo $ans;
			}
		}
		break;

	}


?>