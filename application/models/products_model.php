<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  Class will do all necessary action for blog functionalities
 */

class Products_Model extends CI_Model {

    public function getCategories($fields = '', $condition_to_pass = '', $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0) {
        if ($fields == '') {

            $fields = "c.*,IF(c.parent_id > 0,(select category_name from " . $this->db->dbprefix('mst_categories') . " c2 ";
            $fields.="where c2.category_id = c.parent_id limit 1),'-') as parent_category,(select `url` from ";
            $fields.=$this->db->dbprefix('mst_uri_map') . " u where u.type='category' and u.rel_id=c.category_id) as page_url";
        }

        $this->db->select($fields, FALSE);

        $this->db->from("mst_categories as c");

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

    private function getCategoryTree(
    $d, $r = 0, $pk = 'parent_id', $k = 'category_id', $c = 'children'
    ) {
        $m = array();
        foreach ($d as $e) {
            isset($m[$e[$pk]]) ? : $m[$e[$pk]] = array();
            isset($m[$e[$k]]) ? : $m[$e[$k]] = array();
            $m[$e[$pk]][] = array_merge($e, array($c => &$m[$e[$k]]));
        }

        return $m[$r]; // remove [0] if there could be more than one root nodes
    }

    private function render_categories_SELECT($arr, $level, $appendUrl = 0) {
        $str = "";

        foreach ($arr as $cat) {
            $str.="\n<option>";
            if ($appendUrl) {
                $str.='<a href="' . base_url() . $cat['page_url'] . '">' . $cat['category_name'] . "</a></option>";
            } else {
                $str.=$cat['category_name'] . "</option>";
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

    private function render_categories_UL($arr, $level, $appendUrl = 1) {
        $str = "";

        foreach ($arr as $cat) {
            $str.="\n<li>";
            if ($appendUrl) {
                $str.='<a href="' . base_url() . $cat['page_url'] . '">' . $cat['category_name'] . "</a>";
            } else {
                $str.=$cat['category_name'];
            }

            if (count($cat["children"]) > 0) {
                $level++;
                $str.="\n<ul>" . $this->render_categories_UL($cat["children"], $level, $appendUrl) . "\n</ul>\n</li>";
            } else {
                $str.="\n</li>";
            }
        }

        return $str;
    }

    public function getCategoryTreeResponse($type = 'ul') {
        $arr_categories = $this->getCategories();

        foreach ($arr_categories as $category) {
            $arr_blog_categories[] = array(
                "category_id" => $category['category_id'],
                "parent_id" => $category['parent_id'],
                "category_name" => $category['category_name'],
                "page_url" => "categories/" . $category['page_url']
            );
        }

        $arr_categories_tree = $this->getCategoryTree($arr_blog_categories);

        if ($type == 'ul')
            $str_categories = $this->render_categories_UL($arr_categories_tree, 0);
        elseif ($type == 'select')
            $str_categories = $this->render_categories_UL($arr_categories_tree, 0);

        return $str_categories;
    }

    public function getProducts($fields = '', $condition_to_pass = '', $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0) {
        if ($fields == '')
            $fields = "p.*,(select `url` from " . $this->db->dbprefix('mst_uri_map') . " u where u.rel_id=p.product_id and u.`type`='product') as page_url,(select pi.image_path from " . $this->db->dbprefix('trans_product_images') . " pi where pi.product_id = p.product_id limit 1) as product_image";

        $this->db->select($fields, FALSE);

        $this->db->from("mst_products as p");

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

    public function getCategoryProducts($fields = '', $condition_to_pass = '', $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0) {
        if ($fields == '')
            $fields = "p.*,(select `url` from " . $this->db->dbprefix('mst_uri_map') . " u where u.rel_id=p.product_id and u.`type`='product') as page_url,(select pi.image_path from " . $this->db->dbprefix('trans_product_images') . " pi where pi.product_id = p.product_id limit 1) as product_image";

        $this->db->select($fields, FALSE);

        $this->db->from("mst_products as p");

        $this->db->join("trans_product_categories pc", 'p.product_id=pc.product_id', 'inner');

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

    public function getProductImages($fields = '', $condition_to_pass = '', $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0) {
        if ($fields == '')
            $fields = "*";

        $this->db->select($fields, FALSE);

        $this->db->from("trans_product_images as pi");

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

    public function getProductAttributes($fields = '', $condition_to_pass = '', $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0) {
        if ($fields == '')
            $fields = "pa.*,av.attribute_value_name,av.attribute_value_description,(select attribute_name from pipl_mst_attribute_list al where al.attribute_id=av.attribute_id) as attribute_name";

        $this->db->select($fields, FALSE);

        $this->db->from("trans_product_attributes as pa");
        $this->db->join("trans_attribute_values as av", "pa.attribute_value_id=av.attribute_rec_id", "inner");


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

    public function searchPosts($searchKey) {
        $fields = "b.*,(select `url` from " . $this->db->dbprefix('mst_uri_map') . " u where u.rel_id=b.post_id and u.`type`='blog-post') as page_url";
        $this->db->select($fields, FALSE);

        $this->db->from("mst_blog_posts as b");

        $this->db->or_like(array('post_title' => $searchKey, 'post_short_description' => $searchKey, 'post_content' => $searchKey, 'post_tags' => $searchKey));

        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_comment($arr) {
        $this->db->insert("trans_blog_comments", $arr);
        return $this->db->insert_id();
    }

    public function getPostComments($fields = '', $condition = '', $order = '', $limit = '') {
        if ($fields == '')
            $fields = "*";

        $this->db->select($fields, FALSE);

        $this->db->from("trans_blog_comments as b");

        if ($condition != '')
            $this->db->where($condition);


        if ($order != '')
            $this->db->order_by($order);


        if ($limit != '')
            $this->db->limit($limit);

        $query = $this->db->get();


        /* if(isset($debug_to_pass))
          echo $this->db->last_query(); */

        return $query->result_array();
    }

}