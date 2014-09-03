<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->language('common');
        $this->load->model("home_model");
        CHECK_USER_STATUS();
        UpdateActiveTime();
    }

    /* Index Page for this controller.
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

    /* Defualt home page or base url page */

    public function index() {

        $this->load->model('common_model');
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');

        /* Get session for search criteria  */
        //$data['search_bitcoins'] = $this->session->userdata('filter');

        $data['title'] = 'Home';
        /* get currency details */
        $table = 'currency_management';
        $fields = 'currency_id,currency_code,currency_exchange_code';
        $condition = array('status' => 'A');
        $data['currency_details'] = $this->common_model->getRecords($table, $fields, $condition, $order_by = 'currency_code', $limit = '', $debug = 0);

        /* get online payment method details */
        $table = 'payment_method';
        $fields = 'method_id,method_name';
        $condition = array('status' => 'A', 'parent_method_id' => '1');
        $data['payment_details_online'] = $this->common_model->getRecords($table, $fields, $condition, $order_by = 'method_id', $limit = '', $debug = 0);

        /* get in-person payment method details */
        $table = 'payment_method';
        $fields = 'method_id,method_name';
        $condition = array('status' => 'A', 'parent_method_id' => '2');
        $data['payment_details_cash'] = $this->common_model->getRecords($table, $fields, $condition, $order_by = 'method_id', $limit = '', $debug = 0);

        /* set flag is set for index pageonly to include marcketplace footer */
        $flag['indexFlag'] = 'true';
        $data['menu_active'] = 'home';

        /* using the currency model */
        $this->load->model('currency_model');
        $data['arr_currency_details'] = $this->currency_model->getCurrencyDetails();
        $data['arr_payment_method_details'] = $this->currency_model->getPaymentMethodDetails();

        if ($this->session->userdata('filter')) {

            $data['search_bitcoins'] = $this->session->userdata('filter');

            $search_name = $data['search_bitcoins']['search'];
            $lat = $data['search_bitcoins']['lattitude'];
            $lon = $data['search_bitcoins']['longitude'];
            $filter = explode(',', $search_name);
            $country = end($filter);

            $arr_geo_data['country_name'] = $country;
            $arr_geo_data['city'] = $search_name;

            $data['arr_geo_data'] = $arr_geo_data;
        } else {
        	//echo $_SERVER['REMOTE_ADDR']; die;

           // if (($_SERVER['REMOTE_ADDR'] == '127.0.0.1') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.1') || ($_SERVER['REMOTE_ADDR'] == '182.72.122.106') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.96')) {
              $ip_address = "182.72.122.106";
           // } else {
              //  $ip_address = $_SERVER['REMOTE_ADDR'];
           // }
            

            //$arr_geo_data = geoip_record_by_name($ip_address);

            $lat = trim($arr_geo_data['latitude']);
            $lon = trim($arr_geo_data['longitude']);

            $this->session->userdata('latitude', $lat);
            $country = $arr_geo_data['country_name'];
            $data['arr_geo_data'] = $arr_geo_data;

            $data['search_bitcoins'] = $this->session->userdata('filter');
        }

        $lat = (!empty($lat) ? $lat : 41.3423502);
        $lon = (!empty($lon) ? $lon : -73.0774616);
        /* get trade advertisment details */
        $table_to_pass = 'user_sign_in_log';
        $fields_to_pass = 'log_id,user_id,last_login,last_logout';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_login_details = array();

        /* API used to get the current market price of BTC */
        $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = @file_get_contents($post_data);
        $currencyRateArr = json_decode($currencyRateArr);

        /* Get ads */
        $arr_condition = array(
            "lattitude" => $lat,
            "longitude" => $lon,
            "limit" => 100
        );
        $arrInfo = $this->home_model->getBitcoinsInfo($arr_condition);

        for ($i = 0; $i < count($arrInfo); $i++) {
            foreach ($currencyRateArr as $rateArr) {
                if ($rateArr->code == $arrInfo[$i]['currency_code']) {
                    $price_eq_val = $arrInfo[$i]['price_eq_val'];
                    $currency_rate = $rateArr->rate;
                    $arrInfo[$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                    $arrInfo[$i]['local_currency_code'] = $rateArr->code;
                    break;
                }
            }
            $trade_count = $this->home_model->getConfirmedTradeCount($arrInfo[$i]['user_id']);
            $arrInfo[$i]['confirmed_trade_count'] = $trade_count;
        }

        $data['arrInfo'] = $arrInfo;


        /* Latest updated bitcoin sale ads */
        $arrInfo_sell_ads_latest = $this->home_model->getLatestBitcoinSellAds();

        $data['arrInfo_sell_ads_latest'] = $arrInfo_sell_ads_latest;

        /* Get latest post from blogpost */
        $blogID = $data['global']['blogspot_id'];
        $requestURL = "http://www.blogger.com/feeds/{$blogID}/posts/default?max-results=5";
        $xml = simplexml_load_file($requestURL);

        foreach ($xml->entry as $post) {
            $arr_blogpost[$i]['title'] = $post->title;
            $arr_blogpost[$i]['updated'] = $post->updated;
            $arr_blogpost[$i++]['link'] = $post->link[4]->attributes()->href;
        }
        $data['arr_blogpost'] = $arr_blogpost;

        /* Include api for google maps */
        $data['include_js'] = implode("\n", array('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>'));

        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
            $this->load->view('front/includes/login-landing-page', $data);
        } else {
            $this->load->view('front/includes/home-landing-page', $data);
        }
        $this->load->view('home', $data);
        $this->load->view('front/includes/footer', $flag);
    }

    /* Show instant bitcoins page with filtered bitcoins trade */

    public function instantBitcoins() {

        $this->load->model('common_model');
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['title'] = 'Home';
        /* get currency details */
        $table = 'currency_management';
        $fields = 'currency_id,currency_code,currency_exchange_code';
        $condition = array('status' => 'A');
        $data['currency_details'] = $this->common_model->getRecords($table, $fields, $condition, $order_by = 'currency_code', $limit = '', $debug = 0);

        /* get online payment method details */
        $table = 'payment_method';
        $fields = 'method_id,method_name';
        $condition = array('status' => 'A', 'parent_method_id' => '1');
        $data['payment_details_online'] = $this->common_model->getRecords($table, $fields, $condition, $order_by = 'method_id', $limit = '', $debug = 0);

        /* get in-person payment method details */
        $table = 'payment_method';
        $fields = 'method_id,method_name';
        $condition = array('status' => 'A', 'parent_method_id' => '2');
        $data['payment_details_cash'] = $this->common_model->getRecords($table, $fields, $condition, $order_by = 'method_id', $limit = '', $debug = 0);

        /* set flag is set for index pageonly to include marcketplace footer */
        $flag['indexFlag'] = '';
        $data['menu_active'] = 'home';

        /* using the currency model */
        $this->load->model('currency_model');
        $data['arr_currency_details'] = $this->currency_model->getCurrencyDetails();
        $data['arr_payment_method_details'] = $this->currency_model->getPaymentMethodDetails();


        if (isset($_POST['btn_search'])) {

            $payment = $this->input->post('payment_type');
            $payment = explode('-', $payment);
            $paymentTypeLable = $payment[0];
            $paymentType = $payment[1];

            /* Set session data of user */
            $search_data['search'] = $this->input->post('search');
            $search_data['lattitude'] = $this->input->post('lattitude');
            $search_data['longitude'] = $this->input->post('longitude');
            $search_data['type'] = $this->input->post('radio');

            $search_data['payment_type'] = $paymentType;
            $search_data['currency'] = $this->input->post('currency');
            $search_data['amount'] = $this->input->post('amount');

            $search_name = $search_data['search'];
            $lat = $search_data['lattitude'];
            $lon = $search_data['longitude'];
            $filter = explode(',', $search_name);
            $country = end($filter);

            $search_data['country'] = $country;

            $arr_geo_data['country_name'] = $country;
            $arr_geo_data['city'] = $search_name;

            $data['arr_geo_data'] = $arr_geo_data;

            $trade_type = $search_data['type'];
            $amount = $search_data['amount'];
            $payment_type = $search_data['payment_type'];
            $currency = $search_data['currency'];

            $this->session->set_userdata('filter', $search_data);

            /* If trade type is buy */
            if ($trade_type == '2') {

                if ($paymentTypeLable == 'Online') {
                    //Send array condition with buy_o trade type
                    $arr_condition = array(
                        "lattitude" => $lat,
                        "longitude" => $lon,
                        "limit" => 10,
                        "trade_type" => "buy_o",
                        "payment_type" => $payment_type,
                        "amount" => $amount,
                        "currency" => $currency
                    );
                    $arrInfo_buy_o = $this->home_model->getBitcoinsInfo($arr_condition);
                    /* API used to get the current market price of BTC */
                    $post_data = "https://bitpay.com/api/rates";
                    $currencyRateArr = @file_get_contents($post_data);
                    $currencyRateArr = json_decode($currencyRateArr);

                    for ($i = 0; $i < count($arrInfo_buy_o); $i++) {
                        foreach ($currencyRateArr as $rateArr) {
                            if ($rateArr->code == $arrInfo_buy_o[$i]['currency_code']) {
                                $price_eq_val = $arrInfo_buy_o[$i]['price_eq_val'];
                                $currency_rate = $rateArr->rate;
                                $arrInfo_buy_o[$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                                $arrInfo_buy_o[$i]['local_currency_code'] = $rateArr->code;
                                break;
                            }
                        }
                        /* Get confirmed trade count of user */
                        $trade_count = $this->home_model->getConfirmedTradeCount($arrInfo_buy_o[$i]['user_id']);
                        $arrInfo_buy_o[$i]['confirmed_trade_count'] = $trade_count;
                    }
                    $data['arrInfo_buy_o'] = $arrInfo_buy_o;
                }

                if ($paymentTypeLable == 'Cash') {
                    //Send array condition with buy_c trade type
                    $arr_condition = array(
                        "lattitude" => $lat,
                        "longitude" => $lon,
                        "limit" => 10,
                        "trade_type" => "buy_c",
                        "payment_type" => $payment_type,
                        "amount" => $amount,
                        "currency" => $currency
                    );
                    $arrInfo_buy_c = $this->home_model->getBitcoinsInfo($arr_condition);

                    for ($i = 0; $i < count($arrInfo_buy_c); $i++) {
                        foreach ($currencyRateArr as $rateArr) {
                            if ($rateArr->code == $arrInfo_buy_c[$i]['currency_code']) {
                                $price_eq_val = $arrInfo_buy_c[$i]['price_eq_val'];
                                $currency_rate = $rateArr->rate;
                                $arrInfo_buy_c[$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                                $arrInfo_buy_c[$i]['local_currency_code'] = $rateArr->code;
                                break;
                            }
                        }
                        /* Get confirmed trade count of user */
                        $trade_count = $this->home_model->getConfirmedTradeCount($arrInfo_buy_c[$i]['user_id']);
                        $arrInfo_buy_c[$i]['confirmed_trade_count'] = $trade_count;
                    }
                    $data['arrInfo_buy_c'] = $arrInfo_buy_c;
                }
                /* If trade type is sell */
            } else {
                /* API used to get the current market price of BTC */
                $post_data = "https://bitpay.com/api/rates";
                $currencyRateArr = @file_get_contents($post_data);
                $currencyRateArr = json_decode($currencyRateArr);

                if ($paymentTypeLable == 'Online') {
                    //Send array condition with sell_o trade type
                    $arr_condition = array(
                        "lattitude" => $lat,
                        "longitude" => $lon,
                        "limit" => 10,
                        "trade_type" => "sell_o",
                        "payment_type" => $payment_type,
                        "amount" => $amount,
                        "currency" => $currency
                    );
                    $arrInfo_sell_o = $this->home_model->getBitcoinsInfo($arr_condition);

                    for ($i = 0; $i < count($arrInfo_sell_o); $i++) {
                        foreach ($currencyRateArr as $rateArr) {
                            if ($rateArr->code == $arrInfo_sell_o[$i]['currency_code']) {
                                $price_eq_val = $arrInfo_sell_o[$i]['price_eq_val'];
                                $currency_rate = $rateArr->rate;
                                $arrInfo_sell_o[$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                                $arrInfo_sell_o[$i]['local_currency_code'] = $rateArr->code;
                                break;
                            }
                        }
                        /* Get confirmed trade count of user */
                        $trade_count = $this->home_model->getConfirmedTradeCount($arrInfo_sell_o[$i]['user_id']);
                        $arrInfo_sell_o[$i]['confirmed_trade_count'] = $trade_count;
                    }
                    $data['arrInfo_sell_o'] = $arrInfo_sell_o;
                }

                if ($paymentTypeLable == 'Cash') {
                    //Send array condition with sell_c trade type
                    $arr_condition = array(
                        "lattitude" => $lat,
                        "longitude" => $lon,
                        "limit" => 10,
                        "trade_type" => "sell_c",
                        "payment_type" => $payment_type,
                        "amount" => $amount,
                        "currency" => $currency
                    );
                    $arrInfo_sell_c = $this->home_model->getBitcoinsInfo($arr_condition);

                    for ($i = 0; $i < count($arrInfo_sell_c); $i++) {
                        foreach ($currencyRateArr as $rateArr) {
                            if ($rateArr->code == $arrInfo_sell_c[$i]['currency_code']) {
                                $price_eq_val = $arrInfo_sell_c[$i]['price_eq_val'];
                                $currency_rate = $rateArr->rate;
                                $arrInfo_sell_c[$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                                $arrInfo_sell_c[$i]['local_currency_code'] = $rateArr->code;
                                break;
                            }
                        }
                        /* Get confirmed trade count of user */
                        $trade_count = $this->home_model->getConfirmedTradeCount($arrInfo_sell_c[$i]['user_id']);
                        $arrInfo_sell_c[$i]['confirmed_trade_count'] = $trade_count;
                    }
                    $data['arrInfo_sell_c'] = $arrInfo_sell_c;
                }
            }
        }
        /* get trade advertisment details */
        $table_to_pass = 'user_sign_in_log';
        $fields_to_pass = 'log_id,user_id,last_login,last_logout';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_login_details = array();

        $data['include_js'] = implode("\n", array('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>'));

        $data['search_bitcoins'] = $this->session->userdata('filter');

        /* Load view */
        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        } else {
            $this->load->view('front/includes/dashboard-header-1');
        }
        $this->load->view('front/includes/login-landing-page', $data);
        $this->load->view('instant-bitcoins', $data);
        $this->load->view('front/includes/footer', $flag);
    }

    /* Chnage location and set session to show all bitcoins records from selected location */

    function changeLocation() {

        $search_data['search'] = $this->input->post('change-location');
        $search_data['lattitude'] = $this->input->post('change_lattitude');
        $search_data['longitude'] = $this->input->post('change_longitude');

        $page = $this->input->post('page');
        $this->session->set_userdata('filter', $search_data);
        $data['search_bitcoins'] = $this->session->userdata('filter');
        redirect(base_url() . $page);
    }

    /* Show bitcoins from selected location with trade type buy only */

    function buyBitcoins() {
        $this->load->model('common_model');
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');

        $data['title'] = 'Buy bitcoins';

        /* set flag is set for index pageonly to include marcketplace footer */
        $flag['indexFlag'] = '';
        $data['menu_active'] = 'buy_bitcoin';

        /* using the currency model */
        $this->load->model('currency_model');

        if ($this->session->userdata('filter')) {

            $data['search_bitcoins'] = $this->session->userdata('filter');

            $search_name = $data['search_bitcoins']['search'];
            $lat = $data['search_bitcoins']['lattitude'];
            $lon = $data['search_bitcoins']['longitude'];
            $filter = explode(',', $search_name);
            $country = end($filter);

            $arr_geo_data['country_name'] = $country;
            $arr_geo_data['city'] = $search_name;

            $data['arr_geo_data'] = $arr_geo_data;
        } else {

            if (($_SERVER['REMOTE_ADDR'] == '127.0.0.1') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.1') || ($_SERVER['REMOTE_ADDR'] == '182.72.122.106') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.96')) {
                $ip_address = "182.72.122.106";
            } else {
                $ip_address = $_SERVER['REMOTE_ADDR'];
            }

            $arr_geo_data = geoip_record_by_name($ip_address);

            $lat = trim($arr_geo_data['latitude']);
            $lon = trim($arr_geo_data['longitude']);

            $this->session->userdata('latitude', $lat);
            $country = $arr_geo_data['country_name'];
            $data['arr_geo_data'] = $arr_geo_data;

            $data['search_bitcoins'] = $this->session->userdata('filter');
        }

        $lat = (!empty($lat) ? $lat : 41.3423502);
        $lon = (!empty($lon) ? $lon : -73.0774616);

        /* get trade advertisment details */
        $table_to_pass = 'user_sign_in_log';
        $fields_to_pass = 'log_id,user_id,last_login,last_logout';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_login_details = array();

        //Send array condition with buy_o trade type
        $arr_condition = array(
            "lattitude" => $lat,
            "longitude" => $lon,
            "limit" => 10,
            "trade_type" => "sell_o"
        );
        $arrInfo_buy_o = $this->home_model->getBitcoinsInfo($arr_condition);

        /* API used to get the current market price of BTC */
        $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = @file_get_contents($post_data);
        $currencyRateArr = json_decode($currencyRateArr);

        for ($i = 0; $i < count($arrInfo_buy_o); $i++) {
            foreach ($currencyRateArr as $rateArr) {
                if ($rateArr->code == $arrInfo_buy_o[$i]['currency_code']) {
                    $price_eq_val = $arrInfo_buy_o[$i]['price_eq_val'];
                    $currency_rate = $rateArr->rate;
                    $arrInfo_buy_o[$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                    $arrInfo_buy_o[$i]['local_currency_code'] = $rateArr->code;
                    break;
                }
            }
            /* Get confirmed trade count of user */
            $trade_count = $this->home_model->getConfirmedTradeCount($arrInfo_buy_o[$i]['user_id']);
            $arrInfo_buy_o[$i]['confirmed_trade_count'] = $trade_count;
        }

        $data['arrInfo_buy_o'] = $arrInfo_buy_o;

        //Send array condition with buy_c trade type
        $arr_condition = array(
            "lattitude" => $lat,
            "longitude" => $lon,
            "limit" => 10,
            "trade_type" => "sell_c"
        );
        $arrInfo_buy_c = $this->home_model->getBitcoinsInfo($arr_condition);

        for ($i = 0; $i < count($arrInfo_buy_c); $i++) {
            foreach ($currencyRateArr as $rateArr) {
                if ($rateArr->code == $arrInfo_buy_c[$i]['currency_code']) {
                    $price_eq_val = $arrInfo_buy_c[$i]['price_eq_val'];
                    $currency_rate = $rateArr->rate;
                    $arrInfo_buy_c[$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                    $arrInfo_buy_c[$i]['local_currency_code'] = $rateArr->code;
                    break;
                }
            }
            /* Get confirmed trade count of user */
            $trade_count = $this->home_model->getConfirmedTradeCount($arrInfo_buy_c[$i]['user_id']);
            $arrInfo_buy_c[$i]['confirmed_trade_count'] = $trade_count;
        }

        $data['arrInfo_buy_c'] = $arrInfo_buy_c;

        /* Include api for google maps */
        $data['include_js'] = implode("\n", array('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>'));

        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        } else {
            $this->load->view('front/includes/dashboard-header-1');
        }
        $this->load->view('front/user-account/buy-bitcoins', $data);
        $this->load->view('front/includes/footer', $flag);
    }

    /* Show bitcoins from selected location with trade type sell only */

    function sellBitcoins() {

        $this->load->model('common_model');
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');

        /* Get session for search criteria  */
        //$data['search_bitcoins'] = $this->session->userdata('filter');

        $data['title'] = 'Sell bitcoins';

        /* set flag is set for index pageonly to include marcketplace footer */
        $flag['indexFlag'] = '';
        $data['menu_active'] = 'sell_bitcoin';

        /* using the currency model */
        $this->load->model('currency_model');

        if ($this->session->userdata('filter')) {

            $data['search_bitcoins'] = $this->session->userdata('filter');

            $search_name = $data['search_bitcoins']['search'];
            $lat = $data['search_bitcoins']['lattitude'];
            $lon = $data['search_bitcoins']['longitude'];
            $filter = explode(',', $search_name);
            $country = end($filter);

            $arr_geo_data['country_name'] = $country;
            $arr_geo_data['city'] = $search_name;

            $data['arr_geo_data'] = $arr_geo_data;
        } else {

            if (($_SERVER['REMOTE_ADDR'] == '127.0.0.1') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.1') || ($_SERVER['REMOTE_ADDR'] == '182.72.122.106') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.96')) {
                $ip_address = "182.72.122.106";
            } else {
                $ip_address = $_SERVER['REMOTE_ADDR'];
            }

            $arr_geo_data = geoip_record_by_name($ip_address);

            $lat = trim($arr_geo_data['latitude']);
            $lon = trim($arr_geo_data['longitude']);

            $this->session->userdata('latitude', $lat);
            $country = $arr_geo_data['country_name'];
            $data['arr_geo_data'] = $arr_geo_data;

            $data['search_bitcoins'] = $this->session->userdata('filter');
        }

        $lat = (!empty($lat) ? $lat : 41.3423502);
        $lon = (!empty($lon) ? $lon : -73.0774616);

        /* get trade advertisment details */
        $table_to_pass = 'user_sign_in_log';
        $fields_to_pass = 'log_id,user_id,last_login,last_logout';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_login_details = array();

        //Send array condition with sell_o trade type
        $arr_condition = array(
            "lattitude" => $lat,
            "longitude" => $lon,
            "limit" => 10,
            "trade_type" => "buy_o"
        );
        $arrInfo_sell_o = $this->home_model->getBitcoinsInfo($arr_condition);

        /* API used to get the current market price of BTC */
        $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = @file_get_contents($post_data);
        $currencyRateArr = json_decode($currencyRateArr);

        for ($i = 0; $i < count($arrInfo_sell_o); $i++) {
            foreach ($currencyRateArr as $rateArr) {
                if ($rateArr->code == $arrInfo_sell_o[$i]['currency_code']) {
                    $price_eq_val = $arrInfo_sell_o[$i]['price_eq_val'];
                    $currency_rate = $rateArr->rate;
                    $arrInfo_sell_o[$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                    $arrInfo_sell_o[$i]['local_currency_code'] = $rateArr->code;
                    break;
                }
            }
            /* Get confirmed trade count of user */
            $trade_count = $this->home_model->getConfirmedTradeCount($arrInfo_sell_o[$i]['user_id']);
            $arrInfo_sell_o[$i]['confirmed_trade_count'] = $trade_count;
        }

        $data['arrInfo_sell_o'] = $arrInfo_sell_o;


        //Send array condition with sell_c trade type
        $arr_condition = array(
            "lattitude" => $lat,
            "longitude" => $lon,
            "limit" => 10,
            "trade_type" => "buy_c"
        );
        $arrInfo_sell_c = $this->home_model->getBitcoinsInfo($arr_condition);

        for ($i = 0; $i < count($arrInfo_sell_c); $i++) {
            foreach ($currencyRateArr as $rateArr) {
                if ($rateArr->code == $arrInfo_sell_c[$i]['currency_code']) {
                    $price_eq_val = $arrInfo_sell_c[$i]['price_eq_val'];
                    $currency_rate = $rateArr->rate;
                    $arrInfo_sell_c[$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                    $arrInfo_sell_c[$i]['local_currency_code'] = $rateArr->code;
                }
            }
            /* Get confirmed trade count of user */
            $trade_count = $this->home_model->getConfirmedTradeCount($arrInfo_sell_c[$i]['user_id']);
            $arrInfo_sell_c[$i]['confirmed_trade_count'] = $trade_count;
        }

        $data['arrInfo_sell_c'] = $arrInfo_sell_c;

        /* Include api for google maps */
        $data['include_js'] = implode("\n", array('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>'));

        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        } else {
            $this->load->view('front/includes/dashboard-header-1');
        }
        $this->load->view('front/user-account/sell-bitcoins', $data);
        $this->load->view('front/includes/footer', $flag);
    }

    /* Show bitcoins from selected location with trade type sell only */

    function sellBitcoinsWithCash($pg = '') {

        $this->load->model('common_model');
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');

        /* Get session for search criteria  */
        //$data['search_bitcoins'] = $this->session->userdata('filter');

        $data['title'] = 'Sell bitcoins';

        /* set flag is set for index pageonly to include marcketplace footer */
        $flag['indexFlag'] = '';
        $data['menu_active'] = 'sell_bitcoin';

        /* using the currency model */
        $this->load->model('currency_model');

        if ($this->session->userdata('filter')) {
            $data['search_bitcoins'] = $this->session->userdata('filter');
            $search_name = $data['search_bitcoins']['search'];
            $lat = $data['search_bitcoins']['lattitude'];
            $lon = $data['search_bitcoins']['longitude'];
            $filter = explode(',', $search_name);
            $country = end($filter);
            $arr_geo_data['country_name'] = $country;
            $arr_geo_data['city'] = $search_name;
            $data['arr_geo_data'] = $arr_geo_data;
        } else {
            if (($_SERVER['REMOTE_ADDR'] == '127.0.0.1') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.1') || ($_SERVER['REMOTE_ADDR'] == '182.72.122.106') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.96')) {
                $ip_address = "182.72.122.106";
            } else {
                $ip_address = $_SERVER['REMOTE_ADDR'];
            }
            $arr_geo_data = geoip_record_by_name($ip_address);
            $lat = trim($arr_geo_data['latitude']);
            $lon = trim($arr_geo_data['longitude']);
            $this->session->userdata('latitude', $lat);
            $country = $arr_geo_data['country_name'];
            $data['arr_geo_data'] = $arr_geo_data;
            $data['search_bitcoins'] = $this->session->userdata('filter');
        }


        $lat = (!empty($lat) ? $lat : 41.3423502);
        $lon = (!empty($lon) ? $lon : -73.0774616);

        /* get trade advertisment details */
        $table_to_pass = 'user_sign_in_log';
        $fields_to_pass = 'log_id,user_id,last_login,last_logout';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_login_details = array();


        $data['my_location'] = array('lat' => $lat, 'long' => $lon);

        $my_location_array[] = ("'" . $lat . "," . $lon . "#" . $country . "'");
        $my_location_string = '';
        foreach ($my_location_array as $key => $val) {
            if ($key == count($my_location_array) - 1) {
                $my_location_string.=$val;
            } else {
                $my_location_string.=$val . ",";
            }
        }
        $data['my_location_string'] = $my_location_string;
        $data['address_to_search'] = $arr_geo_data['city'] . "," . $arr_geo_data['country_name'] . "(" . round($lat, 2) . "," . round($lon, 2) . ")";

        /* API used to get the current market price of BTC */
        $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = @file_get_contents($post_data);
        $currencyRateArr = json_decode($currencyRateArr);

        //Send array condition with sell_c trade type
        $arr_condition = array(
            "lattitude" => $lat,
            "longitude" => $lon,
            "trade_type" => "buy_c"
        );
        $arrInfo_sell_c = $this->home_model->getBitcoinsInfoCount($arr_condition);

        /* [Start:: Pagination code] */
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'sell-bitcoins-with-cash';
        $data['count'] = $arrInfo_sell_c;
        $config['total_rows'] = $arrInfo_sell_c;
        $config['per_page'] = $data['global']['per_page_record'];
        $config['cur_page'] = $pg;
        $config['num_links'] = 4;
        $config['cur_tag_open'] = '<strong><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></strong>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<div class="left_scroll_img">';
        $config['prev_tag_close'] = '</div>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<div class="right_scroll_img">';
        $config['next_tag_close'] = '</div>';
        $config['full_tag_open'] = '<div class="last_btn_sec"><div class="pagenBox">';
        $config['full_tag_close'] = '</div></div>';
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $arrayPagination = array("lattitude" => $lat, "longitude" => $lon, "limit" => $config['per_page'], "offset" => $pg, "trade_type" => "buy_c");
        $data['arrInfo_sell_c'] = $this->home_model->getBitcoinsInfo($arrayPagination);
        $data['page'] = $pg;
        /* [End:: Pagination code] */


        for ($i = 0; $i < count($data['arrInfo_sell_c']); $i++) {
            foreach ($currencyRateArr as $rateArr) {
                if ($rateArr->code == $data['arrInfo_sell_c'][$i]['currency_code']) {
                    $price_eq_val = $data['arrInfo_sell_c'][$i]['price_eq_val'];
                    $currency_rate = $rateArr->rate;
                    $data['arrInfo_sell_c'][$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                    $data['arrInfo_sell_c'][$i]['local_currency_code'] = $rateArr->code;
                    $found_location[] = ("'" . $data['arrInfo_sell_c'][$i]['lattitude'] . "," . $data['arrInfo_sell_c'][$i]['longitude'] . "#" . $data['arrInfo_sell_c'][$i]['trade_id'] . "'");
                    break;
                }
            }
            /* Get confirmed trade count of user */
            $trade_count = $this->home_model->getConfirmedTradeCount($data['arrInfo_sell_c'][$i]['user_id']);
            $data['arrInfo_sell_c'][$i]['confirmed_trade_count'] = $trade_count;
        }



        $bitcoins_location_string = '';
        foreach ($found_location as $key => $val) {
            if ($bitcoins_location_string == '') {
                $bitcoins_location_string = $val;
            } else {
                $bitcoins_location_string.="," . $val;
            }
        }

        $data['bitcoins_location_string'] = "[" . $bitcoins_location_string . "]";

        $data['arrInfo_sell_c'] = $data['arrInfo_sell_c'];

        /* Include api for google maps */
        $data['include_js'] = implode("\n", array('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>'));

        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        } else {
            $this->load->view('front/includes/dashboard-header-1');
        }
        $this->load->view('front/user-account/sell-bitcoins-map', $data);
        $this->load->view('front/includes/footer', $flag);
    }

    /* Show bitcoins from selected location with trade type buy only */

    function buyBitcoinsWithCash($pg = '') {

        $this->load->model('common_model');
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');

        $data['title'] = 'Buy bitcoins';

        /* set flag is set for index pageonly to include marcketplace footer */
        $flag['indexFlag'] = '';
        $data['menu_active'] = 'buy_bitcoin';

        /* using the currency model */
        $this->load->model('currency_model');

        if ($this->session->userdata('filter')) {
            $data['search_bitcoins'] = $this->session->userdata('filter');
            $search_name = $data['search_bitcoins']['search'];
            $lat = $data['search_bitcoins']['lattitude'];
            $lon = $data['search_bitcoins']['longitude'];
            $filter = explode(',', $search_name);
            $country = end($filter);
            $arr_geo_data['country_name'] = $country;
            $arr_geo_data['city'] = $search_name;
            $data['arr_geo_data'] = $arr_geo_data;
        } else {
            if (($_SERVER['REMOTE_ADDR'] == '127.0.0.1') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.1') || ($_SERVER['REMOTE_ADDR'] == '182.72.122.106') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.96')) {
                $ip_address = "182.72.122.106";
            } else {
                $ip_address = $_SERVER['REMOTE_ADDR'];
            }
            $arr_geo_data = geoip_record_by_name($ip_address);
            $lat = trim($arr_geo_data['latitude']);
            $lon = trim($arr_geo_data['longitude']);
            $this->session->userdata('latitude', $lat);
            $country = $arr_geo_data['country_name'];
            $data['arr_geo_data'] = $arr_geo_data;
            $data['search_bitcoins'] = $this->session->userdata('filter');
        }


        $lat = (!empty($lat) ? $lat : 41.3423502);
        $lon = (!empty($lon) ? $lon : -73.0774616);

        /* get trade advertisment details */
        $table_to_pass = 'user_sign_in_log';
        $fields_to_pass = 'log_id,user_id,last_login,last_logout';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_login_details = array();


        $data['my_location'] = array('lat' => $lat, 'long' => $lon);

        $my_location_array[] = ("'" . $lat . "," . $lon . "#" . $country . "'");
        $my_location_string = '';
        foreach ($my_location_array as $key => $val) {
            if ($key == count($my_location_array) - 1) {
                $my_location_string.=$val;
            } else {
                $my_location_string.=$val . ",";
            }
        }
        $data['my_location_string'] = $my_location_string;
        $data['address_to_search'] = $arr_geo_data['city'] . "," . $arr_geo_data['country_name'] . "(" . round($lat, 2) . "," . round($lon, 2) . ")";

        /* API used to get the current market price of BTC */
        $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = @file_get_contents($post_data);
        $currencyRateArr = json_decode($currencyRateArr);

        //Send array condition with sell_c trade type
        $arr_condition = array(
            "lattitude" => $lat,
            "longitude" => $lon,
            "trade_type" => "sell_c"
        );
        $arrInfo_buy_c = $this->home_model->getBitcoinsInfoCount($arr_condition);

        /* [Start:: Pagination code] */
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'buy-bitcoins-with-cash';
        $data['count'] = $arrInfo_buy_c;
        $config['total_rows'] = $arrInfo_buy_c;
        $config['per_page'] = $data['global']['per_page_record'];
        $config['cur_page'] = $pg;
        $config['num_links'] = 4;
        $config['cur_tag_open'] = '<strong><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></strong>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<div class="left_scroll_img">';
        $config['prev_tag_close'] = '</div>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<div class="right_scroll_img">';
        $config['next_tag_close'] = '</div>';
        $config['full_tag_open'] = '<div class="last_btn_sec"><div class="pagenBox">';
        $config['full_tag_close'] = '</div></div>';
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $arrayPagination = array("lattitude" => $lat, "longitude" => $lon, "limit" => $config['per_page'], "offset" => $pg, "trade_type" => "sell_c");
        $data['arrInfo_buy_c'] = $this->home_model->getBitcoinsInfo($arrayPagination);
        $data['page'] = $pg;
        /* [End:: Pagination code] */

        for ($i = 0; $i < count($data['arrInfo_buy_c']); $i++) {
            foreach ($currencyRateArr as $rateArr) {
                if ($rateArr->code == $data['arrInfo_buy_c'][$i]['currency_code']) {
                    $price_eq_val = $data['arrInfo_buy_c'][$i]['price_eq_val'];
                    $currency_rate = $rateArr->rate;
                    $data['arrInfo_buy_c'][$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                    $data['arrInfo_buy_c'][$i]['local_currency_code'] = $rateArr->code;
                    $found_location[] = ("'" . $data['arrInfo_buy_c'][$i]['lattitude'] . "," . $data['arrInfo_buy_c'][$i]['longitude'] . "#" . $data['arrInfo_buy_c'][$i]['trade_id'] . "'");
                    break;
                }
            }
            /* Get confirmed trade count of user */
            $trade_count = $this->home_model->getConfirmedTradeCount($data['arrInfo_buy_c'][$i]['user_id']);
            $data['arrInfo_buy_c'][$i]['confirmed_trade_count'] = $trade_count;
        }

        $bitcoins_location_string = '';
        foreach ($found_location as $key => $val) {
            if ($bitcoins_location_string == '') {
                $bitcoins_location_string = $val;
            } else {
                $bitcoins_location_string.="," . $val;
            }
        }

        $data['bitcoins_location_string'] = "[" . $bitcoins_location_string . "]";
        $data['arrInfo_buy_c'] = $data['arrInfo_buy_c'];
        /* Include api for google maps */
        $data['include_js'] = implode("\n", array('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>'));

        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        } else {
            $this->load->view('front/includes/dashboard-header-1');
        }
        $this->load->view('front/user-account/buy-bitcoins-map', $data);
        $this->load->view('front/includes/footer', $flag);
    }

    /* Show bitcoins from selected location with trade type sell only */

    function sellBitcoinsOnline($pg = '') {
        $this->load->model('common_model');
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');

        $data['title'] = 'Sell bitcoins';

        /* set flag is set for index pageonly to include marcketplace footer */
        $flag['indexFlag'] = '';
        $data['menu_active'] = 'sell_bitcoin';

        /* using the currency model */
        $this->load->model('currency_model');

        if ($this->session->userdata('filter')) {
            $data['search_bitcoins'] = $this->session->userdata('filter');
            $search_name = $data['search_bitcoins']['search'];
            $lat = $data['search_bitcoins']['lattitude'];
            $lon = $data['search_bitcoins']['longitude'];
            $filter = explode(',', $search_name);
            $country = end($filter);

            $arr_geo_data['country_name'] = $country;
            $arr_geo_data['city'] = $search_name;

            $data['arr_geo_data'] = $arr_geo_data;
        } else {
            if (($_SERVER['REMOTE_ADDR'] == '127.0.0.1') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.1') || ($_SERVER['REMOTE_ADDR'] == '182.72.122.106') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.96')) {
                $ip_address = "182.72.122.106";
            } else {
                $ip_address = $_SERVER['REMOTE_ADDR'];
            }
            $arr_geo_data = geoip_record_by_name($ip_address);

            $lat = trim($arr_geo_data['latitude']);
            $lon = trim($arr_geo_data['longitude']);

            $this->session->userdata('latitude', $lat);
            $country = $arr_geo_data['country_name'];
            $data['arr_geo_data'] = $arr_geo_data;
            $data['search_bitcoins'] = $this->session->userdata('filter');
        }

        $lat = (!empty($lat) ? $lat : 41.3423502);
        $lon = (!empty($lon) ? $lon : -73.0774616);

        /* get trade advertisment details */
        $table_to_pass = 'user_sign_in_log';
        $fields_to_pass = 'log_id,user_id,last_login,last_logout';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_login_details = array();

        /* API used to get the current market price of BTC */
        $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = @file_get_contents($post_data);
        $currencyRateArr = json_decode($currencyRateArr);

        //Send array condition with sell_o trade type
        $arr_condition = array(
            "lattitude" => $lat,
            "longitude" => $lon,
            "trade_type" => "buy_o"
        );
        /* Get count only for pagination purpose */
        $arrInfo_sell_o = $this->home_model->getBitcoinsInfoCount($arr_condition);

        /* [Start:: Pagination code] */
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'sell-bitcoins-online';
        $data['count'] = $arrInfo_sell_o;
        $config['total_rows'] = $arrInfo_sell_o;
        $config['per_page'] = $data['global']['per_page_record'];
        $config['cur_page'] = $pg;
        $config['num_links'] = 4;
        $config['cur_tag_open'] = '<strong><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></strong>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<div class="left_scroll_img">';
        $config['prev_tag_close'] = '</div>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<div class="right_scroll_img">';
        $config['next_tag_close'] = '</div>';
        $config['full_tag_open'] = '<div class="last_btn_sec"><div class="pagenBox">';
        $config['full_tag_close'] = '</div></div>';
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $arrayPagination = array("lattitude" => $lat, "longitude" => $lon, "limit" => $config['per_page'], "offset" => $pg, "trade_type" => "buy_o");
        $data['arrInfo_sell_o'] = $this->home_model->getBitcoinsInfo($arrayPagination);
        $data['page'] = $pg;
        /* [End:: Pagination code] */

        for ($i = 0; $i < count($data['arrInfo_sell_o']); $i++) {
            foreach ($currencyRateArr as $rateArr) {
                if ($rateArr->code == $data['arrInfo_sell_o'][$i]['currency_code']) {
                    $price_eq_val = $data['arrInfo_sell_o'][$i]['price_eq_val'];
                    $currency_rate = $rateArr->rate;
                    $data['arrInfo_sell_o'][$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                    $data['arrInfo_sell_o'][$i]['local_currency_code'] = $rateArr->code;
                    break;
                }
            }
            /* Get confirmed trade count of user */
            $trade_count = $this->home_model->getConfirmedTradeCount($data['arrInfo_sell_o'][$i]['user_id']);
            $data['arrInfo_sell_o'][$i]['confirmed_trade_count'] = $trade_count;
        }

        $data['arrInfo_sell_o'] = $data['arrInfo_sell_o'];


        /* Include api for google maps */
        $data['include_js'] = implode("\n", array('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>'));

        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        } else {
            $this->load->view('front/includes/dashboard-header-1');
        }
        $this->load->view('front/user-account/sell-bitcoins-online', $data);
        $this->load->view('front/includes/footer', $flag);
    }

    /* Show bitcoins from selected location with trade type buy only */

    function buyBitcoinsOnline($pg = '') {

        $this->load->model('common_model');
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');

        $data['title'] = 'Buy bitcoins';

        /* set flag is set for index pageonly to include marcketplace footer */
        $flag['indexFlag'] = '';
        $data['menu_active'] = 'buy_bitcoin';

        /* using the currency model */
        $this->load->model('currency_model');

        if ($this->session->userdata('filter')) {

            $data['search_bitcoins'] = $this->session->userdata('filter');

            $search_name = $data['search_bitcoins']['search'];
            $lat = $data['search_bitcoins']['lattitude'];
            $lon = $data['search_bitcoins']['longitude'];
            $filter = explode(',', $search_name);
            $country = end($filter);

            $arr_geo_data['country_name'] = $country;
            $arr_geo_data['city'] = $search_name;

            $data['arr_geo_data'] = $arr_geo_data;
        } else {

            if (($_SERVER['REMOTE_ADDR'] == '127.0.0.1') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.1') || ($_SERVER['REMOTE_ADDR'] == '182.72.122.106') || ($_SERVER['REMOTE_ADDR'] == '192.168.2.96')) {
                $ip_address = "182.72.122.106";
            } else {
                $ip_address = $_SERVER['REMOTE_ADDR'];
            }

            $arr_geo_data = geoip_record_by_name($ip_address);

            $lat = trim($arr_geo_data['latitude']);
            $lon = trim($arr_geo_data['longitude']);

            $this->session->userdata('latitude', $lat);
            $country = $arr_geo_data['country_name'];
            $data['arr_geo_data'] = $arr_geo_data;

            $data['search_bitcoins'] = $this->session->userdata('filter');
        }

        $lat = (!empty($lat) ? $lat : 41.3423502);
        $lon = (!empty($lon) ? $lon : -73.0774616);

        /* get trade advertisment details */
        $table_to_pass = 'user_sign_in_log';
        $fields_to_pass = 'log_id,user_id,last_login,last_logout';
        $condition_to_pass = array("user_id" => $data['user_session']['user_id']);
        $arr_user_login_details = array();

        /* API used to get the current market price of BTC */
        $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = @file_get_contents($post_data);
        $currencyRateArr = json_decode($currencyRateArr);

        //Send array condition with buy_o trade type
        $arr_condition = array(
            "lattitude" => $lat,
            "longitude" => $lon,
            "trade_type" => "sell_o"
        );
        $arrInfo_buy_o = $this->home_model->getBitcoinsInfoCount($arr_condition);

        /* [Start:: Pagination code] */
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'buy-bitcoins-online';
        $data['count'] = $arrInfo_buy_o;
        $config['total_rows'] = $arrInfo_buy_o;
        $config['per_page'] = $data['global']['per_page_record'];
        $config['cur_page'] = $pg;
        $config['num_links'] = 4;
        $config['cur_tag_open'] = '<strong><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></strong>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<div class="left_scroll_img">';
        $config['prev_tag_close'] = '</div>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<div class="right_scroll_img">';
        $config['next_tag_close'] = '</div>';
        $config['full_tag_open'] = '<div class="last_btn_sec"><div class="pagenBox">';
        $config['full_tag_close'] = '</div></div>';
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $arrayPagination = array("lattitude" => $lat, "longitude" => $lon, "limit" => $config['per_page'], "offset" => $pg, "trade_type" => "sell_o");
        $data['arrInfo_buy_o'] = $this->home_model->getBitcoinsInfo($arrayPagination);
        $data['page'] = $pg;
        /* [End:: Pagination code] */

        for ($i = 0; $i < count($data['arrInfo_buy_o']); $i++) {
            foreach ($currencyRateArr as $rateArr) {
                if ($rateArr->code == $data['arrInfo_buy_o'][$i]['currency_code']) {
                    $price_eq_val = $data['arrInfo_buy_o'][$i]['price_eq_val'];
                    $currency_rate = $rateArr->rate;
                    $data['arrInfo_buy_o'][$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                    $data['arrInfo_buy_o'][$i]['local_currency_code'] = $rateArr->code;
                    break;
                }
            }
            /* Get confirmed trade count of user */
            $trade_count = $this->home_model->getConfirmedTradeCount($data['arrInfo_buy_o'][$i]['user_id']);
            $data['arrInfo_buy_o'][$i]['confirmed_trade_count'] = $trade_count;
        }

        $data['arrInfo_buy_o'] = $data['arrInfo_buy_o'];

        /* Include api for google maps */
        $data['include_js'] = implode("\n", array('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>'));

        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        } else {
            $this->load->view('front/includes/dashboard-header-1');
        }
        $this->load->view('front/user-account/buy-bitcoins-online', $data);
        $this->load->view('front/includes/footer', $flag);
    }

    /* Lookup for bitcoins by country name */

    function lookUpBitcoins($lookup) {

        $this->load->model('common_model');
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['title'] = 'Home';

        /* set flag is set for index pageonly to include marcketplace footer */
        $flag['indexFlag'] = '';
        $data['menu_active'] = 'home';

        $arr_geo_data['country_name'] = $lookup;

        $data['arr_geo_data'] = $arr_geo_data;

        $geocode_stats = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=" . $lookup . "&sensor=false");

        $output_deals = json_decode($geocode_stats);

        $latLng = $output_deals->results[0]->geometry->location;

        $lat = $latLng->lat;
        $lon = $latLng->lng;



        //Send array condition with buy_o trade type
        $arr_condition = array(
            "lattitude" => $lat,
            "longitude" => $lon,
            "limit" => 10,
            "trade_type" => "buy_o",
        );
        $arrInfo_buy_o = $this->home_model->getBitcoinsInfo($arr_condition);
        /* API used to get the current market price of BTC */
        $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = @file_get_contents($post_data);
        $currencyRateArr = json_decode($currencyRateArr);

        for ($i = 0; $i < count($arrInfo_buy_o); $i++) {
            foreach ($currencyRateArr as $rateArr) {
                if ($rateArr->code == $arrInfo_buy_o[$i]['currency_code']) {
                    $price_eq_val = $arrInfo_buy_o[$i]['price_eq_val'];
                    $currency_rate = $rateArr->rate;
                    $arrInfo_buy_o[$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                    $arrInfo_buy_o[$i]['local_currency_code'] = $rateArr->code;
                    break;
                }
            }
            /* Get confirmed trade count of user */
            $trade_count = $this->home_model->getConfirmedTradeCount($arrInfo_buy_o[$i]['user_id']);
            $arrInfo_buy_o[$i]['confirmed_trade_count'] = $trade_count;
        }

        $data['arrInfo_buy_o'] = $arrInfo_buy_o;

        //Send array condition with sell_o trade type
        $arr_condition = array(
            "lattitude" => $lat,
            "longitude" => $lon,
            "limit" => 10,
            "trade_type" => "sell_o",
        );
        $arrInfo_sell_o = $this->home_model->getBitcoinsInfo($arr_condition);

        for ($i = 0; $i < count($arrInfo_sell_o); $i++) {
            foreach ($currencyRateArr as $rateArr) {
                if ($rateArr->code == $arrInfo_sell_o[$i]['currency_code']) {
                    $price_eq_val = $arrInfo_sell_o[$i]['price_eq_val'];
                    $currency_rate = $rateArr->rate;
                    $arrInfo_sell_o[$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                    $arrInfo_sell_o[$i]['local_currency_code'] = $rateArr->code;
                }
            }
            /* Get confirmed trade count of user */
            $trade_count = $this->home_model->getConfirmedTradeCount($arrInfo_sell_o[$i]['user_id']);
            $arrInfo_sell_o[$i]['confirmed_trade_count'] = $trade_count;
        }

        $data['arrInfo_sell_o'] = $arrInfo_sell_o;

        $data['include_js'] = implode("\n", array('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>'));

        /* Load view */
        $this->load->view('front/includes/header', $data);
        /* [Start:: Checked user is logged in or not] */
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        } else {
            $this->load->view('front/includes/dashboard-header-1');
        }
        $this->load->view('lookup-bitcoins', $data);
        $this->load->view('front/includes/footer', $flag);
    }

    /* Buy Bitcoin trade ads by payment method wise */

    public function buyBitcoinsOnlinePaymentMethod($payment_method_url = '', $currency = '', $pg = 0) {

        /* multi language keywords file */
        $this->load->language('common');

        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['menu_active'] = "";
        $this->load->model("user_model");

        /* get online payment method details */
        $table = 'payment_method';
        $fields = 'method_id,method_name,method_url';
        $condition = array('status' => 'A', 'parent_method_id' => '1');
        $data['payment_details_online'] = $this->common_model->getRecords($table, $fields, $condition, $order_by = 'method_id', $limit = '', $debug = 0);

        /* Get details of payment method url */
        $this->load->model("payment_model");
        $arr_payment_method_data = $this->payment_model->getCategories("method_id,method_name", array("method_url" => $payment_method_url), "", "", 0);
        $data['arr_payment_method_data'] = $arr_payment_method_data[0];

        /* Buy bitcoins online details payment method wise */
        $arr_condition = array(
            "lattitude" => "",
            "longitude" => "",
            "currency" => $currency,
            "method_url" => $payment_method_url,
            "trade_type" => "sell_o",
        );
        $arrInfo_buySell_o_payment_method = $this->home_model->getBitcoinsInfoCount($arr_condition);

        /* [Start:: Pagination code] */
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'buy-bitcoins-online/' . $payment_method_url;
        $data['count'] = $arrInfo_buySell_o_payment_method;
        $config['total_rows'] = $arrInfo_buySell_o_payment_method;
        $config['per_page'] = $data['global']['per_page_record'];
        $config['cur_page'] = $pg;
        $config['num_links'] = 4;
        $config['cur_tag_open'] = '<strong><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></strong>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<div class="left_scroll_img">';
        $config['prev_tag_close'] = '</div>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<div class="right_scroll_img">';
        $config['next_tag_close'] = '</div>';
        $config['full_tag_open'] = '<div class="last_btn_sec"><div class="pagenBox">';
        $config['full_tag_close'] = '</div></div>';
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $arrayPagination = array("limit" => $config['per_page'], "offset" => $pg, "lattitude" => "", "longitude" => "", "currency" => $currency, "trade_type" => "sell_o", "method_url" => $payment_method_url);
        $data['arrInfo_buySell_o_payment_method'] = $this->home_model->getBitcoinsInfo($arrayPagination);
        $data['page'] = $pg;
        /* [End:: Pagination code] */

        /* API used to get the current market price of BTC */
        $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = @file_get_contents($post_data);
        $currencyRateArr = json_decode($currencyRateArr);

        for ($i = 0; $i < count($data['arrInfo_buySell_o_payment_method']); $i++) {
            foreach ($currencyRateArr as $rateArr) {
                if ($rateArr->code == $data['arrInfo_buySell_o_payment_method'][$i]['currency_code']) {
                    $price_eq_val = $data['arrInfo_buySell_o_payment_method'][$i]['price_eq_val'];
                    $currency_rate = $rateArr->rate;
                    $data['arrInfo_buySell_o_payment_method'][$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                    $data['arrInfo_buySell_o_payment_method'][$i]['local_currency_code'] = $rateArr->code;
                    break;
                }
            }
            /* Get confirmed trade count of user */
            $trade_count = $this->home_model->getConfirmedTradeCount($data['arrInfo_buySell_o_payment_method'][$i]['user_id']);
            $data['arrInfo_buySell_o_payment_method'][$i]['confirmed_trade_count'] = $trade_count;
        }

        $data['trade_type'] = 'buy-bitcoins-online';

        /* Load view */
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        } else {
            $this->load->view('front/includes/dashboard-header-1');
        }
        $this->load->view('payment-method-wise-ads', $data);
        $this->load->view('front/includes/footer');
    }

    /* Buy Bitcoin trade ads by payment method wise */

    public function sellBitcoinsOnlinePaymentMethod($payment_method_url = '', $pg = 0) {

        /* multi language keywords file */
        $this->load->language('common');

        /* Load session values */
        $data = $this->common_model->commonFunction();
        $data['user_session'] = $this->session->userdata('user_account');
        $data['menu_active'] = "";
        $this->load->model("user_model");

        /* get online payment method details */
        $table = 'payment_method';
        $fields = 'method_id,method_name,method_url';
        $condition = array('status' => 'A', 'parent_method_id' => '1');
        $data['payment_details_online'] = $this->common_model->getRecords($table, $fields, $condition, $order_by = 'method_id', $limit = '', $debug = 0);

        /* Get details of payment method url */
        $this->load->model("payment_model");
        $arr_payment_method_data = $this->payment_model->getCategories("method_id,method_name", array("method_url" => $payment_method_url), "", "", 0);
        $data['arr_payment_method_data'] = $arr_payment_method_data[0];

        /* Buy bitcoins online details payment method wise */
        $arr_condition = array(
            "lattitude" => "",
            "longitude" => "",
            "method_url" => $payment_method_url,
            "trade_type" => "buy_o",
        );
        $arrInfo_buySell_o_payment_method = $this->home_model->getBitcoinsInfoCount($arr_condition);

        /* [Start:: Pagination code] */
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'sell-bitcoins-online/' . $payment_method_url;
        $data['count'] = $arrInfo_buySell_o_payment_method;
        $config['total_rows'] = $arrInfo_buySell_o_payment_method;
        $config['per_page'] = $data['global']['per_page_record'];
        $config['cur_page'] = $pg;
        $config['num_links'] = 4;
        $config['cur_tag_open'] = '<strong><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></strong>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<div class="left_scroll_img">';
        $config['prev_tag_close'] = '</div>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<div class="right_scroll_img">';
        $config['next_tag_close'] = '</div>';
        $config['full_tag_open'] = '<div class="last_btn_sec"><div class="pagenBox">';
        $config['full_tag_close'] = '</div></div>';
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $arrayPagination = array("limit" => $config['per_page'], "offset" => $pg, "lattitude" => "", "longitude" => "", "trade_type" => "buy_o", "method_url" => $payment_method_url);
        $data['arrInfo_buySell_o_payment_method'] = $this->home_model->getBitcoinsInfo($arrayPagination);
        $data['page'] = $pg;
        /* [End:: Pagination code] */

        /* API used to get the current market price of BTC */
        $post_data = "https://bitpay.com/api/rates";
        $currencyRateArr = @file_get_contents($post_data);
        $currencyRateArr = json_decode($currencyRateArr);

        for ($i = 0; $i < count($data['arrInfo_buySell_o_payment_method']); $i++) {
            foreach ($currencyRateArr as $rateArr) {
                if ($rateArr->code == $data['arrInfo_buySell_o_payment_method'][$i]['currency_code']) {
                    $price_eq_val = $data['arrInfo_buySell_o_payment_method'][$i]['price_eq_val'];
                    $currency_rate = $rateArr->rate;
                    $data['arrInfo_buySell_o_payment_method'][$i]['local_currency_rate'] = ((($currency_rate * 100) * $price_eq_val) / 100);
                    $data['arrInfo_buySell_o_payment_method'][$i]['local_currency_code'] = $rateArr->code;
                    break;
                }
            }
            /* Get confirmed trade count of user */
            $trade_count = $this->home_model->getConfirmedTradeCount($data['arrInfo_buySell_o_payment_method'][$i]['user_id']);
            $data['arrInfo_buySell_o_payment_method'][$i]['confirmed_trade_count'] = $trade_count;
        }

        $data['trade_type'] = 'sell-bitcoins-online';

        /* Load view */
        $this->load->view('front/includes/header', $data);
        if ($this->session->userdata('user_account')) {
            $this->load->view('front/includes/dashboard-header');
        } else {
            $this->load->view('front/includes/dashboard-header-1');
        }
        $this->load->view('payment-method-wise-ads', $data);
        $this->load->view('front/includes/footer');
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
