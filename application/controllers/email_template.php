<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_template extends CI_Controller {

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
        /* using the email template model */
        $this->load->model('email_template_model');
        $data = $this->common_model->commonFunction();
        $arr_privileges = array();
        /* getting all privileges */
        $data['arr_privileges'] = $this->common_model->getRecords('mst_privileges');
        /* getting all email templates from email template table. */
        $data['arr_email_templates'] = $this->email_template_model->getEmailTemplateDetails();
        $data['title'] = "Manage Email Templates";
        $this->load->view('backend/email-template/list', $data);
    }

    /* function for edi temail template */

    public function editEmailTemplate($email_template_id = '') {
        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        /* using the email template model */
        $this->load->model('email_template_model');
        $data = $this->common_model->commonFunction();
        $arr_privileges = array();
        /* getting all privileges */
        $data['arr_privileges'] = $this->common_model->getRecords('mst_privileges');
        if ($this->input->post('input_subject') != '') {
            $arr_to_update = array("email_template_subject" => mysql_real_escape_string($this->input->post('input_subject')), "email_template_content" => mysql_real_escape_string(str_replace("\r\n", "", $this->input->post('text_content'))), "date_updated" => date("Y-m-d"));
            $email_template_id_to_update = $this->input->post('email_template_hidden_id');
            $this->email_template_model->updateEmailTemplateDetailsById($email_template_id_to_update, $arr_to_update);
            $this->session->set_userdata('msg', 'Email Template details has been updated sucessfully.');
            redirect(base_url() . "backend/email-template/list");
        }

        /* getting all email templates from email template table */
        $data['arr_email_template_details'] = $this->email_template_model->getEmailTemplateDetailsById($email_template_id);
        $data['title'] = "Edit Email Templates";
        $data['email_template_id'] = $email_template_id;
        $this->load->view('backend/email-template/edit-email-template', $data);
    }

}
