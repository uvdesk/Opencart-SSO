<html>
<head>
  <title>Account Login</title>
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
              <?php if ($success) { ?>
              <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
              <?php } ?>
              <?php if ($error_warning) { ?>
              <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
              <?php } ?>  
              <h2><?php echo $text_returning_customer; ?></h2>
              <p><strong><?php echo $text_i_am_returning_customer; ?></strong></p>
              <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                  <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
                </div>
                <div class="form-group">
                  <label class="control-label" for="input-password"><?php echo $entry_password; ?></label>
                  <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
                  </div>
                <input type="submit" value="<?php echo $button_login; ?>" class="btn btn-primary" />
              </form>
            </div>
          </div>
        </div>
      </div>
  </div>
</body>
</html>
