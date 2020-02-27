<?php $assets_dir  =   'assets/theme/default/'; ?>
<div class="latest-movie-img-container lazy" data-src="<?php echo $this->common_model->get_video_thumb_url($videos['videos_id']); ?>" style="background-image: url(<?php echo base_url('uploads/default_image/blank_thumbnail.jpg');?>);">
    <div class="movie-img">
        <a href="<?php echo base_url('watch/'.$videos['slug']).'.html';?>" class="ico-play ico-play-sm">
            <img class="img-responsive play-svg svg" src="<?php echo base_url($assets_dir); ?>images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url($assets_dir); ?>images/play-button.png'">
        </a>
        <div class="overlay-div"></div>
        <div class="video_quality">
            <span class="label label-primary">
                <?php if($videos['is_tvseries']=='1'): echo $this->common_model->get_num_episodes_by_id($videos['videos_id']).' EPISODES'; else: echo $videos['video_quality']; endif; ?>
            </span>
        </div>
        <div class="movie-title">
            <h3>
                <a href="<?php echo base_url('watch/'.$videos['slug']).'.html';?>"><?php echo $videos['title'];?></a>
            </h3>
        </div>
    </div>
</div>
