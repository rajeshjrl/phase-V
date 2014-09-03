<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wallet_Model extends CI_Model {
    /* Get wallet information from user_wallet table */

    public function getTableInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0) {
        $this->db->select($fields_to_pass, FALSE);
        $this->db->from($table_to_pass);
        if ($condition_to_pass != '')
            $this->db->where($condition_to_pass);

        if ($order_by_to_pass != '')
            $this->db->order_by($order_by_to_pass);

        if ($limit_to_pass != '')
            $this->db->limit($limit_to_pass);

        $query = $this->db->get();

        if ($debug_to_pass)
            echo $this->db->last_query();

        return $query->result_array();
    }

    /* Create new wallet for user */

    public function createWallet($user_id, $wallet_param) {
        /* 	
          $password="sandeep123456"; //The password for the new wallet. Must be at least 10 characters in length.
          $api_code="f6c53cbe-5d44-476f-83b1-1d2ed5b6951a"; //An API code with create wallets permission.
          $priv	 =""; //A private key to add to the wallet (Wallet import format preferred). (Optional)
          $label   =""; //A label to set for the first address in the wallet. Alphanumeric only. (Optional)
          $email   =""; // An email to associate with the new wallet i.e. the email address of the user you are creating this wallet on behalf of. (Optional)
         */

        $post_data = "https://blockchain.info/api/v2/create_wallet";
        $post_data .= "?api_code=" . $wallet_param['api_code'];
        $post_data .= "&password=" . $wallet_param['wallet_password'];

        if ($wallet_param['wallet_private_key'] != "") {
            $post_data .= "&priv=" . $wallet_param['wallet_private_key'];
        }
        
        if ($wallet_param['wallet_label'] != "") {
            $post_data .= "&label=" . $wallet_param['wallet_label'];
        }

//        if ($wallet_param['wallet_email'] != "") {
//            $post_data .= "&email=" . $wallet_param['wallet_email'];
//        }
        /* Start creating wallet and getting detailed info of wallets  */
        $wallet_deatils = file_get_contents($post_data);		
        $wallet_deatils = json_decode($wallet_deatils);
		
        if (count($wallet_deatils) > 0) {
            $arr_insert = array(
                "user_id" => $user_id,
                "wallet_email" => $wallet_param['wallet_email'],
                "wallet_label" => $wallet_param['wallet_label'],
                "wallet_private_key" => $wallet_param['wallet_private_key'],
                "wallet_password" => $wallet_param['wallet_password'],
                "wallet_guid" => $wallet_deatils->guid,
                "wallet_address" => $wallet_deatils->address,
                "wallet_link" => $wallet_deatils->link
            );
            $this->db->insert("user_wallets", $arr_insert);
        }
    }

    /* Get wallet balance of user */

    public function getWalletBalance($user_id, $wallet_param) {

        $post_data = "https://blockchain.info/merchant/" . $wallet_param['guid'] . "/balance";
        $post_data .= "?password=" . $wallet_param['password'];

        $wallet_balance = file_get_contents($post_data);
        $wallet_balance = json_decode($wallet_balance);
        $wallet_balance = $wallet_balance->balance;

        return $wallet_balance;
    }

    /* Create new wallet address */

    public function createNewWalletAddress($user_id, $wallet_param) {

        $post_data = "https://blockchain.info/merchant/" . $wallet_param['guid'] . "/new_address";
        $post_data .= "?password=" . $wallet_param['main_password'];

        if ($wallet_param['second_password'] != "") {
            $post_data .= "&second_password=" . $wallet_param['second_password'];
        }

        if ($wallet_param['label'] != "") {
            $post_data .= "&label=" . $wallet_param['label'];
        }

        $wallet_new_address = file_get_contents($post_data);
        $wallet_new_address = json_decode($wallet_new_address);
        $wallet_new_address = $wallet_new_address->address;


        if (count($wallet_new_address) > 0) {

            $arr_insert = array(
                "user_id" => $user_id,
                "wallet_email" => $wallet_param['wallet_email'],
                "wallet_label" => $wallet_param['label'],
                "wallet_private_key" => $wallet_param['wallet_private_key'],
                "wallet_password" => $wallet_param['main_password'],
                "wallet_guid" => $wallet_param['guid'],
                "wallet_address" => $wallet_new_address,
                "wallet_link" => $wallet_param['wallet_link']
            );
            $this->db->insert("user_wallets", $arr_insert);
        }
        return $wallet_new_address;
    }

    /* Get wallet transactions */

    public function getWalletTransactions($address) {

        $post_data = "http://blockchain.info/multiaddr?active=$address";
		$wallet_transaction = file_get_contents($post_data);
		return $wallet_transaction;		
		
    }

}

?>
