<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Google{	
	public function __construct(){		
		$this->CI =& get_instance();
		$this->CI->load->database();	
		require APPPATH .'third_party/google-login/Google_Client.php';
		require APPPATH .'third_party/google-login/contrib/Google_Oauth2Service.php';
    	$application_name       =   $this->CI->db->get_where('config' , array('title'=>'google_application_name'))->row()->value;
    	$client_id       		=   $this->CI->db->get_where('config' , array('title'=>'google_client_id'))->row()->value;
    	$client_secret       	=   $this->CI->db->get_where('config' , array('title'=>'google_client_secret'))->row()->value;
    	$redirect_uri       	=   $this->CI->db->get_where('config' , array('title'=>'google_redirect_uri'))->row()->value;
    	$api_key       			=   $this->CI->db->get_where('config' , array('title'=>'google_api_key'))->row()->value;
		$this->client = new Google_Client();
		$this->client->setApplicationName($application_name);
		$this->client->setClientId($client_id);
		$this->client->setClientSecret($client_secret);
		$this->client->setRedirectUri($redirect_uri);
		$this->client->setDeveloperKey($api_key);
		$this->client->setScopes(array());
		$this->client->setAccessType('online');
		$this->client->setApprovalPrompt('auto');
		$this->oauth2 = new Google_Oauth2Service($this->client);
	}
	
	public function login_url() {
        return $this->client->createAuthUrl();
    }
	
	public function authenticate() {
        return $this->client->authenticate();
    }
	
	public function getAccessToken() {
        return $this->client->getAccessToken();
    }
	
	public function setAccessToken() {
        return $this->client->setAccessToken();
    }
	
	public function revokeToken() {
        return $this->client->revokeToken();
    }
	
	public function get_user_info() {
        return $this->oauth2->userinfo->get();
    }
	
}