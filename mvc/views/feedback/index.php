
<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa fa-star"></i> <?=$this->lang->line('panel_title')?></h3>

        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active">FeedBack</li>
        </ol>
    </div><!-- /.box-header -->
	
        
        
   
    <!-- form start -->
    <div class="box-body">
        <div class="row">
			<div class="col-md-12">
				<h5 class="page-header"><p>Average Rating : <?=round($avg_rating)?></p></h5>
			</div>
            <div class="col-md-12">
                <div id="hide-table">
                    <table id="feedbacktab" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('feedback_pnr_ref')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('feedback_overall_experience')?></th>
								<th class="col-lg-1"><?=$this->lang->line('feedback_time_response')?></th>
								<th class="col-lg-1"><?=$this->lang->line('feedback_our_support')?></th>
								<th class="col-lg-1"><?=$this->lang->line('feedback_overall_satisfaction')?></th>
								<th class="col-lg-1"><?=$this->lang->line('feedback_customer_service')?></th>
								<th class="col-lg-5"><?=$this->lang->line('feedback_message')?></th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
  $(document).ready(function() {	 
    $('#feedbacktab').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('feedback/server_processing'); ?>",
      "columns": [{"data": "feedbackID" },
                  {"data": "pnr_ref" },
				  {"data": "overall_experience" },
				  {"data": "time_response" },
				  {"data": "our_support" }, 
                  {"data": "overall_satisfaction"},
				  {"data": "customer_service"},
                  {"data": "message"}
				  ],			     
     dom: 'B<"clear">lfrtip',
     //buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
	 buttons: [
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)" } },
                { text: 'Export All', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('feedback/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","feedback.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }	                
            ] ,
    });
  }); 
  </script>