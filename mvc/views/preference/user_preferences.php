<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> User Preferences</h3>        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_preference')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <form class="form-horizontal pref-setting" role="form" method="post" enctype="multipart/form-data">


			<div id='user_pref_values'  >

			</div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("update_preference")?>" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
   $( ".select2" ).select2( { placeholder: "SELECT" } );
$(document).ready(function() { 
  var type_id = 8;

  var id = <?=$this->session->userdata('loginuserID')?>;
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('pref_setting/getPreferencesbyType')?>",            
              data: {
                           "pref_type_id":type_id,
			   "id":id,
                    },
             dataType: "html",                                  
             success: function(data) {               
				$('#user_pref_values').html(data);
				
				
            }        
});
});
</script>
