<?php

	class Blog_Function extends Control
	{
		public function Blog_Function()
		{
			parent::Control();	
		}
		function post_form($id=false,$a=false)
		{
			$val = array();
			$val['post_title'] = '';
			$val['post_keywords'] = '';
			$val['post_des'] = '';
			$val['editor'] = '';
			$val['post_id'] = 0;
			if($id)
			{
				if($a == 'edit')
				{
					$res = $this->db->query("SELECT * FROM " . POST . " WHERE `post_id` = $id")or die($this->db->error());
					$data = $this->db->fetch_array($res)or die($this->db->error());
					$val['post_title'] = $data['post_title'];
					$val['post_keywords'] = $data['post_keywords'];
					$val['post_des'] = $data['post_des'];
					$val['editor'] = $data['post_content'];
					$val['post_id'] = $id;
				}
			}
			return $val;
		}
		
		function ajax_check_post_name($var)
		{
			$response=array();
			$url = $this->fn->sanitize($var,6);
			$sql = $this->db->query("SELECT post_id FROM " . POST . " WHERE url = '$url'");
			if(strlen(trim($var)) == 0)
			{
				$response['ok'] = false;
				$response['msg'] = 'post name is empty' ;
				$response['img'] = IMG_BASE_PATH . '/wrong.gif';
				$response['code'] = 'wrong';
			}
			elseif(!preg_match("/^[a-zA-Z0-9]+([\\s]{1}[a-zA-Z0-9]|[a-zA-Z0-9])+$/i",$var))
			{
				$response['ok'] = false;
				$response['msg'] = 'post name content Alpha, Numeric' ;
				$response['img'] = IMG_BASE_PATH . '/wrong.gif';
				$response['code'] = 'wrong';
			}
			else
			{
				if($this->db->num_rows($sql)==0)
				{
					$response['ok'] = true;
					$response['msg'] = 'post name accepted' ;
					$response['img'] = IMG_BASE_PATH . '/success.gif';
					$response['code'] = 'success';
					$response['val'] = $this->fn->sanitize($var,1);
				}
				else
				{
					$response['ok'] = true;
					$response['msg'] = 'post name already exists... Please try other...' ;
					$response['img'] = IMG_BASE_PATH . '/wrong.gif';
					$response['code'] = 'wrong';
				}
			}
			return json_encode($response);
		}
		
		function add_edit_post($datas)
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
				
				$val = array();
				$val['post_title']   = $this->fn->sanitize($datas['post_title'],1);
				$val['post_keywords']   = $this->fn->sanitize($datas['post_keywords'],1);
				$val['post_des']   = $this->fn->sanitize($datas['post_des'],8);
				$val['post_content'] = $this->fn->sanitize($datas['editor'],8);
				//$val['url'] = $this->fn->sanitize($postname,6);
				$val['status'] = 'hide';
				
				if($errcnt==0)
				{
					if($datas['post_id'] == 0)
					{
						//insert
						$insert = $this->db->insert(POST,$val,true);
						$response['ok']  = true;
						$response['msg'] = 'post posted successfully.';
						$response['location'] = SITE_URL.'/blog/list/';
					}
					else
					{
						//update
						$update = $this->db->update(POST,$val,"post_id=" . $datas['post_id']);
						$response['ok']  = true;
						$response['msg'] = 'post updated successfully.';
						$response['location'] = SITE_URL.'/blog/list/';
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
		
		/*manage posts*/
		function ajax_delete_post($data)
		{
			$id = $data['id'];
			$sql = $this->db->query("DELETE FROM " . POST . " WHERE post_id = $id") or die ($this->db->error());
			$response = array();
			$response['ok'] = true;
			$response['msg'] = 'success';
			return json_encode($response);		
		}
		
		function post_display_on_off($data)
		{
			if(!is_array($data))
			{
				$data = array('id' => $data);
			}
			$id = $data['id'];
			$status = $data['status'];
			if($status=='1'){$s = 'show'; $addClass='icon-eye-open';}else{$s = 'hide'; $addClass='icon-eye-close';}
			$upt = array('status' => $s);
			$update = $this->db->update(POST,$upt,"post_id=$id");
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
				$sql = "SELECT $field FROM ". POST . " ORDER BY post_id ASC";
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
		
		function manage_post_list($act=false,$p=false)
		{
			if($act)
			{
				$sql = $this->manage_get_sql($act,$p,25);
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
						$val['id'] = $datas['post_id'];
						$val['name'] = $datas['post_name'];
						$val['title'] = ($datas['post_title']=="") ? '---' : $datas['post_title'];
						$val['status'] = $datas['status'];
						$val['action'] = $action_link;
						$response .= self::post_list_table($val);
						$cnt++;		
					}
				}
				else
				{
					$response = self::post_list_table('No-Datas');
				}
			}
			return $response;
		}
		
		private function post_list_table($data)
		{
				$out = '<tr id="page_'.$data['id'].'">
					  <td>'.$data['cnt'].'</td>
					  <td>'.$data['title'].'</td>
					  <td>'.$data['id'].'</td>
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