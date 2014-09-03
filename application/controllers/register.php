<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Register extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("common_model");
        CHECK_USER_STATUS();
		UpdateActiveTime();
    }
    
    public function userRegistrationOptions() {
    	/* checking admin is logged in or not */
    	if ($this->common_model->isLoggedIn()) {
    		redirect(base_url());
    	}
    	
    	/* multi language keywords file */
    	$this->load->language('common');
    	$this->load->language('signup');
    	
    	$data = $this->common_model->commonFunction();
    	$data['title'] = 'signup options';
    	$data['menu_active'] = "";
    	    	    	   	
    	$this->load->view('front/includes/header', $data);
    	$this->load->view('front/registration/registeroptions');
    	$this->load->view('front/includes/footer');
    }

    public function userRegistrationIndividual() {

        /* checking admin is logged in or not */
        if ($this->common_model->isLoggedIn()) {
            redirect(base_url());
        }
        /* multi language keywords file */
        $this->load->language('common');
        $this->load->language('signup');

        $data = $this->common_model->commonFunction();
        $data['title'] = 'signup as individual';
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
            /* insert email id to email log table for log maintaince */
            if ($insert_id != '') {
                $user_registration_id = $insert_id;
                $table_name = 'secondary_email';
                $field_names = array('email_log_id' => '', 'user_id' => mysql_real_escape_string($insert_id), 'secondary_email' => mysql_real_escape_string($this->input->post('user_email')), 'email_send_on' => mysql_real_escape_string(date('Y-m-d H:i:s')), 'activation_code' => mysql_real_escape_string($activation_code), 'status' => '0');
                $insert_id = $this->common_model->insertRow($field_names, $table_name);

                /* Create wallet for user start */
                $this->load->model('wallet_model');
                $user_name = mysql_real_escape_string($this->input->post('user_name'));
                $wallet_email = mysql_real_escape_string($this->input->post('user_email'));
                $wallet_password = $user_name . "@1234";

                $arr_wallet_param = array(
                    "user_id" => $user_registration_id,
                    "wallet_password" => $wallet_password,
                    "api_code" => "f6c53cbe-5d44-476f-83b1-1d2ed5b6951a",
                    "wallet_email" => $wallet_email,
                    "wallet_label" => "",
                    "wallet_private_key" => ""
                );

                $this->wallet_model->createWallet($user_registration_id, $arr_wallet_param);
                /* Create wallet for user end */

                /* get the geo location for log maintaince */

                /* ip address of system */
                if (($_SERVER['REMOTE_ADDR'] == '127.0.0.1') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.1') || ($_SERVER['REMOTE_ADDR'] == '182.72.122.106') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.96')) {
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
                            $fields = array('log_id' => '', 'user_id' => $user_registration_id, 'geo_location_id' => $last_insert_id, 'last_login' => date('Y-m-d H:i:s'));
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
                $this->session->set_userdata('register_success', "Account created successfully.check your e-mail <strong>" . $this->input->post('user_email') . "</strong> in order to activate your account then you can start buying and selling bitcoins !. Check you spam folder if you not found email in your inbox. <a href='" . base_url() . "cms/17/guides' target='_blank' >Quick start guide to buy bitcoins on '" . $data['global']['site_title'] . "'</a>");
                redirect(base_url() . "signin");
            }
        }
        $this->load->view('front/includes/header', $data);
        $this->load->view('front/registration/registerasindividual');
        $this->load->view('front/includes/footer');
    }
    
    public function userRegistrationBusiness() {
    
    	/* checking admin is logged in or not */
    	if ($this->common_model->isLoggedIn()) {
    		redirect(base_url());
    	}
    	/* multi language keywords file */
    	$this->load->language('common');
    	$this->load->language('signup');
    
    	$data = $this->common_model->commonFunction();
    	$data['title'] = 'signup as business';
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
    		/* insert email id to email log table for log maintaince */
    		if ($insert_id != '') {
    			$user_registration_id = $insert_id;
    			$table_name = 'secondary_email';
    			$field_names = array('email_log_id' => '', 'user_id' => mysql_real_escape_string($insert_id), 'secondary_email' => mysql_real_escape_string($this->input->post('user_email')), 'email_send_on' => mysql_real_escape_string(date('Y-m-d H:i:s')), 'activation_code' => mysql_real_escape_string($activation_code), 'status' => '0');
    			$insert_id = $this->common_model->insertRow($field_names, $table_name);
    
    			/* Create wallet for user start */
    			$this->load->model('wallet_model');
    			$user_name = mysql_real_escape_string($this->input->post('user_name'));
    			$wallet_email = mysql_real_escape_string($this->input->post('user_email'));
    			$wallet_password = $user_name . "@1234";
    
    			$arr_wallet_param = array(
    					"user_id" => $user_registration_id,
    					"wallet_password" => $wallet_password,
    					"api_code" => "f6c53cbe-5d44-476f-83b1-1d2ed5b6951a",
    					"wallet_email" => $wallet_email,
    					"wallet_label" => "",
    					"wallet_private_key" => ""
    			);
    
    			$this->wallet_model->createWallet($user_registration_id, $arr_wallet_param);
    			/* Create wallet for user end */
    
    			/* get the geo location for log maintaince */
    
    			/* ip address of system */
    			if (($_SERVER['REMOTE_ADDR'] == '127.0.0.1') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.1') || ($_SERVER['REMOTE_ADDR'] == '182.72.122.106') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.96')) {
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
    						$fields = array('log_id' => '', 'user_id' => $user_registration_id, 'geo_location_id' => $last_insert_id, 'last_login' => date('Y-m-d H:i:s'));
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
    			$this->session->set_userdata('register_success', "Account created successfully.check your e-mail <strong>" . $this->input->post('user_email') . "</strong> in order to activate your account then you can start buying and selling bitcoins !. Check you spam folder if you not found email in your inbox. <a href='" . base_url() . "cms/17/guides' target='_blank' >Quick start guide to buy bitcoins on '" . $data['global']['site_title'] . "'</a>");
    			redirect(base_url() . "signin");
    		}
    	}
    	$this->load->view('front/includes/header', $data);
    	$this->load->view('front/registration/registerasbusiness');
    	$this->load->view('front/includes/footer');
    }
    
    public function userRegistrationSupplier() {
    
    	/* checking admin is logged in or not */
    	if ($this->common_model->isLoggedIn()) {
    		redirect(base_url());
    	}
    	/* multi language keywords file */
    	$this->load->language('common');
    	$this->load->language('signup');
    
    	$data = $this->common_model->commonFunction();
    	$data['title'] = 'signup as supplier';
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
    		/* insert email id to email log table for log maintaince */
    		if ($insert_id != '') {
    			$user_registration_id = $insert_id;
    			$table_name = 'secondary_email';
    			$field_names = array('email_log_id' => '', 'user_id' => mysql_real_escape_string($insert_id), 'secondary_email' => mysql_real_escape_string($this->input->post('user_email')), 'email_send_on' => mysql_real_escape_string(date('Y-m-d H:i:s')), 'activation_code' => mysql_real_escape_string($activation_code), 'status' => '0');
    			$insert_id = $this->common_model->insertRow($field_names, $table_name);
    
    			/* Create wallet for user start */
    			$this->load->model('wallet_model');
    			$user_name = mysql_real_escape_string($this->input->post('user_name'));
    			$wallet_email = mysql_real_escape_string($this->input->post('user_email'));
    			$wallet_password = $user_name . "@1234";
    
    			$arr_wallet_param = array(
    					"user_id" => $user_registration_id,
    					"wallet_password" => $wallet_password,
    					"api_code" => "f6c53cbe-5d44-476f-83b1-1d2ed5b6951a",
    					"wallet_email" => $wallet_email,
    					"wallet_label" => "",
    					"wallet_private_key" => ""
    			);
    
    			$this->wallet_model->createWallet($user_registration_id, $arr_wallet_param);
    			/* Create wallet for user end */
    
    			/* get the geo location for log maintaince */
    
    			/* ip address of system */
    			if (($_SERVER['REMOTE_ADDR'] == '127.0.0.1') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.1') || ($_SERVER['REMOTE_ADDR'] == '182.72.122.106') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.96')) {
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
    						$fields = array('log_id' => '', 'user_id' => $user_registration_id, 'geo_location_id' => $last_insert_id, 'last_login' => date('Y-m-d H:i:s'));
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
    			$this->session->set_userdata('register_success', "Account created successfully.check your e-mail <strong>" . $this->input->post('user_email') . "</strong> in order to activate your account then you can start buying and selling bitcoins !. Check you spam folder if you not found email in your inbox. <a href='" . base_url() . "cms/17/guides' target='_blank' >Quick start guide to buy bitcoins on '" . $data['global']['site_title'] . "'</a>");
    			redirect(base_url() . "signin");
    		}
    	}
    	$this->load->view('front/includes/header', $data);
    	$this->load->view('front/registration/registerassupplier');
    	$this->load->view('front/includes/footer');
    }

    public function userActivation($activation_code) {
        $this->load->model('register_model');
        $table_to_pass = 'mst_users';
        $fields_to_pass = array('user_id', 'first_name', 'last_name', 'user_name', 'user_email', 'user_type', 'email_verified', 'user_status');
        $condition_to_pass = array("activation_code" => $activation_code);
        /* get user details to verify the email address */
        $arr_login_data = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        if (count($arr_login_data)) {
            if ($arr_login_data[0]['email_verified'] == 1) {
                $this->session->set_userdata('activation_error', "Your have already activated your account. Please login.");
            } else {
                $table_name = 'mst_users';
                $update_data = array('email_verified' => 1, 'user_status' => 1);
                $update_data = array("user_status" => '1', 'email_verified' => '1');
                $condition_to_pass = array("activation_code" => $activation_code);
                $this->common_model->updateRow($table_name, $update_data, $condition_to_pass);

                /* update email log status */
                $table_name = 'secondary_email';
                $update_data = array("status" => '1');
                $condition_to_pass = array("activation_code" => $activation_code);
                $this->common_model->updateRow($table_name, $update_data, $condition_to_pass);
                $this->session->set_userdata('activation_success', "<strong>Congratulations!</strong> Your account has been activated successfully. Please login.");
            }
        } else {
            $this->session->set_userdata('activation_error', "Invalid activation code.");
        }
        redirect(base_url() . "signin");
    }

    /* check email duplication to avoid email duplication */

    public function chkEmailDuplicate() {
        $this->load->model('register_model');
        $user_email = $this->input->post('user_email');
        $table_to_pass = 'mst_users';
        $fields_to_pass = array('user_id', 'user_email');
        $condition_to_pass = array("user_email" => $user_email);
        $arr_login_data = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        if (count($arr_login_data)) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    /* check username duplication to avoid username duplication */

    public function chkUserDuplicate() {
        $this->load->model('register_model');
        $user_name = $this->input->post('user_name');
        $table_to_pass = 'mst_users';
        $fields_to_pass = array('user_id', 'user_name');
        $condition_to_pass = array("user_name" => $user_name);
        $arr_login_data = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        if (count($arr_login_data)) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    /* function for captcha generation */

    public function generateCaptcha($rand) {
        $data = $this->common_model->commonFunction();
        $arr1 = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
        $arr2 = array();
        foreach ($arr1 as $val)
            $arr2[] = strtoupper($val);

        $arr3 = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $str = "";
        $arr_all_characters = array_merge($arr1, $arr2, $arr3);
        for ($i = 0; $i < 5; $i++) {
            $str.=$arr_all_characters[array_rand($arr_all_characters)] . "";
        }
        $this->session->set_userdata('security_answer', $str);
        putenv('GDFONTPATH=' . realpath('.'));
        $font = $data['absolute_path'] . 'media/front/captcha/ariblk.ttf';
        $IMGVER_IMAGE = imagecreatefromjpeg(base_url() . "media/front/captcha/bg1.jpg");
        $IMGVER_COLOR_WHITE = imagecolorallocate($IMGVER_IMAGE, 0, 0, 0);
        $text = $str;
        $IMGVER_COLOR_BLACK = imagecolorallocate($IMGVER_IMAGE, 255, 255, 255);
        imagefill($IMGVER_IMAGE, 0, 0, $IMGVER_COLOR_BLACK);
        imagettftext($IMGVER_IMAGE, 24, 0, 20, 28, $IMGVER_COLOR_WHITE, $font, $text);
        imagejpeg($IMGVER_IMAGE);
    }

    /* function for captcha validation */

    public function checkCaptcha() {
        if ($this->input->post('input_captcha_value') == $this->session->userdata('security_answer')) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    /* function for login user/admin */

    public function signin() {
        /* checking admin is logged in or not */
        if ($this->common_model->isLoggedIn()) {
            redirect(base_url());
        }
        /* multi language keywords file */
        $this->load->language('common');
        $this->load->language('signin');
        $data = $this->common_model->commonFunction();
        $this->load->model("register_model");
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/login/log-in.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>', '<script src="' . base_url() . 'media/front/js/facebook-config.js"></script>', '<script src="' . base_url() . 'media/front/js/facebook-connect.js"></script>', '<script src="' . base_url() . 'media/front/js/captcha.js"></script>'));
        $data['title'] = 'signin';
        $data['menu_active'] = "";

        if ($this->input->post('user_name') != '') {
            $table_to_pass = 'mst_users';
            $fields_to_pass = array('user_id', 'first_name', 'last_name', 'user_name', 'user_email', 'user_type', 'email_verified', 'user_status', 'user_password');
            $condition_to_pass = "user_name = '" . mysql_real_escape_string($_POST['user_name']) . "' OR user_email = '" . mysql_real_escape_string($_POST['user_name']) . "'";

            $arr_login_data = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
            if (count($arr_login_data)) {
                if ($arr_login_data[0]['user_password'] != md5($_POST['user_password'])) {
                    $this->session->set_userdata('login_error', "Please enter correct password.");
                    redirect(base_url() . 'signin');
                } elseif ($arr_login_data[0]['email_verified'] == 1) {
                    if ($arr_login_data[0]['user_status'] == 2) {
                        $this->session->set_userdata('login_error', "Your account has been blocked by administrator.");
                        redirect(base_url() . 'signin');
                    } else {
                        /* get the geo location for log maintaince */

                        /* ip address of system */
//                        if (($_SERVER['REMOTE_ADDR'] == '127.0.0.1') || ($_SERVER['REMOTE_ADDR'] == '182.72.122.106') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.96')) {
                        /* for server */
                        if (($_SERVER['REMOTE_ADDR'] == '127.0.0.1') || ($_SERVER['REMOTE_ADDR'] == '182.72.122.106') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.1')) {
                            $ip_address = "182.72.122.106";
                        } else {
                            $ip_address = $_SERVER['REMOTE_ADDR'];
                        }

                        if ($ip_address != '') {
                            $arr_geo_data = geoip_record_by_name($ip_address);
                            if ($arr_geo_data != "") {
                                $fields = array('geo_location_id' => '',
                                    'user_id' => $arr_login_data[0]['user_id'],
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
                                    $fields = array('log_id' => '',
                                        'user_id' => $arr_login_data[0]['user_id'],
                                        'geo_location_id' => $last_insert_id,
                                        'last_login' => date('Y-m-d H:i:s'),
										'last_activity' => strtotime(date('Y-m-d H:i:s'))
                                    );
                                    $table = 'user_sign_in_log';
                                    $last_sign_in_log_id = $this->common_model->insertRow($fields, $table);
                                    $this->session->set_userdata('last_sign_in_log_id', $last_sign_in_log_id);
                                }
                            }
                        }

                        /* Get the wallet balance */
                        /* load wallet model */
                        $this->load->model("wallet_model");
                        $wallet_deatils = $this->wallet_model->getTableInformation("user_wallets", "", array("user_id" => $arr_login_data[0]['user_id']), "wallet_id  DESC", '', 0);

                        if (!empty($wallet_deatils)) {
                            $arr_wallet_bal_param = array(
                                "user_id" => $arr_login_data[0]['user_id'],
                                "password" => $wallet_deatils[0]['wallet_password'],
                                "guid" => $wallet_deatils[0]['wallet_guid']
                            );                            
                            $wallet_balance = $this->wallet_model->getWalletBalance($arr_login_data[0]['user_id'], $arr_wallet_bal_param);
                        } else {
                            $wallet_password = $arr_login_data[0]['user_name'] . "@1234";

                            $arr_wallet_param = array(
                                "user_id" => $arr_login_data[0]['user_id'],
                                "wallet_password" => $wallet_password,
                                "api_code" => "f6c53cbe-5d44-476f-83b1-1d2ed5b6951a",
                                "wallet_email" => $arr_login_data[0]['user_email'],
                                "wallet_label" => "",
                                "wallet_private_key" => ""
                            );

                            $this->wallet_model->createWallet($arr_login_data[0]['user_id'], $arr_wallet_param);
                            $wallet_deatils = $this->wallet_model->getTableInformation("user_wallets", "", array("user_id" => $arr_login_data[0]['user_id']), "wallet_id  DESC", '', 0);
                            $arr_wallet_bal_param = array(
                                "user_id" => $arr_login_data[0]['user_id'],
                                "password" => $wallet_deatils[0]['wallet_password'],
                                "guid" => $wallet_deatils[0]['wallet_guid']
                            );
                            $wallet_balance = $this->wallet_model->getWalletBalance($arr_login_data[0]['user_id'], $arr_wallet_bal_param);
                        }

                        /* get the geo location for log maintaince */

                        /* Get the trust requests */
                        $this->load->model("trusted_contacts_model");
                        $arr_user_list = $this->trusted_contacts_model->getTrustedRequestDetails($arr_login_data[0]['user_id']);
                        $user_data['trust'] = $arr_user_list;

                        /* Set session data of user */
                        $user_data['user_id'] = $arr_login_data[0]['user_id'];
                        $user_data['user_name'] = $arr_login_data[0]['user_name'];
                        $user_data['user_email'] = $arr_login_data[0]['user_email'];
                        $user_data['user_type'] = $arr_login_data[0]['user_type'];
                        $user_data['user_wallet_balance'] = $wallet_balance/100000000;
                        
                        $this->session->set_userdata('user_account', $user_data);
                        /* Set wallet balance in session */
                        $this->session->set_userdata('user_wallet_balance',$user_data['user_wallet_balance']);
                        redirect(base_url(). 'user-dashboard');
                    }
                } else {
                    $resend_link = base_url() . 'resend-verfication-link/' . $arr_login_data[0]['user_id'];
                    $this->session->set_userdata('login_error', "Please activate your account.<a href='" . $resend_link . "'>click here</a> to resend the verification link.");
                    redirect(base_url() . 'signin');
                }
            } else {
                $this->session->set_userdata('login_error', "Invalid email/username.");
                redirect(base_url() . 'signin');
            }
        }
        $this->load->view('front/includes/header', $data);
        $this->load->view('front/login/login');
        $this->load->view('front/includes/footer');
    }

    /* function to check email already exist or not */

    public function chkEmailExist() {
        $this->load->model('register_model');
        $user_email = $this->input->post('user_email');
        $table_to_pass = 'mst_users';
        $fields_to_pass = array('user_id', 'user_email');
        $condition_to_pass = array("user_email" => $user_email);
        $arr_login_data = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        if (count($arr_login_data)) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    /* Function to re-send  email verification link */

    function resendEmailVerficationLink($user_id) {

        $this->load->model('register_model');
        $data = $this->common_model->commonFunction();
        /* get user information by id */
        $table_to_pass = 'mst_users';
        $fields_to_pass = array('user_id', 'first_name', 'last_name', 'activation_code', 'user_name', 'user_email', 'user_type', 'email_verified', 'user_status', 'user_password');
        $condition_to_pass = "user_id = '" . mysql_real_escape_string($user_id) . "'";

        $arr_login_data = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 1);
        /* Send account activation email to user */
        $login_link = '<a href="' . base_url() . 'signin">Click here.</a>';
        if (isset($lang_id) && $lang_id != '') {
            $lang_id = $this->session->userdata('lang_id');
        } else {
            $lang_id = 17; /* Default is 17(English) */
        }
        $activation_code = $arr_login_data[0]['activation_code'];

        $activation_link = '<a href="' . base_url() . 'user-activation/' . $activation_code . '">Click here</a>';
        $reserved_words = array(
            "||USER_NAME||" => mysql_real_escape_string($arr_login_data[0]['user_name']),
            "||USER_EMAIL||" => mysql_real_escape_string($arr_login_data[0]['user_email']),
            "||ACTIVATION_LINK||" => mysql_real_escape_string($activation_link),
            "||SITE_URL||" => mysql_real_escape_string(base_url()),
            "||SITE_TITLE||" => mysql_real_escape_string($data['global']['site_title']),
            "||QUICK_GUIDE||" => mysql_real_escape_string('<a href="' . base_url() . 'cms/17/about">test</a>'),
            "||SAFTY_AND_SECURITY||" => mysql_real_escape_string('<a href="' . base_url() . 'cms/17/about">test</a>'),
            "||FAQS||" => mysql_real_escape_string('<a href="' . base_url() . 'cms/17/about">test</a>'),
            "||DISCUSSION_FORUM||" => mysql_real_escape_string('<a href="' . base_url() . 'cms/17/about">test</a>'),
            "||ABOUT_US||" => mysql_real_escape_string('<a href="' . base_url() . 'cms/17/about">test</a>')
        );
        $template_title = 'registration-successful';
        $arr_emailtemplate_data = $this->common_model->getEmailTemplateInfo($template_title, $lang_id, $reserved_words);
        $recipeinets = mysql_real_escape_string($arr_login_data[0]['user_email']);
        $from = array("email" => $data['global']['site_email'], "name" => $data['global']['site_title']);
        $subject = $arr_emailtemplate_data['subject'];
        $message = stripcslashes($arr_emailtemplate_data['content']);
        $mail = $this->common_model->sendEmail($recipeinets, $from, $subject, $message);

        if ($mail) {
            $this->session->set_userdata('register_success', "email verification link sent successfully.check your e-mail <strong>" . $arr_login_data[0]['user_email'] . "</strong> to verify the email.");
            redirect(base_url() . "signin");
        }
    }

    /* function for password recovery of user */

    public function passwordRecovery() {

        /* multi language keywords file */
        $this->load->language('common');
        $this->load->language('forgot-password');
        $data = $this->common_model->commonFunction();
        $data['menu_active'] = "";
        $this->load->model("register_model");
        /* include required js files */
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/login/forgot-password.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>'));
        if ($this->input->post('user_email') != '') {
            /* get user information to send reset password email */
            $table_to_pass = 'mst_users';
            $fields_to_pass = array('user_id', 'first_name', 'last_name', 'user_name', 'user_email', 'user_password', 'activation_code');
            $condition_to_pass = array("user_email" => $this->input->post('user_email'));
            $arr_password_data = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
            if (count($arr_password_data)) {

                $reset_pasword_link = '<a href="' . base_url() . 'reset-password/' . $arr_password_data[0]['activation_code'] . ' ">Click here</a>';

                if (isset($lang_id) && $lang_id != '') {
                    $lang_id = $this->session->userdata('lang_id');
                } else {
                    $lang_id = 17; /* Default is 17(English) */
                }
                $reserved_words = array(
                    "||USER_NAME||" => mysql_real_escape_string($arr_password_data[0]['user_name']),
                    "||LAST_NAME||" => mysql_real_escape_string($arr_password_data[0]['last_name']),
                    "||USER_EMAIL||" => mysql_real_escape_string($arr_password_data[0]['user_email']),
                    "||USER_PASSWORD_RESET_LINK||" => mysql_real_escape_string($reset_pasword_link),
                    "||SITE_TITLE||" => mysql_real_escape_string($data['global']['site_title']),
                    "||SITE_PATH||" => mysql_real_escape_string(base_url())
                );

                $template_title = 'forgot-password';
                $arr_emailtemplate_data = $this->common_model->getEmailTemplateInfo($template_title, $lang_id, $reserved_words);
                $recipeinets = mysql_real_escape_string($this->input->post('user_email'));
                $from = array("email" => $data['global']['site_email'], "name" => $data['global']['site_title']);
                $subject = $arr_emailtemplate_data['subject'];
                $message = stripcslashes($arr_emailtemplate_data['content']);
                $mail = $this->common_model->sendEmail($recipeinets, $from, $subject, $message);
                if ($mail) {
                    $this->session->set_userdata('password_recover', "We have been sent password reset link on your email <strong>" . $arr_password_data[0]['user_email'] . "</strong>.");
                    redirect(base_url() . 'signin');
                }
            }
        }
        $this->load->view('front/includes/header', $data);
        $this->load->view('front/forgot-password/forgot-password');
        $this->load->view('front/includes/footer');
    }

    /* function to reset the password */

    function resetPassword($reset_code) {

        /* multi language keywords file */
        $this->load->language('common');
        $this->load->language('forgot-password');
        $data = $this->common_model->commonFunction();
        $data['menu_active'] = "";
        $data['title'] = 'Reset password';
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");
        /* required js files */
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/login/reset-password.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.password.js"></script>'));

        if (($reset_code != '')) {
            $table_to_pass = 'mst_users';
            $fields_to_pass = 'user_id,first_name,user_email,user_name,activation_code';
            $condition_to_pass = array('activation_code' => $reset_code);
            $arr_user_data = array();
            $arr_user_data = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
            $data['arr_user_data'] = $arr_user_data[0];
        } else {
            $this->session->set_userdata('msg-error', 'Invalid reset password code');
        }
        $this->load->view('front/includes/header', $data);
        $this->load->view('front/user-account/forgot-password', $data);
        $this->load->view('front/includes/footer');
    }

    /* reset password action */

    function resetPasswordAction() {

        if ($this->input->post('btn_frgt_pwd') != '') {

            $new_pass = $this->input->post('new_user_password');
            $cnf_pass = $this->input->post('cnf_user_password');

            if (trim($new_pass) == trim($cnf_pass)) {

                /* first check new pass is already used or not */
                $table_to_pass = 'user_password';
                $fields_to_pass = 'password_id,user_id,old_password';
                $condition_to_pass = array("user_id" => $this->input->post('user_id'), 'old_password' => md5($new_pass));
                $user_old_pass = array();
                $user_old_pass = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);

                if (count($user_old_pass) > 0) {
                    $this->session->set_userdata('msg-error', "Your can not use the previously used password again.");
                    redirect(base_url() . 'reset-password/' . $this->input->post('activation_code'));
                } else {
                    /* update the password and make a new entry in user_password table */
                    $table_name = 'user_password';
                    $insert_data = array('password_id' => '', 'user_id' => mysql_real_escape_string($this->input->post('user_id')), 'old_password' => mysql_real_escape_string(md5($new_pass)));
                    $insert_pass = $this->common_model->insertRow($insert_data, $table_name);

                    /* update new password */
                    $update_table_name = 'mst_users';
                    $update_data = array('user_password' => mysql_real_escape_string(md5($new_pass)));
                    $condition = array("user_id" => $this->input->post('user_id'));
                    $cnf_pass_update = $this->common_model->updateRow($update_table_name, $update_data, $condition);

                    if ($cnf_pass_update) {
                        $this->session->set_userdata('msg', "Your password has been updated successfully.");
                        redirect(base_url() . 'signin');
                    }
                }
            } else {
                $this->session->set_userdata('msg-error', 'both passwords are not matching!');
                redirect(base_url() . 'reset-password/' . $this->input->post('activation_code'));
            }
        }/* main if */
    }

    /* function for cms page terms and conditions */

    function termsConditions($lang_id, $page_alias) {
        /* lang file */
        $this->load->language('common');
        $this->load->model("cms_model");
        $data = $this->common_model->commonFunction();
        if (($lang_id != '') && ($page_alias != '')) {
            $lang_id = trim($lang_id);
            $page_alias = trim($page_alias);
            $data['cms_details'] = $this->cms_model->getCmsPage($lang_id, $page_alias);
        }
        $this->load->view('front/cms/cms', $data);
    }

}

/* End of file register.php */
/* Location: ./application/controllers/register.php */ 