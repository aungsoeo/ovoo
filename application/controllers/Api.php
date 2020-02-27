<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


/**
 * OXOO - Android Live TV & Movie Portal App
 * ---------------------- OXOO --------------------
 * ------- Android Live TV & Movie Portal App --------
 * - Live tv channel & movie management system -
 *
 * @package     OXOO - Android Live TV & Movie Portal App
 * @author      Abdul Mannan/Spa Green Creative
 * @copyright   Copyright (c) 2014 - 2019 SpaGreen,
 * @license     http://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
 * @link        http://www.spagreen.net
 * @link        support@spagreen.net
 *
 **/

/* API 

// home page
1. get slider config
2. get slider details
3. get image slider
4. get movie slider

// movie
5. get latest movie
5. get movie
11. get movie by genre
12. get movie by country
13. get movie by year


// tv
7. get featured tv channel
8. get all tv channel
9. get all tv channel category
10. get tv channel by category id


//tv-series
6. get latest tv-series
11. get tv-series by genre
12. get tv-series by country
13. get tv-series by year
*/



class Api extends CI_Controller{   
    
	function __construct(){
		parent::__construct();
        $this->load->model('common_model');
        $this->load->model('api_model');
		$this->load->database();
	
   		/*cache controling*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
    
    // index function
    public function index() {
        echo "This is API";
    }

    //test api function
    public function test() {
        $response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $response['status']     = 'success';
                $response['message']    = 'api key is verified.';
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get slider function
    public function get_slider() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $response['slider_type']        =   $this->db->get_where('config' , array('title'=>'slider_type'))->row()->value;
                if($response['slider_type'] == 'image'):
                    if($this->db->get_where('slider',array('publication'=>'1'))->num_rows()==0)
                        $response['slider_type']        = "disable";
                    $response['data']           =   $this->common_model->all_published_slider();
                elseif($response['slider_type'] == 'movie'):
                    $response['data']           =   $this->api_model->get_movies_for_slider();
                endif;

            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    /***** 
    movie section strat here
    *****/

    // get latest movies function
    public function get_latest_movies() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $limit              =   $this->input->get('limit');
                $response           =   $this->api_model->get_latest_movies($limit);

            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get movies function
    public function get_movies() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $page              =   $this->input->get('page');
                $response           =   $this->api_model->get_movies($page);

            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get features genre  function
    public function get_features_genre_and_movie() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $response               =   $this->api_model->get_features_genre_and_movie();
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get movies  by genre ID function
    public function get_movie_by_genre_id() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $id                 =   $this->input->get('id');
                if(!empty($id) && $id !='' && $id !=NULL && is_numeric($id)):
                    $validity           = $this->api_model->verify_genre_id($id);
                    if($validity):
                        $page                   =   $this->input->get('page');
                        $response               =   $this->api_model->get_movie_by_genre_id($id,$page);
                    else:
                        $response['status']     = 'error';
                        $response['message']    = 'Genre ID not found.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Genre ID must not be null or empty.';
                endif; 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get movies  by country ID function
    public function get_movie_by_country_id() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $id                 =   $this->input->get('id');
                if(!empty($id) && $id !='' && $id !=NULL && is_numeric($id)):
                    $validity           = $this->api_model->verify_country_id($id);
                    if($validity):
                        $page                   =   $this->input->get('page');
                        $response               =   $this->api_model->get_movie_by_country_id($id,$page);
                    else:
                        $response['status']     = 'error';
                        $response['message']    = 'country ID not found.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Genre ID must not be null or empty.';
                endif; 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    /***** 
    movie section end here
    *****/


    /***** 
    tv-series section start here
    *****/


    // get latest movies function
    public function get_latest_tvseries() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $limit              =   $this->input->get('limit');
                $response           =   $this->api_model->get_latest_tvseries($limit);

            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get movies function
    public function get_tvseries() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $page              =   $this->input->get('page');
                $response           =   $this->api_model->get_tvseries($page);

            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get movies  by genre ID function
    public function get_tvseries_by_genre_id() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $id                 =   $this->input->get('id');
                if(!empty($id) && $id !='' && $id !=NULL && is_numeric($id)):
                    $validity           = $this->api_model->verify_genre_id($id);
                    if($validity):
                        $page                   =   $this->input->get('page');
                        $response               =   $this->api_model->get_tvseries_by_genre_id($id,$page);
                    else:
                        $response['status']     = 'error';
                        $response['message']    = 'Genre ID not found.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Genre ID must not be null or empty.';
                endif; 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get movies  by country ID function
    public function get_tvseries_by_country_id() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $id                 =   $this->input->get('id');
                if(!empty($id) && $id !='' && $id !=NULL && is_numeric($id)):
                    $validity           = $this->api_model->verify_country_id($id);
                    if($validity):
                        $page                   =   $this->input->get('page');
                        $response               =   $this->api_model->get_tvseries_by_country_id($id,$page);
                    else:
                        $response['status']     = 'error';
                        $response['message']    = 'country ID not found.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Genre ID must not be null or empty.';
                endif; 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    /***** 
    tvseries section end here
    *****/


    // get all country function
    public function get_all_country() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $response               =   $this->api_model->get_all_country();
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }


    // get all genre  function
    public function get_all_genre() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $response               =   $this->api_model->get_all_genre();
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get featured tv channel function
    public function get_featured_tv_channel() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $page              =   $this->input->get('page');
                $response           =   $this->api_model->get_featured_tv_channel($page);

            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get featured tv channel function
    public function get_all_tv_channel() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $page              =   $this->input->get('page');
                $response           =   $this->api_model->get_all_tv_channel($page);

            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get featured tv channel function
    public function get_tv_channel() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $limit              =   $this->input->get('limit');
                $response           =   $this->api_model->get_tv_channel($limit);

            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get featured tv channel function
    public function get_all_tv_channel_by_category() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $limit              =   $this->input->get('limit');
                $response           =   $this->api_model->get_all_tv_channel_by_category($limit);

            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get movies  by country ID function
    public function get_tv_channel_by_category_id() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $id                 =   $this->input->get('id');
                if(!empty($id) && $id !='' && $id !=NULL && is_numeric($id)):
                    $validity           = $this->api_model->verify_live_tv_category_id($id);
                    if($validity):
                        $page                   =   $this->input->get('page');
                        $response               =   $this->api_model->get_tv_channel_by_category_id($id,$page);
                    else:
                        $response['status']     = 'error';
                        $response['message']    = 'TV Channel category ID not found.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'TV Channel category must not be null or empty.';
                endif; 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }


    // get single movie,tvseries & live tv details
    public function get_single_details() {
        $response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        $type                       =   $this->input->get('type');
        $id                         =   $this->input->get('id');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                // verify type
                if($type=='movie' || $type=='tvseries' || $type=='tv'):
                    // verify id
                    if(!empty($id) && $id !='' && $id !=NULL && is_numeric($id)):
                        if($type=='movie'):
                            $verify           = $this->api_model->verify_movie_tvseries_id($id);
                            if($verify):
                                $this->common_model->watch_count_by_slug($id);
                                $response               =   $this->api_model->get_single_movie_details_by_id($id);
                            else:
                                $response['status']     = 'error';
                                $response['message']    = 'Movie ID not found.';
                            endif;
                        elseif($type=='tvseries'):
                            $verify           = $this->api_model->verify_movie_tvseries_id($id);
                            if($verify):
                                $this->common_model->watch_count_by_slug($id);
                                $response               =   $this->api_model->get_single_tvseries_details_by_id($id);
                            else:
                                $response['status']     = 'error';
                                $response['message']    = 'Movie ID not found.';
                            endif;
                        elseif($type=='tv'):
                            $verify           = $this->api_model->verify_tv_id($id);
                            if($verify):
                                $response               =   $this->api_model->get_single_tv_details_by_id($id);
                            else:
                                $response['status']     = 'error';
                                $response['message']    = 'TV ID not found.';
                            endif;
                        endif;
                    else:
                        $response['status']     = 'error';
                        $response['message']    = 'ID must be valid.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Type must be satisfied.';
                endif;                 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }




    // login function
    public function login() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $email                      =   trim($this->input->get('email'));
                $password                   =   md5(trim($this->input->get('password')));
                if (filter_var($email, FILTER_VALIDATE_EMAIL) && $password !='' && $password !=NULL):            
                    $login_status               = $this->api_model->validate_user( $email ,$password);        
                    if ($login_status):
                        $credential    =   array(  'email' => $email , 'password' => $password,'status'=>'1');
                        $this->db->where($credential);
                        $this->db->update('user', array('last_login' => date('Y-m-d H:i:s')));
                        $user_info              = $this->api_model->get_user_info( $email ,$password);
                        $response['status']     = 'success';
                        $response['user_id']    = $user_info->user_id;
                        $response['name']       = $user_info->name;
                        $response['email']      = $user_info->email;
                        $response['gender']     = "Unknown";
                        if($user_info->gender =='1'):
                            $response['gender']      = "Male";
                        elseif($user_info->gender =='0'):
                            $response['gender']      = "Female";
                        endif;
                        $response['join_date']  = $user_info->join_date;
                        $response['last_login'] = $user_info->last_login;
                    else:
                        $response['status']     = 'error';
                        $response['data']       = 'Emai & username not match.Please try again.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['data']       = 'Please enter valid email & password.';
                endif; 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }


    // signup function
    public function signup() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $name                       =   trim($this->input->get('name'));
                $email                      =   trim($this->input->get('email'));
                $password                   =   trim($this->input->get('password'));
                //var_dump($password);
                if (filter_var($email, FILTER_VALIDATE_EMAIL) && $password !='' && $password !=NULL && strlen($password) > 3):
                    $md5_password               = md5($password);         
                    $signup_ability             = $this->api_model->check_signup_ability_by_email( $email);       
                    if ($signup_ability):
                        $this->api_model->create_user($name, $email ,$md5_password);
                        $this->load->model('email_model');
                        $this->email_model->account_opening_email($email, $password);
                        $user_info              = $this->api_model->get_user_info( $email ,$md5_password);                        
                        $response['status']     = 'success';
                        $response['user_id']    = $user_info->user_id;
                        $response['name']       = $user_info->name;
                        $response['email']      = $user_info->email;
                        $response['gender']     = "Unknown";
                        if($user_info->gender =='1'):
                            $response['gender']      = "Male";
                        elseif($user_info->gender =='0'):
                            $response['gender']      = "Female";
                        endif;
                        $response['join_date']  = $user_info->join_date;
                        $response['last_login'] = $user_info->last_login;
                    else:
                        $response['status']     = 'error';
                        $response['data']       = 'Email already exist.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['data']       = 'Please enter valid email & password.';
                endif; 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get_user_details_by_user_id function
    public function get_user_details_by_user_id() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $user_id                      =   trim($this->input->get('id'));
                if (is_numeric($user_id) && $user_id !='' && $user_id !=NULL):            
                    $is_valid_user_id               = $this->api_model->validate_user_by_id( $user_id);        
                    if ($is_valid_user_id):
                        $user_info              = $this->api_model->get_user_info_by_user_id($user_id);
                        $response['status']     = 'success';
                        $response['user_id']    = $user_info->user_id;
                        $response['name']       = $user_info->name;
                        $response['email']      = $user_info->email;
                        $response['gender']     = "Unknown";
                        $response['is_authorized']     = "0";
                        if($user_info->user_id =='1')
                            $response['is_authorized']     = "1";
                        if($user_info->gender =='1'):
                            $response['gender']      = "Male";
                        elseif($user_info->gender =='0'):
                            $response['gender']      = "Female";
                        endif;
                        $response['join_date']  = $user_info->join_date;
                        $response['last_login'] = $user_info->last_login;
                    else:
                        $response['status']     = 'error';
                        $response['data']       = 'User ID not found.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['data']       = 'Please enter valid user ID.';
                endif; 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }


    // get_user_details_by_email function
    public function get_user_details_by_email() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):                
                $email                      =   trim($this->input->get('email'));
                if (filter_var($email, FILTER_VALIDATE_EMAIL) && $email !='' && $email !=NULL):            
                    $is_valid_email               = $this->api_model->validate_user_by_email( $email);        
                    if ($is_valid_email):
                        $user_info              = $this->api_model->get_user_info_by_email($email);
                        $response['status']     = 'success';
                        $response['user_id']    = $user_info->user_id;
                        $response['name']       = $user_info->name;
                        $response['email']      = $user_info->email;
                        $response['image_url']  = $this->common_model->get_image_url('user',$user_info->user_id);
                        $response['gender']     = "Unknown";
                        if($user_info->gender =='1'):
                            $response['gender']      = "Male";
                        elseif($user_info->gender =='0'):
                            $response['gender']      = "Female";
                        endif;
                        $response['join_date']  = $user_info->join_date;
                        $response['last_login'] = $user_info->last_login;
                    else:
                        $response['status']     = 'error';
                        $response['data']       = 'Email not found.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['data']       = 'Please enter valid email.';
                endif; 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // update profile function
    public function update_profile() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->post('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $user_id                    =   trim($this->input->post('id'));
                if (is_numeric($user_id) && $user_id !='' && $user_id !=NULL):            
                    $is_valid_user_id               = $this->api_model->validate_user_by_id( $user_id);        
                    if ($is_valid_user_id):
                        $email                      =   trim($this->input->post('email'));
                        if (filter_var($email, FILTER_VALIDATE_EMAIL) && $email !='' && $email !=NULL): 
                            //$user_info              = $this->api_model->get_user_info_by_email($email);
                            $name                       =   trim($this->input->post('name'));
                            $password                   =   trim($this->input->post('password'));
                            $gender                     =   trim($this->input->post('gender'));
                            $data['email']              =   $email;
                            if(!empty($name) && $name !='' && $name !=NULL):
                                $data['name']           =   $name;
                            endif;
                            if(!empty($password) && $password !='' && $password !=NULL):
                                $data['password']           =   md5($password);
                            endif;
                            if(!empty($gender) && $gender !='' && $gender !=NULL):
                                if($gender=='Male'):
                                    $data['gender']           =   '1';
                                elseif($gender=='Female'):
                                    $data['gender']           =   '0';
                                endif;
                            endif;
                            $this->api_model->update_profile($user_id,$data);
                            if(!empty($_FILES['photo']))
                                move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/user_image/' .$user_id.'.jpg');
                            $response['status']     = 'success';
                            $response['data']       = 'Profile updated successfully.';
                        else:
                            $response['status']     = 'error';
                            $response['data']       = 'Please enter valid email.';
                        endif;
                    else:
                        $response['status']     = 'error';
                        $response['data']       = 'User ID not found.';
                    endif;
                else:
                $response['status']     = 'error';
                $response['data']       = 'Please enter valid user ID.';
                endif; 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // deactivate account function
    public function deactivate_account() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->post('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $user_id                    =   trim($this->input->post('id'));
                $password                   =   md5(trim($this->input->post('password')));
                $reason                     =   trim($this->input->post('reason'));
                if ($password !='' && $password !=NULL && $reason !='' && $reason !=NULL):          
                    $user_exist               = $this->api_model->validate_user_by_id_password($user_id ,$password);        
                    if ($user_exist):
                        $credential    =   array('user_id' => $user_id , 'password' => $password );
                        $this->db->where($credential);
                        $this->db->update('user', array('status' => '0','deactivate_reason'=>$reason));
                        $response['status']     = 'succes';
                        $response['data']       = 'Account successfully deactivated.';
                    else:
                        $response['status']     = 'error';
                        $response['data']       = 'Please send valid user ID & password.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['data']       = 'Please enter user ID & password.';
                endif; 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }



    // get search function
    public function search() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $q                  =   $this->input->get('q');
                if(!empty($q) && $q !='' && $q !=NULL):
                    $page               =   $this->input->get('page');
                    $response['movie']              =   $this->api_model->get_movie_search_result($q,$page);
                    $response['tvseries']           =   $this->api_model->get_tvseries_search_result($q,$page);
                    $response['tv_channels']        =   $this->api_model->get_tv_channel_search_result($q,$page);
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Search string is empty.';
                endif;

            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get app config function
    public function get_config() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $menu                   = $this->db->get_where('config' , array('title'=>'app_menu'))->row()->value;
                $program_guide_enable   = $this->db->get_where('config' , array('title'=>'app_program_guide_enable'))->row()->value;
                $mandatory_login        = $this->db->get_where('config' , array('title'=>'app_mandatory_login'))->row()->value;
                $genre_visible          = $this->db->get_where('config' , array('title' =>'genre_visible'))->row()->value;
                $country_visible        = $this->db->get_where('config' , array('title' =>'country_visible'))->row()->value;

                $response['menu']                   = 'grid';
                if($menu =="vertical"):
                    $response['menu']               = 'vertical';
                endif;

                $response['program_guide_enable']   = false;
                // if($program_guide_enable == "false"):
                //     $response['program_guide_enable']= false;
                // endif;

                $response['mandatory_login']        = false;
                if($mandatory_login == "true"):
                    $response['mandatory_login']    = true;
                endif;

                $response['genre_visible']        = true;
                if($genre_visible == "false"):
                    $response['genre_visible']    = false;
                endif;

                $response['country_visible']        = true;
                if($country_visible == "false"):
                    $response['country_visible']    = false;
                endif;
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }




    // get favorite function
    public function get_favorite() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $user_id                  =   $this->input->get('user_id');
                if(!empty($user_id) && $user_id !='' && $user_id !=NULL && is_numeric($user_id)):
                    $page               =   $this->input->get('page');
                    $response           =   $this->api_model->get_favorite($user_id,$page);
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Invalid user id.';
                endif;

            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get add_favorite function
    public function add_favorite() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $user_id                  =   $this->input->get('user_id');
                if(!empty($user_id) && $user_id !='' && $user_id !=NULL && is_numeric($user_id)):
                    $is_valid_user_id         = $this->api_model->validate_user_by_id( $user_id);        
                    if ($is_valid_user_id):                        
                        $videos_id              =   $this->input->get('videos_id');
                        if(!empty($videos_id) && $videos_id !='' && $videos_id !=NULL && is_numeric($videos_id)):
                            //var_dump($videos_id);
                            $verify                 = $this->api_model->verify_movie_tvseries_id($videos_id);
                            if($verify):
                                $if_exist = $this->api_model->verify_favorite_list($user_id,$videos_id);
                                if(!$if_exist):
                                    $this->api_model->add_favorite($user_id,$videos_id);
                                    $response['status']     = 'success';
                                    $response['message']    = 'Added successfully.';
                                else:
                                    $response['status']     = 'error';
                                    $response['message']    = 'Already exist in your favorite.';
                                endif;
                            else:
                                $response['status']     = 'error';
                                $response['message']    = 'Movie ID not found.';
                            endif;
                        else:
                            $response['status']     = 'error';
                            $response['message']    = 'Invalid videos ID.';
                        endif;
                    else:
                        $response['status']     = 'error';
                        $response['message']    = 'User ID not found.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Invalid user id.';
                endif;
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }


    // get add_favorite function
    public function verify_favorite_list() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $user_id                  =   $this->input->get('user_id');
                if(!empty($user_id) && $user_id !='' && $user_id !=NULL && is_numeric($user_id)):
                    $is_valid_user_id         = $this->api_model->validate_user_by_id( $user_id);        
                    if ($is_valid_user_id):                        
                        $videos_id              =   $this->input->get('videos_id');
                        $if_exist = $this->api_model->verify_favorite_list($user_id,$videos_id);
                        if($if_exist):
                            $response['status']     = 'success';
                            $response['message']    = 'Found in favorite.';
                        else:
                            $response['status']     = 'error';
                            $response['message']    = 'Not found in favorite.';
                        endif;
                    else:
                        $response['status']     = 'error';
                        $response['message']    = 'User ID not found.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Invalid user id.';
                endif;
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get remove_favorite function
    public function remove_favorite() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $user_id                  =   $this->input->get('user_id');
                if(!empty($user_id) && $user_id !='' && $user_id !=NULL && is_numeric($user_id)):
                    $is_valid_user_id         = $this->api_model->validate_user_by_id( $user_id);        
                    if ($is_valid_user_id):                        
                        $videos_id              =   $this->input->get('videos_id');
                        if(!empty($videos_id) && $videos_id !='' && $videos_id !=NULL && is_numeric($videos_id)):
                            //var_dump($videos_id);
                            $verify                 = $this->api_model->verify_favorite_list($user_id,$videos_id);
                            if($verify):
                                $this->api_model->remove_favorite($user_id,$videos_id);
                                $response['status']     = 'success';
                                $response['message']    = 'Removed successfully.';
                            else:
                                $response['status']     = 'error';
                                $response['message']    = 'Movie ID not found to your favorite list.';
                            endif;
                        else:
                            $response['status']     = 'error';
                            $response['message']    = 'Invalid videos ID.';
                        endif;
                    else:
                        $response['status']     = 'error';
                        $response['message']    = 'User ID not found.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Invalid user id.';
                endif;
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }


    // signup function
    public function password_reset() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $email                      =   trim($this->input->get('email'));
                //var_dump($password);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)):         
                    $user_exist             = $this->common_model->check_email($email);
                    if($user_exist):
                        $new_password           = $this->common_model->generate_random_string();
                        $this->api_model->reset_password($email,$new_password);
                        $this->load->model('email_model');
                        $this->email_model->android_password_reset_email($email,$new_password);                       
                        $response['status']     = 'success';
                        $response['message']    = 'Check you email.We have sent your password throught email.';
                    else:
                        $response['status']     = 'error';
                        $response['data']       = 'Email not registered.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Please enter valid email.';
                endif; 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get single movie,tvseries & live tv details
    public function get_all_comments() {
        $response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        $type                       =   $this->input->get('type');
        $id                         =   $this->input->get('id');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                // verify id
                if(!empty($id) && $id !='' && $id !=NULL && is_numeric($id)):
                    $verify           = $this->api_model->verify_movie_tvseries_id($id);
                    if($verify):
                        $response               =   $this->api_model->get_all_comments($id);
                    else:
                        $response['status']     = 'error';
                        $response['message']    = 'Movie ID not found.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'ID must be valid.';
                endif;                 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // add_comments function
    public function add_comments() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $user_id                  =   $this->input->get('user_id');
                if(!empty($user_id) && $user_id !='' && $user_id !=NULL && is_numeric($user_id)):
                    $is_valid_user_id         = $this->api_model->validate_user_by_id( $user_id);        
                    if ($is_valid_user_id):                        
                        $videos_id              =   $this->input->get('videos_id');
                        if(!empty($videos_id) && $videos_id !='' && $videos_id !=NULL && is_numeric($videos_id)):
                            //var_dump($videos_id);
                            $verify                 = $this->api_model->verify_movie_tvseries_id($videos_id);
                            if($verify):
                                $comment              =   trim($this->input->get('comment'));
                                if(!empty($comment) && $comment !='' && $comment !=NULL):
                                    $comments_id                = $this->api_model->add_comments($user_id,$videos_id,$comment);
                                    $response['status']         = 'success';
                                    $response['message']        = 'Comment Added successfully.';
                                    $response['comments_id']    = $comments_id;
                                else:
                                    $response['status']     = 'error';
                                    $response['message']    = 'Comments empty.';
                                endif;
                            else:
                                $response['status']     = 'error';
                                $response['message']    = 'Movie ID not found.';
                            endif;
                        else:
                            $response['status']     = 'error';
                            $response['message']    = 'Invalid videos ID.';
                        endif;
                    else:
                        $response['status']     = 'error';
                        $response['message']    = 'User ID not found.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Invalid user id.';
                endif;
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // add_comments function
    public function add_replay() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $user_id                  =   $this->input->get('user_id');
                if(!empty($user_id) && $user_id !='' && $user_id !=NULL && is_numeric($user_id)):
                    $is_valid_user_id         = $this->api_model->validate_user_by_id( $user_id);        
                    if ($is_valid_user_id):                        
                        $comments_id              =   $this->input->get('comments_id');
                        if(!empty($comments_id) && $comments_id !='' && $comments_id !=NULL && is_numeric($comments_id)):
                            //var_dump($videos_id);
                            $verify                 = $this->api_model->verify_comments_id($comments_id);
                            if($verify):
                                $comment              =   trim($this->input->get('comment'));
                                if(!empty($comment) && $comment !='' && $comment !=NULL):
                                    $replay_id                = $this->api_model->add_replay($user_id,$comments_id,$comment);
                                    $response['status']         = 'success';
                                    $response['message']        = 'Replay Added successfully.';
                                    $response['replay_id']      = $replay_id;
                                else:
                                    $response['status']     = 'error';
                                    $response['message']    = 'Comments empty.';
                                endif;
                            else:
                                $response['status']     = 'error';
                                $response['message']    = 'Comments ID not found.';
                            endif;
                        else:
                            $response['status']     = 'error';
                            $response['message']    = 'Invalid videos ID.';
                        endif;
                    else:
                        $response['status']     = 'error';
                        $response['message']    = 'User ID not found.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Invalid user id.';
                endif;
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get single all replay
    public function get_all_replay() {
        $response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        $id                         =   $this->input->get('id');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                // verify id
                if(!empty($id) && $id !='' && $id !=NULL && is_numeric($id)):
                    $verify           = $this->api_model->verify_comments_id($id);
                    if($verify):
                        $response               =   $this->api_model->get_replay_by_comments_id($id);
                    else:
                        $response['status']     = 'error';
                        $response['message']    = 'Movie ID not found.';
                    endif;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'ID must be valid.';
                endif;                 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }

    // get preroll ads function
    public function get_preroll_ads_details() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $response['status']       =   $this->db->get_where('config' , array('title'=>'preroll_ads_enable'))->row()->value;
                $response['video_url']    =   $this->db->get_where('config' , array('title'=>'preroll_ads_video'))->row()->value; 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }
    // get admob ads function
    public function get_admob_ads_details() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $response['status']                     =   $this->db->get_where('config' , array('title'=>'admob_ads_enable'))->row()->value;
                $response['admob_app_id']               =   $this->db->get_where('config' , array('title'=>'admob_app_id'))->row()->value;
                $response['admob_banner_ads_id']        =   $this->db->get_where('config' , array('title'=>'admob_banner_ads_id'))->row()->value; 
                $response['admob_interstitial_ads_id']  =   $this->db->get_where('config' , array('title'=>'admob_interstitial_ads_id'))->row()->value; 
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }


    // get admob ads function
    public function get_ads() {
        //$response                   =   array();
        $api_secret_key             =   $this->input->get('api_secret_key');
        // check api secret is sent
        if(!empty($api_secret_key) && $api_secret_key !='' && $api_secret_key !=NULL):
            // verify api secret key
            $verify_apps_api_secret_key =   $this->api_model->check_mobile_apps_api_secret_key($api_secret_key);
            if($verify_apps_api_secret_key):
                $response['ima_preroll']=   $this->api_model->get_preroll_ads_details();
                $response['admob']      =   $this->api_model->get_admob_ads_details();
            else:
                $response['status']     = 'error';
                $response['message']    = 'API secret key is invalid.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'API secret key must not be null or empty.';
        endif;
        echo json_encode($response);
    }


}
    
