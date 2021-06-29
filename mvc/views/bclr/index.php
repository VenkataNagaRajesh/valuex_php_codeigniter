<?php if(empty($check_product) && $this->session->userdata('roleID') != 1) { ?>
<div id="notice-warning" class="col-md-12">
    <div class="alert alert-warning" style="margin-top:20px;">
        <i class="fa fa-check-circle"></i>
        Sorry Your Baggage Product Expired ..!
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
</div>
<?php } ?>
<div class="fclr-bar">
<?php  if(permissionChecker('bclr_add')) {  ?>
	<h2 class="title-tool-bar" style="color:#fff;float:left;width:96%;"><i class="fa fa-sun-o"></i> Baggage Control Rule
		<ol class="breadcrumb pull-right">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_bclr')?></li>
        </ol>
	</h2>
	<p class="card-header" data-toggle="collapse" data-target="#bclrAdd"><button style="margin:1px 0;" type="button" class="btn btn-danger pull-right" data-placement="left" title="Add BCLR" data-toggle="tooltip" id='bclr_add_btn' ><i class="fa fa-plus"></i></button></p>
 <?php } ?>
	<div class="col-md-12 fclr-table-add collapse" id="bclrAdd">
		<form class="form-horizontal" action="#" id='bclr_add_form'>
			<div class="col-md-12">           
            <div class="form-group">
					<div class="col-md-2 col-sm-3">
                    <?php  $clist[0] = "Carrier";
                               foreach($myairlines as $airline){
                                   $clist[$airline->vx_aln_data_defnsID] = $airline->code;
                                   if($this->session->userdata('roleID') != 1 && $this->session->userdata('login_user_airlineID')[0] == $airline->vx_aln_data_defnsID){
                                       $login_airline_name = $airline->code;
                                   }
                               }
                               echo form_dropdown("carrierID", $clist,
                                        set_value("carrierID",$carrierID), "id='carrierID' class='form-control hide-dropdown-icon select2'"
                           
                               );
                    ?>
					</div>
                    <div class="col-md-2 col-sm-3">
                        <select  name="from_cabin[]"  id="from_cabin" placeholder="Cabin Content" class="form-control select2" multiple="multiple">
				        </select>
			<span> <input type="checkbox" id="cabin_checkbox_level"> Select All</span>
                    </div>
					<div class="col-md-2 col-sm-3">
                        <select  name="partner_carrierID"  id="partner_carrierID" class="form-control select2">
                        <option value="0">Partner Carrier</option>
				        </select>
					</div>
					<div class="col-md-2 col-sm-3">
						<?php 
                            $allowance[0] = 'All';
                            $allowance[1] = 'Whitelist';
                            $allowance[2] = 'Blacklist';
							echo form_dropdown("allowance", $allowance,set_value("allowance"), "id='allowance' class='form-control hide-dropdown-icon select2'name='allowance'");?>
					</div>
                   
					<div class="col-md-2 col-sm-3">
                        <select  name="aircraft_type"  id="aircraft_type" class="form-control hide-dropdown-icon select2" placeholder="Aircraft Type">
                         <option value="0"> Aircraft </option>
				        </select> 
					</div>
					<div class="col-md-2 col-sm-3">
                       <input type="text" class="form-control" name="flight_num_range" placeholder="Flight Number Range" id="flight_num_range" value="<?=set_value('flight_num_range')?>" />
					</div>
                    
                </div>
                <div class="form-group">
                    <div class="col-md-2 col-sm-3">
                         <?php                         
                          $originlist[0] = "Origin Level";
                          foreach($types as $type){
                              $originlist[$type->vx_aln_data_typeID] = $type->alias;
                          }                       
                        echo form_dropdown("origin_level", $originlist, set_value("origin_level"), "id='origin_level' class='form-control select2'");
                        ?>
					</div>
					<div class="col-md-2 col-sm-3">
                        <select  name="origin_content[]"  id="origin_content" placeholder="Origin Content" class="form-control select2" multiple="multiple">
				        </select> 
                        <span> <input type="checkbox" id="origin_checkbox_level" > Select All</span>
					</div>
					<div class="col-md-2 col-sm-3">
                    <?php                         
                          $destlist[0] = "Destination Level";
                          foreach($types as $type){
                              $destlist[$type->vx_aln_data_typeID] = $type->alias;
                          }  
                        echo form_dropdown("dest_level", $destlist, set_value("dest_level"), "id='dest_level' class='form-control select2'");
                        ?>
                                       
					</div>
					<div class="col-md-2 col-sm-3">
                        <select  name="dest_content[]"  id="dest_content" placeholder="Destination Content" class="form-control select2" multiple="multiple">
				        </select>
                         <span> <input type="checkbox" id="dest_checkbox_level" > Select All</span>         
        			</div>				
					<div class="col-md-2 col-sm-3">
                        <div class="input-group">
							<input type="text" class="form-control" placeholder="Effective Date" id="effective_date" name="effective_date" value="<?=set_value('effective_date')?>">
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
                    </div>
					<div class="col-md-2 col-sm-3">
                        <div class="input-group">
                            <input type="text" class="form-control hasDatepicker" placeholder="Discontinue Date"  id="discontinue_date" name="discontinue_date" value="<?=set_value('discontine_date')?>" >
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2 col-sm-3">
                     <?php                         
                          $seasons['0'] = 'Season';
                          ksort($seasons);
                          echo form_dropdown("season", $seasons,set_value("season"), "id='season' class='form-control hide-dropdown-icon select2'"); 
                    ?>                        
                    </div>
                    <div class="col-md-2 col-sm-3">
                        <?php
							/* $days_of_week[0] = 'Frequency';
							ksort($days_of_week);
							echo form_dropdown("frequency", $days_of_week, set_value("frequency"), "id='frequency' class='form-control hide-dropdown-icon select2'"); */ ?> 
						<input type="text" class="form-control" placeholder="Frequency" id="frequency" name="frequency" value="<?=set_value('frequency')?>" >
                    </div>                     
                    <div class="col-md-2 col-sm-3">
                     <?php                         
						$unittypes = Array();
                          $unittypes[0] = "All";                           
                          $unittypes[1] = "KG";                           
                          $unittypes[2] = "Piece";                           
                        echo form_dropdown("bag_type", $unittypes, set_value("bag_type"), "id='bag_type' class='form-control select2'");
                        ?>
                    </div> 
                    <div class="col-md-2 col-sm-3">
                        <?php  /* $auth[0] = "Rule Auth";
                               foreach($airlines as $airline){
                                   $auth[$airline->vx_aln_data_defnsID] = $airline->code;
                               }
                               echo form_dropdown("rule_auth_carrier", $auth,set_value("rule_auth_carrier"), "id='rule_auth_carrier' class='form-control hide-dropdown-icon select2'"); */
                        ?>
                        <select  name="rule_auth_carrier"  id="rule_auth_carrier" class="form-control select2">
                            <option value="0">Rule Auth</option>
				        </select>
					</div>
                    <div class="col-md-2 col-sm-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Dep Time Start"  id="dep_time_start" name="dep_time_start" value="<?=set_value('dep_time_start')?>" >
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>     
                    </div>  
                    <div class="col-md-2 col-sm-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Dep Time End"  id="dep_time_end" name="dep_time_end" value="<?=set_value('dep_time_end')?>" >
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2 col-sm-3">
                        <input type="number" class="form-control" name="min_unit" id="min_unit" placeholder="Min Unit" value="<?=set_value('min_unit')?>" />                       
                    </div>
                    <div class="col-md-2 col-sm-3">
                        <input type="number" class="form-control" name="max_capacity" id="max_capacity" placeholder="Max Capacity" value="<?=set_value('max_capacity')?>" />                       
                    </div>                      
                    <div class="col-md-2 col-sm-3">
                        <input type="number" class="form-control" name="min_price" id="min_price" placeholder="Min Price" value="<?=set_value('min_price')?>" />                       
                    </div> 
                    <div class="col-md-2 col-sm-3">
                        <input type="number" class="form-control" name="max_price" id="max_price" placeholder="Max Price" value="<?=set_value('max_price')?>" />                       
		<input type="hidden" class="form-control" id="bclr_id" name="bclr_id"   value="" >
					</div>                    
                </div>  
				<div class="col-md-12 col-sm-3 text-right">
						<a href="#" type="button"  id='btn_txt' class="btn btn-danger" onclick="savebclr();">Add BCLR</a>
						<a href="#" type="button"  id='check_rafeed_match' class="btn btn-danger" onclick="matchRafeed();">CHECK RAFEED MATCH</a>
						<a href="#" type="button" id='bclr_cancel_btn' class="btn btn-danger" onclick="form_reset()" data-toggle="collapse" data-target="#bclrAdd" >Cancel</a>
				</div> 	
			</div>
		</form>
	</div>
	<div class="col-md-12 table-responsive">
		<form class="form-horizontal" action="#">
			<div class="col-md-12">
				<div class="form-group">                
					<div class="col-md-2 col-sm-3 select-form">
						<div class="col-md-12">
                            <?php  $fclist[0] = "Carrier";
                               foreach($myairlines as $airline){
                                   $fclist[$airline->vx_aln_data_defnsID] = $airline->code;
                               }
                               echo form_dropdown("flt_carrierID", $fclist,
                                        set_value("flt_carrierID",flt_carrierID), "id='flt_carrierID' class='form-control hide-dropdown-icon select2'"
                           
                               );
                            ?>
						</div>
						<div class="col-md-12">
                            <select  name="flt_partner_carrierID"  id="flt_partner_carrierID" class="form-control select2">
                            <option value="0">Partner Carrier</option>
                            </select>
						</div>
                        <div class="col-md-12">
                            <input type="number" class="form-control" name="flt_min_price" id="flt_min_price" placeholder="Min Price" value="<?=set_value('flt_min_price',$flt_min_price)?>" />                       
                        </div>
                        <div class="col-md-12">
                                <select class="form-control select2"  name="bclr_status" id="bclr_status">    
                                    <option value="2" <?=(($bclr_status == 2 )? "selected":"")?>>All</option>      
                                    <option value="1" <?=(($bclr_status == 1 )? "selected":"")?>>Active</option>
                                    <option value="0" <?=(($bclr_status == 0 || $bclr_status == '' )? "selected":"")?>>In active</option>
                                </select>
                            </div>
					    </div>
					<div class="col-md-2 col-sm-3 select-form">
						<div class="col-md-12">
                            <?php
                                $fallowance[1] = 'Whitelist';
                                $fallowance[2] = 'Blacklist';
                                echo form_dropdown("flt_allowance", $allowance,set_value("flt_allowance",$flt_allowance), "id='flt_allowance' class='form-control hide-dropdown-icon select2'");
                            ?>
						</div>
						<div class="col-md-12">
                            <?php  $fauth[0] = "Rule Auth";
                               foreach($airlines as $airline){
                                   $fauth[$airline->vx_aln_data_defnsID] = $airline->code;
                               }
                               echo form_dropdown("flt_rule_auth_carrier", $fauth,set_value("flt_rule_auth_carrier",$flt_rule_auth_carrier), "id='flt_rule_auth_carrier' class='form-control hide-dropdown-icon select2'");
                            ?>
						</div>
                        <div class="col-md-12">
                            <input type="number" class="form-control" name="flt_max_price" id="flt_max_price" placeholder="Max Price" value="<?=set_value('flt_max_price',$flt_max_price)?>" />                       
                        </div>                         
					</div>
					<div class="col-md-2 col-sm-3 select-form">
                        <div class="col-md-12">
                            <?php
							    $days_of_week[0] = 'Frequency';
							    ksort($days_of_week);
                                echo form_dropdown("flt_frequency", $days_of_week, set_value("flt_frequency",$flt_frequency), "id='flt_frequency' class='form-control hide-dropdown-icon select2'");
                            ?> 
						</div>
                        
						<div class="col-md-12">
                            <?php                         
						$flt_unittypes  = Array();
                                $flt_unittypes[0] = "All";                           
                                $flt_unittypes[1] = "KG";                           
                                $flt_unittypes[2] = "Piece";                           
                                echo form_dropdown("flt_bag_type", $flt_unittypes, set_value("flt_bag_type",$flt_bag_type), "id='flt_bag_type' class='form-control select2'");
                            ?>
						</div>
                        <div class="col-md-12">
                            <input type="number" class="form-control" name="flt_min_unit" id="flt_min_unit" placeholder="Min Unit" value="<?=set_value('flt_min_unit',$flt_min_unit)?>" />                       
                        </div>
                    </div>
		<div class="col-md-2 col-sm-3 select-form">
                        <div class="col-md-12">
							<input type="text" class="form-control" placeholder="Effective Date" id="flt_effective_date" name="flt_effective_date" value="<?=set_value('flt_effective_date',$flt_effective_date)?>">
						</div>
                        <div class="col-md-12">
                            <input type="text" class="form-control hasDatepicker" placeholder="Discontinue Date"  id="flt_discontinue_date" name="flt_discontinue_date" value="<?=set_value('flt_discontine_date',$flt_discontine_date)?>" >
                        </div>
                        <div class="col-md-12">
                            <input type="number" class="form-control" name="flt_max_capacity" id="flt_max_capacity" placeholder="Max Capacity" value="<?=set_value('flt_max_capacity',$flt_max_capacity)?>" />                       
                        </div>                     						
		</div>
		<div class="col-md-2 col-sm-3 select-form">
                        <div class="col-md-12">
                            <?php                         
                                $foriginlist[0] = "Origin Level";
                                foreach($types as $type){
                                    $foriginlist[$type->vx_aln_data_typeID] = $type->alias;
                                }                       
                                echo form_dropdown("flt_origin_level", $foriginlist, set_value("flt_origin_level",$flt_origin_level), "id='flt_origin_level' class='form-control select2'");
                            ?>
                        </div>
                        <div class="col-md-12">
                            <select  name="flt_origin_content[]"  id="flt_origin_content" placeholder="Origin Content" class="form-control select2" multiple="multiple" style="margin-bottom:0;">
                            </select>                            
                        </div>
						 <div class="col-md-12">
                            <select  name="flt_from_cabin[]"  id="flt_from_cabin" placeholder="From Cabin" class="form-control select2" multiple="multiple">
                            </select>
						</div>	
					</div>
					<div class="col-md-2 col-sm-3 select-form">
                        <div class="col-md-12">
                            <?php                         
                                $fdestlist[0] = "Destination Level";
                                foreach($types as $type){
                                    $fdestlist[$type->vx_aln_data_typeID] = $type->alias;
                                }  
                                echo form_dropdown("flt_dest_level", $fdestlist, set_value("flt_dest_level",$flt_dest_level), "id='flt_dest_level' class='form-control select2'");
                            ?>
						</div>
						<div class="col-md-12">
                            <select  name="flt_dest_content[]"  id="flt_dest_content" placeholder="Destination Content" class="form-control select2" multiple="multiple" style="margin-bottom:0;">
                            </select>
						</div>		
						<div class="col-md-12">
							<input type="text" class="form-control" name="flt_bclr_id" id="flt_bclr_id" placeholder="BCLR ID" value="<?=set_value('flt_bclr_id', $flt_bclr_id)?>" />                       
						</div>
                        <div class="col-md-12 text-right">
							<a type="button" class="btn btn-danger" onclick="downloadBCLR()" data-toggle="tooltip" data-title="Download" style="margin-right:10px;"><i class="fa fa-download"></i></a>
							<a href="#" type="button"  id='btn_txt' class="btn btn-danger" onclick="$('#bclrtable').dataTable().fnDestroy();loaddatatable();" data-toggle="tooltip" data-title="Filter"><i class="fa fa-filter"></i></a>
                        </div>
					</div>								                            
				</div>	
            </div>
		</form>
	</div>
	<div class="col-md-12 fclr-table">
		<div id="hide-table" class="fclr-table-data">
             <table id="bclrtable" class="table table-bordered dataTable no-footer">
                 <thead>
					<tr>
					    <th><input class="filter" title="Select All" type="checkbox" id="bulkDelete"/>#</th>
						<th class="col-lg-1"><?=$this->lang->line('carrier')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('version_id')?></th>
						<th class="col-lg-1"><?=$this->lang->line('partner_carrier')?></th>
						<th class="col-lg-1"><?=$this->lang->line('allowance')?></th>
						<th class="col-lg-1"><?=$this->lang->line('aircraft_type')?></th>
						<th class="col-lg-1"><?=$this->lang->line('flight_number_range')?></th>
						<th class="col-lg-1"><?=$this->lang->line('from_cabin')?></th>
						<th class="col-lg-1"><?=$this->lang->line('origin_level')?></th>
						<th class="col-lg-1"><?=$this->lang->line('origin_content')?></th>
						<th class="col-lg-1"><?=$this->lang->line('dest_level')?></th>
						<th class="col-lg-1"><?=$this->lang->line('dest_content')?></th>
						<th class="col-lg-1"><?=$this->lang->line('effective_date')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('discontinue_date')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('season')?></th>
						<th class="col-lg-1"><?=$this->lang->line('frequency')?></th>
						<th class="col-lg-1"><?=$this->lang->line('bag_type')?></th>
						<th class="col-lg-1"><?=$this->lang->line('rule_auth')?></th>
						<th class="col-lg-1 noExport"><?=$this->lang->line('dep_time_start')?></th>
						<th class="col-lg-1 noExport"><?=$this->lang->line('dep_time_end')?></th>
						<th class="col-lg-1 noExport"><?=$this->lang->line('min_unit')?></th>
						<th class="col-lg-1 noExport"><?=$this->lang->line('max_capacity')?></th>
						<th class="col-lg-1 noExport"><?=$this->lang->line('min_price')?></th>
						<th class="col-lg-1 noExport"><?=$this->lang->line('max_price')?></th>
                        <th class="col-lg-2 noExport">Active</th>
                        <th class="col-lg-2 noExport"><?=$this->lang->line('action')?></th>
                    </tr>
                 </thead>
                 <tbody>                          
                 </tbody>
              </table>
         </div>
	</div>
</div>
<script>
    $("#effective_date").datepicker();
    $("#discontinue_date").datepicker();
    $('#dep_time_start').timepicker();
    $('#dep_time_end').timepicker();

    $("#flt_effective_date").datepicker();
    $("#flt_discontinue_date").datepicker();

    $(window).on('load',function(){
        loaddatatable();
    });

    $(document).ready(function() {   
        $('#origin_level').trigger('change');
        $('#dest_level').trigger('change');
        <?php if($this->session->userdata('login_user_airlineID')[0]) { ?>
            $('#carrierID').val(<?=$this->session->userdata('login_user_airlineID')[0]?>).trigger('change');
        <?php } ?>
        $('#flt_carrierID').val(<?=$flt_carrierID?>).trigger('change');
        $('#flt_partner_carrierID').val(<?=$flt_partner_carrierID?>).trigger('change');
        $('#flt_origin_level').val(<?=$flt_origin_level?>).trigger('change');
        var flt_origin_content = [<?=implode(',',$flt_origin_content)?>];
        $('#flt_origin_content').val(flt_origin_content).trigger('change');
        $('#flt_dest_level').val(<?=$flt_dest_level?>).trigger('change');
        var flt_dest_content = [<?=implode(',',$flt_dest_content)?>];
        $('#flt_dest_content').val(flt_dest_content).trigger('change');
        var flt_from_cabin = [<?=implode(',',$flt_from_cabin)?>];
        $('#flt_from_cabin').val(flt_from_cabin).trigger('change');
    
    });

    $('#origin_level').change(function(event) {    
        $('#origin_content').val(null).trigger('change')
        var level_id = $(this).val();                   
        var airline_id = $('#carrierID').val();  
        if( level_id == '17' ) {
            if($('#carrierID').val() == '0') {
                alert('select Airline');
                $("#origin_level").val(0);
                $('#origin_level').trigger('change');
                return false;
            }
        }               
        $.ajax({     async: false,            
            type: 'POST',            
            url: "<?=base_url('marketzone/getSubdataTypes')?>",            
            data: {"id":level_id,"airline_id":airline_id},           
            dataType: "html",                                  
            success: function(data) {               
            $('#origin_content').html(data); }        
        });       
    });
    $('#dest_level').change(function(event) {    
        $('#dest_content').val(null).trigger('change')
        var level_id = $(this).val(); 
        var airline_id = $('#carrierID').val();  
        if( level_id == '17' ) {
            if($('#carrierID').val() == '0') {
                alert('select Airline');
                $("#dest_level").val(0);
                $('#dest_level').trigger('change');
                return false;
            }
        }                               
        $.ajax({     async: false,            
            type: 'POST',            
            url: "<?=base_url('marketzone/getSubdataTypes')?>",            
            data: {"id":level_id,"airline_id":airline_id},           
            dataType: "html",                                  
            success: function(data) {               
            $('#dest_content').html(data); }        
        });       
    });

    $('#flt_origin_level').change(function(event) {    
        //$('#flt_origin_level').val(null).trigger('change')
        var level_id = $(this).val(); 
        var airline_id = $('#flt_carrierID').val();  
        if( level_id == '17' ) {
            if($('#flt_carrierID').val() == '0') {
                alert('select Airline');
                $("#flt_origin_level").val(0);
                $('#flt_origin_level').trigger('change');
                return false;
            }
        }               
        $.ajax({     async: false,            
            type: 'POST',            
            url: "<?=base_url('marketzone/getSubdataTypes')?>",            
            data: {"id":level_id,"airline_id":airline_id},           
            dataType: "html",                                  
            success: function(data) {               
            $('#flt_origin_content').html(data); }        
        });       
    });
    $('#flt_dest_level').change(function(event) {    
       // $('#flt_dest_content').val(null).trigger('change')
        var level_id = $(this).val(); 
        var airline_id = $('#flt_carrierID').val();  
        if( level_id == '17' ) {
            if($('#flt_carrierID').val() == '0') {
                alert('select Airline');
                $("#flt_dest_level").val(0);
                $('#flt_dest_level').trigger('change');
                return false;
            }
        }                               
        $.ajax({     async: false,            
            type: 'POST',            
            url: "<?=base_url('marketzone/getSubdataTypes')?>",            
            data: {"id":level_id,"airline_id":airline_id},           
            dataType: "html",                                  
            success: function(data) {               
            $('#flt_dest_content').html(data); }        
        });       
    });
    $("#cabin_checkbox_level").click(function(){
        if($("#cabin_checkbox_level").is(':checked') ){
            $("#from_cabin > option").prop("selected","selected");
            $("#from_cabin").trigger("change");
        } else {
            $("#from_cabin > option").removeAttr("selected");
            $("#from_cabin").trigger("change");
        }
    });
    $("#origin_checkbox_level").click(function(){
        if($("#origin_checkbox_level").is(':checked') ){
            $("#origin_content > option").prop("selected","selected");
            $("#origin_content").trigger("change");
        } else {
            $("#origin_content > option").removeAttr("selected");
            $("#origin_content").trigger("change");
        }
    });
    $("#dest_checkbox_level").click(function(){
        if($("#dest_checkbox_level").is(':checked') ){
            $("#dest_content > option").prop("selected","selected");
            $("#dest_content").trigger("change");
        } else {
            $("#dest_content > option").removeAttr("selected");
            $("#dest_content").trigger("change");
        }
    });   

    $('#carrierID').change(function(){
        var carrier = $(this).val();    
        $.ajax({ 
            async: false,            
            type: 'POST',            
            url: "<?=base_url('bclr/getAircrafts')?>",            
            data: {"carrierID":carrier},           
            dataType: "html",                                  
            success: function(data) {                         
                $('#aircraft_type').html(data);             
            }        
        });
        $.ajax({ 
            async: false,            
            type: 'POST',            
            url: "<?=base_url('bclr/getCabinsCarrier')?>",            
            data: {"carrierID":carrier},           
            dataType: "html",                                  
            success: function(data) {                         
                $('#from_cabin').html(data);             
            }        
        });
        $.ajax({ 
            async: false,            
            type: 'POST',            
            url: "<?=base_url('bclr/getSeasonsCarrier')?>",            
            data: {"carrierID":carrier},           
            dataType: "html",                                  
            success: function(data) {                         
                $('#season').html(data);             
            }        
        }); 
        $.ajax({ 
            async: false,            
            type: 'POST',            
            url: "<?=base_url('bclr/getPartnerCarriers')?>",            
            data: {"carrierID":carrier},           
            dataType: "html",                                  
            success: function(data) {                         
                $('#partner_carrierID').html(data);                
                <?php if($this->session->userdata('roleID') != 1){ ?>
                 data += "<option value='<?php echo $this->session->userdata('login_user_airlineID')[0]; ?>'> <?=$login_airline_name?></option>";
                <?php } ?>   
                console.log(data);        
                $('#rule_auth_carrier').html(data); 
            }        
        }); 
        if ($('#origin_level').val() == 17 ) {
            $('#origin_level').trigger('change');
        }
        if ($('#dest_level').val() == 17 ) {
            $('#dest_level').trigger('change');
        }
    });

    $('#flt_carrierID').change(function(){
        var carrier = $(this).val();    
        $.ajax({ 
            async: false,            
            type: 'POST',            
            url: "<?=base_url('bclr/getPartnerCarriers')?>",            
            data: {"carrierID":carrier},           
            dataType: "html",                                  
            success: function(data) {                         
                $('#flt_partner_carrierID').html(data);             
            }        
        }); 
        if ($('#flt_origin_level').val() == 17 ) {
            $('#flt_origin_level').trigger('change');
        }
        if ($('#flt_dest_level').val() == 17 ) {
            $('#flt_dest_level').trigger('change');
	}
        $.ajax({ 
            async: false,            
            type: 'POST',            
            url: "<?=base_url('bclr/getCabinsCarrier')?>",            
            data: {"carrierID":carrier},           
            dataType: "html",                                  
            success: function(data) {                         
                $('#flt_from_cabin').html(data);             
            }        
        });
    });

function loaddatatable() {
    $('#bclrtable').DataTable( {
      "bProcessing": true,
	  "stateSave": true,
      "bServerSide": true,
	  "initComplete": function (settings, json) {  
		$("#bclrtable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
	  },
      "sAjaxSource": "<?php echo base_url('bclr/server_processing'); ?>",
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "carrierID","value": $("#flt_carrierID").val()},
		   {"name": "partner_carrierID","value": $("#flt_partner_carrierID").val()},
                   {"name": "allowance","value": $("#flt_allowance").val()},
                   {"name": "frequency","value": $("#flt_frequency").val()},		                           
                   {"name": "effective_date","value": $("#flt_effective_date").val()},		                           
                   {"name": "discontinue_date","value": $("#flt_discontinue_date").val()},		                           
                   {"name": "origin_level","value": $("#flt_origin_level").val()},		                           
                   {"name": "origin_content","value": $("#flt_origin_content").val()},		                           
                   {"name": "dest_level","value": $("#flt_dest_level").val()},		                           
                   {"name": "dest_content","value": $("#flt_dest_content").val()},		                           
                   {"name": "rule_auth","value": $("#flt_rule_auth_carrier").val()},		                           
                   {"name": "bag_type","value": $("#flt_bag_type").val()},		                           
                   {"name": "from_cabin","value": $("#flt_from_cabin").val()},		                           
                   {"name": "min_price","value": $("#flt_min_price").val()},		                           
                   {"name": "max_price","value": $("#flt_max_price").val()},		                           
                   {"name": "min_unit","value": $("#flt_min_unit").val()},		                           
                   {"name": "bclr_id","value": $("#flt_bclr_id").val()},		                           
                   {"name": "max_capacity","value": $("#flt_max_capacity").val()},
                   {"name":"bclr_status","value":$("#bclr_status").val()}		                           
                   ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); },
        "stateSaveCallback": function (settings, data) {
            window.localStorage.setItem("bclrdatatable", JSON.stringify(data));
        },
        "stateLoadCallback": function (settings) {
            var data = JSON.parse(window.localStorage.getItem("bclrdatatable"));
            if (data) data.start = 0;
            return data;
        },
        "columns":[
            
            {"data": "chkbox" },
                   {"data": "carrier_code" },
                   {"data": "version_id"},
                   {"data": "partner_carrier_code" },
                   {"data": "allowance" },
                   {"data": "aircraft_type" },
                   {"data": "flight_num_range" },
                   {"data": "from_cabin_data" },
                   {"data": "origin_level_value" },
                   {"data": "origin_content_data" },
                   {"data": "dest_level_value" },
                   {"data": "dest_content_data" },
                   {"data": "effective_date" },
                   {"data": "discontinue_date" },
                   {"data": "season_name" },
                   {"data": "frequency" },
                   {"data": "bag_type_value" },
                   {"data": "rule_auth_carrier_code" },
                   {"data": "dep_time_start" },
                   {"data": "dep_time_end" },
                   {"data": "min_unit" },
                   {"data": "max_capacity" },
                   {"data": "min_price" },
                   {"data": "max_price" },
                   {"data": "active"},
                   {"data": "action"}
				  ],			     
     dom: 'B<"clear">lfrtip',
    // buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
	 buttons: [ { text: 'Delete', exportOptions: { columns: ':visible' },
                  action: function(e, dt, node, config) {
				    if( $('.deleteRow:checked').length > 0 ){  // at-least one checkbox checked
						var ids = [];
						$('.deleteRow').each(function(){
							if($(this).is(':checked')) { 
								ids.push($(this).val());
							}
						});
						var ids_string = ids.toString();  // array to string conversion 
						$.ajax({
							type: "POST",
							url: "<?php echo base_url('bclr/delete_bclr_bulk_records'); ?>",
							data: {data_ids:ids_string},
							success: function(result) {
							   $('#bclrtable').DataTable().ajax.reload();
							   $('#bulkDelete').prop("checked",false);
							},
							async:false
						});
					}				  
				  }
				},
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },

				{ extend: 'pdf', orientation: 'landscape', pageSize: 'LEGAL',exportOptions: { columns: "thead th:not(.noExport)" } },
                { text: 'Export All', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('bclr/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"carrierID": $("#flt_carrierID").val(),"partner_carrierID": $("#flt_partner_carrierID").val(),"allowance": $("#flt_allowance").val(),"frequency": $("#flt_frequency").val(),"effective_date": $("#flt_effective_date").val(),"discontinue_date": $("#flt_discontinue_date").val(),"origin_level": $("#flt_origin_level").val(),"origin_content": $("#flt_origin_content").val(),"dest_level": $("#flt_dest_level").val(),"dest_content": $("#flt_dest_content").val(),"rule_auth": $("#flt_rule_auth_carrier").val(),"bag_type": $("#flt_bag_type").val(),"min_price": $("#flt_min_price").val(),"max_price": $("#flt_max_price").val(),"min_unit": $("#flt_min_unit").val(),"max_capacity": $("#flt_max_capacity").val(),"bclr_id": $("#flt_bclr_id").val(),"bclr_status":$("#bclr_status").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","bclr.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }                
            ] ,
			//"autoWidth":false,
			//"columnDefs": [ {"targets": 0,"width": "30px" }]
    });	

  } 

function downloadBCLR(){
	$.ajax({
       url: "<?php echo base_url('bclr/server_processing'); ?>?page=all&&export=1",
       type: 'get',
       data: {sSearch: $("input[type=search]").val(),"carrierID": $("#flt_carrierID").val(),"partner_carrierID": $("#flt_partner_carrierID").val(),"allowance": $("#flt_allowance").val(),"frequency": $("#flt_frequency").val(),"effective_date": $("#flt_effective_date").val(),"discontinue_date": $("#flt_discontinue_date").val(),"origin_level": $("#flt_origin_level").val(),"origin_content": $("#flt_origin_content").val(),"dest_level": $("#flt_dest_level").val(),"dest_content": $("#flt_dest_content").val(),"rule_auth": $("#flt_rule_auth_carrier").val(),"bag_type": $("#flt_bag_type").val(),"min_price": $("#flt_min_price").val(),"max_price": $("#flt_max_price").val(),"min_unit": $("#flt_min_unit").val(),"max_capacity": $("#flt_max_capacity").val()}, "bclr_id": $("#flt_bclr_id").val(), "from_cabin": $("#flt_from_cabin").val(),"bclr_status":$("#bclr_status").val(),
       dataType: 'json'
       }).done(function(data){
			var $a = $("<a>");
			$a.attr("href",data.file);
			$("body").append($a);
			$a.attr("download","bclr.xls");
			$a[0].click();
			$a.remove();
		 });
}
  
   $('#bclrtable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#bclrtable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
      if($(this).prop('checked')) {
          status = 'chacked';
          id = $(this).parent().attr("id");
      } else {
          status = 'unchecked';
          id = $(this).parent().attr("id");
      }

      if((status != '' || status != null) && (id !='')) {
          $.ajax({
              type: 'POST',
              url: "<?=base_url('bclr/active')?>",
              data: "id=" + id + "&status=" + status,
              dataType: "html",
              success: function(data) {
                  if(data == 'Success') {
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
                      toastr["error"]("Error")
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
      }
  }); 
$( ".select2" ).select2({closeOnSelect:false, placeholder:'Select Frequency'});
 </script>

<script>

function savebclr() {
    <?php if(empty($check_product) && $this->session->userdata('roleID') !=1 ) { ?>
        alert("Sorry Your Baggage Product Expired..!");
        window.location.reload(true);
   <?php } else { ?>
   var formdata = $('#bclr_add_form').serialize();
    $.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('bclr/save')?>", 
          data: formdata,                   
          dataType: "html",
          success: function(data) {
                    var bclrinfo = jQuery.parseJSON(data);
                    var status = bclrinfo['status'];
		            newstatus = status.replace(/<p>(.*)<\/p>/g, "$1");
                    if (status.includes('success')) {
                        alert(status);      
                        $("#bclrtable").dataTable().fnDestroy();
                        loaddatatable();
                        location.reload();
		        form_reset();
                    } else if (status == 'duplicate'){
			alert('Duplicate Entry');
		    } else {                                
                        alert($(status).text());
                        $.each(bclrinfo['errors'], function(key, value) {
                            if(value != ''){                                         
                            $('#' + key).parent().addClass('has-error'); 
                            } else {
                                $('#' + key).parent().removeClass('has-error');   
                            }                                              
                        });                             
                    }
          },
          error:function()
          {
              alert('data is not saved. please check the content before saving');
          }
    });
    <?php } ?>
}

function matchRafeed(bclr_id = 0) {

   var formdata = $('#bclr_add_form').serialize();
    $.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('bclr/checkRABGFeedMatchForBclrID')?>", 
          data: formdata,                   
          dataType: "html",
          success: function(data) {
			newstatus = data.replace(/\s?(<br\s?\/?>)\s?/g, "\r\n");
                        alert(newstatus);
                    }
    });
}

function editbclr(bclr_id) {

    var isVisible = $("#bclrAdd").is(":visible");
    var isHidden = $("#bclrAdd").is(":hidden");
    if( isVisible == false ) {
            $("#bclr_add_btn").trigger("click");
    }       
    $.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('bclr/getBCLRData')?>",          
          data: {"bclr_id":bclr_id},
          dataType: "html",                     
          success: function(data) {
                var bclrinfo = jQuery.parseJSON(data);
                $('#btn_txt').text('Update BCLR');
                $('#carrierID').val(bclrinfo['carrierID']).trigger('change');
                $('#aircraft_type').val(bclrinfo['aircraft_typeID']).trigger('change');
                $('#partner_carrierID').val(bclrinfo['partner_carrierID']).trigger('change');
                $("#season").val(bclrinfo['season_id']).trigger('change');
                $('#from_cabin').val(bclrinfo['from_cabin'].split(",")).trigger('change');
                $("#allowance").val(bclrinfo['allowance']).trigger('change');
                $("#flight_num_range").val(bclrinfo['flight_num_range']);
                $("#origin_level").val(bclrinfo['origin_level']).trigger('change');
                $('#origin_content').val(bclrinfo['origin_content'].split(",")).trigger('change');
                $("#dest_level").val(bclrinfo['dest_level']).trigger('change');
                $('#dest_content').val(bclrinfo['dest_content'].split(",")).trigger('change');
                $("#effective_date").val(bclrinfo['effective_date']);
                $("#discontinue_date").val(bclrinfo['discontinue_date']);
                //$('#frequency').val(bclrinfo['frequency']).trigger('change');
                $('#bag_type').val(bclrinfo['bag_type']).trigger('change');
                $('#rule_auth_carrier').val(bclrinfo['rule_auth']).trigger('change');               
                $('#min_unit').val(bclrinfo['min_unit']);
                $('#max_capacity').val(bclrinfo['max_capacity']);
                $('#min_price').val(bclrinfo['min_price']);
                $('#max_price').val(bclrinfo['max_price']);

                $('#dep_time_start').timepicker('setTime',bclrinfo['dep_time_start']);
                $('#dep_time_end').timepicker('setTime',bclrinfo['dep_time_end']);
                $('#dep_time_start').val(bclrinfo['dep_time_start']);
                $('#dep_time_end').val(bclrinfo['dep_time_end']);

                if (bclrinfo['frequency'] == '0') {
			        bclrinfo['frequency'] = '';
		        }

                $('#frequency').val(bclrinfo['frequency']);;

                var bclrid  = bclrinfo['bclr_id'];
                $('#bclr_id').val(bclrid);
            }
        });
    }

    function form_reset(){    
    var isVisible = $("#bclrAdd").is(":visible");
    var isHidden = $("#bclrAdd").is(":hidden");
    if( isVisible == true ) {
            $("#bclr_add_btn").trigger("click");
    }       
        $('.select2-search-choice').remove();
	$("#bclr_add_form").trigger('reset'); //jquery
    }  

    $(document).ready(function(){
        // Add minus icon for collapse element which is open by default
        $(".collapse.show").each(function(){
        	$(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
        });
        
        // Toggle plus minus icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
        	$(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
        }).on('hide.bs.collapse', function(){
        	$(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
        });
    });

$(document).ready(function(){

    $("#bulkDelete").on('click',function() { // bulk checked
        var status = this.checked;
        $(".deleteRow").each( function() {
          if(status == 1 && $(this).prop('checked')) {
                
          } else {
                if (status == false && $(this).prop('checked') == false) {

                } else {
                         $(this).prop("checked",status);
                        $(this).not("#bulkDelete").closest('tr').toggleClass('rowselected');
                }
         }
        });
    });


    $('#deleteTriger').on("click", function(event){ // triggering delete one by one
        if( $('.deleteRow:checked').length > 0 ){  // at-least one checkbox checked
            var ids = [];
            $('.deleteRow').each(function(){
                if($(this).is(':checked')) { 
                    ids.push($(this).val());
                }
            });
            var ids_string = ids.toString();  // array to string conversion 
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('bclr/delete_bclr_bulk_records'); ?>",
                data: {data_ids:ids_string},
                success: function(result) {
                   $('#bclrtable').DataTable().ajax.reload();
                   $('#bulkDelete').prop("checked",false);
                },
                async:false
            });
        }
    }); 




$('#bclrtable').on('click', '.deleteRow', function() {
        $(this).not("#bulkDelete").parents("tr").toggleClass('rowselected');
    });
});
</script>
