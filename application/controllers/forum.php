<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forum extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->model('forum_model');
        $this->load->language('common');
        $this->load->language('forum');
        $this->load->helper("file");
        CHECK_USER_STATUS();
		UpdateActiveTime();
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

        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['category_tree'] = $this->getForumCategoriesTreeStructure();
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/forum/javascriptDateFormat.js"></script>', '<script src="' . base_url() . 'media/front/js/forum/javascriptHighlightKeyword.js"></script>'));
        $data['menu_active'] = "forum";
        $posted_key = $this->input->post('search');
        $posted_key = ($posted_key != '') ? $posted_key : '';
        $data['posted_key'] = $posted_key;

        /* get all category list for category dropdow  */
        $category_info_arr = $this->forum_model->getCategories($fields = 'category_id,category_name,', $condition_to_pass = '', $order_by_to_pass = 'category_name asc', $limit_to_pass = '', $debug_to_pass = 0);
        $data['category_info_arr'] = $category_info_arr;

        if ($posted_key != "") {

            $data['header'] = array("title" => "Search results for " . $posted_key, "keywords" => "", "description" => "");
            /* set a flag to show highlighted search results display block */
            $data['search_comment_flag'] = TRUE;
            $data['posted_key'] = $posted_key;
            $forum_topics = $this->searchTopics($posted_key, $limit_to_pass = 6);
            /* get the total topic count */
            $forum_topics_count = $this->forum_model->searchTopicsCount($posted_key);

            /* for view more */
            $data['sort_variable'] = '';
//            $total_topic_count = $this->getTopicTotalCount('mst_forum_topics');
//            $total_topic_count = count($forum_topics);
            $data['total_topic_count'] = count($forum_topics_count);
            $data['first_topic_count'] = 6; /* this value is static same as passed in getTopics function */

            if (count($forum_topics)) {
                foreach ($forum_topics as &$the_topic) {
                    $arr_topic_comments = $this->getTopicComments($the_topic['topic_id']);
                    $the_topic["comments"] = $arr_topic_comments;
                }
            } else {
                $data['search_flag'] = TRUE;
            }

            $data['forum_topics'] = $forum_topics;

            /* get online user list */
            $arr_online_user = $this->getOnlineUserList();
            $data['arr_online_user'] = $arr_online_user;
            /* get absoulute path */
            $absolutePath = $this->common_model->absolutePath($path = '');
            $data['absolutePath'] = $absolutePath;

            $this->load->view('front/includes/header', $data);
            if ($this->session->userdata('user_account')) {
                $this->load->view('front/includes/dashboard-header');
            }
            $this->load->view('front/forum/discussion-forum', $data);
            $this->load->view('front/includes/footer');
        } else {

            if ($the_url == '') {

                $data['header'] = array("title" => "Welcome to forum section", "keywords" => "", "description" => "");
                $forum_topics = $this->getTopics('', array('status' => "1"),$order_by_to_pass = '', $limit_to_pass = 6);

                /* for view more */
                $data['sort_variable'] = '';
                /* get total record count for ajax - view more */
                $total_topic_count = $this->getTopicTotalCount('mst_forum_topics');
                $data['total_topic_count'] = $total_topic_count;
                $data['first_topic_count'] = 6; /* this value is static same as passed in getTopics function */

                foreach ($forum_topics as &$the_topic) {
                    $arr_topic_comments = $this->getTopicComments($the_topic['topic_id']);
                    $the_topic["comments"] = $arr_topic_comments;
                }
                $data['forum_topics'] = $forum_topics;

                /* get online user list */
                $arr_online_user = $this->getOnlineUserList();
                $data['arr_online_user'] = $arr_online_user;
                /* get absoulute path */
                $absolutePath = $this->common_model->absolutePath($path = '');
                $data['absolutePath'] = $absolutePath;

                $this->load->view('front/includes/header', $data);
                if ($this->session->userdata('user_account')) {
                    $this->load->view('front/includes/dashboard-header');
                }
                $this->load->view('front/forum/discussion-forum', $data);
                $this->load->view('front/includes/footer');
            } else {

                $the_page_info = $this->common_model->getPageInfoByUrl($the_url);
                $the_page_info = end($the_page_info);
                $data['sort_variable'] = $the_url;
                
                if (count($the_page_info) > 0) {
                    if ($the_page_info['type'] == 'forum-category') {

                        $category_id = $the_page_info['rel_id'];
                        /* get category info */
                        $category_info = $this->forum_model->getCategories('*', array('category_id' => $category_id));
                        $data['header'] = array("title" => $category_info[0]['page_title'], "keywords" => $category_info[0]['page_keywords'], "description" => $category_info[0]['page_description']);
                        $forum_topics = $this->getTopics('', array("b.`category_id`" => $category_id, 'status' => "1"), $order_by_to_pass = '', $limit_to_pass = 6);
                        /* get total record count for ajax - view more */

                        $total_topic_count = $this->forum_model->getTopicsCountForCategory('', array("b.`category_id`" => $category_id, 'status' => "1"));

                        $data['total_topic_count'] = count($total_topic_count);
                        $data['first_topic_count'] = 6; /* this value is static same as passed in getTopics function */

                        if (count($forum_topics)) {
                            foreach ($forum_topics as &$the_topic) {
                                $arr_topic_comments = $this->getTopicComments($the_topic['topic_id']);
                                $the_topic["comments"] = $arr_topic_comments;
                            }
                        }
                        $data['forum_topics'] = $forum_topics;
                        //$data['forum_topics'] = $this->getTopics('', array("b.`category_id`" => $category_id, 'status' => "1"));

                        /* get online user list */
                        $arr_online_user = $this->getOnlineUserList();
                        $data['arr_online_user'] = $arr_online_user;
                        /* get absoulute path */
                        $absolutePath = $this->common_model->absolutePath($path = '');
                        $data['absolutePath'] = $absolutePath;

                        $this->load->view('front/includes/header', $data);
                        if ($this->session->userdata('user_account')) {
                            $this->load->view('front/includes/dashboard-header');
                        }
                        $this->load->view('front/forum/discussion-forum', $data);
                        $this->load->view('front/includes/footer');
                    } elseif ($the_page_info['type'] == 'forum-topic') {
                        echo 'forum-topic';
                        $topic_id = $the_page_info['rel_id'];

                        $forum_topics = $this->getTopics('', array("b.`topic_id`" => $topic_id));
                        for ($i = 0; $i < count($forum_topics); $i++) {
                            $topic_comments[$i] = $this->getTopicComments($forum_topics[$i]['topic_id']);
                        }

                        $data['topic_comments'] = $topic_comments;
                        $data['forum_topics'] = $forum_topics;
                        //$data['forum_topics'] = $this->getTopics('', array("b.`topic_id`" => $topic_id));

                        $data['header'] = array("title" => $data['forum_topics'][0]['page_title'],
                            "keywords" => $data['forum_topics'][0]['topic_keywords'],
                            "description" => $data['forum_topics'][0]['topic_tags']);
                        $data['topic_id'] = $topic_id;

                        $data['topic_comments'] = $this->getTopicComments($topic_id);
                        $this->load->view('front/includes/header', $data);
                        if ($this->session->userdata('user_account')) {
                            $this->load->view('front/includes/dashboard-header');
                        }
                        $this->load->view('front/forum/discussion-forum', $data);
                        $this->load->view('front/includes/footer');
                    }
                } else {
                    echo "<h2>404 - Page not found</h2>";
                }
            }
        }
    }

    /* function to get forum topic posted by current user */

    public function getUserFeeds() {

        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "signin");
        }

        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['category_tree'] = $this->getForumCategoriesTreeStructure();
        $data['menu_active'] = "forum";

        /* get all category list for category dropdow  */
        $category_info_arr = $this->forum_model->getCategories($fields = 'category_id,category_name,', $condition_to_pass = '', $order_by_to_pass = 'category_name asc', $limit_to_pass = '', $debug_to_pass = 0);
        $data['category_info_arr'] = $category_info_arr;

        $data['header'] = array("title" => "My feeds", "keywords" => "", "description" => "");
        $forum_topics = $this->getTopics('', array('status' => "1", 'b.posted_by' => $data['user_session']['user_id']));

        if (count($forum_topics)) {
            foreach ($forum_topics as &$the_topic) {
                $arr_topic_comments = $this->getTopicComments($the_topic['topic_id']);
                $the_topic["comments"] = $arr_topic_comments;
            }
        }
        $data['forum_topics'] = $forum_topics;

        /* get online user list */
        $arr_online_user = $this->getOnlineUserList();

        $data['arr_online_user'] = $arr_online_user;

        /* get absoulute path */
        $absolutePath = $this->common_model->absolutePath($path = '');
        $data['absolutePath'] = $absolutePath;

        $this->load->view('front/includes/header', $data);

        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }

        $this->load->view('front/forum/discussion-forum', $data);
        $this->load->view('front/includes/footer');
    }

    /* main function */

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
                'status' => "1"
            );

            $topic_id = $this->forum_model->insertTopic($arr_to_insert);

            $insert_url_data = array("type" => "forum-topic",
//                "url" => str_replace(" ", "-", strtolower(mysql_real_escape_string($this->input->post('page_url')))),
                "url" => strtolower(mysql_real_escape_string($this->clean($this->input->post("page_url")))),
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
                'status' => "1"
            );

            $this->common_model->updateRow("mst_forum_topics", $arr_to_insert, array("topic_id" => $this->input->post('topic_id')));

            $insert_url_data = array("type" => "forum-topic",
                "url" => str_replace(" ", "-", strtolower(mysql_real_escape_string($this->input->post('page_url_old')))),
                "rel_id" => $this->input->post('topic_id')
            );

//$this->common_model->insertRow($insert_url_data, "mst_uri_map");
            $this->common_model->updateRow("mst_uri_map", $insert_url_data, array("url" => $this->input->post('page_url_old'), "rel_id" => $this->input->post('topic_id'), "type" => 'forum-topic'));
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

    private function getTopics($fields = '', $condition = '', $order_by_to_pass = '', $limit_to_pass = '') {
        return $this->forum_model->getTopics($fields, $condition, $order_by_to_pass = 'topic_id DESC', $limit_to_pass);
    }

    /* function to get more forum topic ajax call */

    private function getTopicsAjax($fields = '', $condition = '', $limit_to_pass) {
        return $this->forum_model->getTopicsAjax($fields, $condition, $order_by_to_pass = 'topic_id DESC', $limit_to_pass, $debug_to_pass = 0);
    }

    private function getTopicTotalCount($tbl_name = '') {
        return $this->common_model->getTotalRecordCount($tbl_name, $debug = 0);
    }

    /*  Function to search forum topics */

    private function searchTopics($searchKey, $limit) {
        return $this->forum_model->searchTopics($searchKey, $limit);
    }

    private function searchTopicsAjax($searchKey, $limit) {
        return $this->forum_model->searchTopicsAjax($searchKey, $limit);
    }

    private function getTopicComments($topic_id) {
        $limit = "10";
        $condition_to_pass = array("`topic_id`" => $topic_id, "status" => "1");
        $order = ('comment_on asc');
        $arr_comments = $this->forum_model->getTopicComments("", $condition_to_pass, $order, $limit);
//        $arr_comments['user_name'] = $this->forum_model->getTopicCreatedUserName($arr_comments[0]['posted_by'], $debug = 0);
        return $arr_comments;
    }

    public function add_comment() {


        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['menu_active'] = 'forums';


        $topic_id = $this->input->post('p');
        $topic_comment = $this->input->post('msg_comment');

        $arr_forum_comment = array();
        $arr_forum_comment["topic_id"] = $topic_id;
        $arr_forum_comment["comment"] = mysql_real_escape_string($topic_comment);
        $arr_forum_comment["comment_on"] = date("Y-m-d H:i:s");
        $arr_forum_comment["commented_by"] = $data['user_session']['user_id'];
        $arr_forum_comment["status"] = "1";
        $this->forum_model->add_comment($arr_forum_comment);
        echo json_encode(array("error" => "0"));
    }

    /*  Function to add comment */

    public function add_comments() {

        /* Get session value */
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $user_account = $this->session->userdata('user_account');

        $topic_id = $this->input->post('topic_id');
        $topic_comment = $this->input->post('msg_comment');

        $arr_forum_comment = array();
        $arr_forum_comment["topic_id"] = $topic_id;
        $arr_forum_comment["comment"] = mysql_real_escape_string($topic_comment);
        $arr_forum_comment["comment_on"] = date("Y-m-d H:i:s");
        $arr_forum_comment["commented_by"] = $user_account['user_id'];
        $arr_forum_comment["status"] = "1";
        $last_comment_id = $this->forum_model->add_comment($arr_forum_comment);
        if ($last_comment_id) {

            $cmt_count = $this->forum_model->getTopicCommentsCount($topic_id, $debug = 0);
            $commented_by_uname = $this->forum_model->getTopicCreatedUserName($user_account['user_id'], $debug = 0);
            $commented_by_uname = $commented_by_uname[0]['user_name'];

            echo $cmt_count = $cmt_count[0]['comment_count'];
            echo '||';
            $table = 'trans_forum_comments';
            $fields = '*';
            $condition = array('comment_id' => $last_comment_id);
            $last_msg_arr = $this->common_model->getRecords($table, $fields, $condition, $order_by = '', $limit = '', $debug = 0);
            $last_msg_arr = $last_msg_arr[0];

            /* get user profile image */
            $table_to_pass = 'mst_users';
            $fields_to_pass = 'user_id,profile_picture';
            $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
            $profile_image = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass);
            $profile_image[0]['profile_picture'] = (isset($profile_image[0]['profile_picture'])) ? $profile_image[0]['profile_picture'] : 'photo-45519.gif';

            echo $comment_arr = '<div class="user_post_comment" id="user_post_comment_' . $last_comment_id . '" >
                                <div class="user_image"><img src="' . base_url() . 'media/front/images/profile-images/thumb/' . $profile_image[0]['profile_picture'] . '"  width="50px" height="50px"></div>
                                    <div class="user_info">
                                        <div class="post_u_name">' . $commented_by_uname . '</div>
                                        <div class="post_time">' . date("d<\s\up>S</\s\up> M Y h:i A", strtotime($last_msg_arr["comment_on"])) . '</div>                                                
                                    </div>
                                    <div class="user_comment_data">
                                        <p>' . nl2br(stripslashes($last_msg_arr["comment"])) . '</p>
                                    </div>
                            </div>';
        }
    }

    /* add forum topic from frontend */

    public function add_forum_topic_frontend() {


        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');

        if ($this->input->post('category_id') != '') {
            /* insert forum topic details */
            $user_account = $this->session->userdata('user_account');

            $arr_to_insert = array(
                "topic_title" => mysql_real_escape_string($this->input->post('topic_title')),
                'topic_short_description' => mysql_real_escape_string($this->input->post('topic_short_description')),
                'topic_content' => mysql_real_escape_string($this->input->post('topic_short_description')),
                'page_title' => mysql_real_escape_string($this->input->post('topic_title')),
                'topic_tags' => mysql_real_escape_string($this->input->post('topic_title')),
                'topic_keywords' => mysql_real_escape_string($this->input->post('topic_title')),
                'category_id' => intval($this->input->post('category_id')),
                'posted_by' => $user_account['user_id'],
                'posted_on' => date("Y-m-d H:i:s"),
                'status' => '1',
            );
            $topic_id = $this->forum_model->insertTopic($arr_to_insert);

            /* get user profile image */
            $table_to_pass = 'mst_users';
            $fields_to_pass = 'user_id,profile_picture';
            $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
            $profile_image = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass);
            $profile_image[0]['profile_picture'] = (isset($profile_image[0]['profile_picture'])) ? $profile_image[0]['profile_picture'] : 'photo-45519.gif';

            /* add new forum topic uri details */
            if ($topic_id != '') {
                $insert_url_data = array("type" => "forum-topic", "url" => str_replace(" ", "-", strtolower(mysql_real_escape_string($this->input->post('topic_title')))), "rel_id" => $topic_id);
                $this->common_model->insertRow($insert_url_data, "mst_uri_map");

                echo $return_div = '<div class="forum_post">
                                        <div class="user_image">
                                            <img src="' . base_url() . 'media/front/images/profile-images/thumb/' . $profile_image[0]['profile_picture'] . '" width="50px" height="50px">
                                        </div>
                                        <div class="user_info">
                                            <div class="post_u_name">' . $user_account['user_name'] . '</div>
                                            <div class="post_time">' . date("d<\s\up>S</\s\up> M Y h:i A", strtotime(date("Y-m-d H:i:s"))) . '</div>
                                            <span> in</span>
                                            <div class="post_discussion">' . $this->input->post('category_name') . '</div>
                                            <div class="post_social_links">
                                                <ul>
                                                    <li><span class="comment">&nbsp;</span><span class="count" id="comments_' . $topic_id . '"></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="forum_title" onclick="showTopicDescription(' . $topic_id . ')" id = "topic_title">
                <h3>' . $this->input->post('topic_title') . '</h3>
                </div>
                <div class="user_comments" style="display: none;" id="user_comment_id_' . $topic_id . '">
                    <div class="user_comment_data">
                    </div>
                    <div class="total_comment" style="display: block;" id="total_comment_' . $topic_id . '"><div id="total_comment_count_' . $topic_id . '">Total 0 Comments</div></div>
                         <form name="post_comment" id="post_comment" method="" action="">
                            <div class="forums_posted" id="comment_' . $topic_id . '" style="display: block;">
                                <input type="text" id="msg_comment_' . $topic_id . '" required  name="msg_comment" value="" placeholder="Reply...">
                                <input type="hidden" name="topic_id" id="topic_id" value="' . $topic_id . '">                                                   
                                <input type="button" name="hit_comment"  id="hit_comment" value="hit comment" class="btn_post" onclick="addComment(' . $topic_id . ') ">
                            </div>
                        </form>
                </div>                                        
                </div>';
            }
        }
    }

    /* Start forum category management for backend */

    public function getForumCategoryList() {

        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['title'] = "Manage forum categories";
        $data['arr_froum_categories_list'] = $this->forum_model->getCategories();
        $this->load->view('backend/forum/category-list', $data);
    }

    /* Add-Edit Forum categories */

    public function editForumCategory1($category_id = '') {

        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        if ($this->input->post()) {

            $page_url = $this->input->post("page_url");
            $arr_page_url_info = $this->forum_model->getUniqueUri($this->input->post("page_url_old"));

            $insert_url_data = array("type" => "forum-category",
                "url" => strtolower(str_replace('', '-', $page_url)),
                "rel_id" => $this->input->post("category_id")
            );

            if (count($arr_page_url_info) > 0) {
                if ($arr_page_url_info[0]['url'] != $page_url) {
                    $this->common_model->updateRow("mst_uri_map", $insert_url_data, array("url_id" => $arr_page_url_info[0]['url_id']));
                    $insert_url_data['url_id'] = $arr_page_url_info[0]['url_id'];
                } else {
                    $laset_insert_category_id = $this->common_model->insertRow($insert_url_data, "mst_forum_categories");
                    $insert_url_data['url_id'] = $this->common_model->insertRow($insert_url_data, "mst_uri_map");
                }
            } else {
                
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
                $this->common_model->updateRow("mst_uri_map", $insert_url_data, array("url_id" => $insert_url_data['url_id'], "rel_id" => $insert_url_data['rel_id']));
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

    public function addForumCategory() {

        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        if ($this->input->post('btnSubmit') != '') {
            /* insert category details */
            $insert_category_data = array('category_name' => $this->input->post('category_name')
                , 'page_title' => mysql_real_escape_string($this->input->post('page_title'))
                , 'page_keywords' => mysql_real_escape_string($this->input->post('page_keywords'))
                , 'page_description' => mysql_real_escape_string($this->input->post('page_description')));

            $last_insert_category_id = $this->common_model->insertRow($insert_category_data, "mst_forum_categories");

            if ($last_insert_category_id != '') {

//                echo mysql_real_escape_string($this->clean($this->input->post("page_url")));
//                exit;
                $insert_url_data = array("type" => "forum-category", "url" => mysql_real_escape_string($this->clean($this->input->post("page_url"))), "rel_id" => mysql_real_escape_string($last_insert_category_id));
                $last_insert_url_id = $this->common_model->insertRow($insert_url_data, "mst_uri_map");
                $msg = '<span class="alert alert-success">Forum catgory added successfully!</span>';
                $this->session->set_userdata('msg', $msg);
                redirect(base_url() . "backend/forum-categories");
            }
        }
        $this->load->view('backend/forum/add-category', $data);
    }

    /* edit forum category */

    public function editForumCategory($category_id = '') {

        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        /* update forum category details */
        if ($this->input->post('category_id')) {

            /* update data array */
            $update_category_data = array('category_name' => $this->input->post('category_name')
                , 'page_title' => mysql_real_escape_string($this->input->post('page_title'))
                , 'page_keywords' => mysql_real_escape_string($this->input->post('page_keywords'))
                , 'page_description' => mysql_real_escape_string($this->input->post('page_description')));
            $updated_id = $this->common_model->updateRow("mst_forum_categories", $update_category_data, array("category_id" => $this->input->post('category_id')));
            if ($updated_id) {
                $msg = '<span class="alert alert-success">Forum catgory has been updated successfully!</span>';
                $this->session->set_userdata('msg', $msg);
                redirect(base_url() . "backend/forum-categories");
            }
        }

        if ($category_id != '') {

            $data['arr_froum_categories_list'] = $this->forum_model->getCategories();
            $data['arr_froum_categories_info'] = $this->forum_model->getCategories("", array("category_id" => $category_id), "", "", 0);
            $data['arr_froum_categories_info'] = $data['arr_froum_categories_info'][0];
            $this->load->view('backend/forum/edit-category', $data);
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

        $page_url = $this->input->get("page_url");
        if ($this->input->get("page_url_old") == $page_url) {
            echo "true";
            exit;
        }
        $arr_page_url_info = $this->forum_model->getUniqueUri($page_url);
//        print_r($arr_page_url_info);
        if (count($arr_page_url_info) > 0) {
            if ($this->input->get("page_url_old") == $page_url) {
                echo "true";
            } else {
                echo "false";
            }
        } else {
            echo "true";
        }
    }

    public function getAllForumTopicsList($the_url = "") {

        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        /*
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
                $this->load->view('backend/forum/forum-list', $data);
            } else {
                // check uri in database
                //$this->load->model("common_model");
                $the_page_info = $this->common_model->getPageInfoByUrl($the_url);
                $the_page_info = end($the_page_info);

                if (count($the_page_info) > 0) {
                    if ($the_page_info['type'] == 'forum-category') {
                        $category_id = $the_page_info['rel_id'];

                        /* get category info */
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

    public function editForumTopic($topic_id = '') {
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
            "description" => $data['forum_topics'][0]['topic_tags']
        );
        $data['topic_id'] = $topic_id;
        $data['forum_topics'] = $data['forum_topics'][0];
        $data['str_categories_menu_select'] = $this->getForumCategoriesTreeStructure('select');
        $this->load->view('backend/forum/edit-forum-topic', $data);
    }

    public function addForumTopic() {
        /* #checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        /* $data['forum_topics'] = $this->getTopics('', array("b.`topic_id`" => $topic_id));
          $data['header'] = array("title" => $data['forum_topics'][0]['page_title'],
          "keywords" => $data['forum_topics'][0]['topic_keywords'],
          "description" => $data['forum_topics'][0]['topic_tags']);
          $data['topic_id'] = $topic_id;
          $data['forum_topics'] = $data['forum_topics'][0]; */
        $data['str_categories_menu_select'] = $this->getForumCategoriesTreeStructure('select');
        $this->load->view('backend/forum/add-forum-topic', $data);
    }

    public function changeForumTopicStatus($status, $topic_id) {

        /* checking admin is logged in or not */
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
        $table_to_pass = 'user_basic_information';
        $fields_to_pass = '*';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $this->common_model->getRecords();

        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/cms/discussion-forum');
        $this->load->view('front/includes/footer');
    }

    /* function to change avatar(profile image) */

    public function change_avatar_image() {


        /* checking user is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "signin");
        }

        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['menu_active'] = 'forums';
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>', '<script src="' . base_url() . 'media/front/js/forum/change-avatar-image.js"></script>'));

        /* get user profile image */
        $table_to_pass = 'mst_users';
        $fields_to_pass = 'user_id,profile_picture';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $profile_image = $this->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass);
        $data['profile_image'] = $profile_image[0];

        /* start : for image upload */
        if ($this->input->post('btn_upload') != '') {

            if ($_FILES['new_avatar_img']['name'] != '') {

                /* configuration */
                $config['upload_path'] = './media/front/images/profile-images';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = '9000000';
                $config['max_width'] = '12024';
                $config['max_height'] = '7268';
                $file_name = 'user_' . rand();
                $config['file_name'] = $file_name;

                /* upload libraray */
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('new_avatar_img')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $image_data = $this->upload->data();
                    $img_ext = $image_data['file_ext'];
                    $file_name = $file_name . $img_ext;
                    /* thumb */
                    $config = array();
                    /* get absolute Path */
                    $absolutePath = $this->common_model->absolutePath($path = '');

                    /* delete old profile image */
                    $path[0] = $absolutePath . 'media/front/images/profile-images/' . $this->input->post('old_avatar_img');
                    $path[1] = $absolutePath . 'media/front/images/profile-images/thumb/' . $this->input->post('old_avatar_img');

                    foreach ($path as $file_dir) {
                        if (is_file($file_dir)) {
                            $deleted_file = unlink($file_dir);
                        }
                    }

                    $configArray[] = array('source_image' => $image_data['full_path'], 'new_image' => './media/front/images/profile-images/thumb', 'maintain_ration' => true, 'width' => 125, 'height' => 142);
                    foreach ($configArray as $key => $config) {
                        $this->load->library('image_lib', $config);
                        $this->image_lib->initialize($config); //initialize
                        $this->image_lib->resize();
                    }
                    $imageName = $this->upload->file_name;
                    /* update image to table */
                    if ($data['user_session']['user_id'] != '') {
                        $table_name = 'mst_users';
                        $update_data = array('profile_picture' => mysql_real_escape_string($file_name));
                        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
                        $this->common_model->updateRow($table_name, $update_data, $condition_to_pass);
                        $this->session->set_userdata('msg', "<strong>Congratulations!</strong> your avatar image has been changed successfully.");
                        redirect(base_url() . 'forum/change');
                    }
                }
            }
            /* end : for image upload */
        }/* end post */
        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/forum/change-avatar-image');
        $this->load->view('front/includes/footer');
    }

    /* function to get current online users  : 27 March */

    public function getOnlineUserList() {
        return $arr_online_users = $this->forum_model->getOnlineUsers($debug_to_pass = 0);
    }

    /* remove special charactes */

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-?@&.+/', '-', $string); // Replaces multiple hyphens with single one.
    }

    /* ajax load more topics */

    public function load_more_topics() {

        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
      
        $first_count = intval($_POST['first_count']);
        $total_count = intval($_POST['total_count']);
        $posted_key = $this->input->post('posted_key');

//        $where_cond = array('status' => "1");
        $where_cond['status'] = "1";

        if ($_POST['sort_variable'] != '') {
            $the_page_info = $this->common_model->getPageInfoByUrl($_POST['sort_variable']);
            $the_page_info = end($the_page_info);
            $category_id = $the_page_info['rel_id'];
            $where_cond['category_id'] = $category_id;
        }

        $data['header'] = array("title" => "Welcome to forum section", "keywords" => "", "description" => "");

        if ((isset($posted_key)) && ($posted_key != '')) {
            $forum_topics = $forum_topics = $this->searchTopicsAjax($posted_key, $limit_to_pass = $first_count);
            /* for display block functionality */
            $data['search_comment_flag'] = 'yes';
        } else {
            $forum_topics = $this->getTopicsAjax('', $where_cond, $first_count);
        }
        /* new first count will be updated after every ajax call */
        $new_first_count = $first_count + count($forum_topics);
        $data['new_first_count'] = $new_first_count;

        foreach ($forum_topics as &$the_topic) {
        
            $the_topic['posted_on_new'] = date("d<\s\up>S</\s\up> M Y h:i A", strtotime($the_topic["posted_on"]));
            $arr_topic_comments = $this->getTopicComments($the_topic['topic_id']);            
            $the_topic["comments"] = $arr_topic_comments;
        }
        
        $data['forum_topics'] = $forum_topics;
//        $data['forum_topi cs'] = $forum_topics;        
        echo json_encode($data);
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
