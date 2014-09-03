<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog extends CI_Controller {

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
        $data['category_tree'] = $this->getBlogCategoriesTreeStructure();

        $posted_key = $this->input->post('search');

        if ($posted_key != "") {
            $data['header'] = array("title" => "Search results for " . $posted_key, "keywords" => "", "description" => "");
            $data['blog_posts'] = $this->searchPosts($posted_key);
            $this->load->view('front/home', $data);
        } else {
            if ($the_url == '') {
                $data['header'] = array("title" => "Welcome to blog module", "keywords" => "", "description" => "");
                $data['blog_posts'] = $this->getPosts();
                $this->load->view('front/home', $data);
            } else {
                /* /* check uri in database */
                $this->load->model("common_model");
                $the_page_info = $this->common_model->getPageInfoByUrl($the_url);
                $the_page_info = end($the_page_info);

                if (count($the_page_info) > 0) {
                    if ($the_page_info['type'] == 'blog-category') {
                        $category_id = $the_page_info['rel_id'];

                        /* get category info */
                        $this->load->model('blog_model');
                        $category_info = $this->blog_model->getCategories('*', array('category_id' => $category_id));

                        $data['header'] = array("title" => $category_info[0]['page_title'],
                            "keywords" => $category_info[0]['page_keywords'],
                            "description" => $category_info[0]['page_description']);

                        $data['blog_posts'] = $this->getPosts('', array("b.`category_id`" => $category_id));

                        $this->load->view('front/home', $data);
                    } elseif ($the_page_info['type'] == 'blog-post') {
                        $post_id = $the_page_info['rel_id'];
                        $data['blog_posts'] = $this->getPosts('', array("b.`post_id`" => $post_id));
                        $data['header'] = array("title" => $data['blog_posts'][0]['page_title'],
                            "keywords" => $data['blog_posts'][0]['post_keywords'],
                            "description" => $data['blog_posts'][0]['post_tags']);
                        $data['post_id'] = $post_id;
                        $data['post_comments'] = $this->getPostComments($post_id);
                        $this->load->view('front/blog-post', $data);
                    }
                } else {
                    echo "<h2>404 - Page not found</h2>";
                }
            }
        }
    }

    /*
     * Function will return all blog categories with category tree in desired format
     */

    public function getBlogCategoriesTreeStructure($type = 'ul') {
        $this->load->model('blog_model');
        return $this->blog_model->getCategoryTreeResponse($type);
    }

    /*
     *  End Blog Categories Tree Structure function
     */

    /*
     *  Function to get all blog posts
     */

    private function getPosts($fields = '', $condition = '') {
        $this->load->model('blog_model');
        return $this->blog_model->getPosts($fields, $condition);
    }

    /*
     *  Function to search blog posts
     */

    private function searchPosts($searchKey) {
        $this->load->model('blog_model');
        return $this->blog_model->searchPosts($searchKey);
    }

    private function getPostComments($post_id) {
        $limit = "10";
        $condition_to_pass = array("`post_id`" => $post_id, "status" => "1");
        $order = ('comment_on asc');
        $this->load->model("blog_model");
        $arr_comments = $this->blog_model->getPostComments("", $condition_to_pass, $order, $limit);
        return $arr_comments;
    }

    /*
     *  Function to add comment
     */

    public function add_comment() {
        $post_id = $this->input->post('p');
        $post_comment = $this->input->post('msg_comment');

        $arr_blog_comment = array();
        $arr_blog_comment["post_id"] = $post_id;
        $arr_blog_comment["comment"] = mysql_real_escape_string($post_comment);
        $arr_blog_comment["comment_on"] = date("Y-m-d H:i:s");
        $arr_blog_comment["commented_by"] = "Anonymous User";
        $arr_blog_comment["status"] = "1";
        $this->load->model('blog_model');
        $this->blog_model->add_comment($arr_blog_comment);
        echo json_encode(array("error" => "0"));
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */