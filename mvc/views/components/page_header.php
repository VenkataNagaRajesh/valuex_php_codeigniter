<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">

        <title><?=$this->lang->line('panel_title')?></title>

        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <link rel="SHORTCUT ICON" href="<?=base_url("uploads/images/$siteinfos->photo")?>" />

        <link rel="stylesheet" href="<?=base_url('assets/pace/pace.css')?>">

        <script type="text/javascript" src="<?php echo base_url('assets/inilabs/jquery.min.js'); ?>"></script>
        <!-- <script type="text/javascript" src="<?php echo base_url('assets/slimScroll/jquery.slimscroll.min.js'); ?>"></script> -->

        <script type="text/javascript" src="<?php echo base_url('assets/toastr/toastr.min.js'); ?>"></script>
		
		 <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/js/bootstrap-colorpicker.min.js"></script> 
		
		<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
	
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
	  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/smoothness/jquery-ui.css" rel="stylesheet">-->
		
        <link href="<?php echo base_url('assets/bootstrap/bootstrap.min.css'); ?>" rel="stylesheet">

        <link href="<?php echo base_url('assets/fonts/font-awesome.css'); ?>" rel="stylesheet">

        <link href="<?php echo base_url('assets/fonts/icomoon.css'); ?>" rel="stylesheet">

        <link href="<?php echo base_url('assets/datatables/dataTables.bootstrap.css'); ?>" rel="stylesheet">
        
		<link id="headStyleCSSLink" href="<?php echo base_url($backendThemePath.'/style.css'); ?>" rel="stylesheet">

        <link href="<?php echo base_url('assets/inilabs/hidetable.css'); ?>" rel="stylesheet">

        <link id="headInilabsCSSLink" href="<?php echo base_url($backendThemePath.'/inilabs.css'); ?>" rel="stylesheet">

        <link href="<?php echo base_url('assets/inilabs/responsive.css'); ?>" rel="stylesheet">

        <link href="<?php echo base_url('assets/toastr/toastr.min.css'); ?>" rel="stylesheet">

        <link href="<?php echo base_url('assets/inilabs/mailandmedia.css'); ?>" rel="stylesheet">

        <link rel="stylesheet" href="<?php echo base_url('assets/datatables/buttons.dataTables.min.css'); ?>" >

        <link rel="stylesheet" href="<?php echo base_url('assets/inilabs/combined.css'); ?>" >

        <?php
            if(isset($headerassets)) {
                foreach ($headerassets as $assetstype => $headerasset) {
                    if($assetstype == 'css') {
                      if(count($headerasset)) {
                        foreach ($headerasset as $keycss => $css) {
                          echo '<link rel="stylesheet" href="'.base_url($css).'">'."\n";
                        }
                      }
                    } elseif($assetstype == 'js') {
                      if(count($headerasset)) {
                        foreach ($headerasset as $keyjs => $js) {
                          echo '<script type="text/javascript" src="'.base_url($js).'"></script>'."\n";
                        }
                      }
                    }
                }
            }
        ?>

        <script type="text/javascript">
          $(window).load(function() {
            $(".se-pre-con").fadeOut("slow");;
          });
        </script>
		
		
    </head>
    <body class="skin-blue fuelux">
        <div class="se-pre-con"></div>
