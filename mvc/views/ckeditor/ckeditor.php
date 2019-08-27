<!DOCTYPE html>
<html lang="en">  
<head>
<title>How to Integrate CKeditor in Codeigniter using Bootstrap</title>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/ckfinder/ckfinder.js"></script>
</head>
<body>
<div class="container">
 <h1 class="alert alert-info">How to Integrate CKeditor in Codeigniter using Bootstrap</h1>
    
<form method="post">
    <div class="row">
        <div class="col-sm-3 col-lg-12">
            <div class="form-group">
            <label>Title:</label>
            <input type="text" name="title" placeholder="Title" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
       <div class="col-sm-3 col-lg-12">
            <div class="form-group">
            <label>Description: </label>
            <?php echo $this->ckeditor->editor("textarea name","default textarea value"); ?>
            </div>
        </div>
    </div>
    <div class="row">
       <div class="col-sm-3 col-lg-12">
            <div class="form-group">      
            <a href="<?php echo base_url(); ?>posts"><button class="btn btn-warning">Back</button>
            <input type="submit" name="submitBtn" value="Add" class="btn btn-success">
             </div>
        </div>
    </div>
        </form>
    
</div>
</body>
</html>