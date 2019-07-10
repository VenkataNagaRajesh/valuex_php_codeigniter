
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-refresh"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_update')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <table id="table-log" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Level</th>
                        <th>Date</th>
                        <th>Content</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($logs as $key => $log): ?>
                        <tr data-display="stack<?= $key; ?>">

                            <td class="text-<?= $log['class']; ?>">
                                <span class="<?= $log['icon']; ?>" aria-hidden="true"></span>
                                &nbsp;<?= $log['level']; ?>
                            </td>
                            <td class="date"><?= $log['date']; ?></td>
                            <td class="text">
                                <?php if (array_key_exists("extra", $log)): ?>
                                    <a class="pull-right expand btn btn-default btn-xs"
                                       data-display="stack<?= $key; ?>">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </a>
                                <?php endif; ?>
                                <?= $log['content']; ?>
                                <?php if (array_key_exists("extra", $log)): ?>
                                    <div class="stack" id="stack<?= $key; ?>"
                                         style="display: none; white-space: pre-wrap;">
                                        <?= $log['extra'] ?>
                                    </div>
                                <?php endif; ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>  
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('.table-container tr').on('click', function () {
            $('#' + $(this).data('display')).toggle();
        });

        $('#table-log').DataTable({
            "order": [],
            "stateSave": true,
            "stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("datatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("datatable"));
                if (data) data.start = 0;
                return data;
            }
        });
        $('#delete-log, #delete-all-log').click(function () {
            return confirm('Are you sure?');
        });
    });
</script>



