<?php echo doctype("html5"); ?>
<?php if(($this->session->userdata('roleID') == 1 || $this->session->userdata('roleID') == 5)){         
  $this->benchmark->mark('code_start'); } ?>
<html class="white-bg-login" lang="en">
<head>
	<meta charset="UTF-8">	
	<title><?php echo $this->lang->line("panel_title");?></title>	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Title" content="Valuex" />
	<meta name="description" content="Singapore Airlines...."/>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta property="fb:app_id" content="254488398564329"/>
	<!--Twitter-->
	<link href="<?php echo base_url('assets/home/css/animate.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/home/css/icomoon.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/home/css/bootstrap.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/home/css/magnific-popup.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/home/css/bootstrap-datepicker.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/home/css/style.css'); ?>" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">	
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/bootstrap-slider.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/bootstrap-slider.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/css/bootstrap-slider.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/css/bootstrap-slider.min.css" />
    
</head>	

<body>	

	<!--<script type="text/javascript" src="<?php echo base_url('assets/home/js/jquery.min.js');?>"></script>-->	
	<script type="text/javascript" src="<?php echo base_url('assets/home/js/bootstrap.min.js');?>"></script>		
	<script type="text/javascript" src="<?php echo base_url('assets/home/js/bootstrap-datepicker.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/home/js/main.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/home/js/jquery.smartWizard.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/home/js/simple-rating.js');?>"></script>
<?php if(($this->session->userdata('roleID') == 1 || $this->session->userdata('roleID') == 5)){         
  //$this->benchmark->mark('code_start');
  $this->load->view($subview);
  $this->benchmark->mark('code_end'); ?>
    <div class="container">
        <?php 
             if(($this->session->userdata('roleID') == 1 || $this->session->userdata('roleID') == 5)){         
                echo "<b> Time : </b>".$this->benchmark->elapsed_time('code_start', 'code_end').' sec';
                echo "<b> | Memory Usage : </b>".$this->benchmark->memory_usage();  
                $queries = $this->db->queries;
                if($this->session->userdata('roleID') == 5){      
                 echo "<b> | Queries : </b>".count($queries);
                }
			}
        ?>  
    </div>
<?php } else {
  $this->load->view($subview);
  
} ?>

</body>
</html>
