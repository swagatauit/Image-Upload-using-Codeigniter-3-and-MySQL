<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	function do_upload()
	{
		$url = "../images";
		$image=basename($_FILES['pic']['name']);
		$image=str_replace(' ','|',$image);
		$type = explode(".",$image);
		$type = $type[count($type)-1];
		if (in_array($type,array('jpg','jpeg','png','gif')))
		{
			$tmppath="images/".uniqid(rand()).".".$type;
			if(is_uploaded_file($_FILES["pic"]["tmp_name"]))
			{
				move_uploaded_file($_FILES['pic']['tmp_name'],$tmppath);
				return $tmppath;
			}
		}
		else
		{
			redirect(base_url() . 'index.php/Welcome/not_img', 'refresh');
		}
	}

	function image_upload()
	{
		$data ['image_url']= $this->do_upload();
		$data ['alt']= $this->input->post('alt');
		$this->db->insert('image_upload', $data);
 		redirect(base_url() . 'index.php/Welcome/', 'refresh');
	}

	function images()
	{
		$this->load->view('images');
	}

	function not_img()
	{
		$this->load->view('not_img');
	}
}
