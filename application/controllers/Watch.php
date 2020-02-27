<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ovoo-Movie & Video Stremaing CMS Pro
 * ----------------------------- OVOO -----------------------------
 * -------------- Movie & Video Stremaing CMS Pro -----------------
 * -------- Professional video content management system ----------
 *
 * @package     OVOO-Movie & Video Stremaing CMS Pro
 * @author      Abdul Mannan/Spa Green Creative
 * @copyright   Copyright (c) 2014 - 2017 SpaGreen,
 * @license     http://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
 * @link        http://www.spagreen.net
 * @link        support@spagreen.net
 *
 **/

 
class Watch extends Home_Core_Controller{
    public function __construct(){
        parent::__construct();
    }
    
    public function index($slug='',$param1='',$param2=''){
        $error = $this->common_model->check_movie_accessability($slug);
        if($error == FALSE):            
            $data['videos_id']              = $this->common_model->get_videos_id_by_slug($slug);
            $this->common_model->watch_count_by_slug($data['videos_id']);
            $data['watch_videos']           = $this->common_model->get_videos_by_slug($slug);            
            $data['download_links']         = $this->db->get_where('download_link', array("videos_id"=>$data['videos_id']))->result_array();
            $data['total_download_links']   = count($data['download_links']);
            $data['video_files']            = $this->db->get_where('video_file', array('videos_id'=> $data['videos_id']))->result_array();
            $data['total_video_files']      = count($data['video_files']);
            $data['total_episodes']         = $this->db->get_where('episodes', array('videos_id'=> $data['videos_id']))->result_array();
            $data['total_episodes_links']   = count($data['total_episodes']);

            $data['total_seasons']         = $this->db->get_where('seasons', array('videos_id'=> $data['videos_id']))->result_array();

            $data['total_seasons_links']   = count($data['total_seasons']);

            $data['seasons']            = $this->get_season_episode($data['videos_id']); 
              

            $data['slug']                   = $slug;
            $data['param1']                 = $param1;
            $data['param2']                 = $param2;
            $data['page_name']              = 'watch';
            // opengraph for social
            $data['og_title']               = !empty(trim($data['watch_videos']->seo_title)) ? $data['watch_videos']->seo_title : $data['watch_videos']->title;
            $data['og_url']                 = base_url('watch/'.$data['watch_videos']->slug.'.html');
            $data['og_description']         = !empty(trim($data['watch_videos']->meta_description)) ? strip_tags($data['watch_videos']->meta_description) : strip_tags($data['watch_videos']->description);
            $data['og_image_url']           = $this->common_model->get_video_thumb_url($data['watch_videos']->videos_id);
            // end opengraph

            // seo
            $data['title']                  = !empty(trim($data['watch_videos']->seo_title)) ? $data['watch_videos']->seo_title : $data['watch_videos']->title;
            $data['meta_description']       = !empty(trim($data['watch_videos']->meta_description)) ? strip_tags($data['watch_videos']->meta_description) : strip_tags($data['watch_videos']->description);
            $data['focus_keyword']          = $data['watch_videos']->focus_keyword;
            $data['canonical']              = base_url('watch/'.$data['watch_videos']->slug.'.html');
            // end seo
            $this->load->view('theme/'.$this->active_theme.'/index',$data);          
        else:
            redirect('notfound');
        endif;
    }

     function get_season_episode($videos_id=''){
        $response   =   array();
        $this->db->order_by('seasons_id','DESC');
        $this->db->where('videos_id',$videos_id);
        $query      =   $this->db->get('seasons');
        if($query->num_rows() > 0):
            $seasons = $query->result_array();
            $i              =   0;
            foreach ($seasons as $season):
                $response[$i]['seasons_id']     = $season['seasons_id'];
                $response[$i]['seasons_name']   = $season['seasons_name'];
                $response[$i]['download_url']   = $season['download_url'];
                $response[$i]['episodes']       = $this->get_episodes_with_all_video_by_movie_id($season['seasons_id']);
                $i++;
            endforeach;
        endif;
        return $response;
    }

    function get_episodes_with_all_video_by_movie_id($seasons_id){
        $response   =   array();
        $this->db->where('seasons_id',$seasons_id);
        $query = $this->db->get('episodes');
        if($query->num_rows() > 0):
            $episodes   =   $query->result_array();
            $i          =   0;
            foreach ($episodes as $episode):
                $response[$i]['episodes_id']     = $episode['episodes_id'];
                $response[$i]['episodes_name']   = $episode['episodes_name'];
                $response[$i]['stream_key']      = $episode['stream_key'];
                $response[$i]['file_type']       = $episode['file_source'];

                $response[$i]['file_url']        = $episode['file_url'];
                $response[$i]['file_size']   = $episode['file_size'];


                if($episode['file_source'] =='gdrive'):
                    $response[$i]['file_type']          = 'embed';
                elseif($episode['file_source'] =='amazone'):
                    $response[$i]['file_type']          = 'mp4';
                elseif($episode['file_source'] =='m3u8'):
                    $response[$i]['file_type']          = 'hls';
                elseif($episode['file_source'] =='vimeo'):
                    $response[$i]['file_type']          = 'embed';
                    $response[$i]['file_url']           = str_replace('vimeo','player.vimeo',$episode['file_url']);
                    $response[$i]['file_url']           = str_replace('.com/','.com/video/',$response[$i]['file_url']);
                endif;
                $i++;
            endforeach;
        endif;
        return $response;
    }

}