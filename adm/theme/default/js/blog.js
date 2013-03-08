// JavaScript Document
elRTE.prototype.options.panels.webPanel_1 = [
   'bold', 'italic', 'underline', 'forecolor', 'justifyleft', 'justifyright','fontsize','fontname','formatblock','flash','elfinder',
   'justifycenter', 'justifyfull',  'insertorderedlist', 'insertunorderedlist',
   'link', 'image'];
elRTE.prototype.options.toolbars.web2pyToolbar = ['webPanel_1', 'tables'];


$(document).ready(function(){
	
	var opts = {
	cssClass : 'el-rte',
	height   : 350,
	toolbar  : 'web2pyToolbar',
	cssfiles : [themePath + '/css/elrte-inner.css'],
	fmAllow      : true,
	fmOpen   : function(callback) {
					$('<div id="finder"></div>').elfinder({
						url : baseUrl+'php/connector.php',
						lang : 'en',
						dialog : { width : 900, modal : true, title : 'Files' }, // open in dialog
						closeOnEditorCallback : true, // close elFinder after file select
						editorCallback : callback // pass callback to editor
					});
				},
	}
	$('#editor').elrte(opts);

			
	$('form#addnew-post-form').bind('submit',function(){
		var t = $(this);
		var sval = $(this).serialize();
		var btn_sub = $('form#addnew-post-form input#btn_submit');
		
		if($('input[name="post_name"]').val()=='')
		{
			jAlert('post Name is Empty','Alert Box',function(r){
				if(r==true) $('input[name="post_name"]').focus(); return false;
			});
			return false;
		}
		
		if($('input[name="post_title"]').val()=='')
		{
			jAlert('post Title is Empty','Alert Box',function(r){
				if(r==true) $('input[name="post_title"]').focus(); return false;
			});
			return false;
		}
		
		if($('textarea[name="editor"]').val()=='&nbsp;')
		{
			jAlert('post Content is Empty','Alert Box',function(r){
				if(r==true) return false;
			});
			return false;
		}
			
		postId = $('input[name="post_id"]').val();
		btn_sub.next().css('padding-left','10px').html(loading);
		if(this.timer)clearTimeout();
		this.timer = setTimeout(function(){
			$.ajax({
				url:postUrl + '?page=blog&action=addpost&fn=add_edit_post&id='+postId+'&rand='+rand,
				data: sval,
				dataType: 'json',
				type: 'post',
				cache: false,
				success : function(j){
					
					if(j.ok == true)
					{
						$('<div id="note"></div>').html('<span class="success">'+j.msg+'</span>').slideDown('slow').prependTo('body'); $('div#note').delay(3000).slideUp(1000,function(){$(this).remove()});
						clear_form_elements(t);
						window.location.replace(j.location);
					}
					else if(j.ok == false)
					{
						$('<div id="note"></div>').html('<span class="error">'+j.msg+'</span>').slideDown('slow').prependTo('body'); $('div#note').delay(3000).slideUp(1000,function(){$(this).remove()});
					}
					btn_sub.next().remove();
					return false;
				}
			});
		},60);
	});
	
	$('em.icon-remove').live('click',function(){
		var t = $(this);
		var tagId = t.attr('id');
		jConfirm('Are you sure you want ot delete this thread?'+tagId, 'Confirmation Dialog', function(r)
		{
			if(this.timer)clearTimeout();
			if(r == true)
			{
				this.timer = setTimeout(function(){
					$.ajax({
						url:postUrl,
						data: 'page=blog&action=managepost&fn=ajax_delete_post&id='+tagId+'&rand='+rand,
						dataType: 'json',
						success: function(j)
						{
							if(j.ok == true)
							{
								$('#post_' + tagId).remove();
							}
							return false;
						}
					});
				},40);
			}
		});
	});
	
	$('em.status').live('click',function(){
		var id = $(this).attr('id');
		if($(this).is('.icon-eye-close'))
		{
			$.get(postUrl, {'page':'blog','action':'managepost','fn':'post_display_on_off','id':id,'status':'1','rand':rand});
			$(this).removeClass('icon-eye-close').addClass('icon-eye-open');
		}
		else if($(this).is('.icon-eye-open'))
		{
			$.get(postUrl, {'page':'blog','action':'managepost','fn':'post_display_on_off','id':id,'status':'0','rand':rand});
			$(this).removeClass('icon-eye-open').addClass('icon-eye-close');
		}
		else
		{
			return false;
		}
	});
	
	$('em.icon-pencil').live('click',function(){
		var id = $(this).attr('id');
		window.location.replace(baseUrl + '/blog/addpost/?a=edit&b='+id);
	});
	
});