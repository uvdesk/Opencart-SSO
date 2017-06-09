<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-wkocuvdsso" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title_add; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
          </div><br>
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-manage-affiliate" class="form-horizontal">

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name ="name" id="input-name" class="form-control" <?php if(isset($app['name'])){ ?>value="<?php echo $app['name']; ?>"<?php } ?> />
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="text" name ="email" id="input-email" class="form-control" <?php if(isset($app['email'])){ ?>value="<?php echo $app['email']; ?>"<?php } ?> />
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-url"><?php echo $entry_url; ?></label>
            <div class="col-sm-10">
              <input type="text" name ="url" id="input-url" class="form-control" <?php if(isset($app['redirect_url'])){ ?>value="<?php echo $app['redirect_url']; ?>"<?php } ?> />
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-cancel_url"><?php echo $entry_cancel_url; ?></label>
            <div class="col-sm-10">
              <input type="text" name ="cancel_url" id="input-cancel_url" class="form-control" <?php if(isset($app['cancel_url'])){ ?>value="<?php echo $app['cancel_url']; ?>"<?php } ?> />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <option value="0"><?php echo $text_disabled; ?></option>
                <option value="1" <?php if(isset($app['status']) && $app['status']){ ?>selected<?php } ?>><?php echo $text_enabled; ?></option>
              </select>
            </div>
          </div>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>
