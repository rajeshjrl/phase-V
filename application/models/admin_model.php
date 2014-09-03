<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_Model extends CI_Model {
    #function to get admin list from the database

    public function getAdminDetails($user_id = '') {
        $this->db->select('u.user_id,u.user_name,u.first_name,u.last_name,u.user_email,u.user_status,u.user_type,u.register_date,u.role_id,u.gender,r.role_name');
        $this->db->from('mst_users as u');
        $this->db->join('mst_role as r', 'u.role_id = r.role_id', 'left');
        if ($user_id != '') {
            $this->db->where("u.user_id", $user_id);
        }
        $this->db->where("u.user_type", 2);
        $result = $this->db->get();
        return $result->result_array();
    }

}
