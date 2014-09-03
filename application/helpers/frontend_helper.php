<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function GET_TIMEDIFF($dbTime) {
    $CI = & get_instance();
    $getUpdateTime = $dbTime;

    $query = $CI->db->query("SELECT CURTIME() as  today_time");
    if ($query->num_rows() > 0) {
        $row = $query->row();
        $current_time = $row->today_time;
    }
    $time1 = strtotime($getUpdateTime);
    $time2 = strtotime($current_time);
    $seconds = $time2 - $time1;
    $days = floor($seconds / 86400);
    $hours = floor(($seconds - ($days * 86400)) / 3600);
    $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600)) / 60);
    $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes * 60)));

    return $days;
}


function GetTimeAgo($time_ago)
{
	//$get_current_time = mysql_fetch_array(mysql_query('select now() as today'));
	//$cur_time = strtotime($get_current_time['today']);
	$cur_time = strtotime(date('Y-m-d H:i:s'));
	$time_elapsed 	= $cur_time - $time_ago;
	
	$seconds 	= $time_elapsed ;
	$minutes 	= round($time_elapsed / 60 );
	$hours 		= round($time_elapsed / 3600);
	$days 		= round($time_elapsed / 86400 );
	$weeks 		= round($time_elapsed / 604800);
	$months 	= round($time_elapsed / 2600640 );
	$years 		= round($time_elapsed / 31207680 );
	// Seconds
	if($seconds <= 60)
	{
		return "$seconds seconds ago";
	}
	//Minutes
	else if($minutes <=60)
	{
		if($minutes==1){
			return "one minute ago";
		}
		else{
			return "$minutes minutes ago";
		}
	}
	//Hours
	else if($hours <=24)
	{
		if($hours==1){
			return "an hour ago";
		}else{
			return "$hours hours ago";
		}
	}
	//Days
	else if($days <= 7){
		if($days==1){
			return "yesterday";
		}else{
			return "$days days ago";
		}
	}
	//Weeks
	else if($weeks <= 4.3){
		if($weeks==1){
			return "a week ago";
		}else{
			return "$weeks weeks ago";
		}
	}
	//Months
	else if($months <=12){
		if($months==1){
			return "a month ago";
		}else{
			return "$months months ago";
		}
	}
	//Years
	else{
		if($years==1){
			return "one year ago";
		}else{
			return "$years years ago";
		}
	}
}

/* Get active user last seen */
function GetLastSeenTime($user_id)
{
	$CI = & get_instance();
	$data = $CI->common_model->commonFunction();
	/* get user last login details */
	$table_to_pass = 'user_sign_in_log';
	$fields_to_pass = 'last_activity';
	$condition_to_pass = array("user_id" => $user_id);
	$order_by_to_pass = 'log_id DESC';
	$limit_to_pass = '1';
	$arr_user_login_details = array();
	$arr_user_login_details = $CI->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass, $limit_to_pass, $debug_to_pass = 0);
	
	$last_seen = GetTimeAgo($arr_user_login_details[0]['last_activity']);
	
	return $last_seen;
	
}

/* Refresh time of logged in user*/

function UpdateActiveTime()
{
	$CI = & get_instance();
	$data = $CI->common_model->commonFunction();
	$user_account = $CI->session->userdata('user_account');
	/* make entry in sign in log table */
	if ($CI->session->userdata('last_sign_in_log_id') != '') {
	
		/* get user last login details */
        $table_to_pass = 'user_sign_in_log';
        $fields_to_pass = 'last_activity';
        $condition_to_pass = array("user_id" => $user_account['user_id'],"log_id" => $CI->session->userdata('last_sign_in_log_id'));
        $arr_user_login_details = array();
        $arr_user_login_details = $CI->common_model->getRecords($table_to_pass, $fields_to_pass, $condition_to_pass, $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0);
		
		//$get_current_time = mysql_fetch_array(mysql_query('select now() as today'));
		//$cur_time = strtotime($get_current_time['today']);
		$cur_time = strtotime(date('Y-m-d H:i:s'));
			
		$time_since = $cur_time - $arr_user_login_details[0]['last_activity'];		
        $interval = 300;
				
		// Do nothing if last activity is recent
        if ($time_since < $interval) return;
		
		$update_table_name = 'user_sign_in_log';
		$update_data = array('last_activity' => strtotime(date('Y-m-d H:i:s')));
		$condition = array("log_id" => $CI->session->userdata('last_sign_in_log_id'));
		$CI->common_model->updateRow($update_table_name, $update_data, $condition);
	}
	
}

#check user details if user delete or block by super admin

function CHECK_USER_STATUS() {
    $CI = & get_instance();
    $user_account = $CI->session->userdata('user_account');

    if (isset($user_account['user_id']) && $user_account['user_id'] != '') {

        $where = array("user_id" => $user_account['user_id']);
        $arr_user = $CI->db->get_where('mst_users', $where)->row_array();
        #if delete user
        if (empty($arr_user)) {
            $CI->session->unset_userdata('user_account');
            $CI->session->set_userdata("msg-error", "Sorry your account has been deleted by admin.");
            redirect(base_url());
        } else {
            #if user blocked by admin
            if ($arr_user['user_status'] == '0' || $arr_user['user_status'] == '2') {
                $CI->session->unset_userdata('user_account');

                if ($arr_user['user_status'] == 2)
                    $CI->session->set_userdata('msg-error', 'Your account has been blocked by admin.');
                else
                    $CI->session->set_userdata('msg-error', 'Your account has been inactivated by admin.');

                redirect(base_url());
            }
        }
    }
}

