 <div class="well">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">            
              <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>             
              <li><a href="<?=base_url("offer_issue/index")?>"><?php //echo$this->lang->line('menu_offer_issue'); ?>Back</a></li>             
              <li class="active"><?=$this->lang->line('view')?></li>            
            </ol>
         </div>
   </div>
 </div>
	 <div class="col-sm-12" style="background:#fff;color:#333;">
                <div id="hide-table">
		<h3>Offer Information</h3>

		<?php 
		foreach($products as $pdId => $product_name ) {

			$ofr = $offers[$pdId];

			$list = array_column($ofr,'offer_id');
			$offer_id = $list[0];
			$p_cnt = count(explode(',',$ofr[0]->p_list));
			$pnr_ref = array_column($ofr,'pnr_ref');


			switch ($pdId) {

			case 1;
		?>


			<br>


		<div class="off-status">
			<span style="color:orange;"><b>Offer ID: </b></span> <?=$offer_id?><br>
			<span style="color:orange;"><b>PNR Reference:</b> </span> <?=$pnr_ref[0]?><br>
			<span style="color:orange;"><b>Passenger Count: </b></span> <?=$p_cnt?><br>
			<span style="color:orange;"><b>Passenger Details: </b></span> <?php echo $ofr[0]->p_list;?><br>

                </div>
		<br> <br>
                <div id="hide-table">
		<h3><?=$product_name?> Offer</h3>
                </div>
                <div id="hide-table">
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">

				

                        <thead>

                        <tr>
                        <th><?=$this->lang->line("flight_number")?></th>
                        <th><?=$this->lang->line("flight_date")?> </th>
                        <th><?=$this->lang->line("origin")?></th>
                        <th><?=$this->lang->line("destination")?></th>
			<th>From Cabin</th>
			<th>To Cabin</th>			
                        <th><?=$this->lang->line("status")?></th>
			<th>Minimum</th>			
			<th>Maximun</th>			
			<th>Average</th>			
			<th>Slider Start Position</th>			

                        </tr>
			</thead>
			<tbody>
                        <?php
                                foreach($ofr as $data)
                                {?>
                                   <tr>
                                                <td><?=$data->carrier.$data->flight_number?></td>
                                                <td><?php echo date('d/m/Y',$data->flight_date)?></td>
                                                <td><?=$data->from_city?></td>
                                                <td><?=$data->to_city?></td>
						 <td><?=$data->from_cabin?></td>
						 <td><?=$data->to_cabin?></td>
						 <td><?=$data->booking_status?></td>
						 <td><?=$data->min?></td>
						 <td><?=$data->max?></td>
						 <td><?=$data->average?></td>
						 <td><?=$data->slider_start?></td>

                                        </tr>
                               <?php }
                        ?>
			</tbody>
                </table>
	</div>
	<?php 
			break;
		
			case 2:
?>
				<div id="hide-table">
				<h3><?=$product_name?> Offer</h3>
				</div>
                		<div id="hide-table">
			    <table id="example2" class="table table-striped table-bordered table-hover dataTable no-footer">

				<thead>

				<tr>
				<th><?=$this->lang->line("flight_number")?></th>
				<th><?=$this->lang->line("flight_date")?> </th>
				<th><?=$this->lang->line("origin")?></th>
				<th><?=$this->lang->line("destination")?></th>
				<th>Cabin</th>
				<th><?=$this->lang->line("status")?></th>
				<th>Min Unit</th>
				<th>Max Capacity</th>
				<th>Min Price</th>
				<th>Max Price</th>

				</tr>
				</thead>
				<tbody>
				<?php
					foreach($ofr as $data)
					{?>
					   <tr>
							<td><?=$data->carrier.$data->flight_number?></td>
							<td><?php echo date('d/m/Y',$data->flight_date)?></td>
							<td><?=$data->from_city?></td>
							<td><?=$data->to_city?></td>
							 <td><?=$data->from_cabin?></td>
							 <td><?=$data->booking_status?></td>
							 <td><?=$data->min_unit?></td>
							 <td><?=$data->max_capacity?></td>
							 <td><?=$data->min_price?></td>
							 <td><?=$data->max_price?></td>

						</tr>
				       <?php }
				?>
				</tbody>
			</table>
		</div>
<?php

			break;
			}
		} 
	?>
</div>
