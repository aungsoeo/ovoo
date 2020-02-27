<?php $video_source = ovoo_config('video_source');?>
<div class="card">
  <div class="row">
    <div class="col-md-12">
      <a class="btn btn-sm btn-primary waves-effect" href="<?php echo base_url('admin/videos'); ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i></span><?php echo trans('back_to_list'); ?></a>
      <a class="btn btn-sm btn-primary waves-effect" href="<?php echo base_url('watch/') . $slug; ?>" target="_blank"> <span class="btn-label"><i class="fa fa-eye"></i></span><?php echo trans('preview'); ?></a>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('upload_videos') ?></h3>
        </div>
        <div class="panel-body">
          <?php echo form_open_multipart(base_url('admin/movie_upload')); ?>           
            <input type="hidden" name="videos_id" value="<?php echo $param1; ?>">
            <div class="form-group">
              <label class="control-label"><?php echo trans('label') ?></label>&nbsp;&nbsp;<input id="label" type="text" name="label" class="form-control" placeholder="Server#1" required="">
            </div>
            <div class="form-group">
              <label class="control-label"><?php echo trans('order'); ?></label>
              <input type="number" name="order" class="form-control" placeholder="0 to 9999" required>
            </div>
            <div class="form-group">
              <label class="control-label"><?php echo trans('source'); ?></label>
              <select class="form-control" name="source" id="selected-source">
                <option value="upload" <?php if($video_source =='upload'): echo 'selected'; endif;?>><?php echo trans('upload');?></option>
                <option value="youtube" <?php if($video_source =='youtube'): echo 'selected'; endif;?>><?php echo trans('youtube');?></option>
                <option value="vimeo" <?php if($video_source =='vimeo'): echo 'selected'; endif;?>><?php echo trans('video');?></option>
                <option value="embed" <?php if($video_source ==''): echo 'selected'; endif;?>><?php echo trans('google_drive');?></option>
                <option value="amazone" <?php if($video_source =='amazone'): echo 'selected'; endif;?>><?php echo trans('amazone_s3');?></option>
                <option value="mp4" <?php if($video_source =='mp4'): echo 'selected'; endif;?>><?php echo trans('mp4_from_url');?></option>
                <option value="mkv" <?php if($video_source =='mkv'): echo 'selected'; endif;?>><?php echo trans('mkv_from_url');?></option>
                <option value="webm" <?php if($video_source =='webm'): echo 'selected'; endif;?>><?php echo trans('webm_from_url');?></option>
                <option value="m3u8" <?php if($video_source =='m3u8'): echo 'selected'; endif;?>><?php echo trans('m3u8_from_url');?></option>
                <option value="embed" <?php if($video_source =='embed'): echo 'selected'; endif;?>><?php echo trans('embed_url');?></option>
              </select>
            </div>
            <div class="form-group" <?php if($video_source =='upload'): echo 'style="display:none;"'; endif;?> id="url-input">
              <label class="control-label"><?php echo trans('url') ?></label>
              <input type="text" name="url" id="url-input-field" value="" class="form-control" placeholder="http://server-2.com/movies/titalic.mp4" <?php if($video_source !='upload'): echo 'required'; endif;?> ><br>
            </div>
            <div class="form-group" <?php if($video_source !='upload'): echo 'style="display:none;"'; endif;?> id="image-input">
              <label class="control-label"><?php echo trans('select_video'); ?></label>
              <input class="videoselect" name="videofile" id="image-input-field" type="file" accept="video/*" <?php if($video_source =='upload'): echo 'required'; endif;?> />
            </div>
            <div class="form-group">
              <button class="btn btn-sm btn-primary waves-effect" type="submit"> <span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans('add') ?> </button>
            </div>
          </form>
        </div>
      </div>      
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('video_list') ?></h3>
        </div>
        <div class="panel-body">
            <?php echo form_open(base_url() . 'admin/file_and_download/change_order/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
            <input type="hidden" name="videos_id" value="<?php echo $param1; ?>">
          <table class="table table-bordered" id="video-list">
            <thead>
              <tr>
                <th>#</th>
                <th><?php echo trans('source') ?></th>
                <th><?php echo trans('order') ?></th>
                <th><?php echo trans('label') ?></th>
                <th><?php echo trans('url') ?></th>
                <th><?php echo trans('subtitle') ?></th>
                <th><?php echo trans('action') ?></th>
              </tr>
            </thead>
            <?php
            $sl = 0;
            $video_files = $this->common_model->get_video_file_by_videos_id($param1);
            foreach ($video_files as $video_file) :
              $sl++;
              ?>
              <tr id="row_<?php echo $video_file['video_file_id']; ?>">
                <td><?php echo $sl; ?></td>
                <td><a href="<?php echo base_url('watch/') . $this->common_model->get_slug_by_videos_id($video_file['videos_id']) . '.html?key=' . $video_file['stream_key']; ?>"><?php echo $video_file['file_source']; ?></a></td>
                <td>
                    <input type="hidden" name="video_file_id[]" value="<?php echo $video_file['video_file_id']; ?>">
                    <input type="number" name="order[]" value="<?php echo $video_file['order']; ?>" class="form-control" style="width:80px" required>
                </td>
                <td><?php echo $video_file['label']; ?></td>
                <td><?php echo urldecode($video_file['file_url']); ?></td>
                <td>
                  <?php if ($video_file['file_source'] == 'youtube' || $video_file['file_source'] == 'vimeo') : ?>
                    <p><?php echo trans('unsupported') ?></p>
                  <?php else : ?>
                    <?php
                        $subtitles = $this->db->get_where('subtitle', array('video_file_id' => $video_file['video_file_id']))->result_array();
                        foreach ($subtitles as $subtitle) :
                          ?>
                      <a class="label label-default" href="#" onclick="delete_row('subtitle',<?php echo urldecode($subtitle['subtitle_id']); ?>)"><?php echo $subtitle['language']; ?></a>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-white btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a class="dropdown-item"href="<?php echo base_url('admin/file_and_download/edit/'. $video_file['video_file_id']); ?>"><?php echo trans('edit') ?></a></li>
                      <li><a class="dropdown-item" target="_blank" href="<?php echo base_url('watch/') . $this->common_model->get_slug_by_videos_id($video_file['videos_id']) . '.html?key=' . $video_file['stream_key']; ?>"><?php echo trans('watch_now') ?></a></li>
                      <?php if ($video_file['file_source'] != 'youtube' && $video_file['file_source'] != 'vimeo' && $video_file['file_source'] != 'embed') : ?>
                        <li><a href="#" class="dropdown-item" data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/subtitle_add/' . $video_file['videos_id'] . '/' . $video_file['video_file_id']; ?>" id="menu"><?php echo trans('add_subtitle') ?></a> </li>
                      <?php endif; ?>
                      <li><a class="dropdown-item" title="<?php echo trans('delete'); ?>" href="#" onclick="delete_row('video_file',<?php echo urldecode($video_file['video_file_id']); ?>)" class="delete"><?php echo trans('delete'); ?></a> </li>
                    </ul>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </table>
          <div class="pull-right" style="margin-bottom:10px;"><button type="submit" class="btn btn-primary btn-sm"><?php echo trans('save_order');?></button></div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('download_url') ?></h3>
        </div>
        <div class="panel-body">
          <div id="download_link_section">
            <div class="form-group" id="_source2">
              <label class="control-label"><?php echo trans('link_title') ?></label>&nbsp;&nbsp;<input id="link_title" type="url" name="link_title[]" class="form-control" placeholder="<?php echo trans('download_from_openload') ?>" required="">
            </div>
            <div class="form-group" id="_source2">
              <label class="control-label"><?php echo trans('download_url') ?></label>&nbsp;&nbsp;<input id="download_url" type="url" name="download_url[]" class="form-control" placeholder="http://server-2.com/movies/titalic.mp4" required=""><br>
              <button class="btn btn-sm btn-primary waves-effect" id="add-download-link"> <span class="btn-label"><i class="fa fa-plus"></i></span>Add to List </button>
            </div>
          </div>
        </div>
      </div>
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('download_link_list') ?></h3>
        </div>
        <div class="panel-body">
          <table class="table table-bordered" id="download-link-list">
            <?php $download_links = $this->db->get_where('download_link', array('videos_id' => $param1))->result_array();
            foreach ($download_links as $download_link) :
              ?>
              <tr id="row_<?php echo $download_link['download_link_id']; ?>">
                <td><a href="<?php echo $download_link['download_url']; ?>"><strong><?php echo $download_link['link_title']; ?></strong></a></td>
                <td><a href="<?php echo urldecode($download_link['download_url']); ?>"><?php echo urldecode($download_link['download_url']); ?></a></td>
                <td><a title="<?php echo trans('delete'); ?>" class="btn btn-icon" onclick="delete_row(<?php echo " 'download_link' " . ',' . $download_link['download_link_id']; ?>)" class="delete"><i class="fa fa-remove"></i></a></td>
              </tr>
            <?php endforeach; ?>
          </table>
        </div>
      </div>
    </div>

    <script>
      $(document).ready(function() {
        $("#upload-active").click(function() {
          $("#upload_section").show();
          $("#link_section").hide();
        });
        $("#link-active").click(function() {
          $("#upload_section").hide();
          $("#link_section").show();
        });

        $("#add-link").click(function() {
          $(this).html('<span class="btn-label"><i class="fa fa-plus"></i></span>Adding..');
          var type = $("#selected-source").val();
          var base_url = "<?php echo base_url(); ?>";
          var url = $("#video_url").val();
          var videos_id = "<?php echo $param1; ?>";
          if (isUrl(url) == true && url != '' && type != '') {
            $.ajax({
              type: 'POST',
              url: "<?php echo base_url() . 'admin/video_file/'; ?>",
              data: "videos_id=" + videos_id + "&type=" + type + "&url=" + encodeURIComponent(url),
              dataType: 'json',
              success: function(response) {
                var post_status = response.post_status;
                var row_id = response.row_id;
                var type = response.type;
                var url = response.url;
                var watch_url = response.watch_url;
                if (post_status == "success") {
                  var html_text = '<tr id="row_' + row_id + '"><td>#</td><td><a href="' + watch_url + '">Server(' + type + ')</a></td><td>' + url + '</td><td></td><td><div class="btn-group"><button type="button" class="btn btn-white btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button><ul class="dropdown-menu" role="menu"><li><a class="dropdown-item" target="_blank" href="' + watch_url + '">Watch Now</a></li><li><a class="dropdown-item" title="Delete" href="#" onclick="delete_row(' + "'video_file'," + row_id + ')" class="delete">Delete</a> </li></ul></div></td></tr>';

                  //var html_text ='<tr id="row_'+row_id+'"><td>#</td><td>Server('+type+')</td><td>'+url+'</a></td><td><a title="delete" class="btn btn-icon" onclick="delete_row('+"'video_file',"+row_id+')" class="delete"><i class="fa fa-remove"></i></td></tr>';
                  $('#video-list').append(html_text);
                  $("#add-link").html('<span class="btn-label"><i class="fa fa-plus"></i></span>Add');
                  $("#url").val('');
                  $("#add-download-link").html('<span class="btn-label"><i class="fa fa-plus"></i></span>Add to List');
                  $("#video_url").val('');
                  swal('Good job!', 'Video added successfully ', 'success');
                  //alert('Link Added to video.');
                } else {
                  $("#add-link").html('<span class="btn-label"><i class="fa fa-plus"></i></span>Add');
                  swal('OPPS!', post_status, 'error');
                  //alert(post_status); 
                }

              }
            });
          } else {
            $("#add-download-link").html('<span class="btn-label"><i class="fa fa-plus"></i></span>Add to List');
            $("#add-link").html('<span class="btn-label"><i class="fa fa-plus"></i></span>Add to List');
            swal('OPPS!', "please enter a valid url and title", 'error');
          }
        });
        $("#add-download-link").click(function() {
          $(this).html('<span class="btn-label"><i class="fa fa-plus"></i></span>Adding..');
          var link_title = $("#link_title").val();
          var download_url = JSON.stringify($("#download_url").val());
          var videos_id = "<?php echo $param1; ?>";
          if (isUrl(download_url) == true && download_url != '' && link_title != '') {
            $.ajax({
              type: 'POST',
              url: "<?php echo base_url() . 'admin/download_link/'; ?>",
              data: "videos_id=" + videos_id + "&link_title=" + link_title + "&download_url=" + encodeURIComponent(download_url),
              dataType: 'json',
              success: function(response) {
                var post_status = response.post_status;
                var row_id = response.row_id;
                var link_title = response.link_title;
                var download_url = response.download_url;
                if (post_status == "success") {
                  var html_text = '<tr id="row_' + row_id + '"><td><a class="dropdown-item" href="' + download_url + '"><strong>' + link_title + '</strong></a></td><td><a href="' + download_url + '">' + download_url + '</a></td><td><a title="delete" class="btn btn-icon" onclick="delete_row(' + "'download_link'," + row_id + ')" class="delete"><i class="fa fa-remove"></i></a></td></tr>';
                  $('#download-link-list').append(html_text);
                  $("#link_title").val('');
                  $("#download_url").val('');
                  $("#add-download-link").html('<span class="btn-label"><i class="fa fa-plus"></i></span>Add to List');

                  swal('Good job!', 'Download link added successfully ', 'success');
                } else {
                  $("#add-download-link").html('<span class="btn-label"><i class="fa fa-plus"></i></span>Add to List');
                  swal('OPPS!', post_status, 'error');
                }
              }
            });
          } else {
            $("#add-download-link").html('<span class="btn-label"><i class="fa fa-plus"></i></span>Add to List');
            swal('OPPS!', "please enter a valid url and title", 'error');
          }
        });
      });
    </script>
    <script>
      function isUrl(s) {
        var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
        return regexp.test(s);
      }
    </script>
    <script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
    <script>
      jQuery(document).ready(function() {
          $('form').parsley();
          $(".videoselect").filestyle({
              input: true,
              icon: true,
              buttonBefore: true,
              text: "<?php echo trans('select_video'); ?>",
              htmlIcon: '<span class="fa fa-file-video-o"></span>',
              badge: true,
              badgeName: "badge-danger"
          });

          $( "#selected-source" ).change(function() {
             var source = $("#selected-source option:selected" ).val();
             if(source == 'upload'){
               $("#image-input").show('slow');
               $("#url-input").hide('slow');
               $("#image-input-field").attr("required", true);
               $("#url-input-field").attr("required", false);
             }else{
               $("#image-input").hide('slow');
               $("#url-input").show('slow');
               $("#image-input-field").attr("required", false);
               $("#url-input-field").attr("required", true);
             }
          });
      });
    </script>