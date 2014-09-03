<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Currency_Model extends CI_Model {
    /* Function to get all email templates from email template table */

    public function getCurrencyDetails() {
        $this->db->select('currency_id, currency_name, currency_code, currency_exchange_code, status,created_on,updated_on');
        $this->db->from('currency_management');
        $this->db->order_by('currency_id desc');
        $result = $this->db->get();
        return $result->result_array();
    }

    /* function to get currency details using id */

    public function getCurrencyDetailsById($currency_id = '') {
        $this->db->select('*');
        $this->db->from('currency_management');
        $this->db->where('currency_id', $currency_id);
        $result = $this->db->get();
        return $result->result_array();
    }

    public function updateCurrencyDetailsById($currency_id = '', $data) {
        $this->db->where('currency_id', $currency_id);
        $this->db->update('currency_management', $data);
    }

    /* Get payment method details */
    public function getPaymentMethodDetails($method_id = '') {
        $this->db->select('method_id,method_name,method_description,risk_level,method_url,status,created_on');
        $this->db->from('payment_method');
		if($method_id != '')
		{
			$this->db->where('method_id', $method_id);
		}
		else
		{
			$this->db->where('parent_method_id !=', '0');
			$id = array('3','19');
			$this->db->where_not_in('method_id', $id);
		}
        $result = $this->db->get();
        return $result->result_array();
    }

}
