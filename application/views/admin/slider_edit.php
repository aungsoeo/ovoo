<?php
$sliders   = $this->db->get_where('slider', array('slider_id' => $param2))->result_array();
foreach ($sliders as $row) :
    ?>
    <?php echo form_open(base_url() . 'admin/slider/update/' . $param2, array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>

    <h4 class="text-center"><?php echo trans('slider_edit'); ?></h4>
    <hr>

    <div class="form-group">
        <label class=" col-sm-3 control-label"><?php echo trans('title'); ?></label>
        <div class="col-sm-12">
            <input type="text" name="title" value="<?php echo $row['title']; ?>" class="form-control" required>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3"><?php echo trans('description'); ?></label>
        <div class="col-sm-12">
            <textarea class="wysihtml5 form-control" name="description" rows="10"><?php echo $row['description']; ?></textarea>
        </div>
    </div>

    <div class="form-group">
        <label class=" col-sm-3 control-label"><?php echo trans('video_link'); ?></label>
        <div class="col-sm-12">
            <input type="text" name="video_link" value="<?php echo $row['video_link']; ?>" class="form-control" required>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3"><?php echo trans('image'); ?></label>
        <div class="col-sm-12">
            <div class="profile-info-name text-center"> <img id="thumb_image" src="<?php echo $row['image_link']; ?>" class="img-thumbnail" alt=""> </div>
            <br>
            <div id="thumbnail_content">
                <input type="file" id="thumbnail_file" onchange="showImg(this);" name="image" class="filestyle" data-input="false" accept="image/*"></div><br>
            <p class="btn btn-white" id="thumb_link" href="#"><span class="btn-label"><i class="fa fa-link"></i></span>
                <?php echo trans('link') ?>
            </p>
            <p class="btn btn-white" id="thumb_file" href="#"><span class="btn-label"><i class="fa fa-file-o"></i></span>
                <?php echo trans('file') ?>
            </p>
        </div>
    </div>




    <div class="form-group">
        <label class="control-label col-md-3"><?php echo trans('publication'); ?></label>
        <div class="col-sm-12">
            <select class="form-control m-bot15" name="publication">
                <option value="1" <?php if ($row['publication'] == '1') {
                                            echo 'selected';
                                        } ?>><?php echo trans('published'); ?></option>
                <option value="0" <?php if ($row['publication'] == '0') {
                                            echo 'selected';
                                        } ?>><?php echo trans('unpublished'); ?></option>
            </select>
        </div>
    </div>
<?php endforeach; ?>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 m-t-15">
        <button type="submit" class="btn btn-sm btn-primary waves-effect"> <span class="btn-label"><i class="fa fa-floppy-o"></i></span>SAVE </button>
        <button type="" class="btn btn-sm btn-white m-l-5 waves-effect" data-dismiss="modal">CLOSE </button>
    </div>
</div>
</form>
<script>
    jQuery(document).ready(function() {
        $('form').parsley();

    });
</script>

<script>
    jQuery(document).ready(function() {
        $('#thumb_link').click(function() {
            $('#thumbnail_content').html('<input type="text" name="image_link" value="<?php echo $row['image_link']; ?>" class="form-control">');
        });

        $('#thumb_file').click(function() {
            $('#thumbnail_content').html('<input type="file" id="thumbnail_file" onchange="showImg(this);" name="image" class="filestyle" data-input="false" accept="image/*"></div>');
        });

    });
</script>

<!--instant image dispaly-->
<script type="text/javascript">
    function showImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#thumb_image')
                    .attr('src', e.target.result)
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<!--end instant image dispaly-->