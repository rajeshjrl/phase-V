<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Global_Setting extends CI_Controller {
    /*
     * An Controller having functions to manage global settings
     */
    /* construction function used to load all the models used in the controller.	   */

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->model('global_setting_model');
        CHECK_USER_STATUS();
		UpdateActiveTime();
    }

    /* function to list all the global setteings parameter */

    public function listGlobalSettings() {
        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        $data = $this->common_model->commonFunction();
        if ($data['user_account']['role_id'] != 1) {
            /* an admin which is not super admin not privileges to access global settings */
            /* setting session for displaying notiication message. */
            $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to manage global settings!</span>");
            redirect(base_url() . "backend/home");
        }
        $data['title'] = "Manage Global Settings";
        $data['arr_global_settings'] = $this->global_setting_model->getGlobalSettings('', '');
        $this->load->view('backend/global-setting/list', $data);
    }

    /* function to edit the global settings parameter */

    public function editGlobalSettings($edit_id = '', $lang_id = '') {

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }
        /* getting commen data required */
        $data = $this->common_model->commonFunction();

        /* checking user has privilige for the global settings */
        if ($data['user_account']['role_id'] != 1) {
            /* an admin which is not super admin not privileges to access global settings */
            /* setting session for displaying notiication message. */
            $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to manage global settings!</span>");
            redirect(base_url() . "backend/home");
        }

        if (count($_POST) > 0) {
            if ($this->input->post('value') != "") {
                if ($this->input->post('edit_id') != '' && $this->input->post('lang_id') != '') {
                    if ($this->input->post('name') == "default_currency" || $this->input->post('name') == "Default Currency") {
                        /* if parameter is currency then converting it into uppercase */
                        $arr_to_update = array(
                            "value" => mysql_real_escape_string(strtoupper($this->input->post('value')))
                        );
                    } else {
                        $arr_to_update = array(
                            "value" => mysql_real_escape_string($this->input->post('value'))
                        );
                    }
                    /* condition to update record	 */
                    $condition_array = array('lang_id' => intval(base64_decode($this->input->post('lang_id'))), 'global_name_id' => intval(base64_decode($this->input->post('edit_id'))));

                    /* updating the global setttings parameter value into database */
                    $this->common_model->updateRow('trans_global_settings', $arr_to_update, $condition_array);

                    /* updating the global settings to the file for the default language English */
                    $file_name = "global-settings-17";
                    $fp = fopen($data['absolute_path'] . "application/views/backend/global-setting/" . $file_name, "w+");
                    $global_setting_arr = $this->common_model->getGlobalSettings(17);
                    fwrite($fp, serialize($global_setting_arr));
                    fclose($fp);

                    /* setting session for displaying notication message. */
                    $this->session->set_userdata("msg", "<span class='success'>Global setting parameter updated successfully!</span>");
                }
                /* redirecting to global settings list */
                redirect(base_url() . "backend/global-settings/list");
            }
        }
        $data['title'] = "Edit Global Settings";

        if (($edit_id != '') && ($lang_id != '')) {
            $data['edit_id'] = $edit_id;
            $data['lang_id'] = $lang_id;
            $arr_global_settings = $this->global_setting_model->getGlobalSettings(intval(base64_decode($edit_id)), intval($lang_id));

            /* single row fix */
            $data['arr_global_settings'] = end($arr_global_settings);
            $this->load->view('backend/global-setting/edit', $data);
        } else {
            /* go to the page not found */
        }
    }

    /* function to edit the global settings parameter */

    public function editParameterLanguage($edit_id = '') {

        /* checking admin is logged in or not */
        if (!$this->common_model->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        /* getting commen data required */
        $data = $this->common_model->commonFunction();

        /* checking user has privilige for the global settings */
        if ($data['user_account']['role_id'] != 1) {
            /* an admin which is not super admin not privileges to access global settings */
            /* setting session for displaying notiication message. */
            $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to manage global settings!</span>");
            redirect(base_url() . "backend/home");
        }

        if (count($_POST) > 0) {
            if ($this->input->post('value') != "") {
                if ($this->input->post('edit_id') != '' && $this->input->post('lang_id') != '') {
                    if ($this->input->post('name') == "default_currency" || $this->input->post('name') == "Default Currency") {
                        /* if parameter is currency then converting it into uppercase */
                        $arr_to_update = array(
                            "value" => mysql_real_escape_string(strtoupper($this->input->post('value')))
                        );
                    } else {
                        $arr_to_update = array(
                            "value" => mysql_real_escape_string($this->input->post('value'))
                        );
                    }
                    /* condition to update record	 */
                    $condition_array = array('lang_id' => intval($this->input->post('lang_id')), 'global_name_id' => intval(base64_decode($this->input->post('edit_id'))));

                    /* updating the global setttings parameter value into database */
                    $this->common_model->updateRow('trans_global_settings', $arr_to_update, $condition_array);

                    /* updating the global settings Parameeter values to the file according to language. */
                    $file_name = "global-settings-" . intval($this->input->post('lang_id'));
                    $fp = fopen($data['absolute_path'] . "application/views/backend/global-setting/" . $file_name, "w+");
                    $global_setting_arr = $this->common_model->getGlobalSettings(intval($this->input->post('lang_id')));
                    fwrite($fp, serialize($global_setting_arr));
                    fclose($fp);

                    /* setting session for displaying notiication message. */
                    $this->session->set_userdata('msg', "<span class='success'>Global setting parameter updated successfully!</span>");
                }
                /* redirecting to global settings list */
                header("location:" . HTTP_ADMIN . "global-settings/list");
                redirect(base_url() . "backend/global-settings/list");
            }
        }

        $data['title'] = "Edit Global Settings";

        if (($edit_id != '')) {
            $data['edit_id'] = $edit_id;
            $arr_global_settings = $this->global_setting_model->getGlobalSettings(intval(base64_decode($edit_id)));
            // single row fix
            $data['arr_global_settings'] = end($arr_global_settings);

            /* getting all the active languages from the database */
            $data['arr_languages'] = $this->common_model->getRecords("mst_languages", "", array("status" => 'A'));
            $this->load->view('backend/global-setting/edit-language-parameter', $data);
        } else {
            /* go to the page not found */
        }
    }

    public function getGlobalParameterLanguage() {
        if ($this->input->post('lang_id') != "") {
            /* getting the global settings using the language id and parameter id. */
            $arr_language_values = $this->global_setting_model->getGlobalSettings(intval($this->input->post('edit_id')), intval($this->input->post('lang_id')));
            $arr_to_return = array();
            if (count($arr_language_values) > 0) {
                $arr_to_return["value"] = stripslashes($arr_language_values[0]["value"]);
            } else {
                $arr_to_return["value"] = "";
            }
            /* encodeing the array into json formate  */
            echo json_encode($arr_to_return);
        }
    }

}
