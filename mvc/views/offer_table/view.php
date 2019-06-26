 <div class="well">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">            
              <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>             
              <li><a href="<?=base_url("offer_table/index")?>"><?=$this->lang->line('menu_offer_table')?></a></li>             
              <li class="active"><?=$this->lang->line('view')?></li>            
            </ol>
         </div>
   </div>
 </div>
	 <div class="col-sm-12">
                <div id="hide-table">
		<h1><?=$this->lang->line("offer_information")?></h1>

		<?php 

			$list = array_column($ofr,'offer_id');
			$offer_id = $list[0];
			$plist = array_column($ofr,'list');
			$p_cnt = count(explode('<br>',$plist[0]));
			$pnr_ref = array_column($ofr,'pnr_ref');

		?>

			<br>
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">

			<b style="color:grey;font-size: 150%">Offer ID : </b> <?=$offer_id?>            &nbsp;&nbsp; 

			<b style="color:grey;font-size: 150%">PNR Reference:</b><?=$pnr_ref[0]?>  &nbsp;&nbsp;       
			<b style="color:grey;font-size: 150%">Passenger Count:</b><?=$p_cnt?> 
				<br>
		
			<b style="color:grey;font-size: 150%"> Passenger Details:</b><?php print_r($plist[0]);?>
				

                        <thead>

                        <tr>
                        <th><?=$this->lang->line("flight_number")?></th>
                        <th><?=$this->lang->line("flight_date")?> </th>
                        <th><?=$this->lang->line("origin")?></th>
                        <th><?=$this->lang->line("destination")?></th>
                        <th><?=$this->lang->line("status")?></th>

                        </tr>
			</thead>
			<tbody>
                        <?php
                                foreach($ofr as $data)
                                {?>
                                   <tr>
                                                <td><?=$data->carrier.$data->flight_number?></td>
                                                <td><?php echo date('d/m/Y',$data->dep_date)?></td>
                                                <td><?=$data->origin?></td>
                                                <td><?=$data->destination?></td>
						 <td><?=$data->status?></td>

                                        </tr>
                               <?php }
                        ?>
			</tbody>
                </table>
</div>
</div>
