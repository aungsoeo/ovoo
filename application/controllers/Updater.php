<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * OVOO-Live TV & Movie Portal CMS with Unlimited TV-Series
 * ---------------------- OVOO --------------------
 * ------- Live TV & Movie Portal CMS with Unlimited TV-Series --------
 * - Professional live tv and movie management system -
 *
 * @package     OVOO-Movie & Video Stremaing CMS Pro
 * @author      Abdul Mannan/SpaGreen Creative
 * @copyright   Copyright (c) 2014 - 2019 SpaGreen,
 * @license     http://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
 * @link        http://www.spagreen.net
 * @link        support@spagreen.net
 *
 **/
class Updater extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
    }

    //default index function, redirects to login/dashboard 
    public function index(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url() . 'login', 'refresh');
        if ($this->session->userdata('admin_is_login') == 1)
            redirect(base_url() . 'admin/dashboard', 'refresh');
    }
    // updater function

    function process($action = '')
    {
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '161');
        /* end menu active/inactive section*/

        // create directory if not exist.
        $update_dir = 'update';
        if (!is_dir($update_dir))
            mkdir($update_dir, 0777, true);

        $zip_file_name = $_FILES["zip_file"]["name"];
        $path = 'update/' . $zip_file_name;
        move_uploaded_file($_FILES["zip_file"]["tmp_name"], $path);

        // unzip file and remove uploded zip file.
        $zip = new ZipArchive;
        $contents = $zip->open($path);
        if ($contents === TRUE) {
            $zip->extractTo($update_dir);
            $zip->close();
            unlink($path);
        }
        // get json_content
        $unzip_file_name = substr($zip_file_name, 0, -4);
        $str = file_get_contents('./update/' . $unzip_file_name . '/config.json');
        $converted_json = json_decode($str, true);

        // process php file
        require './update/' . $unzip_file_name . '/php_update.php';

        // Create directorie if not exist
        if (!empty($converted_json['directories'])) {
            foreach ($converted_json['directories'] as $dir) {
                if (!is_dir($dir['title']))
                    mkdir($dir['title'], 0777, true);
            }
        }
        // copy file if not exist or replace existing file
        if (!empty($converted_json['files'])) {
            foreach ($converted_json['files'] as $files):
                // copy/replace file
                copy($files['from_dir'], $files['to_dir']);
                unlink($files['from_dir']);
            endforeach;
        }
        // redirect after ompleted
        $this->session->set_flashdata('success', "Update successfully completed.");
        redirect(base_url() . 'admin/update/', 'refresh');
    }

}
