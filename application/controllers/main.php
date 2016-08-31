<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		session_start();
		parent::__construct();
		
	}
	public function index()
	{
		$this->load->model('productmodel');

		$data['featured'] = $this->productmodel->getFeaturedProducts();
		$data['title'] = "EMP Faraday Cages and Bags | EMP and Solar Flare Protection";
		$data['layout'] = "fullwidth";
		$this->load->view('main/home', $data);
	}

	public function contact()
	{
		$data['page_title'] = "Contact Us";
		$data['sub_header'] = "Questions or Comments Welcomed!";
		$data['sidebar'] = "includes/aside.php";

		$data['view'] = 'main/contact';
		$data['title'] = "Contact Us | Faraday EMP Bags";
		$data['layout'] = "rightsidebar";
		$this->load->view('main_template', $data);
	}

	public function about()
	{
		$data['page_title'] = "About Us";
		$data['sub_header'] = "About the Tech Protect Team";
		$data['sidebar'] = "includes/aside.php";
		$data['title'] = "About Us | Faraday EMP Bags";
		$data['view'] = 'main/about';
		$data['layout'] = "rightsidebar";
		$this->load->view('main_template', $data);
	}

	public function faqs()
	{
		$data['page_title'] = "FAQ's";
		$data['sub_header'] = "Frequently Asked Questions";
		$data['sidebar'] = "includes/aside.php";

		$data['title'] = "FAQ's | Faraday EMP Bags";
		$data['view'] = 'main/faqs';
		$data['layout'] = "rightsidebar";
		$this->load->view('main_template', $data);
	}

	public function news($value='')
	{
		$data['page_title'] = "News";
		$data['sub_header'] = "What's happening in the world";
		$data['sidebar'] = "includes/aside.php";

		$data['title'] = "About Us | Faraday EMP Bags";
		$data['view'] = 'main/about';
		$data['layout'] = "rightsidebar";
		$this->load->view('main_template', $data);
	}

	public function videos($value='')
	{
		$data['page_title'] = "Videos";
		$data['sub_header'] = "Prepare and research";
		$data['sidebar'] = "includes/aside.php";

		$data['title'] = "Videos | Faraday EMP Bags";
		$data['view'] = 'main/video';
		$data['layout'] = "rightsidebar";
		$this->load->view('main_template', $data);
	}

	public function sendEmail()
	{
		// var_dump($_POST);
		$to = "info@techprotectbag.com";
		$headers = "FROM: {$_POST['email']}";
		mail($to, $_POST['subject'], $_POST['message'], $headers);
		$_SESSION['contact_sent'] = true;
		redirect(base_url() .'contact');
	}

	public function admin()
	{
		$this->load->view('admin/admin_login');
	}

	public function adminLogin()
	{
		$this->load->model('adminmodel');
		if($this->adminmodel->login($_POST['username'], $_POST['password'])) {
			$_SESSION['logged_in'] = true;
		} 
		redirect(base_url().'admin');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */