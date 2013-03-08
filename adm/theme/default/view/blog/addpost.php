 <div class="span9">
<?php $value = $this->post->post_form($this->b,$this->a);?>
<h1 class="page-title">Dashboard</h1>     
 <div class="row-fluid">
    <div class="block">
            <div class="block-heading">Add New Post</div>
            <div class="block-body">
              <fieldset>
          		<form id="addnew-post-form" method="post" action="javascript:void(0);" >
                	
					<label  style="width:12%">Post Title:</label>
                    <input type="text" name="post_title" id="post_title" value="<?=$value['post_title']?>" style="width:85%"/>
                    <span></span>
                    </p>
					
					<label  style="width:12%">Post Keywords:</label>
                    <input type="text" name="post_keywords" id="post_keywords" value="<?=$value['post_keywords']?>" style="width:85%"/>
                    <span></span>
                    </p>
					
					
					<label  style="width:12%">Post Description:</label>
					<textarea name="post_des" id="post_des" style="width:85%"><?=$value['post_des']?></textarea> 
                    <span></span>
                    </p>
					
                    <label >Post Content</label>
                    <div id="editor"><?=$value['editor']?></div>
                    <span></span>
                    </p>
					
                    <p style="padding-top:20px"><label id="load" ></label> 
                    <input type="hidden" name="post_id" id="post_id" value="<?=$value['post_id']?>"/>                   
                    <input name="submit" type="submit" id="btn_submit" value=" Save "/><span></span></p>
          		</form>
          		</fieldset>
            </div>
        </div>
       
    </div>
</div>
  <div class="clearfix"></div>
</div>