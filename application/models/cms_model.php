<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms_Model extends CI_Model {

    function getCmsList() {
        $fields_to_pass = "A.cms_id,A.lang_id,A.page_alias,A.page_title,A.page_content,A.status,B.lang_name";
        $condition_to_pass = array("B.status" => "A");
        $order_by_to_pass = " B.lang_name ASC ";

        $this->db->select($fields_to_pass);
        $this->db->from('cms as A');
        $this->db->join('mst_languages as B', 'A.lang_id = B.lang_id');
        $this->db->where($condition_to_pass);
        $this->db->order_by('A.cms_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getCmsPageDetails($cms_page_id) {

        $fields_to_pass = "A.cms_id,A.lang_id,A.page_alias,A.page_title,A.page_content,A.status,B.lang_name,A.page_meta_keywords,A.page_meta_description,A.page_seo_title";
        $condition_to_pass = array("B.status" => "A", "A.cms_id" => $cms_page_id);
        $order_by_to_pass = " B.lang_name ASC ";

        $this->db->select($fields_to_pass);
        $this->db->from('cms as A');
        $this->db->join('mst_languages as B', 'A.lang_id = B.lang_id');
        $this->db->where($condition_to_pass);
        $this->db->order_by('B.lang_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getCmsPage($lang_id, $page_alias) {

        $selectFields = array('cms_id', 'page_title', 'page_content');
        $conditions = array('status' => 'published', 'lang_id' => $lang_id, 'page_alias' => $page_alias);
        $this->db->select($selectFields);
        $this->db->from('cms');
        $this->db->where($conditions);
        $query = $this->db->get();        
        return $query->result_array();
    }

}

?>
