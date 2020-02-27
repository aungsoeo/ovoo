<?php
  $app_menu                   = $this->db->get_where('config' , array('title' =>'app_menu'))->row()->value;
  $app_program_guide_enable   = $this->db->get_where('config' , array('title' =>'app_program_guide_enable'))->row()->value;
  $app_mandatory_login        = $this->db->get_where('config' , array('title' =>'app_mandatory_login'))->row()->value;
  $genre_visible              = $this->db->get_where('config' , array('title' =>'genre_visible'))->row()->value;
  $country_visible            = $this->db->get_where('config' , array('title' =>'country_visible'))->row()->value; 
 ?>

<?php echo form_open(base_url() . 'admin/android_setting/update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?> 
<div class="card">
  <div class="row"> 
    <!-- panel  -->
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('android_setting'); ?></h3>
        </div>
        <div class="panel-body"> 
          <!-- panel  -->
          <div class="form-group row">
            <label class="col-sm-3 control-label"><strong><?php echo trans('api_url_for_android');?></strong></label>
            <div class="col-sm-9">
              <input type="text"  value="<?php echo base_url('api/') ?>" readonly class="form-control" required data-parsley-length="[14, 128]" />
              <p><small><?php echo trans('api_url_note');?></small></p>
            </div>
          </div>          

          <div class="form-group row">
            <label class="col-sm-3 control-label"><strong><?php echo trans('api_key_for_android');?></strong></label>
            <div class="col-sm-3">
              <input type="text"  value="<?php echo $this->db->get_where('config' , array('title' =>'mobile_apps_api_secret_key'))->row()->value;?>" name="mobile_apps_api_secret_key" class="form-control" required data-parsley-length="[14, 128]" />
            </div>
            <div class="col-sm-3">
              <a class="btn btn-primary btn-sm" href="<?php echo base_url('admin/regenerate_mobile_secret_key'); ?>"><?php echo trans('create_new_key');?></a>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 control-label"><strong><?php echo trans('terms_url_for_android');?></strong></label>
            <div class="col-sm-9">
            <?php echo trans('terms_url_note_line1');?>
            <p><small><?php echo trans('terms_url_note_line1');?></small></p>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3"><strong><?php echo trans('android_navigation_menu');?></strong></label>
            <div class="col-sm-3">
                <select class="form-control m-bot15" id="app_menu" name="app_menu">
                  <option value="grid" <?php if($app_menu == 'grid'){echo 'selected';}?> ><?php echo trans('grid');?></option>
                  <option value="vertical" <?php if($app_menu == 'vertical'){echo 'selected';}?> ><?php echo trans('vertical');?></option>
                </select>
                <p><small><?php echo trans('');?>Close app then reopen to take effect any changes.</small></p>
            </div>
          </div>

          <!-- <div class="form-group row">
            <label class="control-label col-md-3"><strong>Android TV Program Guide</strong></label>
            <div class="col-sm-3">
                <select class="form-control m-bot15" id="app_program_guide_enable" name="app_program_guide_enable">
                  <option value="true" <?php if($app_program_guide_enable == 'true'){echo 'selected';}?> ><?php echo trans('enable');?></option>
                  <option value="false" <?php if($app_program_guide_enable == 'false'){echo 'selected';}?> ><?php echo trans('disable');?></option>
                </select>
                <p><small>Close app then reopen to take effect any changes.</small></p>
            </div>
          </div> -->

          <div class="form-group row">
            <label class="control-label col-md-3"><strong><?php echo trans('android_mandatory_login');?></strong></label>
            <div class="col-sm-3">
                <select class="form-control m-bot15" id="app_mandatory_login" name="app_mandatory_login">
                  <option value="true" <?php if($app_mandatory_login == 'true'){echo 'selected';}?> ><?php echo trans('enable');?></option>
                  <option value="false" <?php if($app_mandatory_login == 'false'){echo 'selected';}?> ><?php echo trans('disable');?></option>
                </select>
                <p><small><?php echo trans('app_config_change_note');?></small></p>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3"><strong><?php echo trans('android_display_genre_on_app_home');?></strong></label>
            <div class="col-sm-3">
                <select class="form-control m-bot15" id="genre_visible" name="genre_visible">
                  <option value="true" <?php if($genre_visible == 'true'){echo 'selected';}?> ><?php echo trans('yes');?></option>
                  <option value="false" <?php if($genre_visible == 'false'){echo 'selected';}?> ><?php echo trans('no');?></option>
                </select>
                <p><small><?php echo trans('app_config_change_note');?></small></p>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3"><strong><?php echo trans('android_display_country_on_app_home');?></strong></label>
            <div class="col-sm-3">
                <select class="form-control m-bot15" id="country_visible" name="country_visible">
                  <option value="true" <?php if($country_visible == 'true'){echo 'selected';}?> ><?php echo trans('yes');?></option>
                  <option value="false" <?php if($country_visible == 'false'){echo 'selected';}?> ><?php echo trans('no');?></option>
                </select>
                <p><small><?php echo trans('app_config_change_note');?></small></p>
            </div>
          </div>


          <div class="col-sm-offset-3 col-sm-9 m-t-15">
            <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save_change');?></button>
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

<!--instant image dispaly-->
<script type="text/javascript">
    function showImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#landing_page_image')
                    .attr('src', e.target.result)
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<!--end instant image dispaly-->

