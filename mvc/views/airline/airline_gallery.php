<div class="box">
    <div class="box-header" style="width:100%">
        <h3 class="box-title"><i class="fa icon-reset_password"></i> <?=$this->lang->line('panel_title')?></h3>

       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active">Back</li>
			<li class="active"><?='Gallery'?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">
                <form class="form-horizontal" role="form" method="post">
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
					<div class='form-group' > 
                        <label for="username" class="col-sm-2 control-label">
                            <?='Image type'?>
                        </label>
                        <div class="col-sm-6">
                            <div class="select2-wrapper">
                             <select class="form-control" name="img_type" id="img_type">
                             <option value="gallery">Gallery</option>
                             <option value="upgrade_offer_mail_template1">Upgrade Offer Mail Template 1</option>
                             <option value="upgrade_offer_mail_template2">Upgrade Offer Mail Template 2</option>
                             <option value="upgrade_offer_mail_template3">Upgrade Offer Mail Template 3</option>							 
                             <option value="airline_logo">Airline Logo (84*60)</option>					 
                             </select>
                            </div>
                        </div>                        
                    </div>
				</form>
              <div class="container"> 
                				  
		              <input type="file"  name="images[]" id="images" multiple>
				 
		         <hr>
			 </div>
		   <div id="images-to-upload">

		    </div><!-- end #images-to-upload -->

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
					var template = '<form action="/upload" id="'+i+'">'+					   
						'<img src="'+e.target.result+'" width="40px;"> '+
						'<label>Image Title</label> <input type="text" name="name">'+				
						' <button type="submit" class="btn btn-sm btn-info upload">Upload</button>'+
						' <a class="btn btn-sm btn-danger remove" onclick="removeform('+i+')" >Remove</a>'+						
					'</form>';
					$('#images-to-upload').append(template);
				};
			});
		   } else{
				alert("select Shop and image type first");
			} 
		});
		
		function removeform(formid){
			$("#"+formid).remove();			
		}
				
		
		$(document).on('submit','form',function(e){
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
                    	//$("#"+index).remove();                 					
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
		});		
		
		
     
</script>

