<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Testimonial extends CI_Controller {
    /*
      An Controller having functions to manage testimonal ie. listing, adding, editing, deleting and changing testimonial status and displaying testimonial in front side.
     */

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        CHECK_USER_STATUS();
		UpdateActiveTime();
    }

    public function listTestimonial() {
        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        /* checking user has privilige for the Manage Testimonial */
        if ($data['user_account']['role_id'] != 1) {
            /* checking user has privilege to access the manage testimonial */
            $user_account = $this->session->userdata('user_account');
            /* getting user Privileges from the session array */
            $user_priviliges = unserialize($user_account['user_privileges']);
            if (!in_array(1, $user_priviliges)) {
                /* setting session for displaying notiication message. */
                $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage testimonial!</span>");
                redirect(base_url() . "backend/home");
            }
        }

        if (count($_POST) > 0) {
            if (isset($_POST['btn_delete_all'])) {
                /* getting all ides selected */
                $arr_tetstimonal_ids = $this->input->post('checkbox');
                if (count($arr_tetstimonal_ids) > 0) {
                    /* deleting the testimonial from the backend */
                    $this->common_model->deleteRows($arr_tetstimonal_ids, "mst_testimonial", "testimonial_id");
                    $this->session->set_userdata("msg", "<span class='success'>Testimonial deleted successfully!</span>");
                }
            }
        }
        $data['title'] = "Manage Testimonial";
        /* getting all testimonail with descending order */
        $data['arr_tetimonials'] = $this->common_model->getRecords('mst_testimonial', '', '', array('added_date', 'desc'));
        $this->load->view('backend/testimonial/list', $data);
    }

    /**/

    public function changeStatus() {
        if (isset($_POST['testimonial_id'])) {
            /* changing status of testimonial */
            $arr_to_update = array("status" => $this->input->post('status'));
            $this->common_model->updateRow('mst_testimonial', $arr_to_update, array('testimonial_id' => intval($this->input->post('testimonial_id'))));
            echo json_encode(array("error" => "0", "error_message" => ""));
        } else {
            /* if something going wrong providing error message */
            echo json_encode(array("error" => "1", "error_message" => "Sorry, your request can not be fulfilled this time. Please try again later"));
        }
    }

    public function addTestimonial($edit_id = '') {
        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        /* Checking user has privilige for the Manage Role */
        if ($data['user_account']['role_id'] != 1) {
            /* checking user has privilege to access the manage testimonial */
            $user_account = $this->session->userdata('user_account');
            /* getting user Privileges from the session array */
            $user_priviliges = unserialize($user_account['user_privileges']);
            if (!in_array(1, $user_priviliges)) {
                /* setting session for displaying notiication message. */
                $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage testimonial!</span>");
                redirect(base_url() . "backend/home");
            }
        }


        if (count($_POST) > 0) {
            if ($this->input->post('btnSubmit') != "") {
                if ($this->input->post('edit_id') != '') {
                    $arr_to_update = array("testimonial" => mysql_real_escape_string($_POST['inputTestimonial']), "name" => mysql_real_escape_string($_POST['inputName']), "updated_date" => date("Y-m-d H:i:s"));
                    $this->common_model->updateRow('mst_testimonial', $arr_to_update, array('testimonial_id' => intval(base64_decode($this->input->post('edit_id')))));
                    $this->session->set_userdata('msg', '<span class="success">Testimonial updated successfully!</span>');
                } else {
                    $arr_to_insert = array("added_by" => 'Admin', "user_id" => $data['user_account']['user_id'], "status" => 'Active', "testimonial" => mysql_real_escape_string($_POST['inputTestimonial']), "name" => mysql_real_escape_string($_POST['inputName']), "added_date" => date("Y-m-d H:i:s"), "updated_date" => date("Y-m-d H:i:s"));
                    $this->common_model->insertRow($arr_to_insert, "mst_testimonial");
                    $this->session->set_userdata('msg', '<span class="success">Testimonial added successfully!</span>');
                }
                redirect(base_url() . "backend/testimonial/list");
            }
        }

        $arr_privileges = array();
        /* getting all privileges  */
        $data['arr_privileges'] = $this->common_model->getRecords('mst_privileges');
        if (($edit_id != '')) {
            $data['title'] = "Edit Testimonial";
            $data['edit_id'] = $edit_id;
            $data['arr_testimonial'] = $this->common_model->getRecords("mst_testimonial", "", array("testimonial_id" => intval(base64_decode($edit_id))));
            /* single row fix */
            $data['arr_testimonial'] = end($data['arr_testimonial']);
        } else {
            $data['title'] = "Add Testimonial";
            $data['edit_id'] = '';
        }
        $this->load->view('backend/testimonial/add', $data);
    }

    public function viewTestimonial() {
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['arr_tetimonials'] = $this->common_model->getRecords('mst_testimonial', '', array('status' => 'Active'), array('updated_date', 'desc'));
        $this->load->view('front/testimonial', $data);
    }

}