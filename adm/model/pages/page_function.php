<?php

	class Page_Function extends Control
	{
		public function Page_Function()
		{
			parent::Control();	
		}
		function page_form($id=false)
		{
			$val = array();
			$val['page_name'] = '';
			$val['page_title'] = '';
			$val['page_keywords'] = '';
			$val['page_des'] = '';
			$val['editor'] = '';
			$val['page_id'] = 0;
			if($id)
			{
				if($this->a == 'edit')
				{
					$data = $this->db->query("SELECT * FROM " . PAGES . " WHERE page_id = $id",true);
					$val['page_name'] = $data['page_name'];
					$val['page_title'] = $data['page_title'];
					$val['page_keywords'] = $data['page_keywords'];
					$val['page_des'] = $data['page_des'];
					$val['editor'] = $data['page_content'];
					$val['page_id'] = $id;
				}
			}
			return $val;
		}
		
		function ajax_check_page_name($var)
		{
			$response=array();
			$url = $this->fn->sanitize($var,6);
			$sql = $this->db->query("SELECT page_id FROM " . PAGES . " WHERE url = '$url'");
			if(strlen(trim($var)) == 0)
			{
				$response['ok'] = false;
				$response['msg'] = 'Page name is empty' ;
				$response['img'] = IMG_BASE_PATH . '/wrong.gif';
				$response['code'] = 'wrong';
			}
			elseif(!preg_match("/^[a-zA-Z0-9]+([\\s]{1}[a-zA-Z0-9]|[a-zA-Z0-9])+$/i",$var))
			{
				$response['ok'] = false;
				$response['msg'] = 'Page name content Alpha, Numeric' ;
				$response['img'] = IMG_BASE_PATH . '/wrong.gif';
				$response['code'] = 'wrong';
			}
			else
			{
				if($this->db->num_rows($sql)==0)
				{
					$response['ok'] = true;
					$response['msg'] = 'Page name accepted' ;
					$response['img'] = IMG_BASE_PATH . '/success.gif';
					$response['code'] = 'success';
					$response['val'] = $this->fn->sanitize($var,1);
				}
				else
				{
					$response['ok'] = false;
					$response['msg'] = 'Page name already exists... Please try other...' ;
					$response['img'] = IMG_BASE_PATH . '/wrong.gif';
					$response['code'] = 'wrong';
				}
			}
			return json_encode($response);
		}
		
		function add_edit_page($datas)
		{
			$response = array();
			$errcnt = 0;
			if(!is_array($datas))
			{
				$response['ok'] = false;
				$response['msg'] = 'Error';
			}
			else
			{
				$valid_pagename = $this->fn->json_array($this->ajax_check_page_name($datas['page_name']));
				if($valid_pagename['ok']===false)
				{$errs[$errcnt] = $valid_pagename['msg']; $errcnt++;}
				else
				{$pagename = $valid_pagename['val'];}
				
				$val = array();
				$val['page_name']    = $pagename;
				$val['page_title']   = $this->fn->sanitize($datas['page_title'],1);
				$val['page_keywords']   = $this->fn->sanitize($datas['page_keywords'],1);
				$val['page_des']   = $this->fn->sanitize($datas['page_des'],8);
				$val['page_content'] = $this->fn->sanitize($datas['editor'],8);
				$val['url'] = $this->fn->sanitize($pagename,6);
				$val['status'] = 'hide';
				
				if($errcnt==0)
				{
					if($datas['page_id'] == 0)
					{
						//insert
						$insert = $this->db->insert(PAGES,$val,true);
						$response['ok']  = true;
						$response['msg'] = 'Page posted successfully.';
						$response['location'] = $this->site_link('pages_managepage');
					}
					else
					{
						//update
						$update = $this->db->update(PAGES,$val,"page_id=" . $datas['page_id']);
						$response['ok']  = true;
						$response['msg'] = 'Page updated successfully.';
						$response['location'] = $this->site_link('pages_managepage');
					}
				}
				else
				{
					$response['ok']  = false;
					//$response['msg'] = $this->db->error();
					$response['msg'] = $errs;
				}
			}
			return json_encode($response);
		}
		
		/*manage pages*/
		function ajax_delete_page($data)
		{
			$id = $data['id'];
			$sql = $this->db->query("DELETE FROM " . PAGES . " WHERE page_id = $id") or die ($this->db->error());
			$response = array();
			$response['ok'] = true;
			$response['msg'] = 'success';
			return json_encode($response);		
		}
		
		function page_display_on_off($data)
		{
			if(!is_array($data))
			{
				$data = array('id' => $data);
			}
			$id = $data['id'];
			$status = $data['status'];
			if($status=='1'){$s = 'show'; $addClass='icon-eye-open';}else{$s = 'hide'; $addClass='icon-eye-close';}
			$upt = array('status' => $s);
			$update = $this->db->update(PAGES,$upt,"page_id=$id");
			$response=array();
			$response['ok'] = true;
			$response['msg'] = 'success';
			$response['add_class'] = $addClass;
			return json_encode($response);
		}
		
		private function manage_get_sql($act,$p,$limit=false)
		{
			if($act=='all')
			{
				$field = "*";
				$sql = "SELECT $field FROM ". PAGES . " ORDER BY page_id ASC";
			}
			else
			{
				return false;
			}
			$res  = $this->db->query($sql) or die($this->db->error());
			$rows = $this->db->num_rows($res);
			
			if($limit)
			{
				$limit_value = ($p * $limit) - $limit;				
				$sql .= " LIMIT $limit_value, $limit";
			}
			$response['sql'] = $sql; $response['row'] = $rows;
			return $response;
		}
		
		function manage_page_list($act=false,$p=false)
		{
			if($act)
			{
				$sql = $this->manage_get_sql($act,25);
				$res = $this->db->query($sql['sql']) or die($this->db->error());
				if($sql['row']<>0)
				{
					$cnt=1;
					while($datas = $this->db->fetch_assoc($res))
					{
						
						$className = ($cnt&1) ? '' : 'odd';
						$val=array();
						$val['cnt']  = $cnt;
						$val['class'] = $className;
						$val['id'] = $datas['page_id'];
						$val['name'] = $datas['page_name'];
						$val['title'] = ($datas['page_title']=="") ? '---' : $datas['page_title'];
						$val['status'] = $datas['status'];
						$val['action'] = $action_link;
						$response .= self::pages_list_table($val);
						$cnt++;		
					}
				}
				else
				{
					$response = self::pages_list_table('No-Datas');
				}
			}
			return $response;
		}
		
		private function pages_list_table($data)
		{
				$out = '<tr id="page_'.$data['id'].'">
					  <td>'.$data['cnt'].'</td>
					  <td>'.$data['title'].'</td>
					  <td>'.$data['id'].'</td>
					  <td>
					  	<div id="list-edit-icon">
						<em class="icon-pencil" id="'.$data['id'].'" title="edit">edit</em>';
					
				if($data['status'] == 'hide')
				{
					$out .=		'<em class="icon-eye-close status" id="'.$data['id'].'" title="status">display</em>';
				}
				else
				{
					$out .=		'<em class="icon-eye-open status" id="'.$data['id'].'" title="status">display</em>';
				}
				
				$out .=		'<em class="icon-remove" id="'.$data['id'].'" title="delete">delete</em>
						</div>
					  </td>
					</tr>';	
			return $out;
		}		
	}

?>