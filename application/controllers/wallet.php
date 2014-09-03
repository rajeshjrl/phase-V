<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wallet extends CI_Controller {
    /* An Controller having functions to manage admin user login,add edit, forgot password, profile and activating user account */

    public function __construct() {
        parent::__construct();
        $this->load->model("common_model");
        $this->load->model("wallet_model");
        $this->load->language('wallet');
        CHECK_USER_STATUS();
		UpdateActiveTime();
    }

    /* function to list all the users */

    public function index() {

        /* multi language keywords file */
        $this->load->language('common');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }

        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['menu_active'] = "wallet";
        $data['title'] = "Sell and buy bitcoins";
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/send-bitcoin.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>'));
        /* load user model */
        $this->load->model("user_model");
        /* user id value */
        $user_id = $data['user_session']['user_id'];
		
		/* Get user details */
        $table_to_pass = 'mst_users';
        $fields_to_pass = 'register_date';
        $condition_to_pass = array("user_id" => $user_id);
        $arr_user_data = array();
        $arr_user_data = $this->user_model->getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
        $user_register_date = date('Y-m-d', strtotime($arr_user_data[0]['register_date']));
		
		/* Get current date */
		$cur_date = date('Y-m-d');
		
		/* Get earlier month and year */
		$montharr = $this->get_months($user_register_date, $cur_date);
		$data['montharr'] = $montharr;		

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
		/* Set wallet balance in session value. */
		$this->session->set_userdata('user_wallet_balance',$data['wallet_balance']);		
		
		/* API used to get the current market price of BTC */
		$post_data = "https://bitpay.com/api/rates";
		$currencyRateArr = @file_get_contents($post_data);
		$currencyRateArr = json_decode($currencyRateArr);
		
		for($i=0;$i<count($currencyRateArr);$i++)
		{
			$data['currency'][$i]['rate'] = $currencyRateArr[$i]->rate;
			$data['currency'][$i]['code'] = $currencyRateArr[$i]->code;
		}	
		
		
		/* Get total wallet transaction */
		$address = '';
		foreach($wallet_deatils as $addresses)
		{
			$address .= $addresses['wallet_address'].'|';
		}
		$address = rtrim($address,'|');
		
		$wallet_transactions = $this->wallet_model->getWalletTransactions($address);
		
		$wallet_transactions = json_decode($wallet_transactions);
		
		//echo "<pre>";	
		//print_r($wallet_transactions);exit;
				
		$wallet_transation_details['total_received'] = $wallet_transactions->wallet->total_received;
		$wallet_transation_details['total_sent'] = $wallet_transactions->wallet->total_sent;
		$wallet_transation_details['no_transaction'] = $wallet_transactions->wallet->n_tx;
		
		for($i=0;$i<$wallet_transation_details['no_transaction'];$i++)
		{			
			//$firstDayUTS = mktime (0, 0, 0, date("m"), 1, date("Y"));
//			$lastDayUTS = mktime (0, 0, 0, date("m"), date('t'), date("Y"));
//
//			$date = $wallet_transactions->txs[$i]->time;
//			if($date >= $firstDayUTS && $date <= $lastDayUTS)
//			{		
				$wallet[$i]['date'] = $wallet_transactions->txs[$i]->time;
					
				if($wallet_transactions->txs[$i]->result < 0)
				{
					$wallet[$i]['tr_type'] = 'S';				
					$wallet[$i]['sent'] = $wallet_transactions->txs[$i]->result;
					$wallet[$i]['received'] = '';
					if(isset($wallet_transactions->txs[$i]->note)) {
						$wallet[$i]['discription'] = $wallet_transactions->txs[$i]->note;
					} else {
						$wallet[$i]['discription'] = $wallet_transactions->txs[$i]->out[0]->addr;
					}
				}
				else
				{
					$wallet[$i]['tr_type'] = 'R';				
					$wallet[$i]['sent'] = '';
					$wallet[$i]['received'] = $wallet_transactions->txs[$i]->result;
					if(isset($wallet_transactions->txs[$i]->note)) {
						$wallet[$i]['discription'] = $wallet_transactions->txs[$i]->note;
					} else {
						$wallet[$i]['discription'] = $wallet_transactions->txs[$i]->inputs[0]->prev_out->addr;
					}
				}
			//}		
				
				
		}
		
		$wallet_transation_details['txs'] = $wallet;
		$data['wallet_transation_details'] = $wallet_transation_details;
		
		//echo "<pre>";print_r($data);exit;

        $this->load->view('front/includes/header', $data);
        //if ($this->session->userdata('user_account')) {
          //  $this->load->view('front/includes/dashboard-header');
        //}
        $this->load->view('front/wallet/user-wallet', $data);
        $this->load->view('front/includes/footer');
    }

    public function requestNewWallet() {

        $data['user_session'] = $this->session->userdata('user_account');
        /* user id value */
        $user_id = $data['user_session']['user_id'];
        $user_name = $data['user_session']['user_name'];

        /* Get wallet information for wallet address used or not */
        $wallet_deatils = $this->wallet_model->getTableInformation("user_wallets", "", array("user_id" => $user_id, "wallet_status" => "UN"), "wallet_id  DESC", '', 0);

        if (count($wallet_deatils) < 1) {

            $wallet_deatils = $this->wallet_model->getTableInformation("user_wallets", "", array("user_id" => $user_id), "wallet_id  DESC", '', 0);

            /* Create new address */
            $arr_wallet_param = array(
                "user_id" => $user_id,
                "guid" => $wallet_deatils[0]['wallet_guid'],
                "main_password" => $wallet_deatils[0]['wallet_password'],
                "second_password" => "",
                "label" => $wallet_deatils[0]['wallet_label'],
                "wallet_email" => $wallet_deatils[0]['wallet_email'],
                "wallet_link" => $wallet_deatils[0]['wallet_link'],
				"wallet_private_key" => ""
            );

            $this->wallet_model->createNewWalletAddress($user_id, $arr_wallet_param);

            $this->session->set_userdata("msg", "<span class='success'>New wallet address created successfully!</span>");
            redirect(base_url() . 'wallet');
        } else {
            $this->session->set_userdata("msg-error", "<span class='error'> The wallet has already unused addresses. Please use them before you can create new ones. </span>");
            redirect(base_url() . 'wallet');
        }
    }

    public function checkAddress() {

        $address = $this->input->post('rec_bitcoin_address');
        $origbase58 = $address;
        $dec = "0";

        for ($i = 0; $i < strlen($address); $i++) {
            $dec = bcadd(bcmul($dec, "58", 0), strpos("123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz", substr($address, $i, 1)), 0);
        }
        $address = "";

        while (bccomp($dec, 0) == 1) {
            $dv = bcdiv($dec, "16", 0);
            $rem = (integer) bcmod($dec, "16");
            $dec = $dv;
            $address = $address . substr("0123456789ABCDEF", $rem, 1);
        }

        $address = strrev($address);

        for ($i = 0; $i < strlen($origbase58) && substr($origbase58, $i, 1) == "1"; $i++) {
            $address = "00" . $address;
        }

        if (strlen($address) % 2 != 0) {
            $address = "0" . $address;
        }

        if (strlen($address) != 50) {
            return false;
        }

        if (hexdec(substr($address, 0, 2)) > 0) {
            return false;
        }

        return substr(strtoupper(hash("sha256", hash("sha256", pack("H*", substr($address, 0, strlen($address) - 8)), true))), 0, 8) == substr($address, strlen($address) - 8);
    }
	
	function checkBalance() {
		if ($this->input->post('btc_amt') != '') {					
			/* user session values */
			$data['user_session'] = $this->session->userdata('user_account');
        	$user_id = $data['user_session']['user_id'];
			
            $addressFlag = $this->validateBalance($user_id);
            if ($addressFlag > $this->input->post('btc_amt') ) {
                echo 'true';
            } else {
                echo 'false';
            }
        }		
	}
	
	public function validateWalletBalance() {

        if ($this->input->post('btc_amt') != '') {					
			/* user session values */
			$data['user_session'] = $this->session->userdata('user_account');
        	$user_id = $data['user_session']['user_id'];
			
            $addressFlag = $this->validateBalance($user_id);
            if ($addressFlag > $this->input->post('btc_amt') ) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }
	
	function validateBalance($user_id) {
					
		/* get wallet details */
		$wallet_deatils = $this->wallet_model->getTableInformation("user_wallets", "", array("user_id" => $user_id), "wallet_id  DESC", '', 0);
		
		/* Get wallet balance */
		$arr_wallet_bal_param = array(
			"user_id" => $arr_login_data[0]['user_id'],
			"password" => $wallet_deatils[0]['wallet_password'],
			"guid" => $wallet_deatils[0]['wallet_guid']
		);
		$wallet_balance = $this->wallet_model->getWalletBalance($arr_login_data[0]['user_id'], $arr_wallet_bal_param);
		
		return $wallet_balance;
	}

    public function validateWalletAdress() {

        if ($this->input->post('rec_bitcoin_address') != '') {
            $addressFlag = $this->validateAddress($this->input->post('rec_bitcoin_address'));
            if ($addressFlag) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }

    function validateAddress($address) {
        $origbase58 = trim($address);
        $dec = "0";

        for ($i = 0; $i < strlen($address); $i++) {
            $dec = bcadd(bcmul($dec, "58", 0), strpos("123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz", substr($address, $i, 1)), 0);
        }

        $address = "";

        while (bccomp($dec, 0) == 1) {
            $dv = bcdiv($dec, "16", 0);
            $rem = (integer) bcmod($dec, "16");
            $dec = $dv;
            $address = $address . substr("0123456789ABCDEF", $rem, 1);
        }

        $address = strrev($address);

        for ($i = 0; $i < strlen($origbase58) && substr($origbase58, $i, 1) == "1"; $i++) {
            $address = "00" . $address;
        }

        if (strlen($address) % 2 != 0) {
            $address = "0" . $address;
        }

        if (strlen($address) != 50) {
            return false;
        }

        if (hexdec(substr($address, 0, 2)) > 0) {
            return false;
        }

        return substr(strtoupper(hash("sha256", hash("sha256", pack("H*", substr($address, 0, strlen($address) - 8)), true))), 0, 8) == substr($address, strlen($address) - 8);
    }

    public function getAllWalletsListForAdmin() {
        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        $data = $this->common_model->commonFunction();
        /* using the user model */
        //$this->load->model('wallet_module');
        $data['title'] = "Manage User";
//        $data['arr_user_list'] = $this->wallet_module->getUserDetails('');
        $data['arr_user_wallets_list'] = $this->common_model->getRecords('user_wallets');
        $arr_privileges = array();
        $data['arr_privileges'] = $this->common_model->getRecords('mst_privileges');
        $this->load->view('backend/wallets/list', $data);
    }

//        backend/wallet-view


    public function getWalletInfo($user_id) {
        /* #checking admin is logged in or not */
        $user_id = base64_decode($user_id);
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        $data = $this->common_model->commonFunction();
        /* using the user model */
        //$this->load->model('wallet_module');
        $data['title'] = "Manage User";
        //  $data['arr_user_list'] = $this->wallet_module->getUserDetails('');

        $data['arr_user_wallets_list'] = $this->common_model->getRecords('user_wallets', "", array("user_id" => $user_id));
        $arr_privileges = array();
        $data['arr_privileges'] = $this->common_model->getRecords('mst_privileges');
        $this->load->view('backend/wallets/list-details', $data);
    }

    public function send_bitcoins() {

        if ($this->input->post('btn_submit') != '') {
		
			/* user session values */
			$data['user_session'] = $this->session->userdata('user_account');
        	$user_id = $data['user_session']['user_id'];

            /* get wallet information */
            $table_to_pass = 'user_wallets';
            $fields_to_pass = 'wallet_id,user_id,wallet_password,wallet_guid,wallet_address';
            $condition_to_pass = array("user_id" => $user_id);
            $arr_currency_details = array();
            $arr_currency_details = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
			
			/*echo '<pre>';
			print_r($arr_currency_details);
            print_r($_POST);
            exit();*/
			
			$amt_in_satoshi = (int)($this->input->post('btc_amt') * 100000000);
			
			$guid=$arr_currency_details[0]['wallet_guid'];
			$main_password=$arr_currency_details[0]['wallet_password'];
			$amount=$amt_in_satoshi;
			$address=$this->input->post('rec_bitcoin_address');
			$note=str_replace(' ', '', $this->input->post('description'));
			
			$json_url = "http://blockchain.info/merchant/$guid/payment?password=$main_password&to=$address&amount=$amount&note=$note";
			
			//echo "<pre>";print_r($json_url);
						
			$json_data = file_get_contents($json_url);
			//echo "<pre>";print_r($json_data);exit;			
			$json_feed = json_decode($json_data);
		
			if(!($json_feed->error))
			{
				$message = $json_feed->message;
				$txid = $json_feed->tx_hash;
				
				$this->session->set_userdata("msg", $message);	
				
				/* Change status of wallet address as to AN */
				$table_name = 'user_wallets';
				$update_data = array(
					'wallet_status' => 'AN',					
				);
				$condition = array("wallet_address" => $arr_currency_details[0]['wallet_address']);
				$last_insert_id = $this->common_model->updateRow($table_name, $update_data, $condition);
				
				
				/* Get wallet information */
				/*$wallet_deatils = $this->wallet_model->getTableInformation("user_wallets", "", array("user_id" => $user_id), "wallet_id  DESC", '', 0);
				$data['wallet_deatils'] = $wallet_deatils;*/
				
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
				
				
				//$this->session->set_userdata("msg", $message);
            	redirect(base_url() . 'wallet');							
			}
			else
			{
				/* if something going wrong providing error message. */
				//echo json_encode(array("error" => "1", "error_message" => $json_feed->error));			
				$this->session->set_userdata("msg-error", $json_feed->error.'<br>Reduce transaction fee amount i.e. 0.0001 btc from wallet balance and then send btc.');
            	redirect(base_url() . 'wallet');
			
			}	
            
        }
    }
	
	
	function wallet_transactions_monthly($year = '',$month = '')
	{
	
		/* multi language keywords file */
        $this->load->language('common');
        if (!$this->common_model->isLoggedIn()) {
            redirect('signin');
        }

        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['menu_active'] = "wallet";
        $data['title'] = "Sell and buy bitcoins";
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/send-bitcoin.js"></script>', '<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>'));
        /* load user model */
        $this->load->model("user_model");
        /* user id value */
        $user_id = $data['user_session']['user_id'];	
	
		$m = $month;
		$y = $year;
		
		$firstDayUTS = mktime (0, 0, 0, date("$m"), 1, date("$y"));
		$lastDayUTS = mktime (0, 0, 0, date("$m"), date('t'), date("$y"));		
		
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
				
		/* Get total wallet transaction */
		$address = '';
		foreach($wallet_deatils as $addresses)
		{
			$address .= $addresses['wallet_address'].'|';
		}
		$address = rtrim($address,'|');
		
		$wallet_transactions = $this->wallet_model->getWalletTransactions($address);
		
		$wallet_transactions = json_decode($wallet_transactions);
		
		//echo "<pre>";	
		//print_r($wallet_transactions);exit;
		
		for($i=0;$i<$wallet_transation_details['no_transaction'];$i++)
		{
			$date = $wallet_transactions->txs[$i]->time;
			if($date >= $firstDayUTS && $date <= $lastDayUTS)
			{
				$wallet[$i]['date'] = $wallet_transactions->txs[$i]->time;			
			
				if($wallet_transactions->txs[$i]->result < 0)
				{
					$wallet[$i]['tr_type'] = 'S';				
					$wallet[$i]['sent'] = $wallet_transactions->txs[$i]->result;
					$wallet[$i]['received'] = '';
					$wallet[$i]['discription'] = $wallet_transactions->txs[$i]->out[0]->addr;
				}
				else
				{
					$wallet[$i]['tr_type'] = 'R';				
					$wallet[$i]['sent'] = '';
					$wallet[$i]['received'] = $wallet_transactions->txs[$i]->result;
					$wallet[$i]['discription'] = $wallet_transactions->txs[$i]->inputs[0]->prev_out->addr;
				}
				
				
				//$wallet_transation_details['total_received'] = $wallet_transactions->wallet->total_received;
				//$wallet_transation_details['total_sent'] = $wallet_transactions->wallet->total_sent;
				//$wallet_transation_details['no_transaction'] = $wallet_transactions->wallet->n_tx;				
				
			}				
				
		}
		
		$wallet_transation_details['txs'] = $wallet;
		$data['wallet_transation_details'] = $wallet_transation_details;
		
		echo "<pre>";print_r($data);
		
	}
	
	
	function get_months($startstring, $endstring)
	{
		$time1  = strtotime($startstring);//absolute date comparison needs to be done here, because PHP doesn't do date comparisons
		$time2  = strtotime($endstring);
		$my1     = date('mY', $time1); //need these to compare dates at 'month' granularity
		$my2    = date('mY', $time2);
		$year1 = date('Y', $time1);
		$year2 = date('Y', $time2);
		$years = range($year1, $year2);
		 
		foreach($years as $year)
		{
			$months[$year] = array();
			while($time1 < $time2)
			{
				if(date('Y',$time1) == $year)
				{
				$months[$year][] = date('m', $time1);
				$time1 = strtotime(date('Y-m-d', $time1).' +1 month');
				}
				else
				{
				break;
				}
			}
		continue;
		} 
	return $months;
	}
	
	
	   
}
