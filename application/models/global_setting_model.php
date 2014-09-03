<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Global_Setting_Model extends CI_Model {
    #function to get global settings from the database if edit_id and lang_id black then it will return all reacords   

    public function getGlobalSettings($edit_id = '', $lang_id = '') {
        $this->db->select('mst_global.*,trans_global.*');
        $this->db->from('mst_global_settings as mst_global');
        $this->db->join('trans_global_settings as trans_global', 'mst_global.global_name_id = trans_global.global_name_id', 'left');
        if ($edit_id != '') { #if edit id not blank passed it will return all records
            $this->db->where("trans_global.global_name_id", $edit_id);
        }

        if ($lang_id != '') {
            $this->db->where("trans_global.lang_id", $lang_id);
        } else {
            $this->db->where("trans_global.lang_id", 17);
        }
        $result = $this->db->get();
        return $result->result_array();
    }

}
