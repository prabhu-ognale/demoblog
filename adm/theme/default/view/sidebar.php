 <div class="container-fluid">
        
        <div class="row-fluid">
            <div class="span3">
                <div class="sidebar-nav">
                  
				  <div class="nav-header" data-toggle="collapse" data-target="#dashboard-menu"><i class="icon-dashboard"></i>Dashboard</div>
                    <ul id="dashboard-menu" class="nav nav-list collapse in">
                        <li><a href="<?=SITE_URL?>">Home</a></li>
						<li><a href="<?=SITE_URL.'/home/sitesettings/';?>">Settings</a></li>
                    </ul>
					
                <div class="nav-header" data-toggle="collapse" data-target="#user-menu"><i class="icon-briefcase"></i>Blog<span class="label label-info">+10</span></div>
                <ul id="user-menu" class="nav nav-list collapse in">
                  <li ><a href="<?=SITE_URL.'/blog/addpost/';?>">Add Post</a></li>
				  <li ><a href="<?=SITE_URL.'/blog/list/';?>">List Post</a></li>
                  <li ><a href="<?=SITE_URL.'/blog/category/';?>">Category</a></li>
                </ul>

                <div class="nav-header" data-toggle="collapse" data-target="#client-menu"><i class="icon-exclamation-sign"></i>Pages</div>
                <ul id="client-menu" class="nav nav-list collapse in">
                   <li ><a href="<?=SITE_URL.'/pages/addpage/';?>">Add Pages</a></li>
				   <li ><a href="<?=SITE_URL.'/pages/managepage/';?>">Manage Pages</a></li>
                </ul>
				
				<div class="nav-header" data-toggle="collapse" data-target="#project-menu"><i class="icon-exclamation-sign"></i>Gallery</div>
                <ul id="project-menu" class="nav nav-list collapse in">
                  <li ><a href="<?=SITE_URL.'/gallery/addgallery/';?>">Add Gallery</a></li>
                  <li ><a href="<?=SITE_URL.'/gallery/listgallery/';?>">List Gallery</a></li>
                </ul>

                <div class="nav-header" data-toggle="collapse" data-target="#legal-menu"><i class="icon-legal"></i>Legal</div>
                <ul id="legal-menu" class="nav nav-list collapse in">
                  <li ><a href="privacy-policy.html">Privacy Policy</a></li>
                  <li ><a href="terms-and-conditions.html">Terms and Conditions</a></li>
                </ul>
            </div>
        </div>