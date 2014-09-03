<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_Model extends CI_Model {

    public function getUserInformation($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0) {
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

    /* function to get trade list from the database */

    public function getTradeDetails($user_id = '', $arr_condition) {
        
        $this->db->select('T.trade_id,T.status,T.other_information,T.price_eq,T.price_eq_val,c.currency_id,c.currency_code,T.created_on, G.geo_location_id,G.user_id,G.city, G.region, G.country,G.location');
        $this->db->from('mst_trades as T');
        $this->db->join('geo_location as G', 'T.geo_location_id = G.geo_location_id', 'inner');
		$this->db->join('currency_management as c', 'T.currency_id = c.currency_id', 'left');
        if ($user_id != '') {
            $this->db->where("T.user_id", $user_id);
        }
        $this->db->order_by('T.created_on DESC');
        if (isset($arr_condition['limit']) && $arr_condition['limit'] != "") {
            $this->db->limit($arr_condition['limit']);
        }

        if (isset($arr_condition['offset']) && isset($arr_condition['limit']) && $arr_condition['offset'] != "") {
            $this->db->offset($arr_condition['offset']);
        }

        $result = $this->db->get();
//        echo $this->db->last_query();
        return $result->result_array();
    }

    /* function to get trade list count from the database */

    public function getTradeDetailsCount($user_id = '') {
        $this->db->select('T.trade_id,T.status,T.other_information,T.price_eq,T.price_eq_val,c.currency_id,c.currency_code,T.created_on,G.geo_location_id, G.user_id,G.city, G.region,G.country,G.location');
        $this->db->from('mst_trades as T');
        $this->db->join('geo_location as G', 'T.geo_location_id = G.geo_location_id', 'inner');
		$this->db->join('currency_management as c', 'T.currency_id = c.currency_id', 'left');
        if ($user_id != '') {
            $this->db->where("T.user_id", $user_id);
        }
        $this->db->order_by('T.created_on DESC');
        $result = $this->db->get();
        return $result->num_rows();
    }

    public function getTradeStatusDetails($user_id = '', $status = '', $debug = '', $arr_condition) {
        
        $query = "SELECT `T`.`trade_id`, `T`.`currency_id`, `T`.`user_id`, `C`.`currency_code`, `B`.`transaction_id`, `B`.`created_on`, `B`.`transaction_type`, `b`.`user_name` as buyer, `B`.`buyer_id`, `s`.`user_name` as seller, `B`.`seller_id`, `B`.`transaction_status`, `B`.`fiat_currency`, `B`.`btc_amount`, `B`.`local_currency_rate` 
                FROM (`" . $this->db->dbprefix . "buy_sell_transaction` as B) INNER JOIN `" . $this->db->dbprefix . "mst_trades` as T ON `T`.`trade_id` = `B`.`trade_id` 
                INNER JOIN `" . $this->db->dbprefix . "currency_management` as C ON `C`.`currency_id` = `T`.`currency_id` 
                INNER JOIN `" . $this->db->dbprefix . "mst_users` as b ON `B`.`buyer_id` = `b`.`user_id` 
                INNER JOIN `" . $this->db->dbprefix . "mst_users` as s ON `B`.`seller_id` = `s`.`user_id`   
                WHERE ";

        $query .=" ( `B`.`buyer_id` = '" . $user_id . "' OR `B`.`seller_id` = '" . $user_id . "' ) ";

        if ($status != '') {
            $query .=" AND `B`.`transaction_status` = '" . $status . "' ";
        }

        $query .="  ORDER BY `B`.`created_on` DESC ";      
        
        if (intval($arr_condition['offset'])>-1) {
            $query .=" limit " . $arr_condition['offset'] . " ";
        }

        if (intval($arr_condition['limit'])>-1) {
            $query .=" , " . $arr_condition['limit'] . " ";
        }

        $result = $this->db->query($query);
        if ($debug) {
            echo $this->db->last_query();die;
        }
		//echo $this->db->last_query();
        return $result->result_array();
    }

    public function getTradeStatusDetailsCount($user_id = '', $status = '', $debug = '') {

        $query = "SELECT `T`.`trade_id`, `T`.`currency_id`, `T`.`user_id`, `C`.`currency_code`, `B`.`transaction_id`, `B`.`created_on`, `B`.`transaction_type`, `b`.`user_name` as buyer, `B`.`buyer_id`, `s`.`user_name` as seller, `B`.`seller_id`, `B`.`transaction_status`, `B`.`fiat_currency`, `B`.`btc_amount`, `B`.`local_currency_rate` 
                FROM (`" . $this->db->dbprefix . "buy_sell_transaction` as B) INNER JOIN `" . $this->db->dbprefix . "mst_trades` as T ON `T`.`trade_id` = `B`.`trade_id` 
                INNER JOIN `" . $this->db->dbprefix . "currency_management` as C ON `C`.`currency_id` = `T`.`currency_id` 
                INNER JOIN `" . $this->db->dbprefix . "mst_users` as b ON `B`.`buyer_id` = `b`.`user_id` 
                INNER JOIN `" . $this->db->dbprefix . "mst_users` as s ON `B`.`seller_id` = `s`.`user_id`   
                WHERE ";

        $query .=" ( `B`.`buyer_id` = '" . $user_id . "' OR `B`.`seller_id` = '" . $user_id . "' ) ";

        if ($status != 'closed') {
            $query .=" AND `B`.`transaction_status` = '" . $status . "' ";
        }

        $query .="  ORDER BY `B`.`created_on` DESC ";

        $result = $this->db->query($query);
        if ($debug) {
            die($this->db->last_query());
        }
        return $result->num_rows();
    }

    /* get advertisement detail by transaction_id and trade_id */

    public function getTradeDetailsByTransactionId($trade_id = '', $transaction_id = '', $debug = '') {

//        $this->db->select('txn.*,trd.*,user.*');
        $this->db->select('txn.transaction_id,txn.buyer_id,txn.seller_id,txn.fiat_currency,txn.btc_amount,txn.local_currency_rate,txn.transaction_type,txn.transaction_status,txn.transaction_status,txn.verify_code,txn.action_taken_by,txn.created_on,trd.trade_id,trd.user_id as advertiser_id,trd.currency_id,trd.trade_type ,trd.trade_type,e.escrow_status ,e.seller_funded, e.escrow_transaction_id, e.escrow_wallet_address,u.user_name as action_taken_user');
        $this->db->from('buy_sell_transaction as txn');
        $this->db->join('mst_trades as trd', 'txn.trade_id = trd.trade_id', 'inner');
		$this->db->join('mst_escrow_management as e', 'txn.transaction_id = e.contact_id', 'left');
        $this->db->join('mst_users as u', 'txn.action_taken_by = u.user_id', 'inner');
//        $this->db->join('');
        if ($trade_id != '')
            $this->db->where('txn.trade_id', $trade_id);
        if ($transaction_id != '')
            $this->db->where('txn.transaction_id', $transaction_id);

        $result = $this->db->get();

        if ($debug) {
            die($this->db->last_query());
        }
        return $result->result_array();
    }
	
	
	
	/* get advertisement escrow detail by transaction_id and trade_id */

    public function getTradeEscrowDetails($trade_id, $contact_id, $debug = '') {

        $this->db->select('e.escrow_id,e.escrow_transaction_id,e.contact_id,e.trade_id,e.btc_amount,e.buyer_user_id,e.seller_user_id,e.seller_funded,e.escrow_status');
        $this->db->from('mst_escrow_management as e');
        //$this->db->join('mst_trades as trd', 'txn.trade_id = trd.trade_id', 'inner');
//        $this->db->join('mst_users as user', 'txn.buyer_id = user.user_id', 'inner');
//        $this->db->join('');
        if ($trade_id != '')
            $this->db->where('e.trade_id', $trade_id);
        if ($transaction_id != '')
            $this->db->where('e.contact_id', $transaction_id);

        $result = $this->db->get();

        if ($debug) {
            die($this->db->last_query());
        }
        return $result->result_array();
    }
	
	
	    /* get advertisement detail by transaction_id and trade_id */

    public function getTradeChatDetails($trade_id, $transaction_id, $debug = '') {
	
        $this->db->select('t.chat_id,t.trade_id,t.transaction_id,t.msg_from_user_id,t.contact_message,t.created_on,u.user_name');
        $this->db->from('trade_chat as t');
        $this->db->join('mst_users as u', 't.msg_from_user_id = u.user_id', 'inner');

        if ($trade_id != '')
            $this->db->where('t.trade_id', $trade_id);
        if ($transaction_id != '')
            $this->db->where('t.transaction_id', $transaction_id);
			
		$this->db->order_by('t.created_on DESC');

        $result = $this->db->get();

        if ($debug) {
            die($this->db->last_query());
        }
        return $result->result_array();
    }


}

?>