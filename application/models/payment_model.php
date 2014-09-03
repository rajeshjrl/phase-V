<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  Class will do all necessary action for forum functionalities
 */

class Payment_Model extends CI_Model {

	/* Get payment method details */
    public function getCategories($fields = '', $condition_to_pass = '', $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0) {
        if ($fields == '') {

            $fields = "c.*,IF(c.parent_method_id > 0,(select method_name from " . $this->db->dbprefix('payment_method') . " c2 ";
            $fields.="where c2.method_id = c.parent_method_id limit 1),'-') as parent_category";
        }

        $this->db->select($fields, FALSE);
        $this->db->from("payment_method as c");
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

    private function getCategoryTree($d, $r = 0, $pk = 'parent_method_id', $k = 'method_id', $c = 'children') {
        $m = array();
        foreach ($d as $e) {
            isset($m[$e[$pk]]) ? : $m[$e[$pk]] = array();
            isset($m[$e[$k]]) ? : $m[$e[$k]] = array();
            $m[$e[$pk]][] = array_merge($e, array($c => &$m[$e[$k]]));
        }

        return $m[$r]; // remove [0] if there could be more than one root nodes
    }
	
	/* Check unique method url or not */
	public function getUniqueUri($url) {

        $this->db->select("*");
        $this->db->from("payment_method");
        $this->db->where("method_url", $url);
        $query = $this->db->get();
        return $query->result_array();
    }
	
    private function render_categories_SELECT($arr, $level, $appendUrl = 0) {
        $str = "";

        foreach ($arr as $cat) {
            $str.="\n<option value=\"" . $cat['method_id'] . "\">";
            if ($appendUrl) {
                $str.='<a href="' . base_url() . $cat['page_url'] . '">' . $cat['method_name'] . "</a></option>";
            } else {
                $str.=$cat['method_name'] . "</option>";
            }

            if (count($cat["children"]) > 0) {
                $level++;
                $str.="\n" . $this->render_categories_SELECT($cat["children"], $level) . "\n";
            } else {

                $str.="";
            }
        }

        return $str;
    }

    
}
