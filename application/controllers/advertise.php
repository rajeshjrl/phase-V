<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set("display_errors", "on");

class Advertise extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("common_model");
        $this->load->language("common");
        $this->load->language('post-trade');
        CHECK_USER_STATUS();
		UpdateActiveTime();
    }

    /* List all advertisement at admin or backend side */

    function list_advertisement() {

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
                $arr_trade_ids = $this->input->post('checkbox');
                if (count($arr_trade_ids) > 0) {

                    if (count($arr_trade_ids) > 0) {
                        /* deleting the user selected */
                        $this->common_model->deleteRows($arr_trade_ids, "mst_trades", "trade_id");
                    }
                    $this->session->set_userdata("msg", "<span class='success'>Advertisement deleted successfully!</span>");
                }
            }
        }

        /* checking user has privilige for the Manage Admin */
        //if ($data['user_account']['role_id'] != 1) {
        /* an admin which is not super admin not privileges to access Manage Role */
        /* setting session for displaying notiication message. */
        //$this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
        //redirect(base_url() . "backend/home");
        //}

        /* using the user model to get user advertisement details */
        $this->load->model('user_model');
        $data['title'] = "List user advertisement";
        $data['arr_user_list'] = $this->user_model->getUserAdvertisementDetails('');
        $this->load->view('backend/post-trade/advertise-list', $data);
    }

    function trade_requests_list() {

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
                $transaction_id = $this->input->post('checkbox');
                if (count($transaction_id) > 0) {
                    if (count($transaction_id) > 0) {
                        /* deleting the user selected */
                        $this->common_model->deleteRows($transaction_id, "buy_sell_transaction", "transaction_id");
                        $this->common_model->deleteRows($transaction_id, "trade_chat", "transaction_id");
                    }
                    $this->session->set_userdata("msg", "<span class='success'>Trade request deleted successfully!</span>");
                }
            }
        }
        /* checking user has privilige for the Manage Admin */
        if ($data['user_account']['role_id'] != 1) {
            /* an admin which is not super admin not privileges to access Manage Role */
            /* setting session for displaying notiication message. */
            $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
            redirect(base_url() . "backend/home");
        }
        /* using the buy_sell_bitcoin_model to get user advertisement details */
        $this->load->model('buy_sell_bitcoin_model');
        $data['title'] = "trade requests list";
        $data['arr_trade_request_details'] = $this->buy_sell_bitcoin_model->getAllTradeRequestDetails($debug_to_pass = 0);
        $this->load->view('backend/post-trade/trade-request-list', $data);
    }

    public function change_trade_status() {

        if ($this->input->get('transaction_id') != "") {
            $status = ($this->input->get('status'));
            $arr_to_update = array("transaction_status" => $status);
            $condition_array = array('transaction_id' => intval($this->input->get('transaction_id')));
            $status_change = $this->common_model->updateRow('buy_sell_transaction', $arr_to_update, $condition_array);
            echo ($status_change) ? 'true' : 'false';
        }
    }

    /* Add advertisement form at backend */

    function add_advertisement() {

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        /* checking user has privilige for the Manage Admin */
        if ($data['user_account']['role_id'] != 1) {
            /* an admin which is not super admin not privileges to access Manage Role */
            /* setting session for displaying notiication message. */
            $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
            redirect(base_url() . "backend/home");
        }

        /* using the user model to get user advertisement details */
        $data['title'] = "Add user advertisement";

        $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = file_get_contents($post_data);
        $data['arr_currencay_rates'] = $currencyRateArr;
        $currencyRateArr = json_decode($currencyRateArr);
        $data['currencyRateArr'] = $currencyRateArr;

        foreach ($currencyRateArr as $rateArr)
        /* get current btc rate in us doller */
            if ($rateArr->code == trim('USD')) {
                $data['btc_rate_in_usd'] = $rateArr->rate;
                $data['usd_currency_name'] = $rateArr->name;
                $data['usd_currency_code'] = $rateArr->code;
            }
        /* using the currency model */
        $this->load->model('currency_model');
        $data['arr_currency_details'] = $this->currency_model->getCurrencyDetails();
        $data['arr_payment_method_details'] = $this->currency_model->getPaymentMethodDetails();

        $this->load->view('backend/post-trade/add-advertise', $data);
    }

    /* Add advertisement function for backend form */

    function add_advertisement_action() {

        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $user_id = $data['user_session']['user_id'];

        if (count($_POST) > 0) {
            if ($this->input->post('btn_submit') != "") {
                $ip = (($_SERVER['REMOTE_ADDR'] == '127.0.0.1') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.96')) ? '192.168.2.96' : $_SERVER['REMOTE_ADDR'];
                /* save geo location information to geo_location table */
                $arr_to_insert = array(
                    "user_id" => mysql_real_escape_string($user_id),
                    "ip" => mysql_real_escape_string($ip),
                    "city" => mysql_real_escape_string($this->input->post('city')),
                    'region' => mysql_real_escape_string($this->input->post('state')),
                    'country' => mysql_real_escape_string($this->input->post('country')),
                    'lattitude' => mysql_real_escape_string($this->input->post('latitude')),
                    'longitude' => mysql_real_escape_string($this->input->post('longitude')),
                    'location' => mysql_real_escape_string($this->input->post('location')),
                    'created_on' => date("Y-m-d H:i:s")
                );
                /* inserting advertisement details into the mst_trades table */
                $geo_location_id = $this->common_model->insertRow($arr_to_insert, "geo_location");

                $floating_price_chk = ($this->input->post('floating_price_chk') == 'Y') ? 'Y' : 'N';
                /* user published add save to the database */
                $arr_to_insert = array(
                    "user_id" => mysql_real_escape_string($user_id),
                    "geo_location_id" => mysql_real_escape_string($geo_location_id),
                    "payment_method_id" => mysql_real_escape_string($this->input->post('payment_method')),
                    "currency_id" => mysql_real_escape_string($this->input->post('currency')),
                    'trade_type' => $this->input->post('trade_type'),
                    'bank_service' => mysql_real_escape_string($this->input->post('bank_name')),
                    'premium' => mysql_real_escape_string($this->input->post('premium')),
					'price_eq' => mysql_real_escape_string($this->input->post('price_eq')),
					'price_eq_val' => mysql_real_escape_string($this->input->post('price_eq_val')),
                    'floating_price_chk' => mysql_real_escape_string($floating_price_chk),
                    'float_premium' => mysql_real_escape_string($this->input->post('float_premium')),
                    'min_amount' => mysql_real_escape_string($this->input->post('min_amt')),
                    'max_amount' => mysql_real_escape_string($this->input->post('max_amt')),
                    'contact_hours' => mysql_real_escape_string($this->input->post('contact_hrs')),
                    'meeting_place' => mysql_real_escape_string($this->input->post('meeting_place')),
                    'other_information' => $this->input->post('other_info'),
                    'status' => 'A',
                    'created_on' => date("Y-m-d H:i:s")
                );
                /* inserting advertisement details into the mst_trades table */
                $last_insert_id = $this->common_model->insertRow($arr_to_insert, "mst_trades");

                $display_reference = ($this->input->post('reference_chk') == '') ? 'N' : $this->input->post('reference_chk');

                $arr_to_insert = array(
                    "trade_id" => mysql_real_escape_string($last_insert_id),
                    "bank_transfer_details" => $this->input->post('bank_detail'),
                    "min_volume" => mysql_real_escape_string($this->input->post('min_volume')),
                    "min_feedback_score" => mysql_real_escape_string($this->input->post('min_feedback')),
                    "new_buyer_limit" => mysql_real_escape_string($this->input->post('buyer_limit')),
                    'tvc' => mysql_real_escape_string($this->input->post('volume_coefficient')),
                    'display_reference' => mysql_real_escape_string($display_reference),
                    'reference_type' => mysql_real_escape_string($this->input->post('reference_type')),
                    'created_on' => date("Y-m-d H:i:s")
                );
                /* inserting advertisement details into the database */
                $this->common_model->insertRow($arr_to_insert, "trans_trade_online_selling_option");

                $real_name = ($this->input->post('real_name_chk') == '') ? 'N' : $this->input->post('real_name_chk');
                $sms_veri = ($this->input->post('sms_veri_chk') == '') ? 'N' : $this->input->post('sms_veri_chk');
                $trusted_people = ($this->input->post('trusted_people_chk') == '') ? 'N' : $this->input->post('trusted_people_chk');
                $liquidity = ($this->input->post('liquidity_chk') == '') ? 'N' : $this->input->post('liquidity_chk');


                $arr_to_insert = array(
                    "trade_id" => mysql_real_escape_string($last_insert_id),
                    "real_name_required" => mysql_real_escape_string($real_name),
                    "sms_verification" => mysql_real_escape_string($sms_veri),
                    "trusted_people_only" => mysql_real_escape_string($trusted_people),
                    "liquidity_option" => mysql_real_escape_string($liquidity),
                    'payment_window' => mysql_real_escape_string($this->input->post('payment_window')),
                    'created_on' => date("Y-m-d H:i:s")
                );
                /* inserting advertisement details into the database */
                $insert_ad = $this->common_model->insertRow($arr_to_insert, "security_options");

                if ($insert_ad) {
                    $this->session->set_userdata("msg", "<span class='success'>Advertisement published successfully!</span>");
                }
            }
        }

        /* using the user model to get user advertisement details */
        $this->load->model('user_model');
        $data['title'] = "List user advertisement";
        $data['arr_user_list'] = $this->user_model->getUserAdvertisementDetails('');
        $this->load->view('backend/post-trade/advertise-list', $data);
    }

    /* Show edit page for advertisement edit */

    function edit_advertisement($edit_id = '') {

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        /* checking user has privilige for the Manage Admin */
        if ($data['user_account']['role_id'] != 1) {
            /* an admin which is not super admin not privileges to access Manage Role */
            /* setting session for displaying notiication message. */
            $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage user!</span>");
            redirect(base_url() . "backend/home");
        }
        $edit_id = base64_decode($edit_id);
        /* using the currency model */
        $this->load->model('user_model');
        $data['arr_advertise_details'] = $this->user_model->getAdvertisementDetails($edit_id);

        /* get current BTC rate in USD */
        $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = file_get_contents($post_data);
        $data['arr_currencay_rates'] = $currencyRateArr;
        $currencyRateArr = json_decode($currencyRateArr);
        $data['currencyRateArr'] = $currencyRateArr;

        foreach ($currencyRateArr as $rateArr)
        /* get current btc rate in us doller */
            if ($rateArr->code == trim('USD')) {
                $data['btc_rate_in_usd'] = $rateArr->rate;
                $data['usd_currency_name'] = $rateArr->name;
                $data['usd_currency_code'] = $rateArr->code;
            }


        /* using the user model to get user advertisement details
          /* using the currency model */
        $this->load->model('currency_model');
        $data['arr_currency_details'] = $this->currency_model->getCurrencyDetails();
        $data['arr_payment_method_details'] = $this->currency_model->getPaymentMethodDetails();

        $this->load->view('backend/post-trade/edit-advertise', $data);
    }

    /* Function for edit action on advertisement */

    function edit_advertisement_action() {


        $data['user_session'] = $this->session->userdata('user_account');
        $user_id = $data['user_session']['user_id'];

        if (count($_POST) > 0) {

            if ($this->input->post('btn_submit') != "") {

                $ip = (($_SERVER['REMOTE_ADDR'] == '127.0.0.1') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.96')) ? '192.168.2.96' : $_SERVER['REMOTE_ADDR'];
                /* save geo location information to geo_location table */
                $geo_arr_to_update = array(
                    "ip" => mysql_real_escape_string($ip),
                    "user_id" => mysql_real_escape_string($user_id),
                    "city" => mysql_real_escape_string($this->input->post('city')),
                    'region' => mysql_real_escape_string($this->input->post('state')),
                    'country' => mysql_real_escape_string($this->input->post('country')),
                    'lattitude' => mysql_real_escape_string($this->input->post('latitude')),
                    'longitude' => mysql_real_escape_string($this->input->post('longitude')),
                    'location' => mysql_real_escape_string($this->input->post('location')),
                );
                /* inserting geolocation details into the geo_location table */
                $this->common_model->updateRow("geo_location", $geo_arr_to_update, array("geo_location_id" => $this->input->post('geo_location_id')));

                $floating_price_chk = ($this->input->post('floating_price_chk') == 'Y') ? 'Y' : 'N';

                /* update advertisemnt details */
                $status = ($this->input->post('status') == 'A') ? 'A' : 'I';
                $arr_to_update = array(
                    "geo_location_id" => mysql_real_escape_string($this->input->post('geo_location_id')),
                    "payment_method_id" => mysql_real_escape_string($this->input->post('payment_method')),
                    "currency_id" => mysql_real_escape_string($this->input->post('currency')),
                    "status" => mysql_real_escape_string($status),
                    'trade_type' => $this->input->post('trade_type'),
                    'bank_service' => mysql_real_escape_string($this->input->post('bank_name')),
                    'premium' => mysql_real_escape_string($this->input->post('premium')),
					'price_eq' => mysql_real_escape_string($this->input->post('price_eq')),
					'price_eq_val' => mysql_real_escape_string($this->input->post('price_eq_val')),
                    'floating_price_chk' => mysql_real_escape_string($floating_price_chk),
                    'float_premium' => mysql_real_escape_string($this->input->post('float_premium')),
                    'min_amount' => mysql_real_escape_string($this->input->post('min_amt')),
                    'max_amount' => mysql_real_escape_string($this->input->post('max_amt')),
                    'contact_hours' => mysql_real_escape_string($this->input->post('contact_hrs')),
                    'meeting_place' => mysql_real_escape_string($this->input->post('meeting_place')),
                    'other_information' => $this->input->post('other_info'),
                );

                /* updateing advertisement details into the mst_trades table */
                $this->common_model->updateRow("mst_trades", $arr_to_update, array("trade_id" => $this->input->post('trade_id')));

                $display_reference = ($this->input->post('reference_chk') == '') ? 'N' : $this->input->post('reference_chk');

                $arr_to_update = array(
                    "bank_transfer_details" => $this->input->post('bank_detail'),
                    "min_volume" => mysql_real_escape_string($this->input->post('min_volume')),
                    "min_feedback_score" => mysql_real_escape_string($this->input->post('min_feedback')),
                    "new_buyer_limit" => mysql_real_escape_string($this->input->post('buyer_limit')),
                    'tvc' => mysql_real_escape_string($this->input->post('volume_coefficient')),
                    'display_reference' => mysql_real_escape_string($display_reference),
                    'reference_type' => mysql_real_escape_string($this->input->post('reference_type')),
                    'created_on' => date("Y-m-d H:i:s")
                );

                /* update advertisement details into the trans_trade_online_selling_option database */
                $this->common_model->updateRow("trans_trade_online_selling_option", $arr_to_update, array("trade_id" => $this->input->post('trade_id')));

                $real_name = ($this->input->post('real_name_chk') == '') ? 'N' : $this->input->post('real_name_chk');
                $sms_veri = ($this->input->post('sms_veri_chk') == '') ? 'N' : $this->input->post('sms_veri_chk');
                $trusted_people = ($this->input->post('trusted_people_chk') == '') ? 'N' : $this->input->post('trusted_people_chk');
                $liquidity = ($this->input->post('liquidity_chk') == '') ? 'N' : $this->input->post('liquidity_chk');

                $arr_to_update = array(
                    "real_name_required" => mysql_real_escape_string($real_name),
                    "sms_verification" => mysql_real_escape_string($sms_veri),
                    "trusted_people_only" => mysql_real_escape_string($trusted_people),
                    "liquidity_option" => mysql_real_escape_string($liquidity),
                    'payment_window' => mysql_real_escape_string($this->input->post('payment_window')),
                );

                /* updating advertisement details into the security_options database */
                $this->common_model->updateRow("security_options", $arr_to_update, array("trade_id" => $this->input->post('trade_id')));
                $this->session->set_userdata("msg", "<span class='success'>Advertisement edited successfully!</span>");
            }
        }

        redirect(base_url() . 'backend/advertise');
    }

    /*     * ********************************** Show post trade from frontend	 ******************************************** */

    function post_trade() {

        /* multi language keywords file */
        $this->load->language('common');
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . 'signin');
        }
        $data = $this->common_model->commonFunction();
        $data['title'] = 'Trade and excahnge bitcoins';
        $data['menu_active'] = 'post_trade';
        $data['user_session'] = $this->session->userdata('user_account');
        $this->load->model("user_model");

        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/backend/js/jquery.validate.min.js"></script>', '<script src="' . base_url() . 'media/front/js/post-trade/add-advertise.js"></script>', '<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>'));

        /* using the currency model */
        $this->load->model('currency_model');
        $data['arr_currency_details'] = $this->currency_model->getCurrencyDetails();
        $data['arr_payment_method_details'] = $this->currency_model->getPaymentMethodDetails();

        $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = file_get_contents($post_data);
        $data['arr_currencay_rates'] = $currencyRateArr;
        $currencyRateArr = json_decode($currencyRateArr);
        $data['currencyRateArr'] = $currencyRateArr;

        foreach ($currencyRateArr as $rateArr)
        /* get current btc rate in us doller */
            if ($rateArr->code == trim('USD')) {
                $data['btc_rate_in_usd'] = $rateArr->rate;
                $data['usd_currency_name'] = $rateArr->name;
                $data['usd_currency_code'] = $rateArr->code;
            }

        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/advertise/post-trade', $data);
        $this->load->view('front/includes/footer');
    }
	
	function getPaymentdescription()
	{
		/* using the currency model */
        $this->load->model('currency_model');
        $arr_payment_method_details = $this->currency_model->getPaymentMethodDetails($this->input->post('id'));
		echo '<p><strong>'.$arr_payment_method_details[0]['method_name'].'</strong></p>';
		echo '<p><em>'.$arr_payment_method_details[0]['method_description'].'</em></p>';
		if($arr_payment_method_details[0]['risk_level'] == 'high'){
		echo '<p><em style="color:red;">The risk level when selling bitcoins online with this payment method is <strong>'.$arr_payment_method_details[0]['risk_level'].'</strong>.</em></p>';
		echo '<p><em style="color:red;"> See the payment method risk assesment in </em><a href="'.base_url().'cms/17/selling-bitcoins-online-guide">online sale advertisement guide.</a></p>';
		}
		else{
		echo '<p><em>The risk level when selling bitcoins online with this payment method is <strong>'.$arr_payment_method_details[0]['risk_level'].'</strong>.</em></p>';
		echo '<p><em> See the payment method risk assesment in </em><a href="'.base_url().'cms/17/selling-bitcoins-online-guide">online sale advertisement guide.</a></p>';
		}
		
	}

    /* add published advertisement from website by user into database */

    function post_trade_add() {


        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $user_id = $data['user_session']['user_id'];

        if (count($_POST) > 0) {

            if ($this->input->post('btn_submit') != "") {
                $ip = (($_SERVER['REMOTE_ADDR'] == '127.0.0.1') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.96')) ? '192.168.2.96' : $_SERVER['REMOTE_ADDR'];
				
				//echo "<pre>";print_r($_POST);exit;

                /* save geo location information to geo_location table */
                $arr_to_insert = array(
                    "user_id" => mysql_real_escape_string($user_id),
                    "ip" => mysql_real_escape_string($ip),
                    "city" => mysql_real_escape_string($this->input->post('city')),
                    'region' => mysql_real_escape_string($this->input->post('state')),
                    'country' => mysql_real_escape_string($this->input->post('country')),
                    'lattitude' => mysql_real_escape_string($this->input->post('latitude')),
                    'longitude' => mysql_real_escape_string($this->input->post('longitude')),
                    'location' => mysql_real_escape_string($this->input->post('location')),
                    'created_on' => date("Y-m-d H:i:s")
                );
                /* inserting advertisement details into the mst_trades table */
                $geo_location_id = $this->common_model->insertRow($arr_to_insert, "geo_location");


                $floating_price_chk = ($this->input->post('floating_price_chk') == 'Y') ? 'Y' : 'N';
                /* advertise/trade record to add */
                $arr_mst_trades = array(
                    "user_id" => mysql_real_escape_string($user_id),
                    "geo_location_id" => mysql_real_escape_string($geo_location_id),
                    "payment_method_id" => mysql_real_escape_string($this->input->post('payment_method')),
                    "currency_id" => mysql_real_escape_string($this->input->post('currency')),
                    'trade_type' => $this->input->post('trade_type'),
                    'bank_service' => mysql_real_escape_string($this->input->post('bank_name')),
                    'premium' => mysql_real_escape_string($this->input->post('premium')),
					'price_eq' => mysql_real_escape_string($this->input->post('price_eq')),
					'price_eq_val' => mysql_real_escape_string($this->input->post('price_eq_val')),
                    'floating_price_chk' => mysql_real_escape_string($floating_price_chk),
                    'float_premium' => mysql_real_escape_string($this->input->post('float_premium')),
                    'min_amount' => mysql_real_escape_string($this->input->post('min_amt')),
                    'max_amount' => mysql_real_escape_string($this->input->post('max_amt')),
                    'contact_hours' => mysql_real_escape_string($this->input->post('contact_hrs')),
                    'meeting_place' => mysql_real_escape_string($this->input->post('meeting_place')),
                    'other_information' => $this->input->post('other_info'),
                    'status' => 'A',
                    'created_on' => date("Y-m-d H:i:s")
                );
                /* inserting advertisement details into the mst_trades table */
                $last_insert_id = $this->common_model->insertRow($arr_mst_trades, "mst_trades");

                $display_reference = ($this->input->post('reference_chk') == '') ? 'N' : $this->input->post('reference_chk');

                /* add details in trans_trade_online_selling_option only when trade type is buy/sell online */
                if (($this->input->post('trade_type') == 'sell_o') || ($this->input->post('trade_type') == 'buy_o')) {
                    $arr_online_trade = array(
                        "trade_id" => mysql_real_escape_string($last_insert_id),
                        "bank_transfer_details" => $this->input->post('bank_detail'),
                        "min_volume" => mysql_real_escape_string($this->input->post('min_volume')),
                        "min_feedback_score" => mysql_real_escape_string($this->input->post('min_feedback')),
                        "new_buyer_limit" => mysql_real_escape_string($this->input->post('buyer_limit')),
                        'tvc' => mysql_real_escape_string($this->input->post('volume_coefficient')),
                        'display_reference' => mysql_real_escape_string($display_reference),
                        'reference_type' => mysql_real_escape_string($this->input->post('reference_type')),
                        'created_on' => date("Y-m-d H:i:s")
                    );

                    /* inserting advertisement details into the database */
                    $this->common_model->insertRow($arr_online_trade, "trans_trade_online_selling_option");
                }

                $real_name = ($this->input->post('real_name_chk') == '') ? 'N' : $this->input->post('real_name_chk');
                $sms_veri = ($this->input->post('sms_veri_chk') == '') ? 'N' : $this->input->post('sms_veri_chk');
                $trusted_people = ($this->input->post('trusted_people_chk') == '') ? 'N' : $this->input->post('trusted_people_chk');
                $liquidity = ($this->input->post('liquidity_chk') == '') ? 'N' : $this->input->post('liquidity_chk');

                $arr_to_insert = array(
                    "trade_id" => mysql_real_escape_string($last_insert_id),
                    "real_name_required" => mysql_real_escape_string($real_name),
                    "sms_verification" => mysql_real_escape_string($sms_veri),
                    "trusted_people_only" => mysql_real_escape_string($trusted_people),
                    "liquidity_option" => mysql_real_escape_string($liquidity),
                    'payment_window' => mysql_real_escape_string($this->input->post('payment_window')),
                    'created_on' => date("Y-m-d H:i:s")
                );
                /* inserting advertisement details into the database */
                $insert_ad = $this->common_model->insertRow($arr_to_insert, "security_options");

                if ($insert_ad) {
                    $this->session->set_userdata("msg", "<span class='success'>Advertisement published successfully!</span>");
                }
            }
        }
        redirect(base_url() . 'user-dashboard');
    }

    /* front-end : edit advertisement/trade */

    function advertise_edit($edit_id = '') {


        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "signin");
        }
        $edit_id = base64_decode($edit_id);
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['title'] = 'edit trade';
        $data['menu_active'] = '';
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/backend/js/jquery.validate.min.js"></script>', '<script src="' . base_url() . 'media/front/js/post-trade/edit-advertise.js"></script>', '<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>'));
        /* using the user model */
        $this->load->model('user_model');
        /* using the user model to get user advertisement details        */
        $data['arr_advertise_details'] = $this->user_model->getAdvertisementDetails($edit_id);
        $data['arr_advertise_details'] = $data['arr_advertise_details'][0];
		
		
		/* API used to get the current market price of BTC */
        $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = file_get_contents($post_data);
        $data['arr_currencay_rates'] = $currencyRateArr;
        $currencyRateArr = json_decode($currencyRateArr);
        $data['currencyRateArr'] = $currencyRateArr;

        for ($i = 0; $i < count($data['arr_advertise_details']); $i++) {
            foreach ($currencyRateArr as $rateArr) {
                if ($rateArr->code == $data['arr_advertise_details']['currency_code']) {
					$price_eq_val = $data['arr_advertise_details']['price_eq_val'];
					$currency_rate = $rateArr->rate;					
                    $data['arr_advertise_details']['local_currency_rate'] = ((($currency_rate*100)*$price_eq_val)/100);
                    $data['arr_advertise_details']['local_currency_code'] = $rateArr->code;
                }
            }
        }

        /* $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = file_get_contents($post_data);
        $data['arr_currencay_rates'] = $currencyRateArr;
        $currencyRateArr = json_decode($currencyRateArr);
        $data['currencyRateArr'] = $currencyRateArr;

        foreach ($currencyRateArr as $rateArr)       
            if ($rateArr->code == trim('USD')) {
                $data['btc_rate_in_usd'] = $rateArr->rate;
                $data['usd_currency_name'] = $rateArr->name;
                $data['usd_currency_code'] = $rateArr->code;
            }
		*/
		
		//echo "<pre>";print_r($data);exit;

        /* using the currency model */
        $this->load->model('currency_model');
        $data['arr_currency_details'] = $this->currency_model->getCurrencyDetails();
        $data['arr_payment_method_details'] = $this->currency_model->getPaymentMethodDetails();
        $data['myvar'] = '';
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/advertise/edit-trade', $data);
        $this->load->view('front/includes/footer');
    }

    /* edit advertisement action */

    function advertise_edit_action() {
        $data['user_session'] = $this->session->userdata('user_account');
        $user_id = $data['user_session']['user_id'];

        if (count($_POST) > 0) {
            if ($this->input->post('btn_submit') != "") {
                $ip = (($_SERVER['REMOTE_ADDR'] == '127.0.0.1') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.96')) ? '192.168.2.96' : $_SERVER['REMOTE_ADDR'];
                /* save geo location information to geo_location table */
                $geo_arr_to_update = array(
                    "ip" => mysql_real_escape_string($ip),
                    "user_id" => mysql_real_escape_string($user_id),
                    "city" => mysql_real_escape_string($this->input->post('city')),
                    'region' => mysql_real_escape_string($this->input->post('state')),
                    'country' => mysql_real_escape_string($this->input->post('country')),
                    'lattitude' => mysql_real_escape_string($this->input->post('latitude')),
                    'longitude' => mysql_real_escape_string($this->input->post('longitude')),
                    'location' => mysql_real_escape_string($this->input->post('location'))
                );
                /* inserting geolocation details into the geo_location table */
                $this->common_model->updateRow("geo_location", $geo_arr_to_update, array("geo_location_id" => $this->input->post('geo_location_id')));

                $floating_price_chk = ($this->input->post('floating_price_chk') == 'Y') ? 'Y' : 'N';
                /* update advertisemnt details */
                $status = ($this->input->post('status') == 'A') ? 'A' : 'I';

                $arr_to_update = array(
                    "geo_location_id" => mysql_real_escape_string($this->input->post('geo_location_id')),
                    "payment_method_id" => mysql_real_escape_string($this->input->post('payment_method')),
                    "currency_id" => mysql_real_escape_string($this->input->post('currency')),
                    "status" => mysql_real_escape_string($status),
                    'trade_type' => $this->input->post('trade_type'),
                    'bank_service' => mysql_real_escape_string($this->input->post('bank_name')),
                    'premium' => mysql_real_escape_string($this->input->post('premium')),
					'price_eq' => mysql_real_escape_string($this->input->post('price_eq')),
					'price_eq_val' => mysql_real_escape_string($this->input->post('price_eq_val')),
                    'floating_price_chk' => mysql_real_escape_string($floating_price_chk),
                    'float_premium' => mysql_real_escape_string($this->input->post('float_premium')),
                    'min_amount' => mysql_real_escape_string($this->input->post('min_amt')),
                    'max_amount' => mysql_real_escape_string($this->input->post('max_amt')),
                    'contact_hours' => mysql_real_escape_string($this->input->post('contact_hrs')),
                    'meeting_place' => mysql_real_escape_string($this->input->post('meeting_place')),
                    'other_information' => $this->input->post('other_info'),
                );

                /* updateing advertisement details into the mst_trades table */
                $this->common_model->updateRow("mst_trades", $arr_to_update, array("trade_id" => $this->input->post('trade_id')));

                $display_reference = ($this->input->post('reference_chk') == '') ? 'N' : $this->input->post('reference_chk');

                /* add details in trans_trade_online_selling_option only when trade type is buy/sell online */
                if (($this->input->post('trade_type') == 'sell_o') || ($this->input->post('trade_type') == 'buy_o')) {
                    $ol_arr_to_update = array(
                        "bank_transfer_details" => $this->input->post('bank_detail'),
                        "min_volume" => mysql_real_escape_string($this->input->post('min_volume')),
                        "min_feedback_score" => mysql_real_escape_string($this->input->post('min_feedback')),
                        "new_buyer_limit" => mysql_real_escape_string($this->input->post('buyer_limit')),
                        'tvc' => mysql_real_escape_string($this->input->post('volume_coefficient')),
                        'display_reference' => mysql_real_escape_string($display_reference),
                        'reference_type' => mysql_real_escape_string($this->input->post('reference_type')),
                        'created_on' => date("Y-m-d H:i:s")
                    );
                    /* update advertisement details into the trans_trade_online_selling_option database */
                    $this->common_model->updateRow("trans_trade_online_selling_option", $ol_arr_to_update, array("trade_id" => $this->input->post('trade_id')));
                }

                $real_name = ($this->input->post('real_name_chk') == '') ? 'N' : $this->input->post('real_name_chk');
                $sms_veri = ($this->input->post('sms_veri_chk') == '') ? 'N' : $this->input->post('sms_veri_chk');
                $trusted_people = ($this->input->post('trusted_people_chk') == '') ? 'N' : $this->input->post('trusted_people_chk');
                $liquidity = ($this->input->post('liquidity_chk') == '') ? 'N' : $this->input->post('liquidity_chk');

                $arr_to_update = array(
                    "real_name_required" => mysql_real_escape_string($real_name),
                    "sms_verification" => mysql_real_escape_string($sms_veri),
                    "trusted_people_only" => mysql_real_escape_string($trusted_people),
                    "liquidity_option" => mysql_real_escape_string($liquidity),
                    'payment_window' => mysql_real_escape_string($this->input->post('payment_window')),
                );
                /* updating advertisement details into the security_options database */
                $this->common_model->updateRow("security_options", $arr_to_update, array("trade_id" => $this->input->post('trade_id')));
                $this->session->set_userdata("msg", "<span class='success'>Advertisement Updated successfully!</span>");
            }
        }
        redirect(base_url() . 'user-dashboard');
    }

    /* change currency ajax request */

    public function changeCurrency() {

        $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = file_get_contents($post_data);
        $currencyRateArr = json_decode($currencyRateArr);

        if (($this->input->post('currency_id') != "") || ($this->input->get('currency_id') != "")) {
            /* get the record by currency_id. */
            $currency_id = ($this->input->post('currency_id') != '') ? $this->input->post('currency_id') : $this->input->get('currency_id');
            $table_to_pass = 'currency_management';
            $fields_to_pass = 'currency_id,currency_code,currency_exchange_code';
            $condition_to_pass = array("currency_id" => $currency_id);
            $arr_currency_details = array();
            $arr_currency_details = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);

            if ($arr_currency_details[0]['currency_code'] != '') {
                foreach ($currencyRateArr as $rateArr)
                /* get current btc rate in us doller */
                    if ($rateArr->code == trim($arr_currency_details[0]['currency_code'])) {
                        echo $data['btc_rate_of_selected_currency'] = $rateArr->rate;
                        echo ',';
                        echo $arr_currency_details[0]['currency_code'];
                    }
            }
        }
    }

    /* bitcoin buy request */
	
	function validateBalance($user_id) {
					
		/* get wallet details */
		$this->load->model("wallet_model");
		$wallet_deatils = $this->wallet_model->getTableInformation("user_wallets", "", array("user_id" => $user_id), "wallet_id  DESC", '', 0);
		
		/* Get wallet balance */
		$arr_wallet_bal_param = array(
			"user_id" => $user_id,
			"password" => $wallet_deatils[0]['wallet_password'],
			"guid" => $wallet_deatils[0]['wallet_guid']
		);
		$wallet_balance = $this->wallet_model->getWalletBalance($user_id, $arr_wallet_bal_param);
		
		$arr_wallet_details['balance']= $wallet_balance;
		$arr_wallet_details['wallet_address']= $wallet_deatils[0]['wallet_address'];
		
		return $arr_wallet_details;
	}

    public function buySellBitcoin($trade_id = '') {

        /* load models */
        $this->load->model("buy_sell_bitcoin_model");
        $this->load->model("user_model");

        $data = $this->common_model->commonFunction();
//        print_r($data);
        $data['user_session'] = $this->session->userdata('user_account');
        $data['menu_active'] = "";
        $data['title'] = "Buy Sell bitcoin";
        $data['image_url'] = base_url() . 'media/front/images/no-logo.png';
        $data['description'] = '';
//        $data['description'] = 'Bitcoin exchange that allows you to securely buy, sell, send, and receive Bitcoin';
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/backend/js/jquery.validate.min.js"></script>', '<script src="' . base_url() . 'media/front/js/post-trade/send-trade-request.js"></script>', '<script src="' . base_url() . 'media/front/js/fb-share.js"></script>'));

        /* mete tags for fb share */
        $data['share_title'] = 'buySellBitcoins';
        $data['site_name'] = $data['global']['site_title'];

        /* request send for buy / sell by user */

        if ($this->input->post('btn_trade_request') != '') {
						
			/* user session values */
			$data['user_session'] = $this->session->userdata('user_account');
        	$user_id = $data['user_session']['user_id'];
			
            /* first check trade request already send or not */
            if ($this->input->post('trade_id') != '') {
                $table = 'buy_sell_transaction';
                $fields = 'transaction_id,trade_id,buyer_id,seller_id,transaction_status,created_on';
                $condition = array('trade_id' => $this->input->post('trade_id'), 'transaction_status' => 'pending', 'buyer_id' => $this->input->post('session_user_id'), 'seller_id' => $this->input->post('trade_user_id'));
                $arr_trade_request = $this->common_model->getRecords($table, $fields, $condition, $order_by = '', $limit = '', $debug = 0);
                $arr_trade_request = $arr_trade_request[0];

                if (count($arr_trade_request) > 0) {
                    $this->session->set_userdata('msg-error', 'please complete previous request to proceed new one.');
                    redirect(base_url() . 'buy-sell-bitcoin/' . $this->input->post('trade_id'));
                }
            }
			
			//echo "<pre>";print_r($_POST);exit;
            $this->load->helper('string');
            $verify_code = random_string('alnum', 6);
			
			/* Calculate btc amount */
			$margin = $this->input->post('margin');
			$btc_amount = $this->exp_to_dec(abs($this->input->post('txt_btc_amount') * $margin));
			
            $fields = array(
                'transaction_id' => '',
                'trade_id' => mysql_real_escape_string($this->input->post('trade_id')),
                'buyer_id' => mysql_real_escape_string($this->input->post('buyer_id')),
                'seller_id' => mysql_real_escape_string($this->input->post('seller_id')),
                'fiat_currency' => mysql_real_escape_string($this->input->post('txt_currency_rate')),
                'btc_amount' => mysql_real_escape_string($btc_amount),
                'local_currency_rate' => mysql_real_escape_string($this->input->post('local_currency_rate')),
                'btc_rate_in_usd' => mysql_real_escape_string($this->input->post('btc_rate_in_usd')),
                'transaction_type' => mysql_real_escape_string($this->input->post('transaction_type')),
//                'contact_message' => mysql_real_escape_string($this->input->post('contact_message')),
                'transaction_status' => 'pending',
				'verify_code' => mysql_real_escape_string($verify_code),
            );
			//echo "<pre>";print_r($fields);exit;
            $table = 'buy_sell_transaction';
            $last_insert_transaction__id = $this->common_model->insertRow($fields, $table);

            if ($last_insert_transaction__id) {

                /* insert contact message into trade chat table */
                $fields = array(
                    'chat_id' => '',
                    'trade_id' => mysql_real_escape_string($this->input->post('trade_id')),
                    'transaction_id' => mysql_real_escape_string($last_insert_transaction__id),
                    'msg_from_user_id' => mysql_real_escape_string($this->input->post('session_user_id')),
                    'msg_to_user_id' => mysql_real_escape_string($this->input->post('trade_user_id')),
                    'contact_message' => $this->input->post('contact_message'),
                );
                $table = 'trade_chat';
                $chat_last_insert_id = $this->common_model->insertRow($fields, $table);

                /* get usesr information for email sending */
                $this->load->model('register_model');
                $table_to_pass = 'mst_users';
                $fields_to_pass = array('user_id', 'first_name', 'last_name', 'user_name', 'user_email');
                $condition_to_pass = array("user_id" => $this->input->post('trade_user_id'));
                $arr_user_info = $this->register_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
                $arr_user_info = $arr_user_info[0];

                /* Send trade request message email to advertiser */
                $login_link = '<a href="' . base_url() . 'signin">Click here.</a>';
                if (isset($lang_id) && $lang_id != '') {
                    $lang_id = $this->session->userdata('lang_id');
                } else {
                    $lang_id = 17; /* Default is 17(English) */
                }
                $base_url = '<a href="' . base_url() . '">' . $data['global']['site_title'] . '</a>';
                $site_title = '<a href="' . base_url() . '">' . $data['global']['site_title'] . '</a>';
				$fiat_currency = $this->input->post('txt_currency_rate');
				$exchange_rate = $this->input->post('local_currency_rate');
				$advertisement_type = $this->input->post('transaction_type');
				$currency = $this->input->post('currency');
				$message = 'Deal:'.$fiat_currency.' '.$currency.'='.$btc_amount.'(price '.$exchange_rate.' '.$currency.'/BTC)';
				$trade_id = base64_encode($this->input->post('trade_id'));
				$transaction_id = base64_encode($last_insert_transaction__id);
				$trade_link = '<a href="' . base_url() . 'ads/detailed-info/'.$trade_id.'/'.$transaction_id.'">See contact</a>';

                $reserved_words = array(
                    "||USER_NAME||" => mysql_real_escape_string($arr_user_info['user_name']),
					"||ADVERTISE_TYPE||" => mysql_real_escape_string($advertisement_type),
					"||MESSAGE||" => mysql_real_escape_string($message),
                    "||CONTACT_MESSAGE||" => mysql_real_escape_string($this->input->post('contact_message')),
					"||TRADE_LINK||" => mysql_real_escape_string($trade_link),
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
                    $this->session->set_userdata('msg', 'Trade request sent successfully');
                    redirect(base_url().'user-dashboard');
                }
            }
			
        }

        $arr_buy_bitcoin_details = array();
        $arr_trade_bitcoin_details = $this->buy_sell_bitcoin_model->getAdvertisementDetails($trade_id, $debug_to_pass = 0);

        $data['arr_trade_bitcoin_details'] = $arr_trade_bitcoin_details[0];	
		//echo "<pre>";print_r($data['arr_trade_bitcoin_details']);exit;
		
		/* Get the last seen user time */
		$last_seen = $this->GetLastSeenTime($data['arr_trade_bitcoin_details']['user_id']);
        $data['last_seen'] = $last_seen;		
		
		/* Get count of blocked by people */
		$this->load->model('trusted_contacts_model');		
        $arr_user_list = $this->trusted_contacts_model->getTrustedStatusDetails($data['user_session']['user_id'],$data['arr_trade_bitcoin_details']['user_id']);
		//echo "<pre>";print_r($data['arr_user_list']);exit;
		if(count($arr_user_list) > 0){
			if(($arr_user_list[0]['status'] == 'D') || ($arr_user_list[0]['status'] == 'B')) {
				$data['blocked_status'] = 'Y';
			} else {
				$data['blocked_status'] = 'N';
			}	
		} else {
			$data['blocked_status'] = 'N';
		}
		
		/* Check if real name condition occur */
		if(($data['arr_trade_bitcoin_details']['real_name_required'] == 'Y') || ($data['arr_trade_bitcoin_details']['real_name_required'] == '')) {
		
			$this->load->model("user_model");	
			$table_to_pass = 'mst_users';
			$fields_to_pass = 'user_id,first_name';
			$condition_to_pass = array("user_id" => $data['user_session']['user_id']);
			$arr_user_data = array();
			$arr_user_data = $this->user_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
						
			if(count($arr_user_data) > 0) {
				if($arr_user_data[0]['first_name'] == '') {
					$data['real_name_req'] = 'Y';
				} else {
					$data['real_name_req'] = 'N';
				}
			} else {
				$data['real_name_req'] = 'N';
			}
			
		} else {
			$data['real_name_req'] = 'N';
		}
		

        /* get the current btc rate according to currency code of advertiser */
        if ($arr_trade_bitcoin_details[0]['currency_code'] != '') {
            /* API used to get the current market price of BTC */
            $post_data = "https://bitpay.com/api/rates";
            $currencyRateArr = file_get_contents($post_data);
            $currencyRateArr = json_decode($currencyRateArr);

            foreach ($currencyRateArr as $rateArr)
                if ($rateArr->code == $arr_trade_bitcoin_details[0]['currency_code']) {
					$price_eq_val = $arr_trade_bitcoin_details[0]['price_eq_val'];
					$currency_rate = $rateArr->rate;
                    $data['local_currency_rate'] = ((($currency_rate*100)*$price_eq_val)/100);
                    $data['local_currency_name'] = $rateArr->name;
                    $data['local_currency_code'] = $rateArr->code;
					break;
                }
            /* for variable = description will be used in mete tag and set it in header */
            $description = '';
            if (($arr_trade_bitcoin_details[0]['trade_type'] == 'sell_o') || ($arr_trade_bitcoin_details[0]['trade_type'] == 'buy_o')) {
                $description .= 'Sell bitcoins online with ' . $data['local_currency_name'] . ' ' . $data['local_currency_code'] . ', ';
                $twtr_description = 'Sell bitcoins online with ' . $data['local_currency_name'] . ' ' . $data['local_currency_code'];
            } else {
                $description .= 'Buy bitcoins with cash in ' . $data['local_currency_name'] . ' ' . $data['local_currency_code'] . ', ';
                $twtr_description = 'Buy bitcoins with cash in ' . $data['local_currency_name'] . ' ' . $data['local_currency_code'];
            }

            if (($arr_trade_bitcoin_details[0]['trade_type'] == 'buy_c') || ($arr_trade_bitcoin_details[0]['trade_type'] == 'buy_o')) {
                $description .='Cryptosi.com user ' . $arr_trade_bitcoin_details[0]['user_name'] . ' wishes to buy bitcoins from you';
            } else {
                $description .='Cryptosi.com user ' . $arr_trade_bitcoin_details[0]['user_name'] . ' wishes to sell bitcoins to you';
            }

            $data['description'] = $description;
            $data['twtr_description'] = $twtr_description;

            foreach ($currencyRateArr as $rateArr)
            /* get current btc rate in us doller */
                if ($rateArr->code == trim('USD')) {
                    $data['btc_rate_in_usd'] = $rateArr->rate;
                    $data['usd_currency_name'] = $rateArr->name;
                    $data['usd_currency_code'] = $rateArr->code;
					break;
                }
        }
		//print_r($data['arr_trade_bitcoin_details']);
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        } else {
            $this->load->view('front/includes/dashboard-header-1');
        }
        $this->load->view('front/advertise/buy-sell-bitcoin', $data);
        $this->load->view('front/includes/footer');
    }
	
	
	/* Get active user last seen */
	function GetLastSeenTime($user_id)
	{
		$data = $this->common_model->commonFunction();
		/* get user last login details */
		$table_to_pass = 'user_sign_in_log';
		$fields_to_pass = 'last_activity,last_logout';
		$condition_to_pass = array("user_id" => $user_id);
		$order_by_to_pass = 'log_id DESC';
		$limit_to_pass = '1';
		$arr_user_login_details = array();
		$arr_user_login_details = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass, $limit_to_pass, $debug_to_pass = 0);
		
		if($arr_user_login_details[0]['last_logout'] == '0000-00-00 00:00:00'){
			
			$cur_time = strtotime(date('Y-m-d H:i:s'));			
			$time_since = $cur_time - $arr_user_login_details[0]['last_activity'];		
			$interval = 300;					
			// Do nothing if last activity is recent
			if ($time_since < $interval) {
				$status = 'online';
			} else {
				$status = 'recent';
			}
		} else
		{
			$status = 'offline';
		}
		
		$last_seen = GetTimeAgo($arr_user_login_details[0]['last_activity']);
		
		$arr_user_last_seen['status'] = $status;
		$arr_user_last_seen['last_seen'] = $last_seen;
		
		return $arr_user_last_seen;
		
	}
	
	
	
	
	/* Conver exponential to decimal */
	function exp_to_dec($float_str)
	{
		// make sure its a standard php float string (i.e. change 0.2e+2 to 20)
		// php will automatically format floats decimally if they are within a certain range
		$float_str = (string)((float)($float_str));
	
		// if there is an E in the float string
		if(($pos = strpos(strtolower($float_str), 'e')) !== false)
		{
			// get either side of the E, e.g. 1.6E+6 => exp E+6, num 1.6
			$exp = substr($float_str, $pos+1);
			$num = substr($float_str, 0, $pos);
		   
			// strip off num sign, if there is one, and leave it off if its + (not required)
			if((($num_sign = $num[0]) === '+') || ($num_sign === '-')) $num = substr($num, 1);
			else $num_sign = '';
			if($num_sign === '+') $num_sign = '';
		   
			// strip off exponential sign ('+' or '-' as in 'E+6') if there is one, otherwise throw error, e.g. E+6 => '+'
			if((($exp_sign = $exp[0]) === '+') || ($exp_sign === '-')) $exp = substr($exp, 1);
			else trigger_error("Could not convert exponential notation to decimal notation: invalid float string '$float_str'", E_USER_ERROR);
		   
			// get the number of decimal places to the right of the decimal point (or 0 if there is no dec point), e.g., 1.6 => 1
			$right_dec_places = (($dec_pos = strpos($num, '.')) === false) ? 0 : strlen(substr($num, $dec_pos+1));
			// get the number of decimal places to the left of the decimal point (or the length of the entire num if there is no dec point), e.g. 1.6 => 1
			$left_dec_places = ($dec_pos === false) ? strlen($num) : strlen(substr($num, 0, $dec_pos));
		   
			// work out number of zeros from exp, exp sign and dec places, e.g. exp 6, exp sign +, dec places 1 => num zeros 5
			if($exp_sign === '+') $num_zeros = $exp - $right_dec_places;
			else $num_zeros = $exp - $left_dec_places;
		   
			// build a string with $num_zeros zeros, e.g. '0' 5 times => '00000'
			$zeros = str_pad('', $num_zeros, '0');
		   
			// strip decimal from num, e.g. 1.6 => 16
			if($dec_pos !== false) $num = str_replace('.', '', $num);
		   
			// if positive exponent, return like 1600000
			if($exp_sign === '+') return $num_sign.$num.$zeros;
			// if negative exponent, return like 0.0000016
			else return $num_sign.'0.'.$zeros.$num;
		}
		// otherwise, assume already in decimal notation and return
		else return $float_str;
	}

}

?>