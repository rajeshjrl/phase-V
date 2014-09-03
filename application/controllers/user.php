<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {
    /* An Controller having functions to manage admin user login,add edit, forgot password, profile and activating user account */

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
		UpdateActiveTime();
    }

    /* function to list all the users */

    public function listUser() {
        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        /* checking user has privilige for the Manage Admin */
        /* if ($data['user_account']['role_id'] != 1) {
          #an admin which is not super admin not privileges to access Manage Role
          #setting session for displaying notiication message.
          $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
          redirect(base_url() . "backend/home");
          }
         */
        if (count($_POST) > 0) {
            if (isset($_POST['btn_delete_all'])) {
                /* getting all ides selected */
                $arr_user_ids = $this->input->post('checkbox');
                if (count($arr_user_ids) > 0) {
                    if (count($arr_user_ids) > 0) {
                        /* deleting the user selected */
                        $this->common_model->deleteRows($arr_user_ids, "mst_users", "user_id");
                    }
                    $this->session->set_userdata("msg", "<span class='success'>User deleted successfully!</span>");
                }
            }
        }
        /* using the user model */
        $this->load->model('user_model');
        $data['title'] = "Manage User";
        $data['arr_user_list'] = $this->user_model->getUserDetails('');
        $this->load->view('backend/user/list', $data);
    }

    public function changeStatus() {
        if ($this->input->post('user_id') != "") {
            /* updating the user status. */
            $arr_to_update = array(
                "user_status" => $this->input->post('user_status')
            );
            /* condition to update record for the admin status */
            $condition_array = array('user_id' => intval($this->input->post('user_id')));
            /* updating the global setttings parameter value into database */
            $this->common_model->updateRow('mst_users', $arr_to_update, $condition_array);
            echo json_encode(array("error" => "0", "error_message" => ""));
        } else {
            /* if something going wrong providing error message. */
            echo json_encode(array("error" => "1", "error_message" => "Sorry, your request can not be fulfilled this time. Please try again later"));
        }
    }

    /* function to check existancs of username */

    public function checkUserUsername() {
        if (isset($_POST['type'])) {
            /* checking admin user name already exist or not for edit Admin */
            if (strtolower($this->input->post('user_name')) == strtolower($this->input->post('old_username'))) {
                echo "true";
            } else {
                $arr_admin_detail = $this->common_model->getRecords('mst_users', 'user_name', array("user_name" => mysql_real_escape_string($this->input->post('user_name'))));
                if (count($arr_admin_detail) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
        } else {
            /* checking admin user name already exist or not for add admin */
            $arr_admin_detail = $this->common_model->getRecords('mst_users', 'user_name', array("user_name" => mysql_real_escape_string($this->input->post('user_name'))));

            if (count($arr_admin_detail) == 0) {
                echo "true";
            } else {
                echo "false";
            }
        }
    }

    /* function to check existancs of user email */

    public function checkUserEmail() {
        if (isset($_POST['type'])) {
            /* checking admin email already exist or not for edit Admin */
            if (strtolower($this->input->post('user_email')) == strtolower($this->input->post('old_email'))) {
                echo "true";
            } else {
                $arr_admin_detail = $this->common_model->getRecords('mst_users', 'user_email', array("user_email" => mysql_real_escape_string($this->input->post('user_email'))));
                if (count($arr_admin_detail) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
        } else {
            /* checking admin email already exist or not for add admin */
            $arr_admin_detail = $this->common_model->getRecords('mst_users', 'user_email', array("user_email" => mysql_real_escape_string($this->input->post('user_email'))));
            if (count($arr_admin_detail) == 0) {
                echo "true";
            } else {
                echo "false";
            }
        }
    }

    /* function to add new user from backend */

    public function addUser() {
        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        /* getting common data */
        $data = $this->common_model->commonFunction();

        #checking user has privilige for the Manage Admin
        /*        if ($data['user_account']['role_id'] != 1) {
          #an admin which is not super admin not privileges to access Manage Admin
          #setting session for displaying notiication message.
          $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
          redirect(base_url() . "backend/home");
          }
         */
        if (count($_POST) > 0) {
            if ($this->input->post('btn_submit') != "") {
                $activation_code = time();
                /* user record to add */
                $arr_to_insert = array(
                    "user_name" => mysql_real_escape_string($this->input->post('user_name')),
                    "first_name" => mysql_real_escape_string($this->input->post('first_name')),
                    "last_name" => mysql_real_escape_string($this->input->post('last_name')),
                    "user_email" => mysql_real_escape_string($this->input->post('user_email')),
                    "user_password" => md5($this->input->post('user_password')),
                    'user_type' => 1,
                    'user_status' => 0,
                    'activation_code' => $activation_code,
                    'email_verified' => 0,
                    'role_id' => 0,
                    'register_date' => date("Y-m-d H:i:s")
                );
                /* inserting admin details into the dabase */
                $last_insert_id = $this->common_model->insertRow($arr_to_insert, "mst_users");


                /* Send account activation email to user */
                $login_link = '<a href="' . base_url() . 'signin">Click here.</a>';
                if (isset($lang_id) && $lang_id != '') {
                    $lang_id = $this->session->userdata('lang_id');
                } else {
                    $lang_id = 17; /* Default is 17(English) */
                }
                $base_url = base_url();
                $activation_link = '<a href="' . base_url() . 'user-activation/' . $activation_code . '">Click here</a>';
                /* additional links in email */
                $site_title = '<a href="' . base_url() . '">sell&buybitcoin</a>';
                $quick_start_guide = '<a href="' . base_url() . 'cms/17/guides">guides</a>';
                $faq = '<a href="' . base_url() . 'cms/17/faq">Faqs</a>';
                $about_us = '<a href="' . base_url() . 'cms/17/about">About</a>';
                $discussion_forum = '<a href="' . base_url() . 'discussion-forum">Discussion forum</a>';

                $reserved_words = array(
                    "||USER_NAME||" => mysql_real_escape_string($this->input->post('user_name')),
                    "||USER_EMAIL||" => mysql_real_escape_string($this->input->post('user_email')),
                    "||ACTIVATION_LINK||" => mysql_real_escape_string($activation_link),
                    "||SITE_URL||" => mysql_real_escape_string(base_url()),
                    "||SITE_TITLE||" => mysql_real_escape_string($data['global']['site_title']),
                    "||QUICK_GUIDE||" => mysql_real_escape_string($quick_start_guide),
                    "||FAQS||" => mysql_real_escape_string($faq),
                    "||DISCUSSION_FORUM||" => mysql_real_escape_string($discussion_forum),
                    "||ABOUT_US||" => mysql_real_escape_string($about_us)
                );
                $template_title = 'registration-successful';
                $arr_emailtemplate_data = $this->common_model->getEmailTemplateInfo($template_title, $lang_id, $reserved_words);
                $recipeinets = mysql_real_escape_string($this->input->post('user_email'));
                $from = array("email" => $data['global']['site_email'], "name" => $data['global']['site_title']);
                $subject = $arr_emailtemplate_data['subject'];
                $message = stripcslashes($arr_emailtemplate_data['content']);
                $mail = $this->common_model->sendEmail($recipeinets, $from, $subject, $message);
                if ($mail) {
                    $this->session->set_userdata("msg", "<span class='success'>User added successfully! Verification email has been sent to <strong>'" . $this->input->post('user_email') . "'</strong></span>");
                    redirect(base_url() . "backend/user/list");
                }
            }
        }
        $arr_privileges = array();
        /* getting all privileges */
        $data['arr_privileges'] = $this->common_model->getRecords('mst_privileges');
        $data['title'] = "Add User";
        $data['arr_roles'] = $this->common_model->getRecords("mst_role");
        $this->load->view('backend/user/add', $data);
    }

    /* function to activate user account */

    public function activateAccount($activation_code) {
        $fields_to_pass = array('user_id', 'first_name', 'last_name', 'user_name', 'user_email', 'user_type', 'email_verified', 'user_status');
        /* get user details to verify the email address */
        $arr_login_data = $this->common_model->getRecords("mst_users", $fields_to_pass, array("activation_code" => $activation_code));
        if (count($arr_login_data)) {
            /* if email already verified */
            if ($arr_login_data[0]['email_verified'] == 1) {
                $this->session->set_userdata('msg', '<div class="alert alert-success">Your have already activated your account.</div>');
            } else {
                /* if email not verified. */
                $update_data = array('email_verified' => '1', 'user_status' => '1');
                $this->common_model->updateRow("mst_users", $update_data, array("activation_code" => $activation_code));
                $this->session->set_userdata('msg', '<div class="alert alert-success"><strong>Congratulation!</strong> Your account has been activated successfully.</div>');
            }
        } else {
            /* if any error invalid activation link found account */
            $this->session->set_userdata('msg', '<div class="alert alert-error">Invalid activation code.</div>');
        }
        redirect(base_url() . "backend/login");
    }

    public function editUser($edit_id = '') {
        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        $data = $this->common_model->commonFunction();

        /* checking user has privilige for the Manage Admin */
        /* if ($data['user_account']['role_id'] != 1) {
          /* an admin which is not super admin not privileges to access Manage Admin */
        /* setting session for displaying notiication message. 
          $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage admin!</span>");
          redirect(base_url() . "backend/home");
          } */

        if (count($_POST) > 0) {

            if ($this->input->post('edit_id') != "") {

                $arr_admin_detail = $this->common_model->getRecords("mst_users", "", array("user_id" => intval($this->input->post('edit_id'))));
                /* single row fix */
                $arr_admin_detail = end($arr_admin_detail);
                /* setting variable to update or add admin record. */
                if ($this->input->post('user_email') == $this->input->post('old_email')) {
                    if ($this->input->post('user_status') != "") {
                        $status = $this->input->post('user_status');
                    } else {
                        $status = 0;
                    }
                    if ($this->input->post('email_verified') != "") {
                        $email_verified = $this->input->post('email_verified');
                    } else {
                        $email_verified = 0;
                    }
                    /* $email_verified = '1'; */
                    $activation_code = $arr_admin_detail['activation_code'];
                } else {
                    $status = 0;
                    $email_verified = '0';
                    $activation_code = time();
                }
                if ($this->input->post('change_password') == 'on') {
                    $user_password = $_POST['user_password'];

                    /* if password need to change */
                    $arr_to_update = array(
                        "user_name" => mysql_real_escape_string($this->input->post('user_name')),
                        "first_name" => mysql_real_escape_string($this->input->post('first_name')),
                        "last_name" => mysql_real_escape_string($this->input->post('last_name')),
                        "user_email" => mysql_real_escape_string($this->input->post('user_email')),
                        "user_password" => md5($this->input->post('user_password')),
                        "user_status" => $status,
                        'email_verified' => $email_verified,
                        'activation_code' => $activation_code,
                        'role_id' => 0,
                    );
                } else {
                    $user_password = md5($arr_admin_detail['user_password']);
                    /* if passwording need not need to change */
                    $arr_to_update = array(
                        "user_name" => mysql_real_escape_string($this->input->post('user_name')),
                        "first_name" => mysql_real_escape_string($this->input->post('first_name')),
                        "last_name" => mysql_real_escape_string($this->input->post('last_name')),
                        "user_email" => mysql_real_escape_string($this->input->post('user_email')),
                        "user_status" => $status,
                        'email_verified' => $email_verified,
                        'activation_code' => $activation_code,
                        'role_id' => 0
                    );
                }

                /* updating the user details */

                $this->common_model->updateRow("mst_users", $arr_to_update, array("user_id" => $this->input->post('edit_id')));
                if ($this->input->post('user_email') == $this->input->post('old_email')) {

                    /* sending account updating mail to user */
                    $admin_login_link = '<a href="' . base_url() . '/signin" target="_new">Please login</a>';
                    $reserved_words = array
                        ("||SITE_TITLE||" => $data['global']['site_title'],
                        "||SITE_PATH||" => base_url(),
                        "||USER_NAME||" => $this->input->post('user_name'),
                        "||ADMIN_NAME||" => $this->input->post('first_name') . ' ' . $this->input->post('last_name'),
                        "||ADMIN_EMAIL||" => $this->input->post('user_email'),
                        "||PASSWORD||" => $user_password,
                        "||ADMIN_LOGIN_LINK||" => $admin_login_link
                    );

                    /* getting mail subect and mail message using email template title and lang_id and reserved works */
                    $email_content = $this->common_model->getEmailTemplateInfo('admin-updated', 17, $reserved_words);

                    /* sending the mail to deleting user */
                    /* 1.recipient array. 2.From array containing email and name, 3.Mail subject 4.Mail Body */
                    $mail = $this->common_model->sendEmail(array($this->input->post('user_email')), array("email" => $data['global']['site_email'], "name" => $data['global']['site_title']), $email_content['subject'], stripcslashes($email_content['content']));
                } else {
                    /* sending account verification link mail to user */
                    $lang_id = 17;
                    $activation_link = '<a href="' . base_url() . 'backend/user/account-activate/' . $activation_code . '">Activate Account</a>';
                    $reserved_words = array
                        ("||SITE_TITLE||" => $data['global']['site_title'],
                        "||SITE_PATH||" => base_url(),
                        "||USER_NAME||" => $this->input->post('user_name'),
                        "||ADMIN_NAME||" => $this->input->post('first_name') . ' ' . $this->input->post('last_name'),
                        "||ADMIN_EMAIL||" => $this->input->post('user_email'),
                        "||PASSWORD||" => $user_password,
                        "||ACTIVATION_LINK||" => $activation_link
                    );
                    /* getting mail subect and mail message using email template title and lang_id and reserved works */
                    $email_content = $this->common_model->getEmailTemplateInfo('admin-email-updated', 17, $reserved_words);
                    /* sending the mail to deleting user */
                    /* 1.recipient array. 2.From array containing email and name, 3.Mail subject 4.Mail Body */
                    $mail = $this->common_model->sendEmail(array($this->input->post('user_email')), array("email" => $data['global']['site_email'], "name" => $data['global']['site_title']), $email_content['subject'], stripcslashes($email_content['content']));
                }
                $this->session->set_userdata("msg", "<span class='success'>User updated successfully!</span>");
                redirect(base_url() . "backend/user/list");
            }
        }
        $arr_privileges = array();
        /* getting all privileges */
        $data['arr_privileges'] = $this->common_model->getRecords('mst_privileges');
        /* getting admin details from $edit_id from function parameter */
        $data['arr_admin_detail'] = $this->common_model->getRecords("mst_users", "", array("user_id" => intval(base64_decode($edit_id))));
        /* single row fix */
        $data['arr_admin_detail'] = end($data['arr_admin_detail']);
        $data['title'] = "edit User";
        $data['edit_id'] = $edit_id;
        $data['arr_roles'] = $this->common_model->getRecords("mst_role");
        $this->load->view('backend/user/edit', $data);
    }

    /* function to display admin profile */

    public function userProfile($user_id) {
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        $user_id = base64_decode($user_id);
        /* using the admin model */
        $this->load->model('user_model');
        $data = $this->common_model->commonFunction();

        $arr_privileges = array();
        /* getting all privileges */
        $data['arr_privileges'] = $this->common_model->getRecords('mst_privileges');
        /* getting admin details from user id from function parameter */
        $data['arr_user_detail'] = $this->user_model->getUserDetails($user_id);
        /* single row fix */
        $data['arr_user_detail'] = end($data['arr_user_detail']);
        $data['title'] = "Profile";
        $this->load->view('backend/user/user-profile', $data);
    }

    /* function to delete user */

    public function deletion_list() {
        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        if (count($_POST) > 0) {
            if (isset($_POST['btn_delete_all'])) {
                /* getting all ides selected */
                $arr_user_ids = $this->input->post('checkbox');
                if (count($arr_user_ids) > 0) {

                    if (count($arr_user_ids) > 0) {
                        /* deleting the user selected */
                        $this->common_model->deleteRows($arr_user_ids, "user_deletion_requests", "id");
                    }
                    $this->session->set_userdata("msg", "<span class='success'>User deletion request deleted successfully!</span>");
                }
            }
        }

        /* checking user has privilige for the Manage Admin
          if ($data['user_account']['role_id'] != 1) {
          #an admin which is not super admin not privileges to access Manage Role
          #setting session for displaying notiication message.
          $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
          redirect(base_url() . "backend/home");
          } */

        /* using the user model */
        $this->load->model('user_model');
        $data['title'] = "User deletion request";
        $data['arr_user_list'] = $this->user_model->getUserDeletionDetails('');
        $this->load->view('backend/user/deletion-list', $data);
    }

    /* function to get the user login history */

    public function log_list() {

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        /* #checking user has privilige for the Manage Admin
          if ($data['user_account']['role_id'] != 1) {
          #an admin which is not super admin not privileges to access Manage Role
          #setting session for displaying notiication message.
          $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
          redirect(base_url() . "backend/home");
          } */

        /* using the user model */
        $this->load->model('user_model');
        $data['title'] = "User deletion request";
        $data['arr_user_list'] = $this->user_model->getUserLogDetails('');
        $this->load->view('backend/user/log-list', $data);
    }

    public function userViewRequest($user_id) {
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        $user_id = base64_decode($user_id);
        /* using the admin model */
        $this->load->model('user_model');
        $data = $this->common_model->commonFunction();
        $arr_privileges = array();
        /* getting all privileges */
        $data['arr_privileges'] = $this->common_model->getRecords('mst_privileges');
        /* getting admin details from user id from function parameter        */
        $data['arr_user_detail'] = $this->user_model->viewUserDeletionDetails($user_id);
        /* single row fix */
        $data['arr_user_detail'] = end($data['arr_user_detail']);
        $data['title'] = "View Deletion Request";
        $this->load->view('backend/user/view-request', $data);
    }

    /* function to display user deletion requests to admin */

    public function deactivateUser() {
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        if ($this->input->post('btn_submit') != '') {
            $table = 'user_deletion_requests';
            $update_data = array(
                'is_deleted' => '1',
            );
            $condition = array('id' => intval($this->input->post('edit_id')));
            $this->common_model->updateRow($table, $update_data, $condition);

            /* updating the user status. */
            $arr_to_update = array(
                "user_status" => '0',
            );
            /* condition to update record	for the admin status */
            $condition_array = array('user_id' => intval($this->input->post('user_id')));
            /* updating the global setttings parameter value into database */
            $this->common_model->updateRow('mst_users', $arr_to_update, $condition_array);
            $this->session->set_userdata("msg", "<span class='success'>User deactivated successfully!</span>");
            echo json_encode(array("error" => "0", "error_message" => ""));
        }
        redirect('backend/user/deletion-list');
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
                        $this->common_model->deleteRows($arr_user_ids, "mst_trades", "trade_id");
                    }
                    $this->session->set_userdata("msg", "<span class='success'>Trade deleted successfully!</span>");
                }
            }
        }

        /* checking user has privilige for the Manage Admin
          if ($data['user_account']['role_id'] != 1) {
          #an admin which is not super admin not privileges to access Manage Role
          #setting session for displaying notiication message.
          $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
          redirect(base_url() . "backend/home");
          } */

        /* using the user model */
        $this->load->model('user_model');
        $data['title'] = "Manage Trusted people";
        $data['arr_user_list'] = $this->user_model->getTrustedToPeopleDetails('');
        $this->load->view('backend/account/trusted-list', $data);
    }

    /* function to list all api clients */

    public function listApiClients() {
        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        if (count($_POST) > 0) {
            if (isset($_POST['btn_delete_all'])) {
                /* getting all ides selected */
                $arr_api_ids = $this->input->post('checkbox');
                if (count($arr_api_ids) > 0) {
                    if (count($arr_api_ids) > 0) {
                        /* deleting the user selected */
                        $this->common_model->deleteRows($arr_api_ids, "api_client", "api_id");
                    }
                    $this->session->set_userdata("msg", "<span class='success'>Client deleted successfully!</span>");
                }
            }
        }
        /* using the user model */
        $this->load->model('user_model');
        $data['title'] = "Manage Apps";
        $data['arr_client_api'] = $this->user_model->getclientApiDetails($user_id = '', $api_id = '');
        $this->load->view('backend/user/client-api-list', $data);
    }

    /* function to list all api clients */

    public function listApplicationClients() {
        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        if (count($_POST) > 0) {
            if (isset($_POST['btn_delete_all'])) {
                /* getting all ides selected */
                $arr_api_ids = $this->input->post('checkbox');

                if (count($arr_api_ids) > 0) {
                    if (count($arr_api_ids) > 0) {
                        /* deleting the user selected */
                        $this->common_model->deleteRows($arr_api_ids, "api_client", "api_id");
                    }
                    $this->session->set_userdata("msg", "<span class='success'>App deleted successfully!</span>");
                    redirect(base_url() . 'backend/api');
                }
            }
        }
        
        /* using the user model */
        $this->load->model('user_model');
        $data['title'] = "Manage Apps";
        
        $data['arr_app'] = $this->user_model->getAppDetails($user_id = '', $app_id = '');
//        echo 'jsk';exit;
        $this->load->view('backend/user/client-app-list', $data);
    }
}
