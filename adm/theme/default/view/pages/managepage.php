 <div class="span9">

<h1 class="page-title">Dashboard</h1>     
 <div class="row-fluid">
    <div class="block">
            <div class="block-heading">Manage Pages</div>
            <div class="block-body">
            
            <div class="well">
            <table class="table">
              <thead>
                <tr>
                  <th style="width:10%">#</th>
                  <th style="width:40%">Page Name</th>
                  <th style="width:20%">Page Title</th>
                  <th style="width:10%;">Action</th>
                </tr>
              </thead>
              <tbody>
           		<?=$this->page->manage_page_list('all',$this->p);?>
                  </tbody>
            </table>
        </div>
        <div class="pagination">
            <ul>
                <li><a href="#">Prev</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">Next</a></li>
            </ul>
        </div>

            </div>
        </div>
       
    </div>
</div>
  <div class="clearfix"></div>
</div>