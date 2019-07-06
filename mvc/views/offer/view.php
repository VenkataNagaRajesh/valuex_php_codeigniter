 <div class="well">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">            
              <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>             
              <li><a href="<?=base_url("offer_issue/index")?>"><?=$this->lang->line('menu_offer_issue')?></a></li>             
              <li class="active"><?=$this->lang->line('view')?></li>            
            </ol>
         </div>
   </div>
 </div>
	 <div class="col-sm-12">
                <div id="hide-table">
		<h3><?=$this->lang->line("offer_information")?></h3>

		<?php 

			$list = array_column($ofr,'offer_id');
			$offer_id = $list[0];
			$p_cnt = count(explode(',',$ofr[0]->p_list));
			$pnr_ref = array_column($ofr,'pnr_ref');

		?>


			<br>


		<div class="off-status">
			<span style="color:orange;">Offer ID: </span><?=$offer_id?><br>
			<span style="color:orange;">PNR Reference: </span><?=$pnr_ref[0]?><br>
			<span style="color:orange;">Passenger Count: </span><?=$p_cnt?><br>
			<span style="color:orange;">Passenger Details: </span><?php echo $ofr[0]->p_list;?><br>

                </div>


		<br> <br>
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">

				

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
                                                <td><?=$data->carrier_code.$data->flight_number?></td>
                                                <td><?php echo date('d/m/Y',$data->flight_date)?></td>
                                                <td><?=$data->from_city?></td>
                                                <td><?=$data->to_city?></td>
						 <td><?=$data->booking_status?></td>

                                        </tr>
                               <?php }
                        ?>
			</tbody>
                </table>
</div>
</div>
