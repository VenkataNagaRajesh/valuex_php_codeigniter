<div class="box">
    <div class="box-header" style="width:100%">
        <h3 class="box-title"><i class="fa icon-reset_password"></i> <?=$this->lang->line('panel_title')?></h3>

       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><a href="<?=base_url("airline/index")?>">Back</a></li>
			<li class="active"><?='Gallery'?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">
                <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                     <h5>Images Uploader</h5>        
					<?php 
                        if(form_error('airlineID')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="airlineID" class="col-sm-2 control-label">
                            <?='Carrier'?>
                        </label>
                        <div class="col-sm-6">
                         <?php foreach($airlines as $airline){
									$airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
								  }							

							echo form_dropdown("airlineID", $airlinelist,set_value("airlineID",$airlineID), "id='airlineID' class='form-control hide-dropdown-icon select2'"); ?> 
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('airlineID'); ?>
                        </span>
                    </div>
					<?php 
                        if(form_error('img_type')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="username" class="col-sm-2 control-label">
                            <?='Image type'?>
                        </label>
                        <div class="col-sm-6">
                            <div class="select2-wrapper">
                             <select class="form-control" name="img_type" id="img_type">
                            <!-- <option value="gallery">Gallery</option>-->
                             <!-- <option value="upgrade_offer_mail_template1_banner">Upgrade Offer Mail Template1 Banner(732*184)</option>
                             <option value="upgrade_offer_mail_template1_left_img">Upgrade Offer Mail Template1 Left Image(732*184)</option>
                             <option value="upgrade_offer_mail_template1_right_img">Upgrade Offer Mail Template1 Right Image(732*184)</option>
                             <option value="upgrade_offer_mail_template2_banner">Upgrade Offer Mail Template2 Banner(344*438)</option>
                             <option value="upgrade_offer_mail_template3_banner">Upgrade Offer Mail Template3 Banner(732*184)</option> -->	
                             <option value="up_tpl1_bnr">Upgrade Template 1 Banner(1267*675)</option>			 
                             <option value="up_tpl1_lft_img">Upgrade Template 1 Left Image(303*205)</option>			 
                             <option value="up_tpl1_rgt_img">Upgrade Template 1 Right Image(303*205)</option>			 
                             <option value="up_tpl2_bnr">Upgrade Template 2 Banner(1267*675)</option>			 
                             <option value="up_tpl3_bnr">Upgrade Template 3 Banner(1267*675)</option>			 
                             <option value="bg_tpl1_bnr">Baggage Template 1 Banner(1267*675)</option>			 
                             <option value="bg_tpl2_bnr">Baggage Template 2 Banner(1235*883)</option>			 
                             <option value="bg_tpl3_bnr">Baggage Template 3 Banner(1267*675)</option>			 
                             <option value="upbg_tpl1_bnr">Upgrade Baggage Template 1 Banner(800*371)</option>			 
                             <option value="upbg_tpl2_bnr">Upgrade Baggage Template 2 Banner(760*200)</option>			 
                             <option value="upbg_tpl3_bnr">Upgrade Baggage Template 3 Banner(700*500)</option>			 
                             <option value="airline_logo">Airline Logo Mail template(84*60)</option>				 
                             </select>
                            </div>
                        </div>  
                         <span class="col-sm-4 control-label">
                            <?php echo form_error('img_type'); ?>
                        </span>						
                    </div>
					  <?php
                        if(form_error('images'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="images" class="col-sm-2 control-label">
                            <?='Images'?>
                        </label>                				  
		                <input type="file"  name="images[]" id="images" multiple>    <hr>
						 <div id="images-upload">

		                 </div>
						 <span class="col-sm-4 control-label">
                            <?php echo form_error('images'); ?>
                        </span>
 					</div>
					<div class='form-group' >  
                       <div class="col-sm-offset-2 col-sm-8">					
                          <button type="submit" class="btn btn-primary">Upload</button>                          
					  </div>
                    </div>
				</form>
              <!-- end #images-to-upload -->
			

		<hr>

		<!--<button type="submit" class="btn btn-sm btn-success" id="upload_all">Upload all images</button>-->
     
	</div><!-- end .container -->

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

$('.select2').select2();
 
  var fileCollection = new Array();
		$('#images').on('change',function(e){
			var airlineID = $('#airlineID').val();
			var img_type = $('#img_type').val();
		if(airlineID != 0 && img_type != 0){
			var files = e.target.files;
			$.each(files, function(i, file){
				//console.log(file);
				var file_name = file.name;
				var id = file_name.substr(0, file_name.lastIndexOf('.')) || file_name;
				
				fileCollection.push(file);
				var reader = new FileReader();
				reader.readAsDataURL(file);
				reader.onload = function(e){
				
				var template = '<div id="'+i+'">'+                                       
                               '<img src="'+e.target.result+'" width="100px;"> '+                                 
                               '<a class="btn btn-sm btn-danger remove" onclick="removeform('+i+')" >Remove</a>'+'</div><br>'; 
					$('#images-upload').append(template);
				};
			});
		   } else{
				alert("select Shop and image type first");
			} 
		});
		
		function removeform(formid){
			$("#"+formid).remove();			
		} 
				
		
		/* $(document).on('submit','form',function(e){
			e.preventDefault();
			var airlineID = $('#airlineID').val();
			var img_type = $('#img_type').val();		
			//this form index
			var index = $(this).index();          		
			var formdata = new FormData($(this)[0]); //direct form not object			
			//append the file relation to index
			console.log(formdata);
			formdata.append('image',fileCollection[index]);
			formdata.append('img_type',img_type);
			formdata.append('airlineID',airlineID);			
			var request = new XMLHttpRequest();
			request.open('post',"<?php echo base_url('airline/gallery'); ?>", true);
			request.send(formdata);
			 request.onload = function(data) { 			
			   if(request.responseText == 'success'){
				   console.log(index);
                    	//$("#"+index).remove();
                       removeform(index);						
                        toastr["success"]("Success")
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "500",
                            "hideDuration": "500",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
					
                 } else {
                        toastr["error"](request.responseText)
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "500",
                            "hideDuration": "500",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    }
			   }		
		});	 */	
		
		
     
</script>

