<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("airline_cabin/index")?>"><?php //echo $this->lang->line('menu_airline_cabin'); ?> Back</a></li>
            <li class="active"><?=$this->lang->line('add_airline_cabin')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">
                <form class="form-horizontal" role="form" method="post"  enctype="multipart/form-data">

		 <?php
                        if(form_error('airline_code'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="airline_code" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_name")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                        <?php


			                         foreach($airlines as $airline){
                                $airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
                                }


			 $roleID = $this->session->userdata('roleID');
                        if($roleID == 2){
                          $default_airlineID =  key($airlinesdata);
                        } else {
                          $default_airlineID = 0;
                      }


			$airlinelist['0'] = 'Carrier';
			ksort($airlinelist);
                        echo form_dropdown("airline_code", $airlinelist, set_value("airline_code",$default_airlineID), "id='airline_code' class='form-control select2'");
                        ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('airline_code'); ?>
                        </span>
                    </div>



                      <?php
                        if(form_error('airline_aircraft'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="airline_aircraft" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_aircraft")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6"> 

			 <select  name="airline_aircraft"  id="airline_aircraft" class="form-control select2" >
				<option value="0">Select AircraftType</option>
                                </select>

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('airline_aircraft'); ?>
                        </span>
                    </div>


                    <?php
                        if(form_error('airline_cabin'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="airline_cabin" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_cabin")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
			  <select  name="airline_cabin"  id='airline_cabin' class="form-control select2">
                                <option value=0>Cabin</option>
                                                        </select>

			 <?php
			/*
				$airlinecabins['0'] = 'Select cabin';
				ksort($airlinecabins);
				echo form_dropdown("airline_cabin", $airlinecabins, set_value("airline_cabin"), "id='airline_cabin' class='form-control select2'");*/
?>                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('airline_cabin'); ?>
                        </span>
                    </div>


         <?php
                        if(form_error('images'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="images" class="col-sm-2 control-label">
                            <?=$this->lang->line("images")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
			<input type="file"  name="images[]" id="images" multiple>
			 <div id="images-to-upload">

                    	</div>

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('images[]'); ?>
                        </span>

                    </div>




	<?php
                        if(form_error('video'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="video" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_video")?> <span class="text-red">*</span>
                        </label> <span class="btn btn-success mrg fa fa-plus" id='add_box'></span>
				 <span class="btn btn-success mrg fa fa-minus" id='remove_box'></span>
				 
                        <div class="col-sm-6">
				<input type="text" class="form-control" id="video" name="video[]" value="<?=set_value('video')?>" >
				<div class="appending_div">
      				<div>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('video'); ?>
                        </span>
                    </div>




		<br>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_airline_cabin")?>" >
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
$('#airline_code').trigger('change');

$('#airline_code').change(function(event) {    
  var carrier = $('#airline_code').val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('airline_cabin_class/getCabinDataFromCarrier')?>",            
              data: {
                           "carrier":carrier,
                    },
             dataType: "html",                                  
             success: function(data) {               
                                $('#airline_cabin').html(data);
                                }        
      });       
});

$('#airline_code').trigger('change');
<?php $airline_cabin = $this->input->post("airline_cabin") ? $this->input->post("airline_cabin"): 0;?>
$('#airline_cabin').val('<?=$airline_cabin;?>').trigger('change');


/* var ac = <?php echo $this->input->post("airline_aircraft"); ?>;
        $('#airline_aircraft').val(ac).trigger('change');*/


$( ".select2" ).select2({closeOnSelect:false, placeholder:'Select Class'
		         });
var i = 1;
  $('#add_box').on('click', function() {
    var field = '<br><div><input type="text" id="video'+i+'" class="form-control" name="video[]"> </div>';
    $('.appending_div').append(field);
	i = i+1;
  })

$('#remove_box').on('click', function() {
	$(".appending_div").children().last().remove();
	$(".appending_div").children().last().remove();
  })


});




$('#airline_code').change(function(event) {    
        $('#airline_aircraft').val(null).trigger('change')
  var airline_id = $(this).val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('airline_cabin/getAircraftTypes')?>",            
             data: "id=" + airline_id,            
             dataType: "html",                                  
             success: function(data) {               
             $('#airline_aircraft').html(data); }        
      });       
});

var fileCollection = new Array();
                $('#images').on('change',function(e){
                        var files = e.target.files;
                        $.each(files, function(i, file){
                                //console.log(file);
                                var file_name = file.name;
                                var id = file_name.substr(0, file_name.lastIndexOf('.')) || file_name;
                                
                                fileCollection.push(file);
                                var reader = new FileReader();
                                reader.readAsDataURL(file);
                                reader.onload = function(e){
					var fname = 'name'+i;
                                        var template = '<div id="'+i+'">'+                                       
                                                '<img src="'+e.target.result+'" width="40px;"> '+
                                                '<label>Image Title</label> <input type="text" name="'+fname+'">'+                           
                                                ' <a class="btn btn-sm btn-danger remove" onclick="removeform('+i+')" >Remove</a>'+                                            
                                        '</div><br>';
                                        $('#images-to-upload').append(template);
                                };
                        });
                });
                function removeform(formid){
                        $("#"+formid).remove();                 
                }
                    

</script>
