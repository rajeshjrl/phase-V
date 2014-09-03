<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Currency extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        CHECK_USER_STATUS();
		UpdateActiveTime();
    }

    /* function to display all the email templates pages */

    public function index() {
        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* using the currency model */
        $this->load->model('currency_model');
        $data = $this->common_model->commonFunction();
        $arr_privileges = array();
        /* getting all privileges */
        $data['arr_privileges'] = $this->common_model->getRecords('mst_privileges');
        /* getting all active currency details from table. */
        $data['arr_currency_details'] = $this->currency_model->getCurrencyDetails();
        $data['title'] = "Manage Currency";
        $this->load->view('backend/currency/list', $data);
    }

    public function editCurrency($currency_id = '') {

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        $this->load->model('currency_model');
        $data = $this->common_model->commonFunction();
        $arr_privileges = array();
        /* getting all privileges */
        $data['arr_privileges'] = $this->common_model->getRecords('mst_privileges');

        if ($this->input->post('currency_id') != '') {
            $arr_to_update = array("currency_name" => mysql_real_escape_string($this->input->post('currency_name')), "currency_code" => mysql_real_escape_string($this->input->post('currency_code')), "currency_exchange_code" => mysql_real_escape_string($this->input->post('currency_exchange_code')), "status" => mysql_real_escape_string($this->input->post('currency_status')), "updated_on" => date("Y-m-d H:i:s"));
            $currency_id_to_update = $this->input->post('currency_id');
            $this->currency_model->updateCurrencyDetailsById($currency_id_to_update, $arr_to_update);
            $this->session->set_userdata('msg', 'Currency details has been updated sucessfully.');
            redirect(base_url() . "backend/currency/list");
        }
        /* getting all email templates from email template table */
        $data['arr_currency_details'] = $this->currency_model->getCurrencyDetailsById($currency_id);
        $data['arr_currency_details'] = $data['arr_currency_details'][0];
        $data['title'] = "Edit Currency";
        $data['currency_id'] = $currency_id;
        $this->load->view('backend/currency/edit-currency', $data);
    }

    public function addCurrency() {

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        $this->load->model('currency_model');
        $data = $this->common_model->commonFunction();
        $arr_privileges = array();
        /* getting all privileges */
        $data['arr_privileges'] = $this->common_model->getRecords('mst_privileges');

        if ($this->input->post('btnSubmit') != '') {
            $table_name = 'currency_management';
            $insert_data = array("currency_name" => mysql_real_escape_string($this->input->post('currency_name')), "currency_code" => mysql_real_escape_string($this->input->post('currency_code')), "currency_exchange_code" => mysql_real_escape_string($this->input->post('currency_exchange_code')), "status" => mysql_real_escape_string($this->input->post('currency_status')), "updated_on" => date("Y-m-d H:i:s"));
            $last_currency_id = $this->common_model->insertrow($insert_data, $table_name);
            if ($last_currency_id != '') {
                $this->session->set_userdata('msg', 'Currency details has been added sucessfully.');
                redirect(base_url() . "backend/currency/list");
            }
        }
        $data['title'] = "Add Currency";
        $this->load->view('backend/currency/add-currency', $data);
    }

}
