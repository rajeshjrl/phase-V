<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment_Method extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
		$this->load->model('payment_model');
        $this->load->language('common');
        $this->load->language('forum');
        $this->load->helper("file");
        CHECK_USER_STATUS();
		UpdateActiveTime();
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */

    /* Start payment method category management for backend */

    public function getPaymentMethodList() {

        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['title'] = "Manage payment methods";
        $data['arr_payment_categories_list'] = $this->payment_model->getCategories();
		//echo "<pre>";print_r($data);exit;
        $this->load->view('backend/payment-method/list', $data);
    }
	
	public function changePaymentStatus() {
        if ($this->input->post('method_id') != "") {
            /* updating the user status. */
            $arr_to_update = array(
                "status" => $this->input->post('method_status')
            );
            /* condition to update record for the admin status */
            $condition_array = array('method_id' => intval($this->input->post('method_id')));
            /* updating the global setttings parameter value into database */
            $this->common_model->updateRow('payment_method', $arr_to_update, $condition_array);
            echo json_encode(array("error" => "0", "error_message" => ""));
        } else {
            /* if something going wrong providing error message. */
            echo json_encode(array("error" => "1", "error_message" => "Sorry, your request can not be fulfilled this time. Please try again later"));
        }
    }
	
	
	public function addPaymentMethod() {

        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        if ($this->input->post('btnSubmit') != '') {
            /* insert category details */
            $insert_category_data = array('method_name' => mysql_real_escape_string($this->input->post('method_name')),
				'method_url' => str_replace(" ", "-", strtolower(mysql_real_escape_string($this->input->post('method_url')))),
				'risk_level' => mysql_real_escape_string($this->input->post('risk_level')),
			 	'method_description' => $this->input->post('method_description'),
				'parent_method_id' => mysql_real_escape_string($this->input->post('parent_method_id')),
				'status' => mysql_real_escape_string($this->input->post('status')),
                );

            $last_insert_category_id = $this->common_model->insertRow($insert_category_data, "payment_method");
			$msg = '<span class="alert alert-success">Payment method added successfully!</span>';
			redirect(base_url() . "backend/payment-method/list");
        }
		$data['title'] = "Add payment methods";
		$arr_payment_method_info = $this->payment_model->getCategories();
		$data['arr_payment_method_info'] = $arr_payment_method_info;
        $this->load->view('backend/payment-method/add-payment-method', $data);
    }
	
	
	public function editPaymentMethod($method_id) {

        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        if ($this->input->post('btnSubmit') != '') {
            /* insert category details */
            $arr_category_info = array('method_name' => mysql_real_escape_string($this->input->post('method_name')),
					'method_url' => str_replace(" ", "-", strtolower(mysql_real_escape_string($this->input->post('method_url')))),
					'method_description' => $this->input->post('method_description'),
					'risk_level' => mysql_real_escape_string($this->input->post('risk_level')),
			 		'parent_method_id' => mysql_real_escape_string($this->input->post('parent_method_id')),
					'status' => mysql_real_escape_string($this->input->post('status')),
                );
								
			$this->common_model->updateRow("payment_method", $arr_category_info, array("method_id" => $this->input->post("method_id")));
			$msg = '<span class="alert alert-success">Payment method edited successfully!</span>';
			redirect(base_url() . "backend/payment-method/list");
        }
		$data['title'] = "Edit payment methods";
		$data['method_id'] = $method_id;		
		$arr_payment_method_data = $this->payment_model->getCategories("", array("method_id" => $method_id), "", "", 0);		
		$data['arr_payment_method_data'] = $arr_payment_method_data[0];
		$arr_payment_method_info = $this->payment_model->getCategories();
		$data['arr_payment_method_info'] = $arr_payment_method_info;
		//echo "<pre>";print_r($data);exit;
        $this->load->view('backend/payment-method/edit-payment-method', $data);
    }
	
	public function checkUniqueMethodUrl() {

        $method_url = $this->input->get("method_url");    
		if ($this->input->get("method_url_old") == $method_url) {
            echo "true";
            exit;
        }    
        $arr_method_url_info = $this->payment_model->getUniqueUri($method_url);
//        print_r($arr_page_url_info);
        if (count($arr_method_url_info) > 0) {
            if ($this->input->get("method_url_old") == $method_url) {
                echo "true";
            } else {
                echo "false";
            }
        } else {
            echo "true";
        }
    }
	

    
    /* Multilingual Forum Category  */

    public function multilingualForumCategory($category_id) {

//        $this->load->model('common_model');

        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();


//        $this->load->model('forum_model');


        if (isset($lang_id) && $lang_id != '') {
            $lang_id = $this->session->userdata('lang_id');
        } else {
            $lang_id = 17; /* Default is 17(English) */
        }


        $data['arr_froum_categories_info'] = $this->forum_model->getCategories("", array("category_id" => $category_id), "", "", 0);
        $data['arr_froum_categories_info'] = $data['arr_froum_categories_info'][0];
        $this->load->view('backend/forum/multingual-category', $data);
    }
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
