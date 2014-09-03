<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set("display_errors", "on");

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->language('common');
        $this->load->language('user-dashboard');
        $this->load->model("common_model");
        $this->load->model("dashboard_model");
		$this->load->model("wallet_model");
        CHECK_USER_STATUS();
		UpdateActiveTime();
    }

    /* List all advertisement at admin or backend side */

    function userDashboard($pg = '') {

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "signin");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['title'] = 'Dashboard';
        $data['menu_active'] = 'user-dashboard';

        $data['user_session'] = $this->session->userdata('user_account');

        /* get trade advertisment details */
        $table_to_pass = 'user_sign_in_log';
        $fields_to_pass = 'log_id,user_id,last_login,last_logout';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_login_details = array();

        $arrayPagination = array("limit" => '', "offset" => '');

        $arr_trade_list_count = $this->dashboard_model->getTradeDetailsCount($data['user_session']['user_id'], $arrayPagination);
        /* [Start:: Pagination code] */
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'user-dashboard';
        $data['count'] = $arr_trade_list_count;
        $config['total_rows'] = $arr_trade_list_count;
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
        $data['arr_trade_list'] = $this->dashboard_model->getTradeDetails($data['user_session']['user_id'], $arrayPagination);
        $data['page'] = $pg;
        /* [End:: Pagination code] */

        /* API used to get the current market price of BTC */
        $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = @file_get_contents($post_data);
		if($currencyRateArr)
		{
			//print_r($currencyRateArr);exit;
			$currencyRateArr = json_decode($currencyRateArr);
	
			for ($i = 0; $i < count($data['arr_trade_list']); $i++) {
				foreach ($currencyRateArr as $rateArr) {
					if ($rateArr->code == $data['arr_trade_list'][$i]['currency_code']) {
						$price_eq_val = $data['arr_trade_list'][$i]['price_eq_val'];
						$currency_rate = $rateArr->rate;					
						$data['arr_trade_list'][$i]['local_currency_rate'] = ((($currency_rate*100)*$price_eq_val)/100);
						$data['arr_trade_list'][$i]['local_currency_code'] = $rateArr->code;
					}
				}
			}
		}

        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/dashboard/dashboard', $data);
        $this->load->view('front/includes/footer');
    }

    /* List all advertisement at admin or backend side */
	
	
	/* Get all active contacts */
	function activeContacts($pg = 0) {

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "signin");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['title'] = 'Active contact';
        $data['menu_active'] = 'active';
        $data['user_session'] = $this->session->userdata('user_account');

        /* get trade advertisment details */
        $table_to_pass = 'user_sign_in_log';
        $fields_to_pass = 'log_id,user_id,last_login,last_logout';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_login_details = array();
        $arrayPagination = array("limit" => '', "offset" => '');

        $arr_trade_status_list_count = $this->dashboard_model->getTradeStatusDetailsCount($data['user_session']['user_id'], 'pending', $debug = 0);
        /* [Start:: Pagination code] */
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'ads/active';
        $data['count'] = $arr_trade_status_list_count;
        $config['total_rows'] = $arr_trade_status_list_count;
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
        $data['arr_trade_status_list'] = $this->dashboard_model->getTradeStatusDetails($data['user_session']['user_id'], 'pending', $debug = 0, $arrayPagination);
        $data['page'] = $pg;
        /* [End:: Pagination code] */
		
		//echo "<pre>";print_r($data['arr_trade_status_list']);exit;
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/dashboard/active', $data);
        $this->load->view('front/includes/footer');
    }

    function closedContacts($pg = 0) {

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "signin");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['title'] = 'All closed contacts';
        $data['menu_active'] = 'closed';
        $data['user_session'] = $this->session->userdata('user_account');

        /* get trade advertisment details */
        $table_to_pass = 'user_sign_in_log';
        $fields_to_pass = 'log_id,user_id,last_login,last_logout';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_login_details = array();
        $arrayPagination = array("limit" => '', "offset" => '');

        $arr_trade_status_list_count = $this->dashboard_model->getTradeStatusDetailsCount($data['user_session']['user_id'], '', $debug = 0);
        /* [Start:: Pagination code] */
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'ads/closed';
        $data['count'] = $arr_trade_status_list_count;
        $config['total_rows'] = $arr_trade_status_list_count;
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
        $data['arr_trade_status_list'] = $this->dashboard_model->getTradeStatusDetails($data['user_session']['user_id'], '', $debug = 0, $arrayPagination);
        $data['page'] = $pg;
        /* [End:: Pagination code] */
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/dashboard/closed', $data);
        $this->load->view('front/includes/footer');
    }

    function releasedContacts($pg = '') {

        $pg = ($pg == '') ? 0 : $pg;
        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "signin");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['title'] = 'Released contact';
        $data['menu_active'] = 'released';

        $data['user_session'] = $this->session->userdata('user_account');

        /* get trade advertisment details */
        $table_to_pass = 'user_sign_in_log';
        $fields_to_pass = 'log_id,user_id,last_login,last_logout';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_login_details = array();

        $arr_trade_status_list_count = $this->dashboard_model->getTradeStatusDetailsCount($data['user_session']['user_id'], 'released', $debug = 0);

        /* [Start:: Pagination code] */
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'ads/released';
        $data['count'] = $arr_trade_status_list_count;
        $config['total_rows'] = $arr_trade_status_list_count;
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
        $data['arr_trade_status_list'] = $this->dashboard_model->getTradeStatusDetails($data['user_session']['user_id'], 'released', $debug = 0, $arrayPagination);
        $data['page'] = $pg;
        /* [End:: Pagination code] */
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/dashboard/released', $data);
        $this->load->view('front/includes/footer');
    }

    function canceledContacts($pg = '') {

        $pg = ($pg == '') ? 0 : $pg;

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "signin");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['title'] = 'Cancelled contact';
        $data['menu_active'] = 'canceled';

        $data['user_session'] = $this->session->userdata('user_account');

        /* get trade advertisment details */
        $table_to_pass = 'user_sign_in_log';
        $fields_to_pass = 'log_id,user_id,last_login,last_logout';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_login_details = array();
        $arr_trade_status_list_count = $this->dashboard_model->getTradeStatusDetailsCount($data['user_session']['user_id'], 'cancelled', $debug = 0);
//$data['arr_trade_status_list'] = $arr_trade_status_list;


        /* [Start:: Pagination code] */
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'ads/canceled';
        $data['count'] = $arr_trade_status_list_count;
        $config['total_rows'] = $arr_trade_status_list_count;
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
        $data['arr_trade_status_list'] = $this->dashboard_model->getTradeStatusDetails($data['user_session']['user_id'], 'cancelled', $debug = 0, $arrayPagination);
        $data['page'] = $pg;
        /* [End:: Pagination code] */


        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/dashboard/canceled', $data);
        $this->load->view('front/includes/footer');
    }

    /* function to show trade details to seller and buyer */

    function advertise_detailed_info($trade_id = '', $transaction_id = '', $debug = '') {

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "signin");
        }

        $trade_id = base64_decode($trade_id);
        $transaction_id = base64_decode($transaction_id);
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['title'] = 'Contact';
        $data['menu_active'] = '';
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/backend/js/jquery.validate.min.js"></script>', '<script src="' . base_url() . 'media/front/js/post-trade/edit-advertise.js"></script>'));
		
		/* Get wallet balance */
		$user_id = $data['user_session']['user_id'];

        /* Get wallet information */
        $wallet_deatils = $this->wallet_model->getTableInformation("user_wallets", "", array("user_id" => $user_id), "wallet_id  DESC", '', 0);
        $data['wallet_deatils'] = $wallet_deatils;
		
		/* Get wallet balance */
		$arr_wallet_bal_param = array(
			"user_id" => $user_id,
			"password" => $wallet_deatils[0]['wallet_password'],
			"guid" => $wallet_deatils[0]['wallet_guid']
		);
		$wallet_balance = $this->wallet_model->getWalletBalance($user_id, $arr_wallet_bal_param);
		$data['wallet_balance'] = $wallet_balance/100000000;

        /* using the user model to get user advertisement details */
        $data['arr_trade_request_details'] = $this->dashboard_model->getTradeDetailsByTransactionId($trade_id, $transaction_id, $debug = 0);
        $data['arr_trade_request_details'] = $data['arr_trade_request_details'][0];

        /* get buyer information */
        $this->load->model('register_model');
        $table_to_pass = 'mst_users';
        $fields_to_pass = array('user_id', 'first_name', 'last_name', 'user_name');
        $condition_to_pass = array("user_id" => $data['arr_trade_request_details']['buyer_id']);
        $data['arr_buyer_data'] = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        $data['arr_buyer_data'] = $data['arr_buyer_data'][0];

        /* get seller information */
        $table_to_pass = 'mst_users';
        $fields_to_pass = array('user_id', 'first_name', 'last_name', 'user_name');
        $condition_to_pass = array("user_id" => $data['arr_trade_request_details']['seller_id']);
        $data['arr_seller_data'] = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        $data['arr_seller_data'] = $data['arr_seller_data'][0];
		
		/* Get trade chat details */
		$data['arr_trade_chat_details'] = $this->dashboard_model->getTradeChatDetails($trade_id, $transaction_id, $debug = 0);
		
		/* Get wallet information */
		$user_id = $data['user_session']['user_id'];
        $wallet_deatils = $this->wallet_model->getTableInformation("user_wallets", "", array("user_id" => $user_id), "wallet_id  DESC", '', 0);
        $data['wallet_deatils'] = $wallet_deatils[0];
		
		/* get details of selected user */
		if($data['user_session']['user_id'] == $data['arr_trade_request_details']['buyer_id'])
		{
			$trust_user_id = $data['arr_trade_request_details']['seller_id'];
			$data['update_for'] = $data['arr_seller_data']['user_name'];
		}
		else
		{
			$trust_user_id = $data['arr_trade_request_details']['buyer_id'];
			$data['update_for'] = $data['arr_buyer_data']['user_name'];
		}
		
		$this->load->model('trusted_contacts_model');
        $data['arr_user_list'] = $this->trusted_contacts_model->getTrustedStatusDetails($trust_user_id,$data['user_session']['user_id']);
		
		if(count($data['arr_user_list']) < 1)
		{
			$table_name = 'trusted_people';
			$insert_data = array(
				'invitation_from' => mysql_real_escape_string($data['user_session']['user_id'])
				, 'invitation_to' => $trust_user_id
				, 'friend_email' => ''
				, 'status' => 'T'
				, 'is_requested' => '2'
				, 'feedback_comment' => 'I invited you to cryptosi'
				, 'updated_on' => mysql_real_escape_string(date('Y-m-d H:i:s'))
			);
			$last_insert_trust_id = $this->common_model->insertRow($insert_data, $table_name);
			$data['arr_user_list'] = $this->trusted_contacts_model->getTrustedStatusDetails($trust_user_id,$data['user_session']['user_id']);
		}       
		
		//echo "<pre>";print_r($data['arr_user_list']);exit;

        /* using the currency model */
        $this->load->model('currency_model');
        $data['arr_currency_details'] = $this->currency_model->getCurrencyDetailsById($data['arr_trade_request_details']['currency_id']);
        $data['arr_currency_details'] = $data['arr_currency_details'][0];

        $this->load->view('front/includes/header', $data);
        $this->load->view('front/dashboard/ad-details', $data);
        $this->load->view('front/includes/footer');
    }
	
	public function enableEscrow($contact_id = '')
	{
		/* Getting Common data */
		$data = $this->common_model->commonFunction();
		
		/* Get details of contact */		
		$arr_trade_escrow_details = $this->dashboard_model->getTradeDetailsByTransactionId($trade_id = '', $contact_id, $debug = 0);
		
		/* Create new escrow wallet address */
		$post_data = "https://blockchain.info/merchant/" . $data['global']['admin_wallet_guid'] . "/new_address";
		$post_data .= "?password=" . $data['global']['admin_wallet_password'];
		$post_data .= "&label=contact".$arr_trade_escrow_details[0]['transaction_id'];

		//echo $post_data;exit;
		$wallet_new_address = file_get_contents($post_data);
		$wallet_new_address = json_decode($wallet_new_address);
		$wallet_new_address = $wallet_new_address->address;
	
		if($wallet_new_address != ''){
			/* insert escrow details for the selected contact */
			$escrow_transaction_id = time() . rand();
			
			$fields = array(
				'escrow_transaction_id' => mysql_real_escape_string($escrow_transaction_id),
				'escrow_wallet_address' => mysql_real_escape_string($wallet_new_address),
				'trade_id' => mysql_real_escape_string($arr_trade_escrow_details[0]['trade_id']),
				'contact_id' => mysql_real_escape_string($arr_trade_escrow_details[0]['transaction_id']),
				'buyer_user_id' => mysql_real_escape_string($arr_trade_escrow_details[0]['buyer_id']),
				'seller_user_id' => mysql_real_escape_string($arr_trade_escrow_details[0]['seller_id']),
				'seller_funded' => 'N',
				'escrow_status' => 'E',
			);
									
			$table = 'mst_escrow_management';
			$escrow_last_insert_id = $this->common_model->insertRow($fields, $table);
						
			/* Maintain log of escrow event transaction */
			$fields = array(
				'escrow_transaction_id' => mysql_real_escape_string($escrow_transaction_id),
				'description' => 'Escrow transaction created',
			);									
			$table = 'trans_escrow_log';
			$this->common_model->insertRow($fields, $table);
						
			$this->session->set_userdata("msg", "<span class='success'>Escrow for this transaction enabled successfully. </span>");
			
			redirect(base_url() . 'ads/detailed-info/'.base64_encode($arr_trade_escrow_details[0]['trade_id']).'/'.base64_encode($arr_trade_escrow_details[0]['transaction_id']));
		}
		else
		{
			$this->session->set_userdata("msg-error", "<span class='success'>Escrow failed. </span>");
			
			redirect(base_url() . 'ads/detailed-info/'.base64_encode($arr_trade_escrow_details[0]['trade_id']).'/'.base64_encode($arr_trade_escrow_details[0]['transaction_id']));				
		}
			
	}
	
	/* Fund escrow by seller */
	public function makeEscrowPayment()
	{
		//echo "<pre>";print_r($_POST);exit;
		
		/* user session values */
		$data['user_session'] = $this->session->userdata('user_account');
		$user_id = $data['user_session']['user_id'];		

		/* get wallet information of user who is funding to escrow */
		$table_to_pass = 'user_wallets';
		$fields_to_pass = 'wallet_id,user_id,wallet_password,wallet_guid,wallet_address';
		$condition_to_pass = array("user_id" => $user_id);
		$arr_currency_details = array();
		$arr_currency_details = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
		
		/* Make an escrow payment or fund to the admins escrow */						
		$amt_in_satoshi = (int)($this->input->post('btc_amount') * 100000000);
		
		$guid=$arr_currency_details[0]['wallet_guid'];
		$main_password=$arr_currency_details[0]['wallet_password'];
		$amount=$amt_in_satoshi;
		$address=$this->input->post('escrow_wallet_address');
		$note="contact".$this->input->post('transaction_id')."funding";
		
		$json_url = "http://blockchain.info/merchant/$guid/payment?password=$main_password&to=$address&amount=$amount&note=$note";
		
		$json_data = file_get_contents($json_url);
		//echo "<pre>";print_r($json_data);exit;
		
		$json_feed = json_decode($json_data);
		
		if(!($json_feed->error))
		{
			$message = $json_feed->message;
			$txid = $json_feed->tx_hash;
		
			/* Update the status of transaction  */		
			$arr_to_update = array("seller_funded" => 'F');		
			$condition_array = array('escrow_transaction_id ' => $this->input->post('escrow_transaction_id'));		
			$this->common_model->updateRow('mst_escrow_management', $arr_to_update, $condition_array);
			
			
			/* Maintain log of escrow event transaction */
			$fields = array(
				'escrow_transaction_id' => mysql_real_escape_string($this->input->post('escrow_transaction_id')),
				'description' => 'Seller made an escrow payment',
			);									
			$table = 'trans_escrow_log';
			$this->common_model->insertRow($fields, $table);
			
			/* Change status of wallet address as to AN */
			$table_name = 'user_wallets';
			$update_data = array(
				'wallet_status' => 'AN',					
			);
			$condition = array("wallet_address" => $arr_currency_details[0]['wallet_address']);
			$last_insert_id = $this->common_model->updateRow($table_name, $update_data, $condition);
			
			/* Get wallet balance */
			$arr_wallet_bal_param = array(
				"user_id" => $user_id,
				"password" => $arr_currency_details[0]['wallet_password'],
				"guid" => $arr_currency_details[0]['wallet_guid']
			);
			$wallet_balance = $this->wallet_model->getWalletBalance($user_id, $arr_wallet_bal_param);
			$wallet_balance = $wallet_balance/100000000;
			/* Set wallet balance in session value. */
			$this->session->set_userdata('user_wallet_balance',$wallet_balance);		
			
			$this->session->set_userdata("msg", "<span class='success'>".$message."</span>");           
						
		}
		else
		{
			/* if something going wrong providing error message. */
			$this->session->set_userdata("msg-error", "<span class='success'>".$json_feed->error."</span>");            			
		
		}

	}
	
	/* Release escrow to the buyer */
	public function makeEscrowRelease()
	{	
		//echo "<pre>";print_r($_POST);exit;
		
		/* Getting Common data */
        $data = $this->common_model->commonFunction();

		$user_id = $this->input->post('buyer_user_id');
		
		/* get wallet information of user who is funding to escrow */
		$table_to_pass = 'user_wallets';
		$fields_to_pass = 'wallet_id,user_id,wallet_password,wallet_guid,wallet_address';
		$condition_to_pass = array("user_id" => $user_id);
		$arr_currency_details = array();
		$arr_currency_details = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
		
		/* Release escrow and transfer funds to the buyer in btc amount */						
		$amt_in_satoshi = (int)($this->input->post('btc_amount') * 100000000);
		
		$guid=$data['global']['admin_wallet_guid'];
		$main_password=$data['global']['admin_wallet_password'];
		$from = $this->input->post('escrow_wallet_address');
		$amount=$amt_in_satoshi;
		$address=$arr_currency_details[0]['wallet_address'];
		$note="contact".$this->input->post('transaction_id')."release";
		
		$json_url = "http://blockchain.info/merchant/$guid/payment?password=$main_password&to=$address&amount=$amount&from=$from&note=$note";
		//echo $json_url;exit;
		$json_data = file_get_contents($json_url);
		//echo "<pre>";print_r($json_data);exit;
		
		$json_feed = json_decode($json_data);
		
		//echo "<pre>";print_r($json_feed);exit;
		
		if(!($json_feed->error))
		{
			$message = $json_feed->message;
			$txid = $json_feed->tx_hash;
		
			/* Update the status of transaction  */		
			$arr_to_update = array("seller_funded" => 'R');		
			$condition_array = array('escrow_transaction_id ' => $this->input->post('escrow_transaction_id'));		
			$this->common_model->updateRow('mst_escrow_management', $arr_to_update, $condition_array);
			
			
			/* Maintain log of escrow event transaction */
			$fields = array(
				'escrow_transaction_id' => mysql_real_escape_string($this->input->post('escrow_transaction_id')),
				'description' => 'Seller releases escrow.',
			);									
			$table = 'trans_escrow_log';
			$this->common_model->insertRow($fields, $table);
			
			/* updating the contact/transaction status. */
            $arr_to_update = array("transaction_status" => "released");
            /* condition to update status */
            $condition_array = array('transaction_id' => intval($this->input->post('transaction_id')));
            /* updating the record */
            $this->common_model->updateRow('buy_sell_transaction', $arr_to_update, $condition_array);			
			
			
				/* Send mail to buyer */				
				if (isset($lang_id) && $lang_id != '') {
					$lang_id = $this->session->userdata('lang_id');
				} else {
					$lang_id = 17; /* Default is 17(English) */
				}
				$base_url = base_url();
				
				/* using the user model to get user advertisement details */
				$transaction_id = $this->input->post('transaction_id');
        		$arr_trade_request_details = $this->dashboard_model->getTradeDetailsByTransactionId('', $transaction_id, $debug = 0);
        		$arr_trade_request_details = $arr_trade_request_details[0];	
				
				$trade_id = base64_encode($arr_trade_request_details['trade_id']);
				$transaction_id = base64_encode($arr_trade_request_details['transaction_id']);
				$verify_code = $arr_trade_request_details['verify_code'];
				$funds = $this->input->post('btc_amount');
				
				/* get buyer information */
				$this->load->model('register_model');
				$table_to_pass = 'mst_users';
				$fields_to_pass = array('user_id', 'user_name', 'user_email');
				$condition_to_pass = array("user_id" => $arr_trade_request_details['buyer_id']);
				$arr_buyer_data = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
				$arr_buyer_data = $arr_buyer_data[0];
		
				/* get seller information */
				$table_to_pass = 'mst_users';
				$fields_to_pass = array('user_id', 'user_name', 'user_email');
				$condition_to_pass = array("user_id" => $arr_trade_request_details['seller_id']);
				$arr_seller_data = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
				$arr_seller_data = $arr_seller_data[0];
				
				/* additional links in email */
				$site_title = '<a href="' . base_url() . '">sell&buybitcoin</a>';
				$feedback_link = '<a href="' . base_url() . 'ads/detailed-info/'.$trade_id.'/'.$transaction_id.'=">Please leave feedback for this buyer.</a>';	
	
				$reserved_words = array(
					"||SELLER_NAME||" => mysql_real_escape_string($arr_seller_data['user_name']),
					"||BUYER_NAME||" => mysql_real_escape_string($arr_buyer_data['user_name']),
					"||FUNDS||" => mysql_real_escape_string($funds),
					"||VERIFY_CODE||" => mysql_real_escape_string($verify_code),
					"||FEEDBACK_LINK||" => mysql_real_escape_string($feedback_link),
					"||SITE_PATH||" => mysql_real_escape_string($base_url)
				);
				$template_title = 'trade-confirmed';
				$arr_emailtemplate_data = $this->common_model->getEmailTemplateInfo($template_title, $lang_id, $reserved_words);
				$recipeinets = mysql_real_escape_string($arr_seller_data['user_email']);
				$from = array("email" => $data['global']['site_email'], "name" => $data['global']['site_title']);
				$subject = $arr_emailtemplate_data['subject'];
				$message = stripcslashes($arr_emailtemplate_data['content']);
				$mail = $this->common_model->sendEmail($recipeinets, $from, $subject, $message);
				if ($mail) {
					$this->session->set_userdata("msg", "<span class='success'>".$message."</span>");		
				} else {			
            		$this->session->set_userdata("msg", "<span class='success'>".$message."</span>");
				}
						
		}
		else
		{
			/* if something going wrong providing error message. */
            $this->session->set_userdata("msg-error", "<span class='success'>".$json_feed->error."</span>");		
		
		}

	}

    public function changeStatus() {

        if ($this->input->post('trade_id') != "") {
            /* updating the trade status. */
            $status = ($this->input->post('status') == 'I') ? 'A' : 'I';
            $arr_to_update = array("status" => $status);
            /* condition to update status */
            $condition_array = array('trade_id' => intval($this->input->post('trade_id')));
            /* updating the record */
            $this->common_model->updateRow('mst_trades', $arr_to_update, $condition_array);
        } else {
            /* if something going wrong providing error message. */
            echo json_encode(array("error" => "1", "error_message" => "Sorry, your request can not be fulfilled this time."));
        }
    }

    /* send reply message email to the buyer / seller */

    public function send_reply_to_trade_request() {

        /* load models */
        $this->load->model("user_model");

        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['menu_active'] = "";

        /* request send for buy / sell by user */
        //if ($this->input->post('send_trade_msg') != '') {

            /* insert contact message into trade chat table */
            $fields = array(
                'chat_id' => '',
                'trade_id' => mysql_real_escape_string($this->input->post('trade_id')),
                'transaction_id' => mysql_real_escape_string($this->input->post('transaction_id')),
                'msg_from_user_id' => mysql_real_escape_string($this->input->post('msg_from_user_id')),
                'msg_to_user_id' => mysql_real_escape_string($this->input->post('msg_to_user_id')),
                'contact_message' => $this->input->post('contact_message'),
            );
            $table = 'trade_chat';
            $chat_last_insert_id = $this->common_model->insertRow($fields, $table);
            /* get usesr information for email sending */
            $this->load->model('register_model');
            $table_to_pass = 'mst_users';
            $fields_to_pass = array('user_id', 'first_name', 'last_name', 'user_name', 'user_email');
            $condition_to_pass = array("user_id" => $this->input->post('msg_to_user_id'));
            $arr_user_info = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 1);
            $arr_user_info = $arr_user_info[0];

            /* Send trade request message email to advertiser */

            if (isset($lang_id) && $lang_id != '') {
                $lang_id = $this->session->userdata('lang_id');
            } else {
                $lang_id = 17; /* Default is 17(English) */
            }
            $base_url = '<a href="' . base_url() . '">' . $data['global']['site_title'] . '</a>';
            $site_title = '<a href="' . base_url() . '">' . $data['global']['site_title'] . '</a>';

            $reserved_words = array(
                "||USER_NAME||" => mysql_real_escape_string($arr_user_info['user_name']),
                "||CONTACT_MESSAGE||" => mysql_real_escape_string($this->input->post('contact_message')),
                "||USER_EMAIL||" => mysql_real_escape_string($arr_user_info['user_email']),
                "||SITE_URL||" => mysql_real_escape_string($base_url),
                "||SITE_TITLE||" => mysql_real_escape_string($site_title),
            );

            $template_title = 'cryptosi-trade-message';
            $arr_emailtemplate_data = $this->common_model->getEmailTemplateInfo($template_title, $lang_id, $reserved_words);
            $recipeinets = mysql_real_escape_string($arr_user_info['user_email']);
            $from = array("email" => $data['global']['site_email'], "name" => $data['global']['site_title']);
            $subject = $arr_emailtemplate_data['subject'];
            $message = stripcslashes($arr_emailtemplate_data['content']);
            $mail = $this->common_model->sendEmail($recipeinets, $from, $subject, $message);

            if ($mail) {
                $this->session->set_userdata('msg', 'Trade message sent successfully.');
                //redirect(base_url() . 'ads/closed');
            }
        //}
    }

    /* this function is used to cancel or close the request */

    function cancelDeal() {

        if ($_POST['btn_cancel'] == 'cancel_deal') {
		
			$trade_id = base64_encode($this->input->post('trade_id'));
			$transaction_id = base64_encode($this->input->post('transaction_id'));
			
			/* Getting Common data */
        	$data = $this->common_model->commonFunction();
        	$data['user_session'] = $this->session->userdata('user_account');
		
			if($this->input->post('refundable_amount') != ''){
				/* Release escrow and transfer funds to the buyer in btc amount */						
				$amt_in_satoshi = (int)($this->input->post('refundable_amount') * 100000000);
				
				$guid=$data['global']['admin_wallet_guid'];
				$main_password=$data['global']['admin_wallet_password'];
				$amount=$amt_in_satoshi;
				$address=$this->input->post('return_wallet_address');
				$note='contact #'.$this->input->post('transaction_id').' cancelled';
				
				$json_url = "http://blockchain.info/merchant/$guid/payment?password=$main_password&to=$address&amount=$amount&e=$note";
				//echo $json_url;exit;
				$json_data = file_get_contents($json_url);
				//echo "<pre>";print_r($json_data);exit;			
				$json_feed = json_decode($json_data);
				
				if(!($json_feed->error))
				{
					$arr_to_update = array("transaction_status" => 'cancelled',"action_taken_by" => $data['user_session']['user_id']);
					$this->common_model->updateRow("buy_sell_transaction", $arr_to_update, array("transaction_id" => $this->input->post('transaction_id')));
					$this->session->set_userdata("msg", "<span class='success'>Deal has been canceled!</span>");
					
					redirect(base_url() . 'ads/detailed-info/'.$trade_id.'/'.$transaction_id);	
				}
				else {
				
					$this->session->set_userdata("msg-error", "<span class='success'>".$json_feed->error."</span>");
				
					redirect(base_url() . 'ads/detailed-info/'.$trade_id.'/'.$transaction_id);				
				}
				
			} else {
			
				$arr_to_update = array("transaction_status" => 'cancelled',"action_taken_by" => $data['user_session']['user_id']);
				$this->common_model->updateRow("buy_sell_transaction", $arr_to_update, array("transaction_id" => $this->input->post('transaction_id')));
				$this->session->set_userdata("msg", "<span class='success'>Deal has been canceled!</span>");
				
				redirect(base_url() . 'ads/detailed-info/'.$trade_id.'/'.$transaction_id);	
			
			}
			
		
		
            
        }
        //redirect(base_url() . 'user-dashboard');
    }

    /* function to change status of trade request */

    public function change_trade_request_status() {

        if ($this->input->post('transaction_status') != '') {
            $arr_to_update = array("transaction_status" => $this->input->post('transaction_status'));
            $flag_update = $this->common_model->updateRow("buy_sell_transaction", $arr_to_update, array("transaction_id" => $this->input->post('transaction_id')));
            if ($flag_update) {
                echo TRUE;
            }
        }
    }

    /* make payment of trade request */

    public function btc_make_payment($transaction_id) {
        //echo $transaction_id;

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "signin");
        }

        $trade_id = base64_decode($trade_id);
        $transaction_id = base64_decode($transaction_id);
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['title'] = 'make payment';
        $data['menu_active'] = '';
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/backend/js/jquery.validate.min.js"></script>'));



        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/dashboard/released', $data);
        $this->load->view('front/includes/footer');
    }
	
	/* print contact_receipt*/
	
	public function contact_receipt($transaction_id)
	{
		/* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['title'] = 'Contact receipt';
        $data['menu_active'] = '';        

        /* using the user model to get user advertisement details */
        $data['arr_trade_request_details'] = $this->dashboard_model->getTradeDetailsByTransactionId($trade_id = '', $transaction_id, $debug = 0);
        $data['arr_trade_request_details'] = $data['arr_trade_request_details'][0];

        /* get buyer information */
        $this->load->model('register_model');
        $table_to_pass = 'mst_users';
        $fields_to_pass = array('user_id', 'first_name', 'last_name', 'user_name');
        $condition_to_pass = array("user_id" => $data['arr_trade_request_details']['buyer_id']);
        $data['arr_buyer_data'] = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        $data['arr_buyer_data'] = $data['arr_buyer_data'][0];

        /* get seller information */
        $table_to_pass = 'mst_users';
        $fields_to_pass = array('user_id', 'first_name', 'last_name', 'user_name');
        $condition_to_pass = array("user_id" => $data['arr_trade_request_details']['seller_id']);
        $data['arr_seller_data'] = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        $data['arr_seller_data'] = $data['arr_seller_data'][0];
		
		/* Get trade chat details */
		$data['arr_trade_chat_details'] = $this->dashboard_model->getTradeChatDetails($trade_id, $transaction_id, $debug = 0);
		
		/* using the currency model */
        $this->load->model('currency_model');
        $data['arr_currency_details'] = $this->currency_model->getCurrencyDetailsById($data['arr_trade_request_details']['currency_id']);
        $data['arr_currency_details'] = $data['arr_currency_details'][0];
		
        $this->load->view('front/dashboard/print-receipt', $data);	
		
	}

}

?>
