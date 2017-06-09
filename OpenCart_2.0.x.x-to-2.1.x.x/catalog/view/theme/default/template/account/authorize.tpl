<html>
<head>
  <title>Authorize Account</title>
  <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
  <link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="row" style="margin-top:10%;">
      <?php $class = 'col-sm-9'; ?>
      <div id="content" class="<?php echo $class; ?>">
        <div class="row">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <div class="well">
              <h3><?php echo $text_app; ?></h3>
              <br />
              <a href="<?php echo $redirect_url; ?>" class="btn btn-primary"><?php echo $button_authorize; ?></a>
              <a href="<?php echo $cancel_url; ?>" class="btn btn-danger pull-right"><?php echo $button_cancel; ?></a>
              </form>
            </div>
          </div>
        </div>
      </div>
  </div>
</body>
</html>
