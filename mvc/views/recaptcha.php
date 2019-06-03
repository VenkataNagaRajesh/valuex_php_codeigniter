<html>
<head>
    <title>reCAPTCHA Example</title>
</head>
<body>
<form action="<?php echo base_url('myhome/recaptcha'); ?>" method="post">
   <input type="text" name="pnr" />
   <input type="text" name="code" />
<?php// echo $widget;?>
<?php// echo $script;?>
   <br />
<input type="submit" value="submit" />
</form>
</body>
</html>
