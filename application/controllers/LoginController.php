<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

	public function __construct(){
		parent::__construct();
		// load form and url helpers
        $this->load->helper(array('form', 'url'));
        $this->load->model('LoginModel');
        $this->load->library('session');

	}


	public function index()
	{
		
		$this->load->view('login/loginpage');
	}

	public function login()
	{
	   $data=array(
		'email'   =>$_POST['email'],
		'password'=>$_POST['password']
	   );
	  $user=$this->LoginModel->getUser('user',$data);
			
	   if (!empty($user)) {	
	      
	     $userdata=array(
	        'user_name'=>$user[0]['name'],
                'email'    =>$user[0]['email'],
	 	'phone'    =>$user[0]['phone'],
	      );

             $this->session->set_userdata('loginUser',$userdata);

 	     redirect('LoginController/logiUserPage');
	   }else{
	     $this->session->set_flashdata('msg', 'User Not Found');
	     redirect();
	  }
	}

	public function signup()
	{	
		$this->load->library('upload');

		$data=array(
			'name'  	=>$_POST['name'],
			'email'		=>$_POST['email'],
			'password'	=>$_POST['password'],
			'phone'		=>$_POST['phone'],
			);

		$registerData=$this->LoginModel->insertSignup('user',$data);

	    $dataInfo = array();
	    $files = $_FILES;
	    $cpt = count($_FILES['userfile']['name']);
	    for($i=0; $i<$cpt; $i++)
	    {           
	        $_FILES['userfile']['name']= $files['userfile']['name'][$i];
	        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
	        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
	        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
	        $_FILES['userfile']['size']= $files['userfile']['size'][$i];    

	        $this->upload->initialize($this->set_upload_options());
	        $this->upload->do_upload();
	        $dataInfo[] = $this->upload->data();
	    }

	 
	    foreach ($dataInfo as $image) {
	    	$user_image=array(
	    		'user_id'	=>$registerData,
	    		'image_name'=>$image['file_name']
	    		);
	    	$result_set = $this->LoginModel->uploadImage($user_image);
	    }
	   
	     

		 $this->session->set_flashdata('msg', 'User Register Success');
         redirect();
	}


	private function set_upload_options()
	{   
	    //upload an image options
	    $config = array();
	    $config['upload_path'] = './asset/';
	    $config['allowed_types'] = 'gif|jpg|png';
	    $config['max_size']      = '0';
	    $config['overwrite']     = FALSE;

	    return $config;
	}

	public function logiUserPage()
	{
		$data = $this->session->userdata('loginUser');

		
		if (!empty($data)) {
			
			$this->load->view('login/userlogin',compact('data'));

		}else{
			 $this->session->set_flashdata('msg', 'Your Are Not Login In');
                  redirect();
		}

	}

	public function logout()
	{
		$this->session->unset_userdata('loginUser');
		 redirect();

	}
}
