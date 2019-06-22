<div class="mzones">
	<div class="col-md-12 card-header">
		<div class="col-md-12">
			<p data-toggle="collapse" data-target="#mzonesAdd"><button type="button" class="btn btn-danger pull-right" data-placement="left" title="Add Market Zone" data-toggle="tooltip"><i class="fa fa-plus"></i></button></p>
		</div>
	</div>
	<div class="col-md-12 collapse" id="mzonesAdd">
		<div class="col-md-4">
			<div class="srch-buttons">
				<div class="col-md-4">
					<a href="#" type="button" class="btn btn-default">Market Zone</a>
				</div>
				<div class="col-md-8">
				  <div class="input-group">
					<input type="text" class="form-control" placeholder="Search">
					<div class="input-group-btn">
					  <button class="btn btn-danger" type="submit">
						<i class="glyphicon glyphicon-search"></i>
					  </button>
					</div>
				  </div>
				 </div>
			</div>
			<div class="market-info-tree">
				<div class="col-md-12">
					<ul id="tree1">
						<li>TECH
							<ul>
								<li>Company Maintenance</li>
								<li>Employees
									<ul>
										<li>Reports
											<ul>
												<li>Report1</li>
												<li>Report2</li>
												<li>Report3</li>
											</ul>
										</li>
										<li>Employee Maint.</li>
									</ul>
								</li>
								<li>Human Resources</li>
							</ul>
						</li>
						<li>XRP
							<ul>
								<li>Company Maintenance</li>
								<li>Employees
									<ul>
										<li>Reports
											<ul>
												<li>Report1</li>
												<li>Report2</li>
												<li>Report3</li>
											</ul>
										</li>
										<li>Employee Maint.</li>
									</ul>
								</li>
								<li>Human Resources</li>
							</ul>
						</li>
						<li>Middle East
							<ul>
								<li>Company Maintenance</li>
								<li>Employees
									<ul>
										<li>Reports
											<ul>
												<li>Report1</li>
												<li>Report2</li>
												<li>Report3</li>
											</ul>
										</li>
										<li>Employee Maint.</li>
									</ul>
								</li>
								<li>Human Resources</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="mzone-config col-md-12">
				<div class="col-md-12 zone-info1">
					<h2>Market Zone Configuration<span class="pull-right">Tree View</span></h2>
					<div class="col-md-2">
						<p>Airline Code</p>
						<input type="text" class="form-control" id="code">
					</div>
					<div class="col-md-2">
						<p>Market Name</p>
						<input type="text" class="form-control" id="name">
					</div>
					<div class="col-md-2">
						<p>Market Level</p>
						<select class="form-control" id="inc-level">
							<option>level</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
						</select>
					</div>
					<div class="col-md-6">
						<p>Value</p>
						<input type="password" class="form-control" id="pwd">
					</div>
				</div>
				<div class="col-md-12 zone-info2">
					<div class="col-md-6">
						<select class="form-control" id="inc-level">
							<option>Inclusion Level</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
						</select>
						<input type="password" class="form-control" id="level1">
					</div>
					<div class="col-md-6">
						<select class="form-control" id="ex-level">
							<option>Exclusion Level</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
						</select>
						<input type="password" class="form-control" id="level2">
					</div>
					<div class="col-md-12">
						<textarea class="form-control" rows="5" id="comment"></textarea>
						<span><a href="#" type="button" class="btn btn-danger">Add</a></span>
						<span class="pull-right">
							<a href="#" type="button" class="btn btn-danger">Save</a>
							<a href="#" type="button" class="btn btn-danger">Cancel</a>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="mzones-list-bar">
			<form class="form-horizontal" action="#">
				<div class="title-bar">
					<div class="col-md-2">
						<h2>Market Zones</h2><span class="pull-right"></span>
					</div>
					<div class="col-md-10">
						<div class="toolbar"></div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="table-reponsive col-md-12">
						<div class="col-md-11">
							<table class="table table-bordered table-striped table-highlight">
								<thead>
									<th>Airline Code</th>
									<th>Select Marketzone</th>
									<th>Select Level Type</th>
									<th>Select Level Value</th>
									<th>Select Inclusion Type</th>
									<th>Select Inclusion Value</th>
									<th>Select Exclusion Type</th>
									<th>Select Exclusion Value</th>
								</thead>
								<tbody>
									<tr>
										<td>
											<input type="text" class="form-control" id="alcode">
										</td>
										<td>
											<select class="form-control" id="inc-level">
												<option>level</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="inc-level">
												<option>level</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="inc-level">
												<option>level</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
											</select>
										</td>	
										<td>
											<select class="form-control" id="inc-level">
												<option>level</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="inc-level">
												<option>level</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="inc-level">
												<option>level</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="inc-level">
												<option>level</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
											</select>
										</td>	
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-md-1">
							<a href="#" type="button" class="btn btn-danger">Filter</a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-12">
		<div class="col-md-12">
			<button type="submit" class="col-md-1 btn btn-danger pull-right" name="filter" id="filter">Filter</button>
		</div>
		<div class="col-md-12">
			<div class="tab-content table-responsive">
				<table id="tztable" class="table table-bordered dataTable no-footer">
				  <thead>
					   <tr>
							<th><?=$this->lang->line('slno')?></th>
							<th><?=$this->lang->line('market_name')?></th>
							<th><?=$this->lang->line('airline_code')?></th>
							<th><?=$this->lang->line('level_type')?></th>
							<th><?=$this->lang->line('amz_level_value')?></th>
							<th><?=$this->lang->line('amz_incl_type')?></th>
							<th><?=$this->lang->line('amz_incl_value')?></th>
							<th><?=$this->lang->line('amz_excl_type')?></th>
							<th><?=$this->lang->line('amz_excl_value')?></th>
							 <?php if(permissionChecker('marketzone_edit')) { ?>
								 <th><?=$this->lang->line('marketzone_status')?></th>
							<?php } ?>                       
							<?php if(permissionChecker('marketzone_edit') || permissionChecker('marketzone_view') ||  permissionChecker('marketzone_detete')) { ?>
						   <th><?=$this->lang->line('action')?></th>
						   <?php } ?>
					   </tr>
				   </thead>
				   <tbody>
					</tbody>
				</table>
			 </div>
		 </div>
	</div>
</div>
<script>
$.fn.extend({
    treed: function (o) {
      
      var openedClass = 'glyphicon-minus-sign';
      var closedClass = 'glyphicon-plus-sign';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

//Initialization of treeviews

$('#tree1').treed();

$('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});

$('#tree3').treed({openedClass:'glyphicon-chevron-right', closedClass:'glyphicon-chevron-down'});
</script>

<script type="text/javascript">
  $(document).ready(function() {

  $( ".select2" ).select2();

    $('#tztable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('marketzone/server_processing'); ?>",	  
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "marketID","value": $("#market_id").val()},
		   {"name": "levelID","value": $("#amz_level_id").val()},
		   {"name": "inclID","value": $("#amz_incl_id").val()},
		   {"name": "exclID","value": $("#amz_excl_id").val()},
		   {"name": "airlineID","value": $("#airline_id").val()},
		   {"name": "active","value": $("#active").val()}) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); },      
      "columns": [{"data": "market_id" },
		  {"data": "market_name"},
		  {"data": "airline_name"},
                  {"data": "lname" },
				  {"data": "levelname" },
				  {"data": "iname" },
				  {"data": "inclname" },
                  {"data": "ename"},
				  {"data": "exclname"},
		  {"data": "active"},
                  {"data": "action"}
				  ],			   
	//"abuttons": ['copy', 'csv', 'excel', 'pdf', 'print']	
	dom: 'B<"clear">lfrtip',
    buttons: [ 'copy', 'csv', 'excel','pdf' ]
    });
  });
  
   $('#tztable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
 var status = '';
  var id = 0;
 $('#tztable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
      if($(this).prop('checked')) {
          status = 'chacked';
          id = $(this).parent().attr("id");
      } else {
          status = 'unchacked';
          id = $(this).parent().attr("id");
      }

      if((status != '' || status != null) && (id !='')) {
          $.ajax({
              type: 'POST',
              url: "<?=base_url('marketzone/active')?>",
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
</script>
<script>
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
</script>