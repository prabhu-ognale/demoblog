 <div class="span9">

<h1 class="page-title">Dashboard</h1>     
 <div class="row-fluid">
    <div class="block">
            <div class="block-heading">Add New Post</div>
            <div class="block-body">
              <fieldset>
          		<form id="addnew-page-form" method="post" action="javascript:void(0);" >
                	
					<label  style="width:12%">Post Title:</label>
                    <input type="text" name="page_title" id="page_title" value="<?=$value['page_title']?>" style="width:85%"/>
                    <span></span>
                    </p>
					
					<label  style="width:12%">Post Keywords:</label>
                    <input type="text" name="page_keywords" id="page_keywords" value="<?=$value['page_keywords']?>" style="width:85%"/>
                    <span></span>
                    </p>
					
					
					<label  style="width:12%">Post Description:</label>
					<textarea name="page_des" id="page_des" style="width:85%"><?=$value['page_des']?></textarea> 
                    <span></span>
                    </p>
					
                    <label >Post Content</label>
                    <div id="editor"><?=$value['editor']?></div>
                    <span></span>
                    </p>
					
                    <p style="padding-top:20px"><label id="load" ></label> 
                    <input type="hidden" name="page_id" id="page_id" value="<?=$value['page_id']?>"/>                   
                    <input name="submit" type="submit" id="btn_submit" value=" Save "/><span></span></p>
          		</form>
          		</fieldset>
            </div>
        </div>
       
    </div>
</div>
  <div class="clearfix"></div>
</div>