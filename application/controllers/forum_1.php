<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forum_1 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->model('forum_model');
        $this->load->language('common');
        CHECK_USER_STATUS();
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index($the_url = '') {
        $data['category_tree'] = $this->getForumCategoriesTreeStructure();

        $posted_key = $this->input->post('search');

        if ($posted_key != "") {
            $data['header'] = array("title" => "Search results for " . $posted_key, "keywords" => "", "description" => "");
            $data['forum_topics'] = $this->searchTopics($posted_key);
            $this->load->view('front/forum/forum', $data);
        } else {
            if ($the_url == '') {
                $data['header'] = array("title" => "Welcome to forum module", "keywords" => "", "description" => "");
                $data['forum_topics'] = $this->getTopics('', array('status' => "1"));
                $this->load->view('front/forum/forum', $data);
            } else {
                // check uri in database
//                $this->load->model("common_model");
                $the_page_info = $this->common_model->getPageInfoByUrl($the_url);
                $the_page_info = end($the_page_info);

                if (count($the_page_info) > 0) {
                    if ($the_page_info['type'] == 'forum-category') {
                        $category_id = $the_page_info['rel_id'];

                        /* get category info */
//                        $this->load->model('forum_model');
                        $category_info = $this->forum_model->getCategories('*', array('category_id' => $category_id));

                        $data['header'] = array("title" => $category_info[0]['page_title'],
                            "keywords" => $category_info[0]['page_keywords'],
                            "description" => $category_info[0]['page_description']);

                        $data['forum_topics'] = $this->getTopics('', array("b.`category_id`" => $category_id, 'status' => "1"));

                        $this->load->view('front/forum/forum', $data);
                    } elseif ($the_page_info['type'] == 'forum-topic') {
                        $topic_id = $the_page_info['rel_id'];

                        $data['forum_topics'] = $this->getTopics('', array("b.`topic_id`" => $topic_id));

                        $data['header'] = array("title" => $data['forum_topics'][0]['page_title'],
                            "keywords" => $data['forum_topics'][0]['topic_keywords'],
                            "description" => $data['forum_topics'][0]['topic_tags']);
                        $data['topic_id'] = $topic_id;

                        $data['topic_comments'] = $this->getTopicComments($topic_id);

                        $this->load->view('front/forum/forum-topic', $data);
                    }
                } else {
                    echo "<h2>404 - Page not found</h2>";
                }
            }
        }
    }

    public function add_forum_topic() {

        $posted_topic_title = $this->input->post('topic_title');
        if ($posted_topic_title != "") {
            $user_account = $this->session->userdata('user_account');

            $arr_to_insert = array(
                "topic_title" => mysql_real_escape_string($this->input->post('topic_title')),
                'topic_short_description' => mysql_real_escape_string($this->input->post('topic_short_description')),
                'topic_content' => mysql_real_escape_string($this->input->post('topic_description')),
                'page_title' => mysql_real_escape_string($this->input->post('topic_page_title')),
                'topic_tags' => mysql_real_escape_string($this->input->post('topic_meta_description')),
                'topic_keywords' => mysql_real_escape_string($this->input->post('topic_meta_keywords')),
                'category_id' => intval($this->input->post('topic_category')),
                'posted_by' => $user_account['user_id'],
                'posted_on' => date("Y-m-d H:i:s"),
                'status' => "0"
            );

//            $this->load->model("forum_model");
//            $this->load->model("common_model");
            $topic_id = $this->forum_model->insertTopic($arr_to_insert);

            $insert_url_data = array("type" => "forum-topic",
                "url" => str_replace(" ", "-", strtolower(mysql_real_escape_string($this->input->post('topic_title')))),
                "rel_id" => $topic_id
            );

            $this->common_model->insertRow($insert_url_data, "mst_uri_map");
            echo json_encode(array("error" => "0", "errorMessage" => "", "msg" => "SUCCESS"));
            exit;
        } else {
            $data['header'] = array("title" => "Add new forum topic",
                "keywords" => "add new forum topic",
                "description" => "add new forum topic");

            $data['category_tree'] = $this->getForumCategoriesTreeStructure();
            $data['str_categories_menu_select'] = $this->getForumCategoriesTreeStructure('select');
            $this->load->view('front/forum/forum-add-topic', $data);
        }
    }

    public function edit_forum_topic() {

        $posted_topic_title = $this->input->post('topic_title');
        if ($posted_topic_title != "") {
            $user_account = $this->session->userdata('user_account');

            $arr_to_insert = array(
                "topic_title" => mysql_real_escape_string($this->input->post('topic_title')),
                'topic_short_description' => mysql_real_escape_string($this->input->post('topic_short_description')),
                'topic_content' => mysql_real_escape_string($this->input->post('topic_description')),
                'page_title' => mysql_real_escape_string($this->input->post('topic_page_title')),
                'topic_tags' => mysql_real_escape_string($this->input->post('topic_meta_description')),
                'topic_keywords' => mysql_real_escape_string($this->input->post('topic_meta_keywords')),
                'category_id' => intval($this->input->post('topic_category')),
                'posted_by' => $user_account['user_id'],
                'posted_on' => date("Y-m-d H:i:s"),
                'status' => "0"
            );

//            $this->load->model("forum_model");
//            $this->load->model("common_model");
            //$topic_id= $this->forum_model->insertTopic($arr_to_insert);mst_forum_topics

            $this->common_model->updateRow("mst_forum_topics", $arr_to_insert, array("topic_id" => $this->input->post('topic_id')));
            $insert_url_data = array("type" => "forum-topic",
                "url" => str_replace(" ", "-", strtolower(mysql_real_escape_string($this->input->post('topic_title')))),
                "rel_id" => $this->input->post('topic_id')
            );

            //$this->common_model->insertRow($insert_url_data, "mst_uri_map");
            $this->common_model->updateRow("mst_uri_map", $insert_url_data, array("url" => $this->input->post('page_url')));
            echo json_encode(array("error" => "0", "errorMessage" => "", "msg" => "SUCCESS"));
            exit;
        } else {
            $data['header'] = array("title" => "Add new forum topic",
                "keywords" => "add new forum topic",
                "description" => "add new forum topic");

            $data['category_tree'] = $this->getForumCategoriesTreeStructure();
            $data['str_categories_menu_select'] = $this->getForumCategoriesTreeStructure('select');
            $this->load->view('front/forum/forum-add-topic', $data);
        }
    }

    /*
     * Function will return all forum categories with category tree in desired format
     */

    public function getForumCategoriesTreeStructure($type = 'ul') {
//        $this->load->model('forum_model');
        return $this->forum_model->getCategoryTreeResponse($type);
    }

    /*
     *  End Blog Categories Tree Structure function
     */

    /*
     *  Function to get all forum topics
     */

    private function getTopics($fields = '', $condition = '') {
//        $this->load->model('forum_model');
        return $this->forum_model->getTopics($fields, $condition);
    }

    /*
     *  Function to search forum topics
     */

    private function searchTopics($searchKey) {
//        $this->load->model('forum_model');
        return $this->forum_model->searchTopics($searchKey);
    }

    private function getTopicComments($topic_id) {
        $limit = "10";
        $condition_to_pass = array("`topic_id`" => $topic_id, "status" => "1");
        $order = ('comment_on asc');
//        $this->load->model("forum_model");
        $arr_comments = $this->forum_model->getTopicComments("", $condition_to_pass, $order, $limit);
        return $arr_comments;
    }

    /*
     *  Function to add comment
     */

    public function add_comment() {
        $topic_id = $this->input->post('p');
        $topic_comment = $this->input->post('msg_comment');

        $arr_forum_comment = array();
        $arr_forum_comment["topic_id"] = $topic_id;
        $arr_forum_comment["comment"] = mysql_real_escape_string($topic_comment);
        $arr_forum_comment["comment_on"] = date("Y-m-d H:i:s");
        $arr_forum_comment["commented_by"] = "Anonymous User";
        $arr_forum_comment["status"] = "1";
//        $this->load->model('forum_model');
        $this->forum_model->add_comment($arr_forum_comment);
        echo json_encode(array("error" => "0"));
    }

    /* Start forum category management for backend */

    public function getForumCategoryList() {
//        $this->load->model('common_model');

        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        /* Getting Common data */
        $data = $this->common_model->commonFunction();

//        $this->load->model('forum_model');
        $data['title'] = "Manage forum categories";
        $data['arr_froum_categories_list'] = $this->forum_model->getCategories();

        $this->load->view('backend/forum/category-list', $data);
    }

    /* Add-Edit Forum categories */

    public function editForumCategory($category_id = '') {

//        $this->load->model('common_model');

        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
//        $this->load->model('forum_model');
        if ($this->input->post()) {
            $page_url = $this->input->post("page_url");
            $arr_page_url_info = $this->forum_model->getUniqueUri($this->input->post("page_url_old"));
            $insert_url_data = array("type" => "forum-category",
                "url" => $page_url,
                "rel_id" => $this->input->post("category_id")
            );

            if (count($arr_page_url_info) > 0) {
                if ($arr_page_url_info[0]['url'] != $page_url) {
                    $this->common_model->updateRow("mst_uri_map", $insert_url_data, array("url_id" => $arr_page_url_info[0]['url_id']));
                    $insert_url_data['url_id'] = $arr_page_url_info[0]['url_id'];
                } else {
                    echo "false";
                }
            } else {
                $insert_url_data['url_id'] = $this->common_model->insertRow($insert_url_data, "mst_uri_map");
            }

            $arr_category_info = array(
                "category_name" => mysql_real_escape_string($this->input->post("category_name")),
                "parent_id" => mysql_real_escape_string($this->input->post("parent_id")),
                "page_title" => mysql_real_escape_string($this->input->post("page_title")),
                "page_keywords" => mysql_real_escape_string($this->input->post("page_keywords")),
                "page_description" => mysql_real_escape_string($this->input->post("page_description")),
            );

            if ($this->input->post("category_id") != "") {
                $this->common_model->updateRow("mst_forum_categories", $arr_category_info, array("category_id" => $this->input->post("category_id")));
                $msg = '<span class="alert alert-success">Forum catgory updated successfully!</span>';
            } else {
                $arr_category_info["created_on"] = date("Y-m-d H:i:s");
                $insert_url_data['rel_id'] = $this->common_model->insertRow($arr_category_info, "mst_forum_categories");
                $this->common_model->updateRow("mst_uri_map", $insert_url_data, array("url_id" => $insert_url_data['url_id']));

                $msg = '<span class="alert alert-success">Forum catgory added successfully!</span>';
            }
            $this->session->set_userdata('msg', $msg);
            redirect(base_url() . "backend/forum-categories");
        }

        $data['title'] = "Manage forum categories";
        if ($category_id != "" && $category_id != 0) {
            $data['arr_froum_categories_list'] = $this->forum_model->getCategories();
            $data['arr_froum_categories_info'] = $this->forum_model->getCategories("", array("category_id" => $category_id), "", "", 0);
            $data['arr_froum_categories_info'] = $data['arr_froum_categories_info'][0];
            $this->load->view('backend/forum/edit-category', $data);
        } else {
            $this->load->view('backend/forum/add-category', $data);
        }
    }

    /* Multilingual Forum Category  */

    public function multilingualForumCategory($category_id) {

//        $this->load->model('common_model');

        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();


//        $this->load->model('forum_model');


        if (isset($lang_id) && $lang_id != '') {
            $lang_id = $this->session->userdata('lang_id');
        } else {
            $lang_id = 17; /* Default is 17(English) */
        }


        $data['arr_froum_categories_info'] = $this->forum_model->getCategories("", array("category_id" => $category_id), "", "", 0);
        $data['arr_froum_categories_info'] = $data['arr_froum_categories_info'][0];
        $this->load->view('backend/forum/multingual-category', $data);
    }

    /* Fuction for checking unique url */

    public function checkUniqueUrl() {

//        $this->load->model('forum_model');
        $page_url = $this->input->get("page_url");
        if ($this->input->get("page_url_old") == $page_url) {
            echo "true";
            exit;
        }


        $arr_page_url_info = $this->forum_model->getUniqueUri($page_url);
        if (count($arr_page_url_info) > 0) {
            if ($this->input->get("page_url_old") == $page_url) {
                echo "true";
            } else {
                echo "flase";
            }
        } else {
            echo "true";
        }
    }

    public function getAllForumTopicsList($the_url = "") {

//        $this->load->model('common_model');

        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        /*
          $this->load->model('forum_model');


          if (isset($lang_id) && $lang_id != '') {
          $lang_id = $this->session->userdata('lang_id');
          } else {
          $lang_id = 17; /* Default is 17(English) */
        /*     }


          $data['arr_froum_categories_info'] = $this->forum_model->getCategories("",array("category_id"=>$category_id),"","",0);
          $data['arr_froum_categories_info']=	$data['arr_froum_categories_info'][0];
          $this->load->view('backend/forum/multingual-category', $data);

         */

        $data['category_tree'] = $this->getForumCategoriesTreeStructure();

        $posted_key = $this->input->post('search');

        if ($posted_key != "") {
            $data['header'] = array("title" => "Search results for " . $posted_key, "keywords" => "", "description" => "");
            $data['forum_topics'] = $this->searchTopics($posted_key);
            $this->load->view('front/forum/forum', $data);
        } else {
            if ($the_url == '') {
                $data['header'] = array("title" => "Welcome to forum module", "keywords" => "", "description" => "");
                //$data['forum_topics'] = $this->getTopics('', array('status' => "1"));
                $data['forum_topics'] = $this->getTopics('', "");

                /*   echo "<pre>";

                  print_r( $data['forum_topics']);
                  echo "</pre>"; */

                $this->load->view('backend/forum/forum-list', $data);
            } else {
                // check uri in database
//                $this->load->model("common_model");
                $the_page_info = $this->common_model->getPageInfoByUrl($the_url);
                $the_page_info = end($the_page_info);

                if (count($the_page_info) > 0) {
                    if ($the_page_info['type'] == 'forum-category') {
                        $category_id = $the_page_info['rel_id'];

                        /* get category info */
//                        $this->load->model('forum_model');
                        $category_info = $this->forum_model->getCategories('*', array('category_id' => $category_id));
                        $data['header'] = array("title" => $category_info[0]['page_title'],
                            "keywords" => $category_info[0]['page_keywords'],
                            "description" => $category_info[0]['page_description']);


                        $data['forum_topics'] = $this->getTopics('', array("b.`category_id`" => $category_id, 'status' => "1"));


                        $this->load->view('front/forum/forum', $data);
                    } elseif ($the_page_info['type'] == 'forum-topic') {
                        $topic_id = $the_page_info['rel_id'];

                        $data['forum_topics'] = $this->getTopics('', array("b.`topic_id`" => $topic_id));

                        $data['header'] = array("title" => $data['forum_topics'][0]['page_title'],
                            "keywords" => $data['forum_topics'][0]['topic_keywords'],
                            "description" => $data['forum_topics'][0]['topic_tags']);
                        $data['topic_id'] = $topic_id;

                        $data['topic_comments'] = $this->getTopicComments($topic_id);

                        //$this->load->view('front/forum/forum-topic', $data);
                        $this->load->view('backend/forum/forum-topic-list', $data);
                    }
                } else {
                    echo "<h2>404 - Page not found</h2>";
                }
            }
        }
    }

    public function editForumTopic($topic_id) {
//        $this->load->model('common_model');

        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        $data['forum_topics'] = $this->getTopics('', array("b.`topic_id`" => $topic_id));
        $data['header'] = array("title" => $data['forum_topics'][0]['page_title'],
            "keywords" => $data['forum_topics'][0]['topic_keywords'],
            "description" => $data['forum_topics'][0]['topic_tags']);
        $data['topic_id'] = $topic_id;
        $data['forum_topics'] = $data['forum_topics'][0];
        /* echo"<pre>";
          print_r($data['forum_topics']);
          echo"</pre>"; */
        $data['str_categories_menu_select'] = $this->getForumCategoriesTreeStructure('select');
        $this->load->view('backend/forum/edit-forum-topic', $data);
    }

    public function changeForumTopicStatus($status, $topic_id) {

//        $this->load->model('common_model');
        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        /* Getting Common data */
        $insert_url_data = array("status" => $status);

        $this->common_model->updateRow("mst_forum_topics", $insert_url_data, array("topic_id" => $topic_id));
        $msg = '<span class="alert alert-success">Topic status changed successfully!</span>';
        $this->session->set_userdata('msg', $msg);
        redirect(base_url() . "backend/forum-list");
    }

    /* front end forum section */

    public function discusionForum() {

        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['menu_active'] = 'forums';

        /* function get_forum_category_list() */
        $table_to_pass = 'mst_forum_categories';
        $fields_to_pass = '*';
        $condition = array('parent_id' => '0');
        $arr_category = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition, $order_by = '', $limit = '', $debug = 0);
        $data['arr_category'] = $arr_category;

        /**/

        $arr_forum_topic = $this->forum_model->getForumTopicList($debug = 0);
        $data['arr_forum_topic'] = $arr_forum_topic;
//        echo '<pre>';
//        print_r($data['arr_forum_topic']);
//        echo '</pre>';
//      print_r($data['arr_category']);
        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        } else {
            $this->load->view('front/includes/dashboard-header-1');
        }
        $this->load->view('front/forum/discussion-forum');
        $this->load->view('front/includes/footer');
    }

    /* get forum topics comments */

    public function get_forum_topic_comments() {

        if ($this->input->post('topic_id') != '') {

            $topic_id = $this->input->post('topic_id');
            $fields = '*';
            $condition = array('topic_id' => $topic_id);
            //getForumTopicCommentList
            $arr_forum_topic_comment_list = $this->forum_model->getTopicComments($fields, $condition, $order = '', $limit = '', $debug_to_pass = 0);
            print_r($arr_forum_topic_comment_list);
        }
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
