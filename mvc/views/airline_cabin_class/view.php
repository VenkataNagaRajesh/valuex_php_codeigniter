 <div class="well">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">            
              <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>             
              <li><a href="<?=base_url("airline_cabin_class/index")?>"><?php //echo $this->lang->line('menu_airline_cabin_class');?>Back</a></li>             
              <li class="active"><?=$this->lang->line('view')?></li>            
            </ol>
         </div>
   </div>
 </div>
	 <div class="col-sm-12">
                <div id="hide-table">
		<h1><?=$this->lang->line("airline_cabin_information")?></h1>
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">

                        <thead>

                        <tr>
                        <th><?=$this->lang->line("carrier")?></th>
                        <th><?=$this->lang->line("airline_cabin")?> </th>
                        <th><?=$this->lang->line("airline_class")?></th>
                        <th><?=$this->lang->line("is_revenue")?></th>
                        <th><?=$this->lang->line("order")?></th>
                        <th><?=$this->lang->line("airline_cabin_create_user")?></th>
			<th><?=$this->lang->line("airline_cabin_modify_user")?></th>
			<th><?=$this->lang->line("airline_cabin_create_date")?></th>
                        <th><?=$this->lang->line("airline_cabin_modify_date")?></th>

                        </tr>
			</thead>
			<tbody>
                        <?php
                                foreach($airline_cabin as $data)
                                {?>
                                   <tr>
                                                <td><?=$data->carrier?></td>
                                                <td><?=$data->airline_cabin?></td>
                                                <td><?=$data->airline_class?></td>
                                                <td><?php echo $data->is_revenue ? 'yes' : 'no'; ?> </td>
                                                <td><?=$data->order?></td>
					        <td><?php echo $this->user_m->get_username_byid($data->create_userID);?></td>
						<td><?php echo $this->user_m->get_username_byid($data->create_userID);?></td>
                                                 <td><?php echo  date('d/m/Y',$data->create_date);?></td>
                                                 <td><?php echo date('d/m/Y',$data->modify_date);?></td>

                                        </tr>
                               <?php }
                        ?>
			</tbody>
                </table>
</div>
</div>
