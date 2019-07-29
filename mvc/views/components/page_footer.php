        </div><!-- ./wrapper -->


        


        <!-- Bootstrap js -->
        <script type="text/javascript" src="<?php echo base_url('assets/bootstrap/bootstrap.min.js'); ?>"></script>
        <!-- Style js -->
        <script type="text/javascript" src="<?php echo base_url('assets/inilabs/style.js'); ?>"></script>

        <!-- Jquery datatable tools js -->
        <script type="text/javascript" src="<?php echo base_url('assets/datatables/tools/jquery.dataTables.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/datatables/tools/dataTables.buttons.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/datatables/tools/jszip.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/datatables/tools/pdfmake.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/datatables/tools/vfs_fonts.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/datatables/tools/buttons.html5.min.js'); ?>"></script>
        <!-- dataTables Tools / -->
        <script type="text/javascript" src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js'); ?>"></script>

        <script type="text/javascript" src="<?php echo base_url('assets/inilabs/inilabs.js'); ?>"></script>


        <!-- Jquery gritter -->
        <!-- datatable with buttons -->
        <script>
        $(document).ready(function() {
          $('#example3, #example1, #example2').DataTable( {
              dom: 'Bfrtip',
             /*  buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdfHtml5'
              ], */
			   buttons: [
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)" } }                
            ] ,
              search: false
          } );	

           $('.filter').on('click', function(e){
			   e.stopPropagation();    
			});		  

		$('.dataTables_filter').on('click', function(e){
			if ($('#bulkDelete').prop("checked")){
				$('#bulkDelete').prop("checked",false);
				 $('.deleteRow').each(function(){

					if($(this).prop("checked")){
						$(this).prop("checked",false);
						$(this).not("#bulkDelete").closest('tr').toggleClass('rowselected');
					}
				 });
			}
		});

		$('.dataTables_paginate').on('click', function(e){
                        if ($('#bulkDelete').prop("checked")){
                                $('#bulkDelete').prop("checked",false);

                        }
                });

        } );
	 /* $('.dataTable').DataTable( {
		 buttons: [{
		  extend: 'collection',
		  className: 'exportButton',
		  text: 'Data Export',
		  buttons: ['copy','excel','csv','pdf','print'],
		  exportOptions: {
			modifer: {
			  page: 'all',
			  search: 'none' }
		  }
		}]
	 }); */
        </script>
        <!-- dataTable with buttons end -->

        <script type="text/javascript">
            $(function() {
                $("#withoutBtn").dataTable();
            });


        </script>

        <?php if ($this->session->flashdata('success')): ?>
            <script type="text/javascript">
                toastr["success"]("<?=$this->session->flashdata('success');?>")
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
            </script>
        <?php endif ?>
        <?php if ($this->session->flashdata('error')): ?>
           <script type="text/javascript">
                toastr["error"]("<?=$this->session->flashdata('error');?>")
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
            </script>
        <?php endif ?>

        <?php
            if(isset($footerassets)) {
                foreach ($footerassets as $assetstype => $footerasset) {
                    if($assetstype == 'css') {
                      if(count($footerasset)) {
                        foreach ($footerasset as $keycss => $css) {
                          echo '<link rel="stylesheet" href="'.base_url($css).'">'."\n";
                        }
                      }
                    } elseif($assetstype == 'js') {
                      if(count($footerasset)) {
                        foreach ($footerasset as $keyjs => $js) {
                          echo '<script type="text/javascript" src="'.base_url($js).'"></script>'."\n";
                        }
                      }
                    }
                }
            }
        ?>
        <script type="text/javascript">

            $("ul.sidebar-menu li").each(function(index, value) {


                if($(this).attr('class') == 'active') {
                    $(this).parents('li').addClass('active');
                }
                             
            });
			
        </script>
    </body>
</html>
