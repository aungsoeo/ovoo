<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

class Install extends CI_Controller {

	function __construct() {
        parent::__construct();	
		$this->load->helper('url');
		$this->load->helper('file');
		// Cache control
		//date_default_timezone_set("Asia/Dhaka");
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
	}
	/*installation page*/
	function index(){
		$data['action_url'] = "http://".$_SERVER['HTTP_HOST'];
        $data['action_url'] .= preg_replace('@/+$@','',dirname($_SERVER['SCRIPT_NAME'])).'/';
		$data['msg']	=	'';
		$this->load->view('install',$data);
	}

		/*	if error occurs return to installation page with message*/
	function install_error(){
		$data['msg']	=	'error';
		$this->load->view('install',$data);
		
	}
		/*	installation start */
	function run_install(){	
		$hostname 					=	$this->input->post('hostname');
		$db_username 				= 	$this->input->post('db_username');
		$db_password 				= 	$this->input->post('db_password');
		$db_name 					= 	$this->input->post('db_name');
		$buyer						=	$this->input->post('buyer');
		$purchase_code				=	$this->input->post('purchase_code');
		$site_name					=	$this->input->post('site_name');
		$email						=	$this->input->post('email');
		$login_username				=	$this->input->post('login_username');
		$login_password				=	md5($this->input->post('login_password'));		
		
		//Validating connection
		$connection_status 				= $this->validate_connection( $hostname ,  $db_username ,  $db_password , $db_name  );
		$response['connection_status'] 	= $connection_status;				
		//Validating connection
		$purchase_status 				= $this->valid_purchase_code( $buyer,$purchase_code );
		$response['purchase_status'] 	= $purchase_status;		
		//Replying ajax request with validation response
		
		
		if($connection_status == 'success' && $purchase_status 	== 'success'){
			$base_url = "http://".$_SERVER['HTTP_HOST'];
			$base_url .= preg_replace('@/+$@','',dirname($_SERVER['SCRIPT_NAME'])).'/';

			$data = read_file('./application/config/database.php');
			$data = str_replace('%_database_name_%',$db_name,$data);
			$data = str_replace('%_database_user_name_%',$db_username,$data);
			$data = str_replace('%_database_password_%',$db_password,$data);						
			$data = str_replace('%_host_name_%',$hostname,$data);
			write_file('./application/config/database.php',$data);
			
			// Replace new default routing controller
			$data2 = read_file('./application/config/routes.php');
			$data2 = str_replace('install','home',$data2);
			write_file('./application/config/routes.php', $data2);

			//place session
			$data3 = read_file('./application/config/autoload.php');
			$data3 = str_replace('ftp','session',$data3);
			$data3 = str_replace('cart','database',$data3);
			write_file('./application/config/autoload.php', $data3);

			//replace base_url
			$data4 = read_file('./application/config/config.php');
			$data4 = str_replace("//%_%","",$data4);
			$data4 = str_replace("%_config_%","config",$data4);
			$data4 = str_replace("%_url_%",$base_url,$data4);
			write_file('./application/config/config.php', $data4);

						
			// Run the installer sql schema
			$db_path = './uploads/install/install.sql';
			$installer_path = './application/controllers/install.php';
			$database_schema = read_file($db_path);
  		
			$query = rtrim( trim($database_schema), "\n;");
			$query_list = explode(";", $query);
			$this->load->database();
			foreach($query_list as $query_run){
				$this->db->query($query_run);				
				}
				 
				 
			//Replace the admin login credentials
			$this->db->where('user_id' , 1);
			$this->db->update('user' , array('username'=>$login_username,'email'	=>	$email,'password'	=>	$login_password));
			
			// Replace the company name						
			$this->db->where('title', 'site_name');
			$this->db->update('config', array(
				'value' => $site_name
			));
			$this->load->helper("file");
			//unlink($db_path);
			//unlink($installer_path);
			redirect($base_url . 'user/login', 'refresh');
		}
		else 
		{
			$data['msg'] ='<div class="alert alert-danger"><strong>Opps</strong> Installation not completed.Please check your purchase information &amp; database credentials carefully then try again..</div>';
			$this->load->view('install_status',$data);
		}
	}

	function check_db_connection(){
		$link	=	@mysqli_connect($this->input->post('hostname'),
						$this->input->post('db_username'),
							$this->input->post('db_password'));
		if(!$link)
		{
			@mysqli_close($link);
		 	return false;
		}
		
		$db_selected	=	mysqli_select_db($this->input->post('db_name'), $link);
		if (!$db_selected)
		{
			@mysqli_close($link);
		 	return false;
		}
		
		@mysqli_close($link);
		return true;
	}


	function check_installation_connection(){
		$response = array();		
		//Ajax database name,username and password request
		$hostname 					= $_POST["hostname"];
		$db_username 				= $_POST["db_username"];
		$db_password 				= $_POST["db_password"];
		$db_name 					= $_POST["db_name"];		
		$response['submitted_data'] = $_POST;		
		
		//Validating connection
		$connection_status = $this->validate_connection( $hostname ,  $db_username ,  $db_password , $db_name  );
		$response['connection_status'] = $connection_status;	
		
		//Replying ajax request with validation response
		echo json_encode($response);
	}
    
    //Validating connection from ajax request
    function validate_connection($hostname	=	'' , $db_username	 =  '' , $db_password	 =  '' , $db_name =''){
		 $link	=	@mysql_connect($hostname,$db_username,$db_password);
		if(!$link)
		{
			@mysql_close($link);
		 	return 'invalid';
		}
		
		$db_selected	=	mysql_select_db($db_name, $link);
		if (!$db_selected)
		{
			@mysql_close($link);
		 	return 'invalid';
		}
		
		@mysql_close($link);
		return 'success';		
    }

    function check_purchase_code(){
		//return true;
		$buyer				=	$this->input->post('buyer');
		$purchase_code		=	$this->input->post('purchase_code');
		$curl 				=	curl_init('http://marketplace.envato.com/api/edge/spagreen/oiysrb3xok0mkxzmydb6vga71qbofrg9/verify-purchase:'.$purchase_code.'.xml');
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt( $curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
		
		$purchase_data		=	curl_exec($curl);
		curl_close($curl);
		$purchase_data		=	json_decode(json_encode((array) simplexml_load_string($purchase_data)),1);

		if ( isset($purchase_data['verify-purchase']['buyer']) && $purchase_data['verify-purchase']['buyer'] == $buyer)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	function ajax_check_purchase_code(){
		$response = array();
		$buyer				=	$_POST["buyer"];
		$purchase_code		=	$_POST["purchase_code"];		
		//Validating connection
		$status = $this->valid_purchase_code( $buyer,$purchase_code );
		$response['purchase_status'] = $status;
		$response['purchase_code'] = $purchase_code;	
		
		//Replying ajax request with validation response
		echo json_encode($response);
	}


	function valid_purchase_code($buyer ='', $purchase_code =''){

    	$curl 				=	curl_init('http://marketplace.envato.com/api/edge/spagreen/oiysrb3xok0mkxzmydb6vga71qbofrg9/verify-purchase:'.$purchase_code.'.xml');
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt( $curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
		
		$purchase_data		=	curl_exec($curl);
		curl_close($curl);
		$purchase_data		=	json_decode(json_encode((array) simplexml_load_string($purchase_data)),1);

		if ( isset($purchase_data['verify-purchase']['buyer']) && $purchase_data['verify-purchase']['buyer'] == $buyer)
		{
			return 'success';
		}
		else
		{
			return 'invalid';
		}
	}
}

