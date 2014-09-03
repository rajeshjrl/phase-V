<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_Model extends CI_Model {

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

#function to get user list from the database

    public function getUserDetails($user_id = '') {
        $this->db->select('u.user_id,u.user_name,u.first_name,u.last_name,u.user_email,u.user_status,u.user_type,u.register_date,u.role_id,u.gender,r.role_name');
        $this->db->from('mst_users as u');
        $this->db->join('mst_role as r', 'u.role_id = r.role_id', 'left');
        if ($user_id != '') {
            $this->db->where("u.user_id", $user_id);
        }
        $this->db->where("u.user_type", 1);
        $this->db->order_by('u.user_id desc');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function insertUserDeleteRequestInformation($table, $fields, $debug_to_pass = 0) {
        if ($debug_to_pass)
            echo $this->db->last_query();

        $this->db->insert($table, $fields);
        return $this->db->insert_id();
    }

    #function to get user list which requested for deletion and previously deactivated

    public function getUserDeletionDetails($user_id = '') {
        $this->db->select('u.id,u.user_id,u.is_deleted,u.requested_timestamp,u.comment,u.is_deleted,r.user_name,r.first_name,r.user_email,r.user_status,r.role_id');
        $this->db->from('user_deletion_requests as u');
        $this->db->join('mst_users as r', 'u.user_id = r.user_id', 'left');
        //$this->db->where("u.is_deleted", '0');
        $this->db->order_by("u.is_deleted", "asc");

        if ($user_id != '') {
            $this->db->where("u.user_id", $user_id);
        }
        $this->db->order_by('u.id desc');
        $result = $this->db->get();
        return $result->result_array();
    }

    #function to view user details on view page which requested for deletion

    public function viewUserDeletionDetails($user_id = '') {
        $this->db->select('u.id,u.user_id,u.is_deleted,u.requested_timestamp,u.comment,r.user_name,r.first_name,r.user_email,r.user_status,r.role_id');
        $this->db->from('user_deletion_requests as u');
        $this->db->join('mst_users as r', 'u.user_id = r.user_id', 'left');
        if ($user_id != '') {
            $this->db->where("u.id", $user_id);
        }
        $result = $this->db->get();
        return $result->result_array();
    }

    #To chcek user alredy requested for delete his account.

    public function chkUserDeletionDetails($user_id = '') {
        $this->db->select('u.id,u.user_id');
        $this->db->from('user_deletion_requests as u');
        if ($user_id != '') {
            $this->db->where("u.user_id", $user_id);
            $this->db->where("u.is_deleted", '0');
        }
        $result = $this->db->get();
        return $result->result_array();
    }

    #function to get user log list

    public function getUserLogDetails($user_id = '',$limit = '') {
        $this->db->select('u.log_id,u.user_id,u.last_login,u.last_logout,u.geo_location_id,r.user_name,r.role_id,g.geo_location_id,g.ip,g.city,g.region,g.country,g.lattitude,g.longitude,g.created_on');
        $this->db->from('user_sign_in_log as u');
        $this->db->join('mst_users as r', 'u.user_id = r.user_id', 'left');
        $this->db->join('geo_location as g', 'u.geo_location_id = g.geo_location_id', 'left');
		if ($user_id != '') {
            $this->db->where("u.user_id", $user_id);            
        }
        $this->db->order_by('log_id desc');
		if ($limit != '') {
            $this->db->limit($limit);            
        }
        $result = $this->db->get();
		//echo $this->db->last_query();
        return $result->result_array();
    }

    public function getUserAdvertisementDetails($user_id = '') {
        $this->db->select('t.trade_id,t.geo_location_id,t.payment_method_id,t.currency_id,t.trade_type,t.bank_service,t.premium,t.price_eq,t.price_eq_val,t.min_amount,t.max_amount,t.status,t.created_on,r.user_name,r.role_id,c.currency_name,g.city,p.method_name');
        $this->db->from('mst_trades as t');
        $this->db->join('mst_users as r', 't.user_id = r.user_id', 'left');
        $this->db->join('currency_management as c', 't.currency_id = c.currency_id', 'left');
        $this->db->join('geo_location as g', 't.geo_location_id = g.geo_location_id', 'left');
        $this->db->join('payment_method as p', 't.payment_method_id = p.method_id', 'left');
        $this->db->order_by('t.trade_id desc');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function getAdvertisementDetails($edit_id = '') {
        $this->db->select('t.trade_id,t.status,t.floating_price_chk,t.float_premium,t.price_eq,t.price_eq_val,t.meeting_place,t.other_information,t.payment_method_id,t.currency_id,t.trade_type,t.bank_service,t.premium,t.min_amount,t.max_amount,t.contact_hours,r.user_name,r.role_id,c.currency_id,c.currency_code,g.city,s.real_name_required, s.sms_verification, s.trusted_people_only, s.liquidity_option, s.payment_window,o.bank_transfer_details,o.min_volume, o.min_feedback_score,o.new_buyer_limit , o.tvc , o.display_reference,o.reference_type,g.geo_location_id,g.city,g.location,g.region,g.country,g.lattitude,g.longitude');
        $this->db->from('mst_trades as t');
        $this->db->join('mst_users as r', 't.user_id = r.user_id', 'left');
        $this->db->join('currency_management as c', 't.currency_id = c.currency_id', 'left');
        $this->db->join('geo_location as g', 't.geo_location_id = g.geo_location_id', 'left');
        $this->db->join('payment_method as p', 't.payment_method_id = p.method_id', 'left');
        $this->db->join('security_options as s', 't.trade_id = s.trade_id', 'left');
        $this->db->join('trans_trade_online_selling_option as o', 't.trade_id = o.trade_id', 'left');

        if ($edit_id != '') {
            $this->db->where("t.trade_id", $edit_id);
        }

        $result = $this->db->get();
//        echo $this->db->last_query();
        return $result->result_array();
    }

    #function to get client api information

    public function getclientApiDetails($user_id = '', $api_id = '', $client_id = '') {
        $this->db->select('a.api_id,a.api_client_name,a.url_prefix,a.redirect_url,a.access_tokens,a.income,a.client_id,a.client_secret,a.client_scope,u.user_name,u.user_id');
        $this->db->from('api_client as a');
        $this->db->join('mst_users as u', 'a.user_id = u.user_id', 'left');
        if ($user_id != '') {
            $this->db->where("a.user_id", $user_id);
        }
        if ($api_id != '') {
            $this->db->where("a.api_id", $api_id);
        }
        if ($client_id != '') {
            $this->db->where("a.client_id", $client_id);
        }
        $result = $this->db->get();
        return $result->result_array();
    }
	
	
	public function getAppDetails($user_id = '',$app_id = '') {
        $this->db->select('a.app_id,a.app_name,a.scope,a.token,p.api_client_name,p.url_prefix,p.redirect_url,p.access_tokens,p.income,p.client_id,p.client_secret,u.user_name,u.user_id');
        $this->db->from('apps as a');
        $this->db->join('mst_users as u', 'a.user_id = u.user_id', 'left');
		$this->db->join('api_client as p', 'a.api_id = p.api_id', 'left');
        if ($user_id != '') {
            $this->db->where("a.user_id", $user_id);
        }
		if ($app_id != '') {
            $this->db->where("a.app_id", $app_id);
        }
        $result = $this->db->get();
        return $result->result_array();
    }

}

?>