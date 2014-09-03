<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set("display_errors", "on");

class Trusted_Contacts extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("common_model");
        $this->load->language('trusted-contacts');
		UpdateActiveTime();
    }

    /* Invite friend to register our site */

    function inviteFriend() {

        /* multi language keywords file */
        $this->load->language('common');

        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }
        $data = $this->common_model->commonFunction();
        $data['title'] = 'Trusted prople';
        $data['menu_active'] = 'trusted';
        $data['user_session'] = $this->session->userdata('user_account');

        $this->load->model("user_model");
        $this->load->model("trusted_contacts_model");
        /* include required js files */
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>'));

        if ($this->input->post('btn_invite') != '') {

            $friends_email = $this->input->post('friends_email');
            $friends_name = $this->input->post('friends_name');

            if ($friends_email != '') {

                $table_to_pass = 'trusted_people';
                $fields_to_pass = 'trust_id,invitation_from,invitation_to';
                $condition_to_pass = array('friend_email' => $friends_email, 'invitation_from' => $data['user_session']['user_id']);
                $trusted_people_data = array();
                $trusted_people_data = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);

                /* first check new email is already registered or not */
                $table_to_pass = 'mst_users';
                $fields_to_pass = 'user_id,user_email';
                $condition_to_pass = array('user_email' => $friends_email);
                $already_registered_user = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);

                if (count($already_registered_user) > 0) {
                    /* If email is already register add trust only */
                    if (count($trusted_people_data) < 1) {
                        /* If not already asked for trust then add record to the trusted_people table */
                        $table_name = 'trusted_people';
                        $insert_data = array(
                            'invitation_from' => mysql_real_escape_string($data['user_session']['user_id'])
                            , 'invitation_to' => $already_registered_user[0]['user_id']
                            , 'friend_email' => mysql_real_escape_string($friends_email)
                            , 'status' => 'T'
                            , 'is_requested' => '1'
                            , 'updated_on' => mysql_real_escape_string(date('Y-m-d H:i:s'))
                        );
                        $last_insert_trust_id = $this->common_model->insertRow($insert_data, $table_name);
                    }

                    $this->session->set_userdata('msg', 'That mail is already registered to ' . $data['global']['site_title'] . ' Added trust and asked that person to trust you back.');
                    redirect(base_url() . 'trusted-contacts/invite-friend');

                    /* If email is not register then send invitation */
                } else {

                    /* Send email to notification to invite to register and trust */

                    $email_update_link = '<a href="' . base_url() . 'signin">Click here.</a>';
                    if (isset($lang_id) && $lang_id != '') {
                        $lang_id = $this->session->userdata('lang_id');
                    } else {
                        $lang_id = 17; // Default is 17(English)
                    }

                    $activation_code = $data['user_session']['user_id'];
                    $base_url = '<a href="' . base_url() . '">"' . base_url() . '"</a>';
                    $activation_link = '<a href="' . base_url() . 'trusted/register/' . base64_encode($activation_code) . '">Click here</a>';

                    $reserved_words = array(
                        "||FRIEND_NAME||" => $friends_name,
                        "||USER_NAME||" => mysql_real_escape_string($data['user_session']['user_name']),
                        "||ACTIVATION_LINK||" => $activation_link,
                        "||SITE_URL||" => mysql_real_escape_string(base_url()),
                        "||SITE_TITLE||" => mysql_real_escape_string($data['global']['site_title']),
                        "||SITE_PATH||" => mysql_real_escape_string($base_url)
                    );

                    $template_title = 'invite-trusted-people';
                    $arr_emailtemplate_data = $this->common_model->getEmailTemplateInfo($template_title, $lang_id, $reserved_words);
                    $recipeinets = $friends_email;
                    $from = array("email" => $data['global']['site_email'], "name" => $data['global']['site_title']);
                    $subject = $arr_emailtemplate_data['subject'];
                    $message = stripcslashes($arr_emailtemplate_data['content']);
                    $mail = $this->common_model->sendEmail($recipeinets, $from, $subject, $message);
                    if ($mail) {
                        $this->session->set_userdata('msg', 'You have invited ' . $friends_email . ' to ' . $data['global']['site_title']);
                        redirect(base_url() . "trusted-contacts/invite-friend");
                    }
                }
            }
        }/* main if */

        /* Get user information */
        $table_to_pass = 'mst_users';
        $fields_to_pass = 'user_id,first_name,last_name,user_email,user_name,user_type,user_status,profile_picture,gender';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_data = array();
        $arr_user_data = $this->user_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        $data['arr_user_data'] = $arr_user_data[0];

        /* Get count and list of trusted prople */
        $user_id = $data['user_session']['user_id'];
        $user_name = $data['user_session']['user_name'];
        $data['arr_people_you_trust_list'] = $this->trusted_contacts_model->getPeopleYouTrustList($user_id);
        $data['arr_people_trust_you_list'] = $this->trusted_contacts_model->getPeopleTrustYouList($user_id);
		
		/* Get count of confirmed trades */
		$this->load->model('home_model');
		for($i=0;$i<count($data['arr_people_you_trust_list']);$i++)
		{
			$data['arr_people_you_trust_list'][$i]['confirmed_trade_count'] = $this->home_model->getConfirmedTradeCount($data['arr_people_you_trust_list'][$i]['invitation_to']);
		}
		for($i=0;$i<count($data['arr_people_trust_you_list']);$i++)
		{
			$data['arr_people_trust_you_list'][$i]['confirmed_trade_count'] = $this->home_model->getConfirmedTradeCount($data['arr_people_trust_you_list'][$i]['invitation_from']);
		}

        //echo "<pre>";print_r($data);exit;		

        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/trusted-people', $data);
        $this->load->view('front/includes/footer');
    }

    /* Register trusted people */

    function trustedRegister($user_id = '') {

        /* multi language keywords file */
        $this->load->language('common');
        $this->load->language('signup');

        $data = $this->common_model->commonFunction();
        $data['title'] = 'Trusted prople';
        $data['menu_active'] = 'trusted';
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");
        $this->load->model("trusted_contacts_model");

        $user_id = base64_decode($user_id);

        /* Get user information */
        $table_to_pass = 'mst_users';
        $fields_to_pass = 'user_id,first_name,last_name,user_email,user_name,user_type,user_status,profile_picture,gender';
        $condition_to_pass = array("user_id" => $user_id);
        $arr_user_data = array();
        $arr_user_data = $this->user_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        $data['arr_user_data'] = $arr_user_data[0];

        $this->session->set_userdata('activation_success', "You have been invited to join " . $data['global']['site_title'] . " by " . $data['arr_user_data']['user_name'] . ". You may register below. ");

        $data['title'] = 'signup';
        $data['menu_active'] = "";
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/login/sign-up.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>', '<script src="' . base_url() . 'media/front/js/facebook-config.js"></script>', '<script src="' . base_url() . 'media/front/js/facebook-connect.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.password.js"></script>', '<script src="' . base_url() . 'media/front/js/captcha.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.colorbox.js"></script>'));
        $data['include_css'] = implode("\n", array('<link rel="stylesheet" href="' . base_url() . 'media/front/css/jquery.validate.password.css" />', '<link rel="stylesheet" href="' . base_url() . 'media/front/css/colorbox.css" />'));
        if ($this->input->post('user_email') != '') {

            $table = 'mst_users';
            $activation_code = time() . rand();
            $fields = array(
                'user_email' => mysql_real_escape_string($this->input->post('user_email')),
                'user_name' => mysql_real_escape_string($this->input->post('user_name')),
                'user_password' => mysql_real_escape_string(md5($this->input->post('user_password'))),
                'user_type' => '1',
                'user_status' => '0',
                'activation_code' => mysql_real_escape_string($activation_code),
                'email_verified' => '0',
                'register_date' => mysql_real_escape_string(date("Y-m-d H:i:s")),
                'ip_address' => mysql_real_escape_string($_SERVER['REMOTE_ADDR'])
            );
            $this->load->model('register_model');
            $condition = '';
            $insert_id = $this->common_model->insertRow($fields, $table);


            /* Add trust in trusted_people */

            /* Add  trust on registered user by invited user */
            $table_name = 'trusted_people';
            $insert_data = array(
                'invitation_from' => mysql_real_escape_string($user_id)
                , 'invitation_to' => $insert_id
                , 'friend_email' => mysql_real_escape_string($this->input->post('user_email'))
                , 'status' => 'T'
                , 'is_requested' => '2'
                , 'updated_on' => mysql_real_escape_string(date('Y-m-d H:i:s'))
            );
            $last_insert_trust_id = $this->common_model->insertRow($insert_data, $table_name);

            /* Add trust back to invited user */
            $table_name = 'trusted_people';
            $insert_data = array(
                'invitation_from' => mysql_real_escape_string($insert_id)
                , 'invitation_to' => $user_id
                , 'friend_email' => mysql_real_escape_string($data['arr_user_data']['user_email'])
                , 'status' => 'T'
                , 'is_requested' => '2'
                , 'updated_on' => mysql_real_escape_string(date('Y-m-d H:i:s'))
            );
            $last_insert_trust_id = $this->common_model->insertRow($insert_data, $table_name);


            /* insert email id to email log table for log maintaince */
            if ($insert_id != '') {
                $user_registration_id = $insert_id;
                $table_name = 'secondary_email';
                $field_names = array('email_log_id' => '', 'user_id' => mysql_real_escape_string($insert_id), 'secondary_email' => mysql_real_escape_string($this->input->post('user_email')), 'email_send_on' => mysql_real_escape_string(date('Y-m-d H:i:s')), 'activation_code' => mysql_real_escape_string($activation_code), 'status' => '0');
                $insert_id = $this->common_model->insertRow($field_names, $table_name);

                /* get the geo location for log maintaince */

                /* ip address of system */
                if (($_SERVER['REMOTE_ADDR'] == '192.168.2.1') || ($_SERVER['REMOTE_ADDR'] == '182.72.122.106') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.96')) {
                    $ip_address = "182.72.122.106";
                } else {
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                }

                if ($ip_address != '') {
                    $arr_geo_data = geoip_record_by_name($ip_address);
                    if ($arr_geo_data != "") {
                        $fields = array('geo_location_id' => '',
                            'user_id' => $user_registration_id,
                            'ip' => $ip_address,
                            'city' => mysql_real_escape_string($arr_geo_data['city']),
                            'regin_code' => mysql_real_escape_string($arr_geo_data['region']),
                            'region' => mysql_real_escape_string(geoip_region_name_by_code($arr_geo_data['country_code'], $arr_geo_data['region'])),
                            'country' => mysql_real_escape_string($arr_geo_data['country_name']),
                            'country_code' => mysql_real_escape_string($arr_geo_data['country_code']),
                            'country_code3' => mysql_real_escape_string($arr_geo_data['country_code3']),
                            'lattitude' => mysql_real_escape_string($arr_geo_data['latitude']),
                            'longitude' => mysql_real_escape_string($arr_geo_data['longitude'])
                        );
                        $table = 'geo_location';
                        $last_insert_id = $this->common_model->insertRow($fields, $table);

                        /* insert login details to user_sign_in_log table */
                        if ($last_insert_id != '') {
                            $fields = array('log_id' => '', 'user_id' => $user_registration_id, 'geo_location_id' => $last_insert_id, 'last_login' => 'NOW()', 'last_logout' => "NOW()");
                            $table = 'user_sign_in_log';
                            $this->common_model->insertRow($fields, $table);
                        }
                    }
                }
                /* get the geo location for log maintaince */
            }

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
                //"||SAFTY_AND_SECURITY||" => mysql_real_escape_string(base_url . 'cms/17/about'),
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
                $this->session->set_userdata('register_success', "Account created successfully.check your e-mail <strong>" . $this->input->post('user_email') . "</strong> to verify the address.You are now logged in and you can start buying and selling bitcoins? <a href='" . base_url() . "cms/17/guides' target='_blank' >Quick start guide to buy bitcoins on '" . $data['global']['site_title'] . "'</a>");
                redirect(base_url() . "signin");
            }
        }
        $this->load->view('front/includes/header', $data);
        $this->load->view('front/registration/trustregister');
        $this->load->view('front/includes/footer');
    }

    /* Update feedback for trusted contacts */

    function trustedFeedback($trust_id) {

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");
        $this->load->model("trusted_contacts_model");

        if (isset($_POST['btn_register']) || isset($_POST['rating'])) {

            $table_name = 'trusted_people';
            $update_data = array(
                'status' => $this->input->post('rating'),
				'feedback_comment' => $this->input->post('feedback'),
                'updated_on' => mysql_real_escape_string(date('Y-m-d H:i:s'))
            );
            $condition = array("trust_id" => $trust_id);
            $last_insert_trust_id = $this->common_model->updateRow($table_name, $update_data, $condition);

            redirect(base_url() . 'trusted-contacts/invite-friend');
        }
    }

	
	function updateFeedback() {

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");
        $this->load->model("trusted_contacts_model");

        if (isset($_POST['btn_register']) || isset($_POST['rating'])) {
		
			//echo "<pre>";print_r($_POST);exit;
            $table_name = 'trusted_people';
			if($this->input->post('trust_id') != '') {
				$update_data = array(
					'type' => $this->input->post('type'),
					'trade_volume' => $this->input->post('trade_volume'),
					'status' => $this->input->post('rating'),
					'feedback_comment' => $this->input->post('feedback'),
					'updated_on' => mysql_real_escape_string(date('Y-m-d H:i:s'))
				);
				$condition = array("trust_id" => $this->input->post('trust_id'));
				$last_insert_trust_id = $this->common_model->updateRow($table_name, $update_data, $condition);			
			} else {
			
				$fields = array(
					'invitation_from' => $data['user_session']['user_id'],
					'invitation_to' => $this->input->post('update_for'),
					'status' => $this->input->post('rating'),
					'feedback_comment' => $this->input->post('feedback'),					
				);			
				$last_insert_id = $this->common_model->insertRow($fields, $table);
			}
			$this->session->set_userdata("msg", "Feedback updated successfully!");
            
        }
    }


    /* Update feedback for trusted contacts */

    function trustedFeedbackRequest($trust_id) {

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");
        $this->load->model("trusted_contacts_model");

        if (isset($_POST['btn_register']) || isset($_POST['rating'])) {

            //echo "<pre>";print_r($_POST);exit;

            $table_name = 'trusted_people';
            $update_data = array(
                'is_requested' => '2'
                , 'updated_on' => mysql_real_escape_string(date('Y-m-d H:i:s'))
            );
            $condition = array("trust_id" => $trust_id);
            $last_update_trust_id = $this->common_model->updateRow($table_name, $update_data, $condition);


            $table_name = 'trusted_people';
            $insert_data = array(
                'invitation_from' => mysql_real_escape_string($data['user_session']['user_id'])
                , 'invitation_to' => $this->input->post('user_id')
                , 'friend_email' => $this->input->post('user_email')
                , 'status' => 'T'
                , 'is_requested' => '2'
                , 'updated_on' => mysql_real_escape_string(date('Y-m-d H:i:s'))
            );
            $last_insert_trust_id = $this->common_model->insertRow($insert_data, $table_name);

            $this->session->unset_userdata('trust');

            redirect(base_url() . 'trusted-contacts/invite-friend');
        }
    }

    /* Show Trusted Advertisements */

    function trustedBitcoins() {

        /* multi language keywords file */
        $this->load->language('common');
        $this->load->language('signup');

        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }

        $data = $this->common_model->commonFunction();
        $data['title'] = 'Trade bitcoins with trusted people';
        $data['menu_active'] = 'trusted-ads';
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");
        $this->load->model("trusted_contacts_model");

        $user_id = $data['user_session']['user_id'];


        /* Get count and list of trusted prople */
        $user_id = $data['user_session']['user_id'];
        $user_name = $data['user_session']['user_name'];
        $data['arr_trade_trusted_sell'] = $this->trusted_contacts_model->getTradeTrustedSell($user_id);
        $data['arr_trade_trusted_buy'] = $this->trusted_contacts_model->getTradeTrustedBuy($user_id);


        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/trusted-bitcoins');
        $this->load->view('front/includes/footer');
    }

    /* Show trusted people list at backend */

    function trusted_to() {
        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $this->load->model("trusted_contacts_model");

        /* Delete selected */
        if (count($_POST) > 0) {
            if (isset($_POST['btn_delete_all'])) {
                /* getting all ides selected */
                $arr_user_ids = $this->input->post('checkbox');
                if (count($arr_user_ids) > 0) {

                    if (count($arr_user_ids) > 0) {
                        /* deleting the user selected */
                        $this->common_model->deleteRows($arr_user_ids, "trusted_people", "trust_id");
                    }
                    $this->session->set_userdata("msg", "Trusted people deleted successfully!");
                }
            }
        }

        /* checking user has privilige for the Manage Admin */
        //if ($data['user_account']['role_id'] != 1) {
        /* an admin which is not super admin not privileges to access Manage Role
          setting session for displaying notiication message. */
        //$this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
        //redirect(base_url() . "backend/home");
        //}

        /* using the user model */
        $this->load->model('user_model');
        $data['title'] = "Manage Trusted people";
        $data['arr_user_list'] = $this->trusted_contacts_model->getTrustedToPeopleDetails('');
        $this->load->view('backend/account/trusted-list', $data);
    }

    /* Show trusted advertise list at backend */

    function trusted_ads() {
        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $this->load->model("trusted_contacts_model");

        /* checking user has privilige for the Manage Admin */
        //if ($data['user_account']['role_id'] != 1) {
        /* an admin which is not super admin not privileges to access Manage Role
          setting session for displaying notiication message. */
        //$this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
        // redirect(base_url() . "backend/home");
        //}

        /* using the user model */
        $this->load->model('user_model');
        $data['title'] = "Trusted advertisements";
        $data['arr_trusted_advertise_list'] = $this->trusted_contacts_model->getTrustedTradeList('');
        $this->load->view('backend/account/trusted-ads', $data);
    }
	
	function userFeedback($user_name = '', $type = '', $pg = '')
	{
		/* multi language keywords file */
        $this->load->language('common');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }

        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['menu_active'] = "";
        $this->load->model("user_model");		
		
		/* Get user details */
        $table_to_pass = 'mst_users';
        $fields_to_pass = 'user_id,first_name,user_email,email_verified,user_name,user_type,user_status,profile_picture,register_date';
        $condition_to_pass = array("user_name" => $user_name);
        $arr_user_data = array();
        $arr_user_data = $this->user_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
		$data['arr_user_data'] = $arr_user_data[0];
		
		if($type == 'unconf')
		{
			$feedback_type = 'U';
		}
		else
		{
			$feedback_type = 'C';
		}
				
		/* get all unconfirmed feedback */
		$this->load->model("trusted_contacts_model");	
        $arr_feedback_list_count = $this->trusted_contacts_model->getFeedbackDetails($arr_user_data[0]['user_id'],$feedback_type);
        //echo "<pre>";print_r($data);exit;
		
		/* [Start:: Pagination code] */
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'profile/'.$user_name.'/feedback/'.$type;
        $data['count'] = count($arr_feedback_list_count);
        $config['total_rows'] = count($arr_feedback_list_count);
        $config['per_page'] = $data['global']['per_page_record'];
        $config['cur_page'] = $pg;
        $config['num_links'] = 4;
        $config['cur_tag_open'] = '<strong><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></strong>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<div class="left_scroll_img">';
        $config['prev_tag_close'] = '</div>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<div class="right_scroll_img">';
        $config['next_tag_close'] = '</div>';
        $config['full_tag_open'] = '<div class="last_btn_sec"><div class="pagenBox">';
        $config['full_tag_close'] = '</div></div>';
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $arrayPagination = array("limit" => $config['per_page'], "offset" => $pg);
        $data['arr_feedback_list'] = $this->trusted_contacts_model->getFeedbackDetails($arr_user_data[0]['user_id'],$feedback_type);
        $data['page'] = $pg;
        /* [End:: Pagination code] */
		
		$this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/feedback');
        $this->load->view('front/includes/footer');
		
	}

}

?>