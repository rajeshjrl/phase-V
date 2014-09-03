<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  Class will do all necessary action for forum functionalities
 */

class Forum_Model extends CI_Model {

    public function getCategories($fields = '', $condition_to_pass = '', $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0) {
        if ($fields == '') {

            $fields = "c.*,IF(c.parent_id > 0,(select category_name from " . $this->db->dbprefix('mst_forum_categories') . " c2 ";
            $fields.="where c2.category_id = c.parent_id limit 1),'-') as parent_category,(select `url` from ";
            $fields.=$this->db->dbprefix('mst_uri_map') . " u where u.type='forum-category' and u.rel_id=c.category_id) as page_url";
        }

        $this->db->select($fields, FALSE);
        $this->db->from("mst_forum_categories as c");
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

    private function getCategoryTree($d, $r = 0, $pk = 'parent_id', $k = 'category_id', $c = 'children') {
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
            $str.="\n<option value=\"" . $cat['category_id'] . "\">";
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

    /*   private function render_categories_UL($arr, $level, $appendUrl = 1) {
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
      } */

    private function render_categories_UL($arr, $level, $appendUrl = 1) {
        $str = "";
        $i = 0;
        foreach ($arr as $cat) {
            if ($i == 4) {
                $str.="\n<li><b><label>Regional</label></b></li>";
            }

            if ($i == 16) {
                $str.="\n<li><b><label>Developers and affiliates</label></b></li>";
            }

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
            $i++;
        }
        return $str;
    }

    public function getCategoryTreeResponse($type = 'ul') {
        $arr_categories = $this->getCategories();
        foreach ($arr_categories as $category) {
            $arr_forum_categories[] = array(
                "category_id" => $category['category_id'],
                "parent_id" => $category['parent_id'],
                "category_name" => $category['category_name'],
                "page_url" => "forum/" . $category['page_url']
            );
        }
        $arr_categories_tree = $this->getCategoryTree($arr_forum_categories);
        if ($type == 'ul')
            $str_categories = $this->render_categories_UL($arr_categories_tree, 0);
        elseif ($type == 'select')
            $str_categories = $this->render_categories_SELECT($arr_categories_tree, 0);
        return $str_categories;
    }

    public function getTopics($fields = '', $condition_to_pass = '', $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0) {

        if ($fields == '')
            $fields = "b.*,(select user_name from " . $this->db->dbprefix('mst_users') . " us where us.user_id = b.posted_by ) as user_name,(select profile_picture from " . $this->db->dbprefix('mst_users') . " us where us.user_id = b.posted_by ) as profile_picture,(select category_name from " . $this->db->dbprefix('mst_forum_categories') . " bc where bc.category_id=b.category_id) as category_name,(select `url` from " . $this->db->dbprefix('mst_uri_map') . " u where u.rel_id=b.topic_id and u.`type`='forum-topic') as page_url";
        $this->db->select($fields, FALSE);
        $this->db->from("mst_forum_topics as b");
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

    /* function to get the total count of records for */

    public function getTopicsCountForCategory($fields = '', $condition_to_pass = '', $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0) {

        if ($fields == '')
            $fields = "b.*,(select user_name from " . $this->db->dbprefix('mst_users') . " us where us.user_id = b.posted_by ) as user_name,(select profile_picture from " . $this->db->dbprefix('mst_users') . " us where us.user_id = b.posted_by ) as profile_picture,(select category_name from " . $this->db->dbprefix('mst_forum_categories') . " bc where bc.category_id=b.category_id) as category_name,(select `url` from " . $this->db->dbprefix('mst_uri_map') . " u where u.rel_id=b.topic_id and u.`type`='forum-topic') as page_url";
        $this->db->select($fields, FALSE);
        $this->db->from("mst_forum_topics as b");
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

    public function getTopicsAjax($fields = '', $condition_to_pass = '', $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0) {

        if ($fields == '')
            $fields = "b.*,(select user_name from " . $this->db->dbprefix('mst_users') . " us where us.user_id = b.posted_by ) as user_name,(select profile_picture from " . $this->db->dbprefix('mst_users') . " us where us.user_id = b.posted_by ) as profile_picture,(select category_name from " . $this->db->dbprefix('mst_forum_categories') . " bc where bc.category_id=b.category_id) as category_name,(select `url` from " . $this->db->dbprefix('mst_uri_map') . " u where u.rel_id=b.topic_id and u.`type`='forum-topic') as page_url";
        $this->db->select($fields, FALSE);
        $this->db->from("mst_forum_topics as b");
        if ($condition_to_pass != '')
            $this->db->where($condition_to_pass);
        if ($order_by_to_pass != '')
            $this->db->order_by($order_by_to_pass);
        if ($limit_to_pass != '')
            $this->db->limit(3, $limit_to_pass);
        $query = $this->db->get();
        if ($debug_to_pass)
            echo $this->db->last_query();
        return $query->result_array();
    }

    public function searchTopics($searchKey, $limit) {

        $fields = "b.*,(select user_name from " . $this->db->dbprefix('mst_users') . " us where us.user_id = b.posted_by ) as user_name,(select profile_picture from " . $this->db->dbprefix('mst_users') . " us where us.user_id = b.posted_by ) as profile_picture,(select category_name from " . $this->db->dbprefix('mst_forum_categories') . " bc where bc.category_id=b.category_id) as category_name,(select `url` from " . $this->db->dbprefix('mst_uri_map') . " u where u.rel_id=b.topic_id and u.`type`='forum-topic') as page_url";
        $this->db->select($fields, FALSE);
        $this->db->from("mst_forum_topics as b");
        $this->db->or_like(array('topic_title' => $searchKey, 'topic_short_description' => $searchKey, 'topic_content' => $searchKey, 'topic_tags' => $searchKey));
        if ($limit != '')
            $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }

    /*this function for  search forum topic ajax call(offset,limit) */
    public function searchTopicsAjax($searchKey, $limit) {

        $fields = "b.*,(select user_name from " . $this->db->dbprefix('mst_users') . " us where us.user_id = b.posted_by ) as user_name,(select profile_picture from " . $this->db->dbprefix('mst_users') . " us where us.user_id = b.posted_by ) as profile_picture,(select category_name from " . $this->db->dbprefix('mst_forum_categories') . " bc where bc.category_id=b.category_id) as category_name,(select `url` from " . $this->db->dbprefix('mst_uri_map') . " u where u.rel_id=b.topic_id and u.`type`='forum-topic') as page_url";
        $this->db->select($fields, FALSE);
        $this->db->from("mst_forum_topics as b");
        $this->db->or_like(array('topic_title' => $searchKey, 'topic_short_description' => $searchKey, 'topic_content' => $searchKey, 'topic_tags' => $searchKey));
        if ($limit != '')
            $this->db->limit(3,$limit);
        $query = $this->db->get();
        return $query->result_array();
    }

    /* search result */

    public function searchTopicsCount($searchKey) {

        $fields = "b.*,(select user_name from " . $this->db->dbprefix('mst_users') . " us where us.user_id = b.posted_by ) as user_name,(select profile_picture from " . $this->db->dbprefix('mst_users') . " us where us.user_id = b.posted_by ) as profile_picture,(select category_name from " . $this->db->dbprefix('mst_forum_categories') . " bc where bc.category_id=b.category_id) as category_name,(select `url` from " . $this->db->dbprefix('mst_uri_map') . " u where u.rel_id=b.topic_id and u.`type`='forum-topic') as page_url";
        $this->db->select($fields, FALSE);
        $this->db->from("mst_forum_topics as b");
        $this->db->or_like(array('topic_title' => $searchKey, 'topic_short_description' => $searchKey, 'topic_content' => $searchKey, 'topic_tags' => $searchKey));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_comment($arr) {
        $this->db->insert("trans_forum_comments", $arr);

        return $this->db->insert_id();
    }

    public function insertTopic($arr) {
        $this->db->insert("mst_forum_topics", $arr);
        return $this->db->insert_id();
    }

    public function getTopicComments($fields = '', $condition = '', $order = '', $limit = '', $debug_to_pass = '') {

        if ($fields == '')
            $fields = "b.*,(select user_name from " . $this->db->dbprefix('mst_users') . " u where u.user_id = b.commented_by) as user_name,(select profile_picture from " . $this->db->dbprefix('mst_users') . " u where u.user_id = b.commented_by) as c_profile_picture";

        $this->db->select($fields, FALSE);
        $this->db->from("trans_forum_comments as b");
        if ($condition != '')
            $this->db->where($condition);
        if ($order != '')
            $this->db->order_by($order);
        if ($limit != '')
            $this->db->limit($limit);
        $query = $this->db->get();

        if ($debug_to_pass != '')
            echo $this->db->last_query();

        return $query->result_array();
    }

    public function getUniqueUri($url) {

        $this->db->select("*");
        $this->db->from("mst_uri_map");
        $this->db->where("url", $url);
        $query = $this->db->get();
        return $query->result_array();
    }

    /* function to get all forum topic list */

    public function getForumTopicCommentList($debug_to_pass = '') {

        $this->db->select('ft.topic_id,ft.topic_title,ft.category_id,ft.topic_short_description,ft.topic_content,ft.posted_by,ft.posted_on,ft.status as ft_status,fc.category_id,fc.category_name,fc.page_description,u.user_name,u.user_id');
        $this->db->from('mst_forum_topics as ft');
        $this->db->join('mst_forum_categories as fc', 'ft.category_id = fc.category_id', 'inner');
        $this->db->join('mst_users as u', 'ft.posted_by=u.user_id', 'inner');
//        $this->db->join('trans_forum_comments as tfc', 'tfc.topic_id=ft.topic_id', 'inner');
        $this->db->where('ft.status', '1');
//        $this->db->where('tfc.status','1');
        $this->db->order_by('ft.topic_id desc');
        $query = $this->db->get();
        if ($debug_to_pass)
            echo $this->db->last_query();
        return $query->result_array();
    }

    /* function to get all forum topic list */

    public function getForumTopicList($debug_to_pass = '') {

        $this->db->select('ft.topic_id,ft.topic_title,ft.category_id,ft.topic_short_description,ft.topic_content,ft.posted_by,ft.posted_on,ft.status as ft_status,fc.category_id,fc.category_name,fc.page_description,u.user_name,u.user_id');
        $this->db->from('mst_forum_topics as ft');
        $this->db->join('mst_forum_categories as fc', 'ft.category_id = fc.category_id', 'inner');
        $this->db->join('mst_users as u', 'ft.posted_by=u.user_id', 'inner');
//        $this->db->join('trans_forum_comments as tfc', 'tfc.topic_id=ft.topic_id', 'inner');
        $this->db->where('ft.status', '1');
//        $this->db->where('tfc.status','1');
        $this->db->order_by('ft.topic_id desc');
        $query = $this->db->get();
        if ($debug_to_pass)
            echo $this->db->last_query();
        return $query->result_array();
    }

    /* get comment count */

    public function getTopicCommentsCount($topic_id, $debug_to_pass = '') {

        $this->db->select('count(comment_id) as comment_count');
        $this->db->from('trans_forum_comments');
        $this->db->where('topic_id', $topic_id);
        $query = $this->db->get();
        if ($debug_to_pass)
            echo $this->db->last_query();
        return $query->result_array();
    }

    public function getTopicCreatedUserName($user_id, $debug_to_pass = '') {

        $this->db->select('user_id,user_name');
        $this->db->from('mst_users');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        if ($debug_to_pass)
            echo $this->db->last_query();
        return $query->result_array();
    }

    /*
      SELECT slog.log_id,slog.user_id,slog.last_login,slog.last_logout,u.user_name,u.profile_picture
      FROM `p784_user_sign_in_log` as slog
      JOIN p784_mst_users as u
      ON slog.user_id=u.user_id
      WHERE
      slog.`last_logout`='0000-00-00 00:00:00' group by slog.`user_id` order by slog.`last_logout` desc
     */

    public function getOnlineUsers($debug_to_pass = '') {

        $this->db->select('slog.log_id,slog.user_id,slog.last_login,slog.last_activity,slog.last_logout,u.user_name,u.profile_picture');
        $this->db->from('p784_user_sign_in_log as slog');
        $this->db->join('p784_mst_users as u', 'slog.user_id=u.user_id', 'inner');
        $this->db->where('slog.last_logout', '0000-00-00 00:00:00');
        $this->db->group_by('slog.user_id');
        $this->db->order_by('slog.last_logout desc');
        $query = $this->db->get();
        if ($debug_to_pass)
            echo $this->db->last_query();
        return $query->result_array();
    }

}
