<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Register_Model extends CI_Model {

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

    public function insertUserInformation($table, $fields, $debug_to_pass = 0) {
        if ($debug_to_pass)
            echo $this->db->last_query();

        $this->db->insert($table, $fields);
        return $this->db->insert_id();
    }

}