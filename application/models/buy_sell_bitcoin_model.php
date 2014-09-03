
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class buy_sell_bitcoin_model extends CI_Model {

    public function getUserAdvertisementDetails($user_id = '') {
        $this->db->select('t.trade_id,t.geo_location_id,t.payment_method_id,p.method_name,p.method_url,t.currency_id,t.trade_type,t.bank_service,t.premium,t.price_eq,t.price_eq_val,t.min_amount,t.max_amount,t.status,t.created_on,r.user_name,r.role_id,c.currency_name,g.city,p.method_name');
        $this->db->from('mst_trades as t');
        $this->db->join('mst_users as r', 't.user_id = r.user_id', 'left');
        $this->db->join('currency_management as c', 't.currency_id = c.currency_id', 'left');
        $this->db->join('geo_location as g', 't.geo_location_id = g.geo_location_id', 'left');
        $this->db->join('payment_method as p', 't.payment_method_id = p.method_id', 'left');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function getAdvertisementDetails($edit_id = '', $debug_to_pass = '') {
        $this->db->select('t.trade_id,t.status,t.floating_price_chk,t.float_premium,t.price_eq,t.price_eq_val,t.meeting_place,t.other_information,t.payment_method_id,p.method_name,p.method_url,t.currency_id,t.trade_type,t.bank_service,t.premium,t.min_amount,t.max_amount,t.contact_hours,r.user_name,r.user_id,r.role_id,c.currency_id,c.currency_code,g.city,s.real_name_required, s.sms_verification, s.trusted_people_only, s.liquidity_option, s.payment_window,o.bank_transfer_details,o.min_volume, o.min_feedback_score,o.new_buyer_limit , o.tvc , o.display_reference,o.reference_type,g.geo_location_id,g.city,g.location,g.region,g.country,g.lattitude,g.longitude');
        $this->db->from('mst_trades as t');
        $this->db->join('mst_users as r', 't.user_id = r.user_id', 'left');
        $this->db->join('currency_management as c', 't.currency_id = c.currency_id', 'left');
        $this->db->join('geo_location as g', 't.geo_location_id = g.geo_location_id', 'left');
        $this->db->join('payment_method as p', 't.payment_method_id = p.method_id', 'left');
        $this->db->join('security_options as s', 't.trade_id = s.trade_id', 'left');
        $this->db->join('trans_trade_online_selling_option as o', 't.trade_id = o.trade_id', 'left');

        if ($edit_id != '')
            $this->db->where("t.trade_id", $edit_id);

        $result = $this->db->get();

        if ($debug_to_pass)
            echo $this->db->last_query();

        return $result->result_array();
    }

    /* get trade request list */

    public function getAllTradeRequestDetails($debug = '') {

        $this->db->select('txn.transaction_id,txn.created_on,txn.buyer_id,txn.seller_id,txn.fiat_currency,txn.btc_amount,txn.local_currency_rate,txn.transaction_type,txn.transaction_status,trd.trade_id,trd.user_id as advertiser_id,trd.currency_id,trd.trade_type,trd.trade_type');
        $this->db->select('user.user_id,user.user_name,user.user_email,user.role_id');
        $this->db->select('cur.currency_id,cur.currency_code,,cur.currency_name');
        $this->db->from('buy_sell_transaction as txn');
        $this->db->join('mst_trades as trd', 'txn.trade_id = trd.trade_id', 'inner');
        $this->db->join('mst_users as user', 'txn.buyer_id = user.user_id', 'inner');
        $this->db->join('currency_management as cur', 'trd.currency_id = cur.currency_id', 'inner');
        $this->db->order_by('txn.transaction_id desc');
        $result = $this->db->get();        
        if ($debug) {
            die($this->db->last_query());
        }
        return $result->result_array();
    }

}

?>
