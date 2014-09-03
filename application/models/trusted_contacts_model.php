<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trusted_Contacts_Model extends CI_Model {

    public function insertUserInformation($table, $fields, $debug_to_pass = 0) {
        if ($debug_to_pass)
            echo $this->db->last_query();

        $this->db->insert($table, $fields);
        return $this->db->insert_id();
    }

    /* Get list of all trusted people list at backend */

    public function getTrustedToPeopleDetails($user_id = '') {
        $this->db->select('u.trust_id,u.invitation_from,u.invitation_to,u.friend_email,u.updated_on,u.status,r.user_name,s.user_name as trusted_on');
        $this->db->from('trusted_people as u');
        $this->db->join('mst_users as r', 'u.invitation_from = r.user_id', 'left');
        $this->db->join('mst_users as s', 'u.invitation_to = s.user_id', 'left');
        $result = $this->db->get();
        $this->db->order_by('u.trust_id desc');
        return $result->result_array();
    }

    /* Get list of people you trust */

    public function getPeopleYouTrustList($user_id = '') {
        $this->db->select('u.trust_id,u.invitation_to,u.updated_on,u.status,r.user_name');
        $this->db->from('trusted_people as u');
        $this->db->join('mst_users as r', 'u.invitation_to = r.user_id', 'left');
        if ($user_id != '') {
            $this->db->where("u.invitation_from", $user_id);
            $this->db->where("u.invitation_to != 'NULL'");
            $this->db->where("u.status", 'T');
        }
        $result = $this->db->get();
        return $result->result_array();
    }

    /* Get list of people trust you */

    public function getPeopleTrustYouList($user_id = '') {
        $this->db->select('u.trust_id,u.invitation_from,u.updated_on,u.status,r.user_name');
        $this->db->from('trusted_people as u');
        $this->db->join('mst_users as r', 'u.invitation_from = r.user_id', 'left');
        if ($user_id != '') {
            $this->db->where("u.invitation_to", $user_id);
            $this->db->where("u.status", 'T');
        }
        $result = $this->db->get();
        return $result->result_array();
    }

    /* Get list of requests to add trust to register people */

    public function getTrustedRequestDetails($user_id = '') {
        $this->db->select('u.trust_id,u.invitation_from,u.updated_on,u.status,r.user_name');
        $this->db->from('trusted_people as u');
        $this->db->join('mst_users as r', 'u.invitation_from = r.user_id', 'left');
        if ($user_id != '') {
            $this->db->where("u.invitation_to", $user_id);
            $this->db->where("u.is_requested", '1');
        }
        $result = $this->db->get();
        return $result->result_array();
    }

    /* Get status of trust */

    public function getTrustedStatusDetails($trusted_user_id = '', $user_id = '') {
        $this->db->select('u.trust_id,u.status,u.is_requested,u.feedback_comment');
        $this->db->from('trusted_people as u');
        //$this->db->join('mst_users as r', 'u.invitation_from = r.user_id', 'left');
        if ($user_id != '') {
            $this->db->where("u.invitation_from", $user_id);
            $this->db->where("u.invitation_to", $trusted_user_id);
            //$this->db->where("u.status", 'T');
            //$this->db->where("u.is_requested", '2');
        }
        $result = $this->db->get();
        return $result->result_array();
    }

    /* Get list of trades from people that trust you have having ads available for selling Bitcoin right now. */

    public function getTradeTrustedSell($user_id = '') {
        $this->db->select('T.trade_id,T.other_information,T.created_on,T.min_amount,T.max_amount,T.trade_type,C.currency_code,G.geo_location_id,G.user_id,G.city,G.region, G.country, G.location,P.invitation_from,P.status,U.user_name');
        $this->db->from('mst_trades as T');
        $this->db->join('geo_location as G', 'T.geo_location_id = G.geo_location_id', 'inner');
        $this->db->join('currency_management as C', 'T.currency_id = C.currency_id', 'inner');
        $this->db->join('trusted_people as P', 'T.user_id = P.invitation_from', 'inner');
        $this->db->join('mst_users as U', 'U.user_id = P.invitation_from', 'inner');
        if ($user_id != '') {
            $this->db->where("P.invitation_to", $user_id);
            $this->db->where("P.status", 'T');
            $trade_type = array('sell_o', 'sell_c');
            $this->db->where_in('T.trade_type', $trade_type);
        }
        $result = $this->db->get();
        //echo $this->db->last_query();
        return $result->result_array();
    }

    /* Get list of trades from people that trust you have having ads available for selling Bitcoin right now. */

    public function getTradeTrustedBuy($user_id = '') {
        $this->db->select('T.trade_id,T.other_information,T.created_on,T.min_amount,T.max_amount,T.trade_type,C.currency_code,G.geo_location_id,G.user_id,G.city,G.region, G.country, G.location,P.invitation_to,P.status,U.user_name');
        $this->db->from('mst_trades as T');
        $this->db->join('geo_location as G', 'T.geo_location_id = G.geo_location_id', 'inner');
        $this->db->join('currency_management as C', 'T.currency_id = C.currency_id', 'inner');
        $this->db->join('trusted_people as P', 'T.user_id = P.invitation_to', 'inner');
        $this->db->join('mst_users as U', 'U.user_id = P.invitation_to', 'inner');
        if ($user_id != '') {
            $this->db->where("P.invitation_from", $user_id);
            $this->db->where("P.status", 'T');
            $trade_type = array('buy_o', 'buy_c');
            $this->db->where_in('T.trade_type', $trade_type);
        }
        $result = $this->db->get();
        //echo $this->db->last_query();
        return $result->result_array();
    }

    /* Get list of all trusted advertisement. */

    public function getTrustedTradeList() {
        $this->db->select('T.trade_id,T.other_information,T.created_on,T.min_amount,T.max_amount,T.trade_type,C.currency_code,G.geo_location_id,G.user_id,G.city,G.region, G.country, G.location,U.user_name,S.trusted_people_only');
        $this->db->from('mst_trades as T');
        $this->db->join('geo_location as G', 'T.geo_location_id = G.geo_location_id', 'inner');
        $this->db->join('currency_management as C', 'T.currency_id = C.currency_id', 'inner');
        $this->db->join('mst_users as U', 'U.user_id = T.user_id', 'inner');
        $this->db->join('security_options as S', 'S.trade_id = T.trade_id', 'inner');
        $this->db->where("S.trusted_people_only", "Y");
        $this->db->order_by('T.trade_id desc');
        $result = $this->db->get();
        //echo $this->db->last_query();
        return $result->result_array();
    }
	
	
	/* Get list of people blocked you */

    public function getPeopleBlockedYouList($user_id = '') {
        $this->db->select('u.trust_id,u.invitation_from,u.updated_on,u.status,r.user_name');
        $this->db->from('trusted_people as u');
        $this->db->join('mst_users as r', 'u.invitation_from = r.user_id', 'left');
        if ($user_id != '') {
            $this->db->where("u.invitation_to", $user_id);
            $this->db->where("u.status", 'B');
        }
        $result = $this->db->get();
        return $result->result_array();
    }
	
	
	/* Get feedback from user */

    public function getFeedbackDetails($user_id = '',$type = '',$status = '',$limit = '') {
        $this->db->select('u.trust_id,u.updated_on,u.invitation_from,u.feedback_comment,u.trade_volume');
        $this->db->from('trusted_people as u');
        //$this->db->join('mst_users as r', 'u.invitation_from = r.user_id', 'left');
        if ($user_id != '') {
            $this->db->where("u.invitation_to", $user_id);            
        }
		if ($type != '') {
            $this->db->where("u.type", $type);            
        }
		if ($status != '') {
            $this->db->where("u.status", $status);            
        }
		if ($limit != '') {
            $this->db->limit($limit);
        }
        $result = $this->db->get();
		//echo $this->db->last_query();
        return $result->result_array();
    }

}