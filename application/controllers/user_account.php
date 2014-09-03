<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set("display_errors", "on");

class User_Account extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("common_model");
		$this->load->model("home_model");
        $this->load->language("edit-profile");
		$this->load->language('common');
        CHECK_USER_STATUS();
		UpdateActiveTime();
    }

    /* function to display public profile */

    public function profile($user_name = '') {
        /* multi language keywords file */
        $this->load->language('common');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }

        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['menu_active'] = "";
		$data['title'] = $user_name;
        $this->load->model("user_model");
		
		
		/* Get user details */
        $table_to_pass = 'mst_users';
        $fields_to_pass = 'user_id,first_name,user_email,email_verified,user_name,user_type,user_status,profile_picture,register_date';
        $condition_to_pass = array("user_name" => $user_name);
        $arr_user_data = array();
        $arr_user_data = $this->user_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        $data['arr_user_data'] = $arr_user_data[0];
		
		/* Get user basic information */	
		$table_to_pass = 'user_basic_information';
        $fields_to_pass = 'self_introduction';
        $condition_to_pass = array("user_id" => $arr_user_data[0]['user_id']);
        $user_basic_information = array();
        $user_basic_information = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
		if(count($user_basic_information) > 0){
			$data['arr_user_basic_info'] = $user_basic_information[0];
		}

        /* user id value */
        //$user_id = ($user_id == '') ? $data['user_session']['user_id'] : $user_id;

        /* Get count of trusted people */
        $this->load->model("trusted_contacts_model");
        $arr_people_trust_you_list = $this->trusted_contacts_model->getPeopleTrustYouList($arr_user_data[0]['user_id']);
        $data['trusted_count'] = count($arr_people_trust_you_list);
		
		/* Get count of blocked by people */
		$arr_people_blocked_you = $this->trusted_contacts_model->getPeopleBlockedYouList($arr_user_data[0]['user_id']);
		$data['blocked_count'] = count($arr_people_blocked_you);
		
		/* Get count of confirmed trades */
		$data['confirmed_trade_count'] = $this->home_model->getConfirmedTradeCount($arr_user_data[0]['user_id']);
		
		/* Get feedback score */
		$this->load->model("trusted_contacts_model");	
        $arr_feedback_list = $this->trusted_contacts_model->getFeedbackDetails($arr_user_data[0]['user_id'],'','','');
		$data['arr_confirmed_feedback_list'] = $this->trusted_contacts_model->getFeedbackDetails($arr_user_data[0]['user_id'],'C','','2');
		$arr_total_feedback_count = count($arr_feedback_list);
		$data['arr_feedback_count'] = (int)(($data['trusted_count'] / $arr_total_feedback_count)*100);        
		
		/* Get trust status of selected user */
        /* Check that current login user has trust on seleted user */
        $data['current_user_trust_on_selected'] = $this->trusted_contacts_model->getTrustedStatusDetails($arr_user_data[0]['user_id'], $data['user_session']['user_id']);

        /* Check that seleted user trust on current user */
        $data['selected_user_trust_on_current'] = $this->trusted_contacts_model->getTrustedStatusDetails($data['user_session']['user_id'], $arr_user_data[0]['user_id']);

        /* get details of selected user */
        $data['arr_user_list'] = $this->trusted_contacts_model->getTrustedStatusDetails($arr_user_data[0]['user_id'], $data['user_session']['user_id']);		

        /* get user last login details */
        $table_to_pass = 'user_sign_in_log';
        $fields_to_pass = 'log_id,user_id,last_login,last_logout';
        $condition_to_pass = array("user_id" => $arr_user_data[0]['user_id'], "last_logout !=" => '0000-00-00 00:00:00');
        $arr_user_login_details = array();
        $arr_user_login_details = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = 'log_id desc', $limit_to_pass = '1', $debug_to_pass = 0);
        $data['arr_user_login_details'] = $arr_user_login_details[0];
		
        /* get time interval for account creation */
        $current_date = date('Y-m-d H:i:s');
        $register_date = $data['arr_user_data']['register_date'];
        $arr_date_diff = $this->common_model->dateDiff($current_date, $register_date);
        $arr_date_diff = array_reverse($arr_date_diff);

        /* get the  date Difference string for account created */
        $arr_date_diff_string = $this->dateDiffString($arr_date_diff);
        $data['arr_date_diff_string'] = $arr_date_diff_string;
		
		/* Get the last seen user time */
		$last_seen = GetLastSeenTime($arr_user_data[0]['user_id']);
        $data['arr_last_seen_diff_string'] = $last_seen;
		
		/* Get the ads posted by user */
		if($arr_user_data[0]['user_id'] != $data['user_session']['user_id']){
		
			/* API used to get the current market price of BTC */
			$post_data = "https://bitpay.com/api/rates";
			$currencyRateArr = @file_get_contents($post_data);
			if($currencyRateArr)
			{
			
			$currencyRateArr = json_decode($currencyRateArr);
		
			//Send array condition with buy_o trade type
			$arr_condition = array(
				"lattitude" => "",
				"longitude" => "",
				"trade_type" => "buy_o",
				"user_id" => $arr_user_data[0]['user_id'],
				"limit" => '1',
			);
			$arrInfo_buy_o = $this->home_model->getBitcoinsInfo($arr_condition);
						
			for ($i = 0; $i < count($arrInfo_buy_o); $i++) {
				foreach ($currencyRateArr as $rateArr) {
					if ($rateArr->code == $arrInfo_buy_o[$i]['currency_code']) {
						$price_eq_val = $arrInfo_buy_o[$i]['price_eq_val'];
						$currency_rate = $rateArr->rate;
						$arrInfo_buy_o[$i]['local_currency_rate'] = ((($currency_rate*100)*$price_eq_val)/100);
						$arrInfo_buy_o[$i]['local_currency_code'] = $rateArr->code;
						break;
					}
				}
				/* Get confirmed trade count of user*/
				$trade_count = $this->home_model->getConfirmedTradeCount($arrInfo_buy_o[$i]['user_id']);
				$arrInfo_buy_o[$i]['confirmed_trade_count'] = $trade_count;
			}
			$data['arrInfo_buy_o'] = $arrInfo_buy_o;
			
			//Send array condition with buy_c trade type
			$arr_condition = array(
				"lattitude" => "",
				"longitude" => "",
				"trade_type" => "buy_c",
				"user_id" => $arr_user_data[0]['user_id'],
				"limit" => '1',
			);
			$arrInfo_buy_c = $this->home_model->getBitcoinsInfo($arr_condition);
						
			for ($i = 0; $i < count($arrInfo_buy_c); $i++) {
				foreach ($currencyRateArr as $rateArr) {
					if ($rateArr->code == $arrInfo_buy_c[$i]['currency_code']) {
						$price_eq_val = $arrInfo_buy_c[$i]['price_eq_val'];
						$currency_rate = $rateArr->rate;
						$arrInfo_buy_c[$i]['local_currency_rate'] = ((($currency_rate*100)*$price_eq_val)/100);
						$arrInfo_buy_c[$i]['local_currency_code'] = $rateArr->code;
						break;
					}
				}
				/* Get confirmed trade count of user*/
				$trade_count = $this->home_model->getConfirmedTradeCount($arrInfo_buy_c[$i]['user_id']);
				$arrInfo_buy_c[$i]['confirmed_trade_count'] = $trade_count;
			}
			$data['arrInfo_buy_c'] = $arrInfo_buy_c;
			
			//Send array condition with sell_o trade type
			$arr_condition = array(
				"lattitude" => "",
				"longitude" => "",		
				"trade_type" => "sell_o",
				"user_id" => $arr_user_data[0]['user_id'],
				"limit" => '1',
			);
			$arrInfo_sell_o = $this->home_model->getBitcoinsInfo($arr_condition);
	
			for ($i = 0; $i < count($arrInfo_sell_o); $i++) {
				foreach ($currencyRateArr as $rateArr) {
					if ($rateArr->code == $arrInfo_sell_o[$i]['currency_code']) {
						$price_eq_val = $arrInfo_sell_o[$i]['price_eq_val'];
						$currency_rate = $rateArr->rate;
						$arrInfo_sell_o[$i]['local_currency_rate'] = ((($currency_rate*100)*$price_eq_val)/100);
						$arrInfo_sell_o[$i]['local_currency_code'] = $rateArr->code;
						break;
					}
				}
				/* Get confirmed trade count of user*/
				$trade_count = $this->home_model->getConfirmedTradeCount($arrInfo_sell_o[$i]['user_id']);
				$arrInfo_sell_o[$i]['confirmed_trade_count'] = $trade_count;
			}
			$data['arrInfo_sell_o'] = $arrInfo_sell_o;
			
			//Send array condition with sell_c trade type
			$arr_condition = array(	
				"lattitude" => "",
				"longitude" => "",		
				"trade_type" => "sell_c",
				"user_id" => $arr_user_data[0]['user_id'],
				"limit" => '1',
			);
			$arrInfo_sell_c = $this->home_model->getBitcoinsInfo($arr_condition);
	
			for ($i = 0; $i < count($arrInfo_sell_c); $i++) {
				foreach ($currencyRateArr as $rateArr) {
					if ($rateArr->code == $arrInfo_sell_o[$i]['currency_code']) {
						$price_eq_val = $arrInfo_sell_o[$i]['price_eq_val'];
						$currency_rate = $rateArr->rate;
						$arrInfo_sell_c[$i]['local_currency_rate'] = ((($currency_rate*100)*$price_eq_val)/100);
						$arrInfo_sell_c[$i]['local_currency_code'] = $rateArr->code;
						break;
					}
				}
				/* Get confirmed trade count of user*/
				$trade_count = $this->home_model->getConfirmedTradeCount($arrInfo_sell_c[$i]['user_id']);
				$arrInfo_sell_c[$i]['confirmed_trade_count'] = $trade_count;
			}
			$data['arrInfo_sell_c'] = $arrInfo_sell_c;
			}
		}		
		
		/* Load view */
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/user-profile', $data);
        $this->load->view('front/includes/footer');
    }
	
	
	/* User ads for buy */
	public function userAdsForBuyOrSell($user_name = '' , $trade_type_method = '', $pg = 0) {
	
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
		
		if($trade_type_method == 'buy-bitcoins-online')
		{
			$trade_type = 'sell_o';
		}
		if($trade_type_method == 'sell-bitcoins-online')
		{
			$trade_type = 'buy_o';
		}
		if($trade_type_method == 'buy-bitcoins-with-cash')
		{
			$trade_type = 'sell_c';
		}
		if($trade_type_method == 'sell-bitcoins-with-cash')
		{
			$trade_type = 'buy_c';
		}
		
		$arr_condition = array(
			"lattitude" => "",
			"longitude" => "",			
			"trade_type" => $trade_type,
			"user_id" => $arr_user_data[0]['user_id'],				
		);
		$arrInfo_buy_or_sell = $this->home_model->getBitcoinsInfoCount($arr_condition);
		
		/* [Start:: Pagination code] */
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'profile/'.$arr_user_data[0]['user_id'].'/'.$trade_type_method;
        $data['count'] = $arrInfo_buy_or_sell;
        $config['total_rows'] = $arrInfo_buy_or_sell;
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
        $arrayPagination = array("limit" => $config['per_page'], "offset" => $pg, "lattitude" => "", "longitude" => "", "trade_type" => $trade_type, "user_id" => $arr_user_data[0]['user_id']);
        $data['arrInfo_buy_or_sell'] = $this->home_model->getBitcoinsInfo($arrayPagination);
        $data['page'] = $pg;
        /* [End:: Pagination code] */		
		
		/* API used to get the current market price of BTC */
		$post_data = "https://bitpay.com/api/rates";
		$currencyRateArr = @file_get_contents($post_data);
		$currencyRateArr = json_decode($currencyRateArr);

		for ($i = 0; $i < count($data['arrInfo_buy_or_sell']); $i++) {
			foreach ($currencyRateArr as $rateArr) {
				if ($rateArr->code == $data['arrInfo_buy_or_sell'][$i]['currency_code']) {
					$price_eq_val = $data['arrInfo_buy_or_sell'][$i]['price_eq_val'];
					$currency_rate = $rateArr->rate;
					$data['arrInfo_buy_or_sell'][$i]['local_currency_rate'] = ((($currency_rate*100)*$price_eq_val)/100);
					$data['arrInfo_buy_or_sell'][$i]['local_currency_code'] = $rateArr->code;
					break;
				}
			}
			/* Get confirmed trade count of user*/
			$trade_count = $this->home_model->getConfirmedTradeCount($data['arrInfo_buy_or_sell'][$i]['user_id']);
			$data['arrInfo_buy_or_sell'][$i]['confirmed_trade_count'] = $trade_count;
		}
		//$data['arrInfo_buy_or_sell'] = $arrInfo_buy_or_sell;
		$data['trade_type'] = $trade_type;
		$data['trade_type_method'] = $trade_type_method;
		
		/* Load view */
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/user-buy-sell-ads', $data);
        $this->load->view('front/includes/footer');
		
	}

    /* function to get the time interval string */

    public function dateDiffString($dateDiff) {
        $dateDiffString = "";
        $i = 0;
        foreach ($dateDiff as $key => $value) {
            if ($value > 0) {
                if ($i >= 1) {
                    $dateDiffString.=", ";
                }
                $dateDiffString.= $value . " " . $key;
                $i++;
            }
        }
        return $dateDiffString;
    }

    /* function to edit the user profile */

    function edit_profile() {

        /* multi language keywords file */
        $this->load->language('common');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }

        $data = $this->common_model->commonFunction();
        $data['title'] = 'Edit profile';
        $data['menu_active'] = "";
        /* set flag for edit profile footer option */
        $data['flagBasicInfo'] = TRUE;
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");
        /* include required js files */
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/formvalidate.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>', '<script src="' . base_url() . 'media/front/js/edit-profile/edit-user-profile.js"></script>'));

        if ($this->input->post('btn_basic_info') != '') {
            /* check if user record already exist */
            $table_to_pass = 'user_basic_information';
            $fields_to_pass = '*';
            $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
            $arr_user_data = array();
            $user_basic_information = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);

            if (count($user_basic_information) == 1) {
                /* update the record */
                $table_name = 'user_basic_information';
                $update_data = array(
                    'timezone_id' => mysql_real_escape_string($this->input->post('timezone_id'))
                    , 'cash_txn_auto_funding' => mysql_real_escape_string($this->input->post('cash_txn_auto_funding'))
                    , 'selling_vacation' => mysql_real_escape_string($this->input->post('selling_vacation'))
                    , 'buying_vacation' => mysql_real_escape_string($this->input->post('buying_vacation'))
                    , 'sms_for_new_trade_contact' => mysql_real_escape_string($this->input->post('sms_for_new_trade_contact'))
                    , 'sms_for_new_ol_payment' => mysql_real_escape_string($this->input->post('sms_for_new_ol_payment'))
                    , 'sms_for_messages' => mysql_real_escape_string($this->input->post('sms_for_messages'))
                    , 'sms_for_escrow_release' => mysql_real_escape_string($this->input->post('sms_for_escrow_release'))
                    , 'self_introduction' => $this->input->post('self_introduction')
                );
                $condition = array("user_id" => $data['user_session']['user_id']);
                $cnf_basic_info = $this->common_model->updateRow($table_name, $update_data, $condition);

                if ($cnf_basic_info) {
                    $this->session->set_userdata('msg', "Your profile has been updated successfully.");
                    redirect(base_url() . 'profile/edit');
                }
            } else {
                /* insert new record */
                $table_name = 'user_basic_information';
                $insert_data = array('basic_info_id' => ''
                    , 'user_id' => mysql_real_escape_string($this->input->post('user_id'))
                    , 'timezone_id' => mysql_real_escape_string($this->input->post('timezone_id'))
                    , 'cash_txn_auto_funding' => mysql_real_escape_string($this->input->post('cash_txn_auto_funding'))
                    , 'selling_vacation' => mysql_real_escape_string($this->input->post('selling_vacation'))
                    , 'buying_vacation' => mysql_real_escape_string($this->input->post('buying_vacation'))
                    , 'sms_for_new_trade_contact' => mysql_real_escape_string($this->input->post('sms_for_new_trade_contact'))
                    , 'sms_for_new_ol_payment' => mysql_real_escape_string($this->input->post('sms_for_new_ol_payment'))
                    , 'sms_for_messages' => mysql_real_escape_string($this->input->post('sms_for_messages'))
                    , 'sms_for_escrow_release' => mysql_real_escape_string($this->input->post('sms_for_escrow_release'))
                    , 'self_introduction' => $this->input->post('self_introduction')
                );
                $insert_basic_info = $this->common_model->insertRow($insert_data, $table_name);

                if ($insert_basic_info) {
                    $this->session->set_userdata('msg', "Your profile has been updated successfully.");
                    redirect(base_url() . 'profile/edit');
                }
            }
        }/* main if */

        $table_to_pass = 'user_basic_information';
        $fields_to_pass = '*';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $user_basic_information = array();
        $user_basic_information = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);

        if (count($user_basic_information) > 0) {
            $data['arr_user_data'] = $user_basic_information[0];
        } else {
            $data['arr_user_data'] = array('basic_info_id' => ''
                , 'user_id' => ''
                , 'timezone_id' => ''
                , 'cash_txn_auto_funding' => ''
                , 'selling_vacation' => ''
                , 'buying_vacation' => ''
                , 'sms_for_new_trade_contact' => ''
                , 'sms_for_new_ol_payment' => ''
                , 'sms_for_messages' => ''
                , 'sms_for_escrow_release' => ''
                , 'self_introduction' => '');
        }
        /* get timezones in array */
        $table_to_pass = 'timezones';
        $fields_to_pass = '*';
        $condition_to_pass = "";
        $arr_timezones = array();
        $arr_timezones = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        $data['arr_timezones'] = $arr_timezones;

        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/edit-user-profile', $data);
        $this->load->view('front/includes/footer');
    }

    /* function to check email address duplication */

    public function chkEditEmailDuplicate() {
        $this->load->model("user_model");
        if ($this->input->post('user_email') == $this->input->post('user_email_old')) {
            echo 'true';
        } else {
            $table_to_pass = 'mst_users';
            $fields_to_pass = array('user_id', 'user_email');
            $condition_to_pass = array("user_email" => $this->input->post('user_email'));
            $arr_login_data = $this->user_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
            if (count($arr_login_data)) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
    }

    /* function to check username duplication */

    public function chkEditUSernameDuplicate() {
        $this->load->model("user_model");
        if ($this->input->post('user_name') == $this->input->post('user_name_old')) {
            echo 'true';
        } else {
            $table_to_pass = 'mst_users';
            $fields_to_pass = array('user_id', 'user_name');
            $condition_to_pass = array("user_email" => $this->input->post('user_name'));
            $arr_login_data = $this->user_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
            if (count($arr_login_data)) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }

    /* function to update account setting of the user profile */

    public function account_setting() {
        /* multi language keywords file */
        $this->load->language('common');
        $this->load->language('change-password');

        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }
        $data = $this->common_model->commonFunction();
        $data['menu_active'] = "";
        $data['user_session'] = $this->session->userdata('user_account');
        /* set flag for edit profile footer option */
        $data['flagChangePass'] = TRUE;
        $this->load->model("user_model");
        /* include js files */
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/login/change-password.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.password.js"></script>'));

        if (($this->input->post('new_user_password') != '') && (trim($this->input->post('new_user_password')) == trim($this->input->post('cnf_user_password')))) {

            $old_pass = $this->input->post('old_user_password');
            $new_pass = $this->input->post('new_user_password');
            $cnf_pass = $this->input->post('cnf_user_password');

            /* if old and new same */
            if (trim($old_pass) == trim($new_pass)) {
                $this->session->set_userdata('msg-error', "Your new password must not be same as old password.");
                redirect(base_url() . 'profile/account-setting');
            }

            /* if old and new password different */
            if (trim($old_pass) != trim($new_pass)) {

                /* first check new pass is already used or not */
                $table_to_pass = 'user_password';
                $fields_to_pass = 'password_id,user_id,old_password';
                $condition_to_pass = array("user_id" => $data['user_session']['user_id'], 'old_password' => md5($new_pass));
                $user_old_pass = array();
                $user_old_pass = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);

                if (count($user_old_pass) > 0) {
                    $this->session->set_userdata('msg-error', "Your can not use the previously used password again.");
                    redirect(base_url() . 'profile/account-setting');
                } else {
                    /* update the password and make a new entry in user_password table */
                    /* insert new record */
                    $table_name = 'user_password';
                    $insert_data = array('password_id' => '', 'user_id' => mysql_real_escape_string($data['user_session']['user_id']), 'old_password' => mysql_real_escape_string(md5($old_pass)));
                    $insert_pass = $this->common_model->insertRow($insert_data, $table_name);

                    /* update new password */
                    $update_table_name = 'mst_users';
                    $update_data = array('user_password' => mysql_real_escape_string(md5($new_pass)));
                    $condition = array("user_id" => $data['user_session']['user_id']);
                    $cnf_pass = $this->common_model->updateRow($update_table_name, $update_data, $condition);

                    if ($cnf_pass) {
                        $this->session->set_userdata('msg', "Your password has been updated successfully.");
                        redirect(base_url() . 'profile/account-setting');
                    }
                }
            }
        }

        $table_to_pass = 'mst_users';
        $fields_to_pass = 'user_id,first_name,last_name,user_email,user_name,user_type,user_status,profile_picture,gender';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_data = array();
        $arr_user_data = $this->user_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        $data['arr_user_data'] = $arr_user_data[0];
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/account-setting', $data);
        $this->load->view('front/includes/footer');
    }

    /* function to change the email address of user */

    function changeEmailId() {
        /* multi language keywords file */
        $this->load->language('common');
        $this->load->language('change-email-id');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }

        $data = $this->common_model->commonFunction();
        $data['menu_active'] = "";
        $data['user_session'] = $this->session->userdata('user_account');
        /* set flag for edit profile footer option */
        $data['flagChangeEmail'] = TRUE;
        $this->load->model("user_model");
        /* include required js files */
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/login/change-email.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>'));

        if (($this->input->post('btn_chg_email') != '')) {
            $user_email = $this->input->post('user_email');
            if (trim($user_email) != '') {
                /* first check new email is already used or not */
                $table_to_pass = 'secondary_email';
                $fields_to_pass = 'email_log_id,user_id,secondary_email';
                $condition_to_pass = array('secondary_email' => $user_email);
                $user_old_pass = array();
                $user_old_pass = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);

                if (count($user_old_pass) > 0) {
                    $this->session->set_userdata('msg-error', 'This email address is already used,please choose another.');
                    redirect(base_url() . 'profile/change-email');
                } else {
                    /* update the email and make a new entry in secondary_email table */
                    /* insert new record */
                    $activation_code = time() . rand();
                    $table_name = 'secondary_email';
                    $insert_data = array('email_log_id' => ''
                        , 'user_id' => mysql_real_escape_string($data['user_session']['user_id'])
                        , 'secondary_email' => mysql_real_escape_string($user_email)
                        , 'email_send_on' => mysql_real_escape_string(date('Y-m-d H:i:s'))
                        , 'activation_code' => mysql_real_escape_string($activation_code)
                        , 'status' => '0'
                    );
                    $insert_email_log_id = $this->common_model->insertRow($insert_data, $table_name);
                    if ($insert_email_log_id) {
                        /* Send email updation email to user */

                        $email_update_link = '<a href="' . base_url() . 'signin">Click here.</a>';
                        if (isset($lang_id) && $lang_id != '') {
                            $lang_id = $this->session->userdata('lang_id');
                        } else {
                            $lang_id = 17; // Default is 17(English)
                        }

                        $activation_link = '<a href="' . base_url() . 'profile/update-email/' . $activation_code . '">Click here</a>';

                        $reserved_words = array(
                            "||USER_NAME||" => mysql_real_escape_string($data['user_session']['user_name']),
                            "||ACTIVATION_LINK||" => $activation_link,
                            "||SITE_URL||" => mysql_real_escape_string(base_url()),
                            "||SITE_TITLE||" => mysql_real_escape_string($data['global']['site_title']),
                            "||SITE_PATH||" => mysql_real_escape_string(base_url())
                        );

                        $template_title = 'user-email-updated';
                        $arr_emailtemplate_data = $this->common_model->getEmailTemplateInfo($template_title, $lang_id, $reserved_words);
                        $recipeinets = $user_email;
                        $from = array("email" => $data['global']['site_email'], "name" => $data['global']['site_title']);
                        $subject = $arr_emailtemplate_data['subject'];
                        $message = stripcslashes($arr_emailtemplate_data['content']);
                        $mail = $this->common_model->sendEmail($recipeinets, $from, $subject, $message);
                        if ($mail) {
                            $this->session->set_userdata('msg', 'We sent email to verify your email account on ' . $user_email . ', please verify the your account.');
                            redirect(base_url() . "profile/edit");
                        }
                    }
                }
            }
        }/* main if */

        $table_to_pass = 'mst_users';
        $fields_to_pass = 'user_id,first_name,last_name,user_email,user_name,user_type,user_status,profile_picture,gender';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_data = array();
        $arr_user_data = $this->user_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        $data['arr_user_data'] = $arr_user_data[0];
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/change-email', $data);
        $this->load->view('front/includes/footer');
    }

    /* function to change the email address of user real name */

    function changeRealName() {

        /* multi language keywords file */
        $this->load->language('common');
        $this->load->language('change-real-name');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }
        $data = $this->common_model->commonFunction();
        $data['menu_active'] = "";
        $data['user_session'] = $this->session->userdata('user_account');
        /* set flag for edit profile footer option */
        $data['flagChangeRealName'] = TRUE;
        $this->load->model("user_model");
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/login/change-real-name.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>'));

        if ($this->input->post('user_name')) {
            if ($this->input->post('user_name') != '') {
                $table_name = 'mst_users';
                $update_data = array('first_name' => mysql_real_escape_string($this->input->post('user_name')));
                $condition_to_pass = array("user_id" => mysql_real_escape_string($data['user_session']['user_id']));
                $update_cnf = $this->common_model->updateRow($table_name, $update_data, $condition_to_pass);

                if ($update_cnf) {
                    $this->session->set_userdata('msg', 'Your real name has been updated successfully.');
                    redirect(base_url() . 'profile/change-real-name');
                }
            }
        }

        $table_to_pass = 'mst_users';
        $fields_to_pass = 'user_id,user_name,first_name,user_name_verified';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_data = array();
        $arr_user_data = $this->user_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        $data['arr_user_data'] = $arr_user_data[0];

        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/change-real-name', $data);
        $this->load->view('front/includes/footer');
    }

    /* fuction to avoid real name duplication */

    public function chkUserRealNameDuplicate() {

        $this->load->model('register_model');
        $user_name = $this->input->post('user_name');
        $old_real_name = $this->input->post('old_user_name');
        /* check is new real-name and old real-name are same */

        if (trim($old_real_name) == trim($user_name)) {
            echo 'true';
            exit;
        }

        $table_to_pass = 'mst_users';
        $fields_to_pass = array('user_id', 'user_name');
        $condition_to_pass = array("first_name" => $user_name);

        $arr_login_data = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        if (count($arr_login_data)) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    /* function to update user email : edit profile */

    public function updateUserEmail($activation_code) {

        $table_to_pass = 'secondary_email';
        $fields_to_pass = array('email_log_id', 'user_id', 'secondary_email', 'email_send_on', 'activation_code', 'status');
        $condition_to_pass = array("activation_code" => $activation_code);
        /* get user details to verify the email address */
        $arr_email_log = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);

        /* check user email is alredy used or not */
        if ($arr_email_log[0]['secondary_email'] != '') {

            $table_to_pass = 'mst_users';
            $fields_to_pass = array('user_id', 'user_email');
            $condition_to_pass = array("user_email" => $arr_email_log[0]['secondary_email']);
            /* get user details by email address */
            $arr_record_by_email = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);

            if (count($arr_record_by_email) > 0) {
                $this->session->set_userdata('activation_error', "The email address '" . $arr_email_log[0]['secondary_email'] . "' is already registered with us.");
                redirect(base_url() . "signin");
                exit;
            }
        }

        if (count($arr_email_log)) {
            if ($arr_email_log[0]['status'] == 1) {
                $this->session->set_userdata('activation_error', "Your have already verifired your email.");
            } else {
                /* check activation link is in valid time span (72 hrs) */
                $email_send_on = StrToTime($arr_email_log[0]['email_send_on']);
                $current_date = StrToTime(date('Y-m-d H:i:s'));
                $diff = $current_date - $email_send_on;
                $hours = round($diff / ( 60 * 60 ));

                if ($hours <= 72) {
                    /* update the status of table secondary_email and email of table users */
                    $table_name = 'secondary_email';
                    $update_data = array('status' => '1');
                    $condition_to_pass = array("activation_code" => $activation_code);
                    $this->common_model->updateRow($table_name, $update_data, $condition_to_pass);

                    /* update email */
                    $table_name = 'mst_users';
                    $update_data = array('user_email' => mysql_real_escape_string($arr_email_log[0]['secondary_email']));
                    $condition_to_pass = array("user_id" => mysql_real_escape_string($arr_email_log[0]['user_id']));
                    $this->common_model->updateRow($table_name, $update_data, $condition_to_pass);
                    $this->session->set_userdata('msg', "<strong>Congratulations !</strong>Your have successfully verified your email address !");
                } else {
                    $this->session->set_userdata('msg-error', "<strong>Sorry !</strong>Your activation code has expired.");
                }
            }
        } else {
            $this->session->set_userdata('msg-error', "Invalid activation code.");
        }
        redirect(base_url() . "signin");
    }

    /* function to restrict user to use already used password */
    public function edit_user_password_chk() {
        $this->load->model("user_model");
        $table_to_pass = 'mst_users';
        $fields_to_pass = array('user_id', 'user_password');
        $condition_to_pass = array("user_password" => md5($this->input->post('old_user_password')));
        $arr_login_data = $this->user_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        if (count($arr_login_data)) {
            echo 'true';
        } else {
            echo 'false';
        }
    }
	
	
	/* function to check user inserted correct password */
    public function user_password_chk() {
        $this->load->model("user_model");
        $table_to_pass = 'mst_users';
        $fields_to_pass = array('user_id', 'user_password');
        $condition_to_pass = array("user_password" => md5($this->input->post('password')));
        $arr_login_data = $this->user_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        if (count($arr_login_data)) {
            echo 'true';
        } else {
            echo 'false';
        }
    }
	
	

    /* function to logout the user/unset the session */

    function logout() {

        $data = $this->common_model->commonFunction();
        /* make entry in sign in log table */
        if ($this->session->userdata('last_sign_in_log_id') != '') {

            $update_table_name = 'user_sign_in_log';
            $update_data = array('last_logout' => date('Y-m-d H:i:s'),'last_activity' => strtotime(date('Y-m-d H:i:s')));
            $condition = array("log_id" => $this->session->userdata('last_sign_in_log_id'));
            $this->common_model->updateRow($update_table_name, $update_data, $condition);
            $this->session->unset_userdata('last_sign_in_log_id');
        }
        $this->session->unset_userdata('user_account');
        redirect(base_url());
    }

    /* function to check whether user has already sent  account deletion request to admin */

    function delete_profile() {

        /* multi language keywords file */
        $this->load->language('common');
        $this->load->language('delete-user-account');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }
        $data = $this->common_model->commonFunction();
        $data['menu_active'] = "";
        /* set flag for edit profile footer option */
        $data['flagAccountDeletion'] = TRUE;
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/formvalidate.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>'));

        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");
        $user_id = $data['user_session']['user_id'];

        #check that user has already requested for deactivate his account
        $data['arr_user_detail'] = $this->user_model->chkUserDeletionDetails($user_id);

        if (count($data['arr_user_detail']) > 0) {
            $this->session->set_userdata('msg-error', "You have already requested for deletion your account.");
            redirect('profile/edit');
        } else {

            $this->load->view('front/includes/header', $data);
            if ($this->session->userdata('user_account')) {
                $this->load->view('front/includes/dashboard-header');
            }
            $this->load->view('front/user-account/delete-user-profile', $data);
            $this->load->view('front/includes/footer');
        }
    }

    /* function to send the user account deletion request to admin */

    function delete_request() {

        $data = $this->common_model->commonFunction();
        $data['menu_active'] = "";
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");

        $this->form_validation->set_rules('old_user_password', 'Enter your password', 'required|min_length[8]');
        $this->form_validation->set_rules('comment', 'Enter your comment', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->delete_profile();
        } else {
            $table = 'mst_users';
            $fields = 'user_password';
            $condition = array("user_id" => $data['user_session']['user_id']);
            $arr_user_data = array();
            $arr_basic_info = $this->common_model->getRecords($table, $fields, $condition, $order_by = '', $limit = '', $debug = 0);

            #server side validation for checking password correct
            if ($arr_basic_info[0]['user_password'] != md5($this->input->post('old_user_password'))) {
                $this->session->set_userdata('msg-error', 'Password incorrect');
                redirect(base_url() . "profile/delete");
            } else {

                #Sent user request for deletion to admin
                $user_id = $data['user_session']['user_id'];
                if ($this->input->post('old_user_password') != '') {
                    $table = 'user_deletion_requests';
                    $fields = array('user_id' => mysql_real_escape_string($this->input->post('user_id')), 'comment' => mysql_real_escape_string($this->input->post('comment')), 'is_deleted' => '0');
                    $condition = '';
                    $insert_id = $this->common_model->insertRow($fields, $table);

                    if ($insert_id) {
                        $this->session->set_userdata('msg', "Your account deletion request sent successfully.");
                    }
                }
                redirect(base_url() . "signin");
            }
        }
    }

    public function trustprofile($user_name) {
        /* multi language keywords file */
        $this->load->language('common');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }

        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['menu_active'] = "";
        $this->load->model("user_model");
        $table_to_pass = 'mst_users';
        $fields_to_pass = 'user_id,first_name,user_email,email_verified,user_name,user_type,user_status,profile_picture,register_date';
        $condition_to_pass = array("user_name" => $user_name);
        $arr_user_data = array();
        $arr_user_data = $this->user_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        /* Get trust status of selected user */
        $this->load->model("trusted_contacts_model");

        /* Check that current login user has trust on seleted user */
        $data['current_user_trust_on_selected'] = $this->trusted_contacts_model->getTrustedStatusDetails($arr_user_data[0]['user_id'], $data['user_session']['user_id']);

        /* Check that seleted user trust on current user */
        $data['selected_user_trust_on_current'] = $this->trusted_contacts_model->getTrustedStatusDetails($data['user_session']['user_id'], $arr_user_data[0]['user_id']);

        /* get details of selected user */
        $data['arr_user_list'] = $this->trusted_contacts_model->getTrustedStatusDetails($arr_user_data[0]['user_id'], $data['user_session']['user_id']);
        //echo "<pre>";print_r($data);exit;
        $data['arr_user_data'] = $arr_user_data[0];


        /* Get count of trusted people */
        $arr_people_trust_you_list = $this->trusted_contacts_model->getPeopleTrustYouList($arr_user_data[0]['user_id']);
        $data['trusted_count'] = count($arr_people_trust_you_list);


        /* get user last login details */
        $table_to_pass = 'user_sign_in_log';
        $fields_to_pass = 'log_id,user_id,last_login,last_logout';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_login_details = array();
        $arr_user_login_details = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        $data['arr_user_login_details'] = $arr_user_login_details[0];

        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/trusted-user-profile', $data);
        $this->load->view('front/includes/footer');
    }

    /* Manage app page to show list of all apps and api client */

    public function manageApps() {

        /* multi language keywords file */
        $this->load->language('common');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }
        $data = $this->common_model->commonFunction();
        $data['menu_active'] = "apps";
        $data['title'] = "Manage apps";
        /* set flag for edit profile footer option */
        $data['flagLocalbitcoinApps'] = TRUE;
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/formvalidate.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>'));

        /* Get current user session */
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");
        $user_id = $data['user_session']['user_id'];

        $this->load->model("user_model");

        $data['arr_client_api'] = $this->user_model->getclientApiDetails($user_id, $api_id = '', $client_id = '');
        $data['arr_app'] = $this->user_model->getAppDetails($user_id, $app_id = '');
        /* Load view */
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/user-apps', $data);
        $this->load->view('front/includes/footer');
    }

    /* create Api client */

    public function createApiClient() {
        /* multi language keywords file */
        $this->load->language('common');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }
        $data = $this->common_model->commonFunction();
        $data['menu_active'] = "apps";
        $data['title'] = "Create a new api client";
        /* set flag for edit profile footer option */
        $data['flagLocalbitcoinApps'] = TRUE;
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/formvalidate.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>'));

        /* Get current user session */
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");
        $user_id = $data['user_session']['user_id'];

        if (count($_POST) > 0) {
			$client_scope = '';
		
			foreach($_POST['client_scope'] as $scope)
			{
				$client_scope .= $scope.','; 
			}
			
			$client_scope = rtrim($client_scope,',');

            //echo "<pre>";print_r($_POST);exit;
            $this->load->helper('string');
            $client_id = random_string('alnum', 20);

            $client_secret = random_string('alnum', 40);

            if ($this->input->post('chk_advance_options') == 'on') {
                $arr_to_insert = array(
                    "user_id" => mysql_real_escape_string($user_id),
                    "api_client_name" => mysql_real_escape_string($this->input->post('api_name')),
                    "url_prefix" => mysql_real_escape_string($this->input->post('url_prefix')),
                    "redirect_url" => mysql_real_escape_string($this->input->post('redirect_url')),
                    "client_type" => mysql_real_escape_string($this->input->post('client_type')),
                    "access_tokens" => 0,
                    "income" => 0,
                    "client_id" => $client_id,
                    "client_secret" => $client_secret,
					"client_scope" => $client_scope,
                );
            } else {
                $arr_to_insert = array(
                    "user_id" => mysql_real_escape_string($user_id),
                    "api_client_name" => mysql_real_escape_string($this->input->post('api_name')),
                    "url_prefix" => mysql_real_escape_string('http://localhost/'),
                    "redirect_url" => mysql_real_escape_string('http://localhost/'),
                    "client_type" => 0,
                    "access_tokens" => 0,
                    "income" => 0,
                    "client_id" => $client_id,
                    "client_secret" => $client_secret,
					"client_scope" => 'read',
                );
            }

            $last_insert_id = $this->common_model->insertRow($arr_to_insert, "api_client");

            $this->session->set_userdata('msg', "Client added successfully.");
            redirect(base_url() . "api-client/" . $last_insert_id);
        }

        /* inserting admin details into the dabase */



        /* Load view */
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/create-api-client', $data);
        $this->load->view('front/includes/footer');
    }

    /* view and edit Api client */

    public function editApiClient($api_id = '') {
        /* multi language keywords file */
        $this->load->language('common');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }
        $data = $this->common_model->commonFunction();
        $data['menu_active'] = "apps";
        $data['title'] = "Manage the app";
        /* set flag for edit profile footer option */
        $data['flagLocalbitcoinApps'] = TRUE;
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/formvalidate.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>'));

        /* Get current user session */
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");
        $user_id = $data['user_session']['user_id'];

        if (count($_POST) > 0) {
		
			
			$client_scope = '';
			if(!empty($_POST['client_scope'])) {
				foreach($_POST['client_scope'] as $scope)
				{
					$client_scope .= $scope.','; 
				}			
				$client_scope = rtrim($client_scope,',');
			} else {
				$client_scope = 'read';
			}

            $arr_to_update = array(
                "user_id" => mysql_real_escape_string($user_id),
                "api_client_name" => mysql_real_escape_string($this->input->post('api_name')),
                "url_prefix" => mysql_real_escape_string($this->input->post('url_prefix')),
                "redirect_url" => mysql_real_escape_string($this->input->post('redirect_url')),
				"client_scope" => $client_scope,
            );

            /* updating the user details */
            $this->common_model->updateRow("api_client", $arr_to_update, array("api_id" => $api_id));
            $this->session->set_userdata('msg', "Client edited successfully.");
        }


        $arr_client_api = $this->user_model->getclientApiDetails($user_id = '', $api_id, $client_id = '');
				
		$arr_client_scope = explode(',',$arr_client_api[0]['client_scope']);
		
		$data['arr_client_api'] = $arr_client_api;
				
		$data['arr_client_scope'] = $arr_client_scope;

        /* Load view */
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/edit-api-client', $data);
        $this->load->view('front/includes/footer');
    }

    /* regenerate api client secret key and id */

    public function regenerateApiClientSecret($api_id = '') {
        /* multi language keywords file */
        $this->load->language('common');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }
        $data = $this->common_model->commonFunction();
        $data['menu_active'] = "apps";
        $data['title'] = "Confirm client secret registration";
        /* set flag for edit profile footer option */
        $data['flagLocalbitcoinApps'] = TRUE;
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/formvalidate.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>'));

        /* Get current user session */
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");
        $user_id = $data['user_session']['user_id'];

        $data['api_id'] = $api_id;

        if (count($_POST) > 0) {

            $keys = $this->generateKeys();

            $arr_to_update = array(
                "client_id" => mysql_real_escape_string($keys['client_id']),
                "client_secret" => mysql_real_escape_string($keys['client_secret']),
            );

            /* updating the user details */
            $this->common_model->updateRow("api_client", $arr_to_update, array("api_id" => $api_id));

            $this->session->set_userdata('msg', "Secret changed successfully.");
            redirect(base_url() . "api-client/" . $api_id);
        }

        /* Load view */
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/regen-api-client-secret', $data);
        $this->load->view('front/includes/footer');
    }

    public function generateKeys() {
        $this->load->helper('string');
        $data['client_id'] = random_string('alnum', 20);
        $data['client_secret'] = random_string('alnum', 40);

        $arr_client_api = $this->user_model->getclientApiDetails($user_id = '', $api_id = '', $data['client_id']);
        if (count($arr_client_api) > 0) {
            $this->generateKeys();
        }

        return $data;
    }

    /* Authorize app */

    public function authorizeApp($api_id = '') {
        //print_r($_REQUEST);
        /* multi language keywords file */
        $this->load->language('common');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }
        $data = $this->common_model->commonFunction();
        $data['menu_active'] = "apps";
        $data['title'] = "Connect with " . $data['global']['site_title'];
        /* set flag for edit profile footer option */
        $data['flagLocalbitcoinApps'] = TRUE;
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/formvalidate.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>'));

        /* Get current user session */
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");
        $user_id = $data['user_session']['user_id'];

        $client_id = $_REQUEST['client_id'];
        /* get api deteails using client_id */
        $data['arr_client_api'] = $this->user_model->getclientApiDetails($user_id = '', $api_id = '', $client_id);

        $data['api_id'] = $data['arr_client_api'][0]['api_id'];

        /* Load view */
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/authorize-confirm', $data);
        $this->load->view('front/includes/footer');
    }

    public function authorizeConfirm($api_id = '') {

        $this->load->language('common');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }
        $data = $this->common_model->commonFunction();

        /* Get current user session */
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");
        $user_id = $data['user_session']['user_id'];

        if (count($_POST) > 0) {

            $arr_client_api = $this->user_model->getclientApiDetails($user_id = '', $api_id = $api_id, $client_id = '');

            $this->load->helper('string');

            $token = random_string('alnum', 40);

            $arr_to_insert = array(
                "user_id" => mysql_real_escape_string($arr_client_api[0]['user_id']),
                "api_id" => mysql_real_escape_string($api_id),
                "app_name" => mysql_real_escape_string($this->input->post('app_name')),
                "scope" => mysql_real_escape_string($this->input->post('scope')),
                "token" => mysql_real_escape_string($token),
            );
            $last_insert_id = $this->common_model->insertRow($arr_to_insert, "apps");

            $access_tokens = $arr_client_api[0]['access_tokens'] + 1;
            $arr_to_update = array(
                "access_tokens" => mysql_real_escape_string($access_tokens),
            );

            $this->common_model->updateRow("api_client", $arr_to_update, array("api_id" => $api_id));

            redirect($arr_client_api[0]['redirect_url']);
        }
    }

    /* Revoke token when click on delete link */

    public function revokeToken($app_id = '', $token = '') {
        /* multi language keywords file */
        $this->load->language('common');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }
        $data = $this->common_model->commonFunction();
        $data['menu_active'] = "apps";
        $data['title'] = "Confirm token revocation";
        /* set flag for edit profile footer option */
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/formvalidate.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>'));

        /* Get current user session */
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");
        $user_id = $data['user_session']['user_id'];

        $data['app_id'] = $app_id;
        $data['token'] = $token;

        $data['arr_app'] = $this->user_model->getAppDetails($user_id = '', $app_id);

        if (count($_POST) > 0) {
            //echo "<pre>";print_r($_POST);exit;

            /* deleting the app selected */
            //$this->common_model->deleteRows($app_id, "apps", "app_id");

            $this->db->delete('apps', array('app_id' => $app_id));

            $this->session->set_userdata('msg', "App deleted successfully.");
            redirect(base_url() . "apps");
        }

        /* Load view */
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/revoke-api-token', $data);
        $this->load->view('front/includes/footer');
    }

    /* Revoke all token and app access from users account */

    public function revokeTokenAll() {
        /* multi language keywords file */
        $this->load->language('common');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }
        $data = $this->common_model->commonFunction();
        $data['menu_active'] = "apps";
        $data['title'] = "Confirm clearing API access";
        /* set flag for edit profile footer option */
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/formvalidate.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>'));

        /* Get current user session */
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");
        $user_id = $data['user_session']['user_id'];

        if (count($_POST) > 0) {
            //echo "<pre>";print_r($_POST);exit;

            $arr_app = $this->user_model->getAppDetails($user_id, $app_id = '');

            //echo "<pre>";print_r($arr_app);exit;

            $i = 0;
            if (count($arr_app) > 0) {
                foreach ($arr_app as $app) {
                    $this->db->delete('apps', array('app_id' => $app['app_id']));
                    $i++;
                }
            }

            $this->session->set_userdata('msg', "" . $i . " tokens revoked successfully.");
            redirect(base_url() . "apps");
        }

        /* Load view */
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/user-account/revoke-api-token-all', $data);
        $this->load->view('front/includes/footer');
    }

}

?>