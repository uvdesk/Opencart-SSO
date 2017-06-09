<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="button" id="btn_delete" data-toggle="tooltip" title="<?php echo $text_delete; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
        <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="submit" form="form-wkocuvdsso" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li>
          <a href="<?php echo $breadcrumb['href']; ?>">
            <?php echo $breadcrumb['text']; ?>
          </a>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
      <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i>
      <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
        </div><br>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-wkocuvdsso" class="form-horizontal">

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-wkocuvdsso_status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="wkocuvdsso_status" id="input-wkocuvdsso_status" class="form-control">
                <option value="0" <?php if(!$wkocuvdsso_status) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                <option value="1" <?php if($wkocuvdsso_status) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
              </select>
            </div>
          </div>
          <?php if(isset($apps) && $apps){ ?>
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <td width="1" style="text-align: center;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left">
                    <?php echo $entry_name; ?>
                  </td>
                  <td class="text-left">
                    <?php echo $entry_email; ?>
                  </td>
                  <td class="text-left">
                    <?php echo $entry_url; ?>
                  </td>
                  <td class="text-left">
                    <?php echo $entry_cancel_url; ?>
                  </td>
                  <td class="text-left">
                    <?php echo $entry_client_id; ?>
                  </td>
                  <td class="text-left">
                    <?php echo $entry_client_secret; ?>
                  </td>
                  <td class="text-left">
                    <?php echo $entry_status; ?>
                  </td>
                  <td class="text-left">
                    <?php echo $text_action; ?>
                  </td>
                </tr>
              </thead>
              <tbody>
                <?php foreach($apps AS $app){ ?>
                <tr>
                  <td><input type="checkbox" name="selected[]" value="<?php echo $app['id']; ?>" /></td>
                  <td>
                    <?php echo $app['name']; ?>
                  </td>
                  <td>
                    <?php echo $app['email']; ?>
                  </td>
                  <td>
                    <?php echo $app['redirect_url']; ?>
                  </td>
                  <td>
                    <?php echo $app['cancel_url']; ?>
                  </td>
                  <td>
                    <?php echo $app['client_id']; ?>
                  </td>
                  <td>
                    <?php echo $app['client_secret']; ?>
                  </td>
                  <td>
                    <?php if($app['status']){  echo $text_enabled; } else { echo $text_disabled; } ?>
                  </td>
                  <td>
                    <a href="<?php echo $app['edit']; ?>" data-toggle="tooltip" title="<?php echo $text_edit; ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <?php } ?>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('#btn_delete').on('click', function() {
    $('#form-wkocuvdsso').attr('action', '<?php echo $delete; ?>&token=<?php echo $token; ?>');
    $('#form-wkocuvdsso').submit();
  });
</script>
<?php echo $footer; ?>
