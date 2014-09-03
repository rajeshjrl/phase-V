<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_Model extends CI_Model {
    /* function to get global setttings from the database  */

    public function getGlobalSettings($lang_id = '') {
        $global = array();
        $this->db->select('mst_global.*,trans_global.*');
        $this->db->from('mst_global_settings as mst_global');
        $this->db->join('trans_global_settings as trans_global', 'mst_global.global_name_id = trans_global.global_name_id', 'left');
        if ($lang_id != '') {
            $this->db->where("trans_global.lang_id", $lang_id); /* for lnag id passed ie. english */
        } else {
            $this->db->where("trans_global.lang_id", 17); /* for default language ie. english */
        }
        $result = $this->db->get();
        foreach ($result->result_array() as $row) {
            $global[$row['name']] = $row['value'];
        }
        return $global;
    }

    /* common function to get records from the database table	 */

    public function getRecords($table, $fields = '', $condition = '', $order_by = '', $limit = '', $debug = 0) {

        $str_sql = '';
        if (is_array($fields)) { /* $fields passed as array */
            $str_sql.=implode(",", $fields);
        } elseif ($fields != "") {   #$fields passed as string
            $str_sql .= $fields;
        } else {
            $str_sql .= '*';  /* $fields passed blank */
        }

        $this->db->select($str_sql);

        if (is_array($condition)) { /* $condition passed as array */
            if (count($condition) > 0) {
                foreach ($condition as $field_name => $field_value) {
                    if ($field_name != '' && $field_value != '') {
                        $this->db->where($field_name, $field_value);
                    }
                }
            }
        } else if ($condition != "") { /* $condition passed as string */
            $this->db->where($condition);
        }

        if ($limit != "")
            $this->db->limit($limit); /* limit is not blank */

        if (is_array($order_by)) {
            $this->db->order_by($order_by[0], $order_by[1]);  /* $order_by is not blank */
        } else if ($order_by != "") {
            $this->db->order_by($order_by);  /* $order_by is not blank */
        }


        $this->db->from($table);  /* getting record from table name passed */
        $query = $this->db->get();

        if ($debug) {
            die($this->db->last_query());
        }
        return $query->result_array();
    }

    /* function to get common record for the user	ie. absoulute path, global settings. */

    public function commonFunction() {
        $global = array();
        /* geting global settings from file */
        $land_id = 17; /* default is 17 for english set lang id from session if global setting required for different language. */
        $file_name = "global-settings-" . $land_id;
        $resp = file_get_contents($this->absolutePath() . "application/views/backend/global-setting/" . $file_name);
        $data['global'] = unserialize($resp);
        $data['absolute_path'] = $this->absolutePath();
        $data['user_account'] = $this->session->userdata('user_account');
        return($data);
    }

    /* function to check user loged in or not. */

    public function isLoggedIn() {
        $user_account = $this->session->userdata('user_account');
        if (isset($user_account['user_id']) && $user_account['user_id'] != '') {
            return true;
        } else {
            return false;
        }
    }

    #function to insert record into the database	

    public function insertRow($insert_data, $table_name) {
        $this->db->insert($table_name, $insert_data);
        return $this->db->insert_id();
    }

    #function to update record in the database	

    public function updateRow($table_name, $update_data, $condition) {

        //echo "<pre>";print_r($condition);exit;
        if (is_array($condition)) {
            if (count($condition) > 0) {
                foreach ($condition as $field_name => $field_value) {
                    if ($field_name != '' && $field_value != '') {
                        $this->db->where($field_name, $field_value);
                    }
                }
            }
        } else if ($condition != "") {
            $this->db->where($condition);
        }
        $result = $this->db->update($table_name, $update_data);
        //echo $this->db->last_query();

        return $result;
    }

    #common function to delete rows from the table

    public function deleteRows($arr_delete_array, $table_name, $field_name) {
        if (count($arr_delete_array) > 0) {
            foreach ($arr_delete_array as $id) {
                $this->db->where($field_name, $id);
                $query = $this->db->delete($table_name);
            }
        }
    }

    #function to get absolute path for project

    public function absolutePath($path = '') {
        $abs_path = str_replace('system/', $path, BASEPATH);
        //Add a trailing slash if it doesn't exist.
        $abs_path = preg_replace("#([^/])/*$#", "\\1/", $abs_path);
        return $abs_path;
    }

    public function getEmailTemplateInfo($template_title, $lang_id, $reserved_words) {

        // gather information for database table
        $template_data = $this->getRecords('mst_email_templates', '', array("email_template_title" => $template_title, "lang_id" => $lang_id));

        $content = $template_data[0]['email_template_content'];
        $subject = $template_data[0]['email_template_subject'];

        // replace reserved words if any
        foreach ($reserved_words as $k => $v) {
            $content = str_replace($k, $v, $content);
        }

        return array("subject" => $subject, "content" => $content);
    }

    public function sendEmail($recipeinets, $from, $subject, $message) {
        // ci email helper initialization
        $config['protocol'] = 'mail';
        $config['wordwrap'] = FALSE;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $this->load->library('email', $config);
        $this->email->initialize($config);

        // set the from address
        $this->email->from($from['email'], $from['name']);

        // set the subject
        $this->email->subject($subject);

        // set recipeinets
        $this->email->to($recipeinets);

        // set mail message
        $this->email->message($message);

        // return boolean value for email send
        return $this->email->send();
    }

    public function getPageInfoByUrl($uri) {

        $arr_to_return = $this->getRecords("mst_uri_map", "*", array("url" => $uri));
        return $arr_to_return;
    }

    /* get time difference between two timestamps */

    public function dateDiff($d1, $d2) {
        $date1 = strtotime($d1);
        $date2 = strtotime($d2);
        $seconds = $date1 - $date2;
        $weeks = floor($seconds / 604800);
        $seconds -= $weeks * 604800;
        $days = floor($seconds / 86400);
        $seconds -= $days * 86400;
        $hours = floor($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;
        $months = round(($date1 - $date2) / 60 / 60 / 24 / 30);
        $years = round(($date1 - $date2) / (60 * 60 * 24 * 365));
        $diffArr = array("Seconds" => $seconds, "minutes" => $minutes, "Hours" => $hours, "Days" => $days, "Weeks" => $weeks, "Months" => $months, "Years" => $years);
        return $diffArr;
    }

    public function getTotalRecordCount($tbl_name = '', $debug = '') {

        $this->db->select('*');
        $this->db->from($tbl_name);
        $query = $this->db->get();
        if ($debug != '') {
            echo $this->db->last_query();
        }
        return $query->num_rows();
    }

}
