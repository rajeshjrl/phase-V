<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FAQS extends CI_Controller {

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
    public function index() {


        $data['header'] = array("title" => "Welcome to faqs module", "keywords" => "", "description" => "");
        $faqs = $this->getFAQS();

        $categorised_faqs = array();

        foreach ($faqs as $faq) {
            if (isset($categorised_faqs[$faq['category_name']]))
                $categorised_faqs[$faq['category_name']][] = array("question" => $faq['question'], "answer" => $faq['answer']);
            else
                $categorised_faqs[$faq['category_name']][0] = array("question" => $faq['question'], "answer" => $faq['answer']);
        }

        $data['categorized_faqs'] = $categorised_faqs;
        $this->load->view('front/faqs', $data);
    }

    /*
     *  Function to get all faqs
     */

    private function getFAQS($fields = '', $condition = '') {
        $this->load->model('faq_model');
        return $this->faq_model->getFAQS($fields, $condition);
    }

}

/* End of file faqs.php */
/* Location: ./application/controllers/faq.php */