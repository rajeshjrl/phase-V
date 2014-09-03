<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set("display_errors", "on");

class Account extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("common_model");
        $this->load->language("edit-profile");
        CHECK_USER_STATUS();
		UpdateActiveTime();
    }

    function trusted_to() {
        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        /* Delete selected */
        if (count($_POST) > 0) {
            if (isset($_POST['btn_delete_all'])) {
                /* getting all ides selected */
                $arr_user_ids = $this->input->post('checkbox');
                if (count($arr_user_ids) > 0) {

                    if (count($arr_user_ids) > 0) {
                        /* deleting the user selected */
                        $this->common_model->deleteRows($arr_user_ids, "mst_trusted", "id");
                    }
                    $this->session->set_userdata("msg", "<span class='success'>Trusted people deleted successfully!</span>");
                }
            }
        }

        /* checking user has privilige for the Manage Admin */
        if ($data['user_account']['role_id'] != 1) {
            /* an admin which is not super admin not privileges to access Manage Role
              setting session for displaying notiication message. */
            $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
            redirect(base_url() . "backend/home");
        }

        /* using the user model */
        $this->load->model('user_model');
        $data['title'] = "Manage Trusted people";
        $data['arr_user_list'] = $this->user_model->getTrustedToPeopleDetails('');
        $this->load->view('backend/account/trusted-list', $data);
    }

}

?>