
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("definition_data/index")?>"></i> <?php //echo$this->lang->line('menu_defdata'); ?>Back</a></li>
            <li class="active"><?=$this->lang->line('menu_edit')?> <?=$this->lang->line('menu_defdata')?></li>
        </ol>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">
                    <?php 
                        if(form_error('aln_data_value')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="aln_data_value" class="col-sm-2 control-label">
                            <?=$this->lang->line("defdata_value")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="aln_data_value" name="aln_data_value" value="<?=set_value('aln_data_value', $defdata->aln_data_value)?>" >							
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('aln_data_value'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("update_defdata")?>" >
                        </div>
                    </div>
                </form>
			</div>
        </div>
    </div>
</div>
