<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CMS extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->model('cms_model');
        $this->load->language('common');
        CHECK_USER_STATUS();
		UpdateActiveTime();
    }

    function listCMS() {

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        /* using the admin model */
        $this->load->model('admin_model');
        $data['title'] = "Manage CMS";
        $data['get_cms_list'] = $this->cms_model->getCmsList();
        $this->load->view('backend/cms/cms-list', $data);
    }

    function editCMS($cms_id = 0) {
        /* checking admin is logged in or not */

        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* Getting Common data */
        $data = $this->common_model->commonFunction();

        if ($this->input->post()) {

            $cms_page_title = mysql_real_escape_string($_POST['cms_page_title']);
            $cms_page_content = mysql_real_escape_string($_POST['content']);
            $cms_page_meta_keywords = mysql_real_escape_string($_POST['cms_page_meta_keywords']);
            $cms_page_meta_description = mysql_real_escape_string($_POST['cms_page_meta_description']);
            $cms_page_seo_title = mysql_real_escape_string($_POST['cms_page_seo_title']);
            $cms_page_status = 'Published';

            $arr_set_fields = array(
                "page_title" => $cms_page_title,
                "page_content" => $cms_page_content,
                "page_meta_keywords" => $cms_page_meta_keywords,
                "page_meta_description" => $cms_page_meta_description,
                "page_seo_title" => $cms_page_seo_title,
                "status" => $cms_page_status,
                "on_date" => date('Y-m-d H:i:s')
            );

            $this->common_model->updateRow('cms', $arr_set_fields, array("cms_id" => $cms_id));
            $this->session->set_userdata("msg", "<span class='success'>Record updated successfully!</span>");
            redirect(base_url() . 'backend/cms');
        }

        /* using the admin model */
        $this->load->model('admin_model');
        $data['title'] = "Manage CMS";
        $data['arr_cms_details'] = $this->cms_model->getCmsPageDetails($cms_id);
        $this->load->view('backend/cms/edit-cms', $data);
    }

    function getCmsPage($lang_id, $page_alias) {
        /* multi language keywords file */
        $this->load->language('common');
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');

        if (($lang_id != '') && ($page_alias != '')) {
            $lang_id = trim($lang_id);
            $page_alias = trim($page_alias);
            $cms_details = $this->cms_model->getCmsPage($lang_id, $page_alias);
            $data['cms_details'] = $cms_details;
            $data['title'] = $cms_details[0]['page_title'];
            $data['menu_active'] = trim($page_alias);
        }

        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/cms/cms');
        $this->load->view('front/includes/footer');
    }

    function contactUs() {

        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['menu_active'] = '';
        $data['include_js'] = implode("\n", array('<script src="' . base_url() . 'media/front/js/jquery.validate.js"></script>', '<script src="' . base_url() . 'media/front/js/cms/contact-us.js"></script>'));

        if ($this->input->post() != '') {

            /* if user is logged in then we use session user email o/w entered email id by user on contact us page */
            $user_email = ($data['user_session']['user_email'] != '') ? $data['user_session']['user_email'] : $this->input->post('reply_email');

            /* insert customer request email */
            $table = 'contact_us_email_log';
            $fields = array('email_log_id' => '',
                'sender_email' => mysql_real_escape_string($user_email),
                'receiver_email' => mysql_real_escape_string($data['global']['site_email']),
                'message_content' => mysql_real_escape_string($this->input->post('message')),
                'attachment' => 'no attachment'
            );
            $insert_id = $this->common_model->insertRow($fields, $table);

            /* start : for image upload */
            if ($_FILES['attachment']['name'] != '') {
                //configuration 
                $config['upload_path'] = './media/front/images/contact-us-attachment';
                $config['allowed_types'] = 'jpg|jpeg';
                $config['max_size'] = '9000000';
                $config['max_width'] = '12024';
                $config['max_height'] = '7268';
                $file_name = 'attach_' . rand();
                $config['file_name'] = $file_name;

                /* upload libraray */
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('attachment')) {
                    $error = array('error' => $this->upload->display_errors());
//                    $this->session->set_userdata('activation_error', "<strong>Congratulation!</strong> your request has been submitted successfully.");
//                    redirect(base_url () . 'contact-us');
                } else {
                    $this->upload->data();
                    /* update image to table */
                    if ($insert_id) {
                        $table_name = 'contact_us_email_log';
                        $update_data = array('attachment' => mysql_real_escape_string($file_name));
                        $condition_to_pass = array("email_log_id" => $insert_id);
                        $this->common_model->updateRow($table_name, $update_data, $condition_to_pass);
                    }
                }
            }
            /* end : for image upload */

            /* start : for email sending to admin */
            if (isset($lang_id) && $lang_id != '') {
                $lang_id = $this->session->userdata('lang_id');
            } else {
                $lang_id = 17; /* Default is 17(English) */
            }
            /* for email paramter */

            $name = ($this->input->post('name') == '') ? $this->input->post('name') : '';

            $reserved_words = array("||MESSAGE||" => $this->input->post('message'), "||ADMIN_NAME||" => 'Admin', "||USER_EMAIL||" => $user_email);
            $template_title = 'contact-us-email';
            $arr_emailtemplate_data = $this->common_model->getEmailTemplateInfo($template_title, $lang_id, $reserved_words);
            $recipeinets = $data['global']['site_email'];
            $from = array("email" => $user_email, 'name' => $name);
            $subject = $arr_emailtemplate_data['subject'];
            $message = stripcslashes($arr_emailtemplate_data['content']);
            $mail = $this->common_model->sendEmail($recipeinets, $from, $subject, $message);

            if ($mail) {
                $this->session->set_userdata('msg', "Congratulations!</strong> your request has been submitted successfully.");
                redirect(base_url() . 'contact-us');
            }
        }
        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/cms/contact_us');
        $this->load->view('front/includes/footer');
    }

    function supportAndContact() {
        /* multi language keywords file */
        $this->load->language('common');
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['menu_active'] = '';

        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        } else {
            $this->load->view('front/includes/dashboard-header-1');
        }
        $this->load->view('front/cms/support-and-contact');
        $this->load->view('front/includes/footer');
    }

    function paymentDispute() {
        /* multi language keywords file */
        $this->load->language('common');
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['menu_active'] = '';

        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/cms/payment-dispute');
        $this->load->view('front/includes/footer');
    }

    /* for chat forum */

    public function chat() {

        /* multi language keywords file */
        $this->load->language('common');
        /* Getting Common data */
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['menu_active'] = '';

        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        }
        $this->load->view('front/cms/chat');
        $this->load->view('front/includes/footer');
    }

}

?>
