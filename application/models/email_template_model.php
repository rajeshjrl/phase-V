<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_Template_Model extends CI_Model {
    /*
     * Function to get all email templates from email template table 
     * 
     */

    public function getEmailTemplateDetails() {
        $this->db->select('email.*,lang.lang_name');
        $this->db->from('mst_email_templates as email');
        $this->db->join('mst_languages as lang', 'lang.lang_id= email.lang_id', 'inner');
        $this->db->order_by('email_template_id desc');
        $result = $this->db->get();
        return $result->result_array();
    }
    /*
     *  function to get  email templates from email template table by using id 
     */

    public function getEmailTemplateDetailsById($email_template_id = '') {
        $this->db->select('email.*,lang.lang_name');
        $this->db->from('mst_email_templates as email');
        $this->db->join('mst_languages as lang', 'lang.lang_id= email.lang_id', 'inner');
        $this->db->where('email.email_template_id', $email_template_id);
        $result = $this->db->get();
        return $result->result_array();
    }

    /*
     * function to update  email templates  by using id 
     */

    public function updateEmailTemplateDetailsById($email_template_id = '', $data) {
        $this->db->where('email_template_id', $email_template_id);
        $this->db->update('mst_email_templates as email', $data);
    }

}
