<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("airline_cabin/index")?>"><?php //echo $this->lang->line('menu_airline_cabin'); ?>Back</a></li>
            <li class="active"><?=$this->lang->line('update_airline_cabin')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">
                <form class="form-horizontal" role="form" method="post" id='edit_airline_cabin' enctype="multipart/form-data">


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
	
			 $airlinesdata['0'] = 'Select Airlines';
                        ksort($airlinesdata);
				echo form_dropdown("airline_code", $airlinesdata, set_value("airline_code",$airline->airline_code), "id='airline_code' class='form-control select2'");
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
                                <option value="0">Select Aircraft</option>
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
                            <?=$this->lang->line("airline_cabin")?>
                        </label>
                        <div class="col-sm-6">
				
<?php		        	$airlinecabins['0'] = 'Select cabin';       
				ksort($airlinecabins);
			echo form_dropdown("airline_cabin", $airlinecabins, set_value("airline_cabin",$airline->airline_cabin), "id='airline_cabin' class='form-control select2'");
?>
                        </div>
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
			<div>
                        <?php foreach($airline_cabin->gallery as $gallery){
			
                                     $array = array(
                                "src" => base_url('uploads/images/'.$gallery->image),
                                        'width' => '35px',
                                        'height' => '35px',
                                        'class' => 'img-rounded'
                                );
				?>
			
		<a href="<?php echo base_url('airline_cabin/deleteAirlineCabinimage/'.$gallery->cabin_images_id); ?>" onclick="return confirm('you are about to delete a record. This cannot be undone. are you sure?')" class="btn btn-danger btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Delete"><?php echo img($array)?></a>


                      <?php  }?>
                        </div>

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
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("update_airline_cabin")?>" >
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$( ".select2" ).select2();
$('#airline_code').change(function(event) {    
        $('#airline_aircraft').val(null).trigger('change');
  var airline_id = $(this).val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('airline_cabin/getAircrafts')?>",            
             data: "id=" + airline_id,            
             dataType: "html",                                  
             success: function(data) {               
             $('#airline_aircraft').html(data); }        
      });       
});


 $(document).ready(function(){

$('#airline_code').trigger('change');
var aircraftID = '<?=$airline->aircraft_id?>';
$('#airline_aircraft').val(aircraftID).trigger('change');



  var form_data = $('#edit_airline_cabin').serialize();
  $('#edit_airline_cabin').submit(function () {
      if ( form_data == $(this).serialize() ) {
	event.preventDefault();
	window.location.replace('<?=base_url('airline_cabin/index')?>');
      }
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
var jQueryArray = <?php echo json_encode(explode(',',$airline->video_links)); ?>;
        $.each(jQueryArray, function(index, value){
		if ( index == '0' ) {
			$('#video').val(value);;
		} else {
			var field = '<br><div><input type="text" id="video'+index+'" class="form-control" name="video[]"> </div>';
    			$('.appending_div').append(field);
			$('#video'+index).val(value);
		}
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
