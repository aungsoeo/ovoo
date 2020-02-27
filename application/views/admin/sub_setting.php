<?php
$trial_enable               =   $this->db->get_where('config', array('title' => 'trial_enable'))->row()->value;
$paypal_email               =   $this->db->get_where('config', array('title' => 'paypal_email'))->row()->value;
$stripe_publishable_key     =   $this->db->get_where('config', array('title' => 'stripe_publishable_key'))->row()->value;
$stripe_secret_key          =   $this->db->get_where('config', array('title' => 'stripe_secret_key'))->row()->value;
$currency_symbol            =   $this->db->get_where('config', array('title' => 'currency_symbol'))->row()->value;
$currency                    =   $this->db->get_where('config', array('title' => 'currency'))->row()->value;
$reve_public_key            =   $this->db->get_where('config', array('title' => 'reve_public_key'))->row()->value;;
$reve_secret_key            =   $this->db->get_where('config', array('title' => 'reve_secret_key'))->row()->value;;
$reve_encryption_key        =   $this->db->get_where('config', array('title' => 'reve_encryption_key'))->row()->value;;

?>
<?php echo form_open(base_url() . 'subscription/sub_setting/update/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
<div class="card">
  <div class="row">
    <!-- panel  -->
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('subscription_setting'); ?></h3>
        </div>
        <div class="panel-body">
          <!-- panel  -->
          <div class="form-group">
            <label class="col-sm-6 control-label"><?php echo trans('currency_symbol'); ?></label>
            <div class="col-sm-6">
              <input type="text" value="<?php echo $currency_symbol; ?>" name="currency_symbol" class="form-control" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label"><?php echo trans('currency'); ?></label>
            <div class="col-sm-6">
              <input type="text" value="<?php echo $currency; ?>" name="currency" class="form-control" required />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label"><?php echo trans('trial_functionality'); ?></label>
            <div class="col-sm-6 ">
              <select class="form-control" name="trial_enable" required>
                <option value="1" <?php if ($trial_enable == "1") {
                                    echo "selected";
                                  } ?>><?php echo trans('enable'); ?></option>
                <option value="0" <?php if ($trial_enable == "0") {
                                    echo "selected";
                                  } ?>><?php echo trans('disable'); ?></option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label"><?php echo trans('trial_period_number_of_days'); ?></label>
            <div class="col-sm-6">
              <input type="number" value="<?php echo $this->db->get_where('config', array('title' => 'trial_period'))->row()->value; ?>" name="trial_period" class="form-control" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label"><?php echo trans('paypal_merchant_email'); ?></label>
            <div class="col-sm-6">
              <input type="email" value="<?php echo $paypal_email; ?>" name="paypal_email" class="form-control" required />
            </div>
          </div>
          <strong><?php echo trans('stripe_payment_gateway'); ?></strong>
          <hr>
          <div class="form-group">
            <label class="col-sm-6 control-label"><?php echo trans('stripe_publishable_key'); ?></label>
            <div class="col-sm-6">
              <input type="text" value="<?php echo $stripe_publishable_key; ?>" name="stripe_publishable_key" class="form-control" required />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label"><?php echo trans('stripe_secret_key'); ?></label>
            <div class="col-sm-6">
              <input type="text" value="<?php echo $stripe_secret_key; ?>" name="stripe_secret_key" class="form-control" required />
            </div>
          </div>
          <strong><?php echo trans('reve_payment_gateway'); ?></strong>
          <hr>

          <div class="form-group">
            <label class="col-sm-6 control-label"><?php echo trans('reve_public_key'); ?></label>
            <div class="col-sm-6">
              <input type="text" value="<?php echo $reve_public_key; ?>" name="reve_public_key" class="form-control" required />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-6 control-label"><?php echo trans('reve_secret_key'); ?></label>
            <div class="col-sm-6">
              <input type="text" value="<?php echo $reve_secret_key; ?>" name="reve_secret_key" class="form-control" required />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label"><?php echo trans('reve_encryption_key'); ?></label>
            <div class="col-sm-6">
              <input type="text" value="<?php echo $reve_encryption_key; ?>" name="reve_encryption_key" class="form-control" required />
            </div>
          </div>




          <div class="col-sm-offset-3 col-sm-9 m-t-15">
            <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save_changes'); ?></button>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('form').parsley();
  });
</script>

<!-- file select-->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>
<!-- file select-->