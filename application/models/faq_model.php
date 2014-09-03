<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  Class will do all necessary action for blog functionalities
 */

class FAQ_Model extends CI_Model {

    public function getCategories($fields = '', $condition_to_pass = '', $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0) {
        if ($fields == '') {

            $fields = "*";
        }

        $this->db->select($fields, FALSE);

        $this->db->from("mst_faq_categories");

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

    public function getFAQS($fields = '', $condition_to_pass = '', $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0) {
        if ($fields == '')
            $fields = "f.*,(select title from " . $this->db->dbprefix('mst_faq_categories') . " fc where fc.category_id=f.category_id) as category_name";

        $this->db->select($fields, FALSE);

        $this->db->from("mst_faqs as f");

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

}