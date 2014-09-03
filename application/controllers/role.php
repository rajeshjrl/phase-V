<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Role extends CI_Controller {

    /**
     * An Controller having functions to manage user role
     */
    /* construction function used to load all the models used in the controller.	   */
    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        CHECK_USER_STATUS();
		UpdateActiveTime();
    }

    /* function to list all the roles */

    public function listRole() {
        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        /* checking user has privilige for the Manage Role */
        if ($data['user_account']['role_id'] != 1) {
            /* an admin which is not super admin not privileges to access Manage Role */
            /* setting session for displaying notiication message. */
            $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage role!</span>");
            redirect(base_url() . "backend/home");
        }

        if (count($_POST) > 0) {
            if (isset($_POST['btn_delete_all'])) {

                /* getting all ides selected */
                $arr_role_ids = $this->input->post('checkbox');
                if (count($arr_role_ids) > 0) {
                    $role_assigned = 0;
                    foreach ($arr_role_ids as $key => $role_id) {
                        /* checking Role is assigned or not for any user */
                        $condition_array = array("role_id" => intval($role_id));

                        $arr_admin_detail = $this->common_model->getRecords("mst_users", "", $condition_array);
                        if (count($arr_admin_detail) > 0) {
                            $role_assigned = 1;
                            unset($arr_role_ids[$key]);
                        }
                    }
                    if (count($arr_role_ids) > 0) {
                        /* deleting the role old priviliges */
                        $this->common_model->deleteRows($arr_role_ids, "mst_role", "role_id");
                    }

                    /* if role is assinned any one of the user then settting message. */
                    if ($role_assigned) {
                        $this->session->set_userdata("msg", "<span class='error'>One or more roles are not deleted as it is assigned to one or more user, to delete role it should not be assigned to any user!</span>");
                    } else {
                        $this->session->set_userdata("msg", "<span class='success'>Role deleted successfully!</span>");
                    }
                }
            }
        }


        $data['title'] = "Manage Roles";
        $data['arr_roles'] = $this->common_model->getRecords('mst_role');
        $this->load->view('backend/role/list', $data);
    }

    /* function to add and edit the role */

    public function addRole($edit_id = '') {

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        /* checking user has privilige for the Manage Role */
        if ($data['user_account']['role_id'] != 1) {
            /* an admin which is not super admin not privileges to access Manage Role */
            /* setting session for displaying notiication message. */
            $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage role!</span>");
            redirect(base_url() . "backend/home");
        }

        if (count($_POST) > 0) {
            if ($this->input->post('role_name') != "") {
                if ($this->input->post('edit_id') != '') {
                    /* setting session for displaying notiication message. */
                    $this->session->set_userdata('msg', "<span class='success'>Global setting parameter updated successfully!</span>");
                    $arr_to_update = array(
                        "role_name" => mysql_real_escape_string(str_replace('"', '&quot;', $this->input->post('role_name')))
                    );
                    /* condition to update record	 */
                    $condition_array = array('role_id' => intval(base64_decode($this->input->post('edit_id'))));
                    /* updating the role name value into database */
                    $this->common_model->updateRow('mst_role', $arr_to_update, $condition_array);
                    /* deleting the role old priviliges */
                    $this->common_model->deleteRows(array(base64_decode($_POST['edit_id'])), "trans_role_privileges", "role_id");
                    /* inserting the role new priviliges */
                    $role_privileges = $this->input->post('role_privileges');
                    foreach ($role_privileges as $privilege) {
                        $privilege_to_insert = array("role_id" => base64_decode($_POST['edit_id']), "privilege_id" => $privilege);
                        $this->common_model->insertRow($privilege_to_insert, "trans_role_privileges");
                    }
                    $this->session->set_userdata("msg", "<span class='success'>Role updated successfully!</span>");
                } else {
                    /* inserting new role into database */
                    $arr_to_insert = array("role_name" => mysql_real_escape_string($_POST['role_name']));
                    $last_insert_id = $this->common_model->insertRow($arr_to_insert, "mst_role");
                    /* inserting priviges for Role */
                    $role_privileges = $this->input->post('role_privileges');
                    foreach ($role_privileges as $privilege) {
                        $privilege_to_insert = array("role_id" => $last_insert_id, "privilege_id" => $privilege);
                        $this->common_model->insertRow($privilege_to_insert, "trans_role_privileges");
                    }
                    $this->session->set_userdata("msg", "<span class='success'>Role added successfully!</span>");
                }
                redirect(base_url() . "backend/role/list");
            }
        }

        $arr_privileges = array();
        /* getting all privileges  */
        $data['arr_privileges'] = $this->common_model->getRecords('mst_privileges');
        if (($edit_id != '')) {
            $data['title'] = "Edit Role";
            $data['edit_id'] = $edit_id;
            $data['arr_role'] = $this->common_model->getRecords("mst_role", "", array("role_id" => intval(base64_decode($edit_id))));
            // single row fix
            $data['arr_role'] = end($data['arr_role']);
            /* getting role privileges  */
            $arr_role_privileges = $this->common_model->getRecords("trans_role_privileges", "privilege_id", array("role_id" => intval(base64_decode($edit_id))));
            foreach ($arr_role_privileges as $role_privilege) {
                $data['arr_role_privileges'][] = $role_privilege['privilege_id'];
            }
        } else {
            $data['title'] = "Add Role";
            $data['edit_id'] = '';
        }
        $this->load->view('backend/role/add', $data);
    }

    public function checkRole() {
        if ($this->input->post('type') == "edit") {
            /* checking role is already exist or not when role is editing */
            if (strtolower($this->input->post('role_name')) == strtolower($this->input->post('old_role_name'))) {
                echo "true";
            } else {
                $condition_array = array("role_name" => mysql_real_escape_string($this->input->post('role_name')));
                $arr_role_detail = $this->common_model->getRecords('mst_role', '', $condition_array);
                if (count($arr_role_detail) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
        } else {
            /* checking role is already exist or not when new role is adding */
            $condition_array = array("role_name" => mysql_real_escape_string($this->input->post('role_name')));
            $arr_role_detail = $this->common_model->getRecords('mst_role', '', $condition_array);
            if (count($arr_role_detail) == 0) {
                echo "true";
            } else {
                echo "false";
            }
        }
    }

}
