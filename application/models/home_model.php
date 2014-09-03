<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_Model extends CI_Model {
    /*
     * Function to get all slider banner which is set by actve by an admin by language id
     */

    public function getSliderForFrontPage($lang_id = '17') {
        $this->db->select('*');
        $this->db->from('mst_sliders as slider');
        $this->db->join('mst_languages as lang', 'lang.lang_id= slider.lang_id', 'inner');
        $this->db->join('trans_slider_banner_effects  as effect', 'effect.slider_banner_effects_id=slider.slider_effect_id_fk', 'inner');
        $this->db->where('slider.slider_status', 'Active');
        $this->db->where('slider.lang_id', $lang_id);
        $result = $this->db->get();
        return $result->result_array();
    }

    /*
     * Function to get all slider banner onject by slider id
     */

    public function getAllSliderBannerObjects($date, $slider_id) {
        $this->db->select('*');
        $this->db->from('trans_slider_banner_objects as slider_banner');
        $this->db->join('mst_sliders as slider', 'slider.slider_id=slider_banner.slider_id_fk', 'inner');
        $this->db->join('trans_slider_widths_heights  as width_height', 'width_height.slider_widths_heights_id=slider.slider_width_height_fk', 'inner');
        $this->db->where('slider_id_fk', $slider_id);
        $this->db->where("(str_to_date(banner_object_start_date,'%Y-%m-%d')<='" . $date . "' and str_to_date(banner_object_end_date,'%Y-%m-%d')>='" . $date . "')");
        $result = $this->db->get();
        return $result->result_array();
    }

    
	/* Get bitcoins details add */

    public function getBitcoinsInfo($arr_condition) {

        $query = "SELECT T.trade_id,T.user_id,T.status,T.other_information,T.created_on,T.price_eq,T.price_eq_val,T.min_amount,T.max_amount,T.trade_type,U.user_name,P.method_name,P.method_url,
				 C.currency_code, G.geo_location_id,G.location, G.lattitude , G.longitude ,
		( 3959 * acos( cos( radians('" . mysql_real_escape_string($arr_condition['lattitude']) . "') ) * cos( radians( G.lattitude ) ) * cos( radians( G.longitude ) - radians('" . mysql_real_escape_string($arr_condition['longitude']) . "') ) + sin( radians('" . mysql_real_escape_string($arr_condition['lattitude']) . "') ) * sin( radians( G.lattitude ) ) ) ) * 1.609344 AS distance 
		FROM " . $this->db->dbprefix . "mst_trades as T 
		INNER JOIN " . $this->db->dbprefix . "payment_method as P ON T.payment_method_id = P.method_id 
		INNER JOIN " . $this->db->dbprefix . "mst_users as U ON T.user_id = U.user_id 
		INNER JOIN " . $this->db->dbprefix . "geo_location as G ON T.geo_location_id = G.geo_location_id 
		INNER JOIN " . $this->db->dbprefix . "currency_management as C ON T.currency_id = C.currency_id
		WHERE T.status='A'";

        /* If trade type then */
        if (isset($arr_condition['trade_type']) && $arr_condition['trade_type'] != "") {
            if (strpos("WHERE", $query) < 1) {
                $query .=" AND T.trade_type = '" . mysql_real_escape_string($arr_condition['trade_type']) . "' ";
            } else {
                $query .=" WHERE T.trade_type = '" . mysql_real_escape_string($arr_condition['trade_type']) . "' ";
            }
        }
		
		/* If method_url then */
        if (isset($arr_condition['method_url']) && $arr_condition['method_url'] != "") {
            if (strpos("WHERE", $query) < 1) {
                $query .=" AND P.method_url = '" . mysql_real_escape_string($arr_condition['method_url']) . "' ";
            } else {
                $query .=" WHERE P.method_url = '" . mysql_real_escape_string($arr_condition['method_url']) . "' ";
            }
        }
		
		/* If user_id then */
        if (isset($arr_condition['user_id']) && $arr_condition['user_id'] != "") {
            if (strpos("WHERE", $query) < 1) {
                $query .=" AND T.user_id = '" . mysql_real_escape_string($arr_condition['user_id']) . "' ";
            } else {
                $query .=" WHERE T.user_id = '" . mysql_real_escape_string($arr_condition['user_id']) . "' ";
            }
        }

        /*  If Payment method is added by user this will append query */
        if (isset($arr_condition['payment_type']) && $arr_condition['payment_type'] != "") {
			if(($arr_condition['payment_type'] != '3') && ($arr_condition['payment_type'] != '19')) {
				if (strpos("WHERE", $query) < 1) {
					$query .=" AND T.payment_method_id ='" . mysql_real_escape_string($arr_condition['payment_type']) . "'";
				} else {
					$query .=" WHERE T.payment_method_id ='" . mysql_real_escape_string($arr_condition['payment_type']) . "'";
				}
			}
        }

        /*  If trade amount is added by user this will append query */
        if (isset($arr_condition['amount']) && $arr_condition['amount'] != "") {
            if (strpos("WHERE", $query) < 1) {
                $query .=" AND T.min_amount <='" . mysql_real_escape_string($arr_condition['amount']) . "' AND T.max_amount >='" . mysql_real_escape_string($arr_condition['amount']) . "'";
            } else {
                $query .=" WHERE T.min_amount <='" . mysql_real_escape_string($arr_condition['amount']) . "' AND T.max_amount >='" . mysql_real_escape_string($arr_condition['amount']) . "'";
            }
        }
		
		/*  If Payment method is added by user this will append query */
        if (isset($arr_condition['currency']) && $arr_condition['currency'] != "") {
			if (strpos("WHERE", $query) < 1) {
				$query .=" AND T.currency_id ='" . mysql_real_escape_string($arr_condition['currency']) . "'";
			} else {
				$query .=" WHERE T.currency_id ='" . mysql_real_escape_string($arr_condition['currency']) . "'";
			}
        }
		

        /* Order by distance */
        $query .=" order by distance ";
        
        if (isset($arr_condition['limit']) && $arr_condition['limit'] != "") {
            $query .=" limit " . $arr_condition['limit'] . " ";
        }
        
         if (isset($arr_condition['offset']) && isset($arr_condition['limit']) && $arr_condition['offset'] != "") {
            $query .=" , " . $arr_condition['offset'] . " ";
        }

        $result = $this->db->query($query);
		//echo $this->db->last_query();
        return $result->result_array();
    }
	
	/* Get count of query for pagination */
	public function getBitcoinsInfoCount($arr_condition) {

        $query = "SELECT T.trade_id,T.user_id,T.status,T.other_information,T.price_eq,T.price_eq_val,T.created_on,T.min_amount,T.max_amount,T.trade_type,U.user_name,P.method_name,P.method_url,
				 C.currency_code, G.geo_location_id,G.location, G.lattitude , G.longitude ,
		( 3959 * acos( cos( radians('" . mysql_real_escape_string($arr_condition['lattitude']) . "') ) * cos( radians( G.lattitude ) ) * cos( radians( G.longitude ) - radians('" . mysql_real_escape_string($arr_condition['longitude']) . "') ) + sin( radians('" . mysql_real_escape_string($arr_condition['lattitude']) . "') ) * sin( radians( G.lattitude ) ) ) ) * 1.609344 AS distance 
		FROM " . $this->db->dbprefix . "mst_trades as T 
		INNER JOIN " . $this->db->dbprefix . "payment_method as P ON T.payment_method_id = P.method_id 
		INNER JOIN " . $this->db->dbprefix . "mst_users as U ON T.user_id = U.user_id 
		INNER JOIN " . $this->db->dbprefix . "geo_location as G ON T.geo_location_id = G.geo_location_id 
		INNER JOIN " . $this->db->dbprefix . "currency_management as C ON T.currency_id = C.currency_id
		WHERE T.status='A'";

        /* If trade type then */
        if (isset($arr_condition['trade_type']) && $arr_condition['trade_type'] != "") {
            if (strpos("WHERE", $query) < 1) {
                $query .=" AND T.trade_type = '" . mysql_real_escape_string($arr_condition['trade_type']) . "' ";
            } else {
                $query .=" WHERE T.trade_type = '" . mysql_real_escape_string($arr_condition['trade_type']) . "' ";
            }
        }
		
		/* If method_url then */
        if (isset($arr_condition['method_url']) && $arr_condition['method_url'] != "") {
            if (strpos("WHERE", $query) < 1) {
                $query .=" AND P.method_url = '" . mysql_real_escape_string($arr_condition['method_url']) . "' ";
            } else {
                $query .=" WHERE P.method_url = '" . mysql_real_escape_string($arr_condition['method_url']) . "' ";
            }
        }
		
		/* If user_id then */
        if (isset($arr_condition['user_id']) && $arr_condition['user_id'] != "") {
            if (strpos("WHERE", $query) < 1) {
                $query .=" AND T.user_id = '" . mysql_real_escape_string($arr_condition['user_id']) . "' ";
            } else {
                $query .=" WHERE T.user_id = '" . mysql_real_escape_string($arr_condition['user_id']) . "' ";
            }
        }

        /*  If trade amount is added by user this will append query */
        if (isset($arr_condition['amount']) && $arr_condition['amount'] != "") {
            if (strpos("WHERE", $query) < 1) {
                $query .=" AND T.min_amount <='" . mysql_real_escape_string($arr_condition['amount']) . "' AND T.max_amount >='" . mysql_real_escape_string($arr_condition['amount']) . "'";
            } else {
                $query .=" WHERE T.min_amount <='" . mysql_real_escape_string($arr_condition['amount']) . "' AND T.max_amount >='" . mysql_real_escape_string($arr_condition['amount']) . "'";
            }
        }
		
		/*  If Payment method is added by user this will append query */
        if (isset($arr_condition['payment_type']) && $arr_condition['payment_type'] != "") {
			if(($arr_condition['payment_type'] != '3') && ($arr_condition['payment_type'] != '19')) {
				if (strpos("WHERE", $query) < 1) {
					$query .=" AND T.payment_method_id ='" . mysql_real_escape_string($arr_condition['payment_type']) . "'";
				} else {
					$query .=" WHERE T.payment_method_id ='" . mysql_real_escape_string($arr_condition['payment_type']) . "'";
				}
			}
        }
		
		/*  If Payment method is added by user this will append query */
        if (isset($arr_condition['currency']) && $arr_condition['currency'] != "") {
			if (strpos("WHERE", $query) < 1) {
				$query .=" AND T.currency_id ='" . mysql_real_escape_string($arr_condition['currency']) . "'";
			} else {
				$query .=" WHERE T.currency_id ='" . mysql_real_escape_string($arr_condition['currency']) . "'";
			}
        }
		

        /* Order by distance */
        $query .=" order by distance ";
        
        if (isset($arr_condition['limit']) && $arr_condition['limit'] != "") {
            $query .=" limit " . $arr_condition['limit'] . " ";
        }
        
         if (isset($arr_condition['offset']) && isset($arr_condition['limit']) && $arr_condition['offset'] != "") {
            $query .=" , " . $arr_condition['offset'] . " ";
        }

        $result = $this->db->query($query);
        return $result->num_rows();
    }
	
	
	/* Get latest updated sell bitcoins ads */
	public function getLatestBitcoinSellAds() {

        $this->db->select('T.trade_id,T.status,T.created_on,T.trade_type,U.user_name,P.method_name,P.method_url,G.geo_location_id,G.city,G.location,G.region,G.country');

        $this->db->from('mst_trades as T');
        $this->db->join('payment_method as P', 'T.payment_method_id = P.method_id', 'inner');
        $this->db->join('mst_users as U', 'T.user_id = U.user_id', 'inner');
        $this->db->join('geo_location as G', 'T.geo_location_id = G.geo_location_id', 'inner');

		$this->db->where_in("T.status", 'A');
		
		$trade_type = array('sell_o', 'sell_c');
        $this->db->where_in("T.trade_type", $trade_type);
		
        $this->db->order_by('T.created_on DESC');
		$this->db->limit(5);
        $result = $this->db->get();
        return $result->result_array();
    }
	
	public function getConfirmedTradeCount($user_id = '', $debug_to_pass = '') {
        $this->db->select('txn.transaction_id,txn.transaction_status,txn.buyer_id,txn.seller_id');
        $this->db->from('buy_sell_transaction as txn');
		
        if ($user_id != '') {            
			$this->db->where("txn.transaction_status", 'released');
			$this->db->where("(txn.buyer_id = $user_id || txn.seller_id = $user_id)");
		}

        $result = $this->db->get();

        if ($debug_to_pass)
            echo $this->db->last_query();

        return $result->num_rows();
    }
	
	
	
	public function getBitcoinsTradeInfo($arr_condition) {

        $query = "SELECT T.trade_id,T.status,T.other_information,T.created_on,T.min_amount,T.max_amount,T.trade_type,U.user_name,P.method_name,P.method_url,
				 C.currency_code, G.geo_location_id,G.location, G.lattitude , G.longitude 
		FROM " . $this->db->dbprefix . "mst_trades as T 
		INNER JOIN " . $this->db->dbprefix . "payment_method as P ON T.payment_method_id = P.method_id 
		INNER JOIN " . $this->db->dbprefix . "mst_users as U ON T.user_id = U.user_id 
		INNER JOIN " . $this->db->dbprefix . "geo_location as G ON T.geo_location_id = G.geo_location_id 
		INNER JOIN " . $this->db->dbprefix . "currency_management as C ON T.currency_id = C.currency_id
		WHERE T.status='A'";

        /* If trade type then */
        if (isset($arr_condition['trade_type']) && $arr_condition['trade_type'] != "") {
            if (strpos("WHERE", $query) < 1) {
                $query .=" AND T.trade_type = '" . mysql_real_escape_string($arr_condition['trade_type']) . "' ";
            } else {
                $query .=" WHERE T.trade_type = '" . mysql_real_escape_string($arr_condition['trade_type']) . "' ";
            }
        }
		
		/* If method_url then */
        if (isset($arr_condition['method_url']) && $arr_condition['method_url'] != "") {
            if (strpos("WHERE", $query) < 1) {
                $query .=" AND P.method_url = '" . mysql_real_escape_string($arr_condition['method_url']) . "' ";
            } else {
                $query .=" WHERE P.method_url = '" . mysql_real_escape_string($arr_condition['method_url']) . "' ";
            }
        }
		
		/* If user_id then */
        if (isset($arr_condition['user_id']) && $arr_condition['user_id'] != "") {
            if (strpos("WHERE", $query) < 1) {
                $query .=" AND T.user_id = '" . mysql_real_escape_string($arr_condition['user_id']) . "' ";
            } else {
                $query .=" WHERE T.user_id = '" . mysql_real_escape_string($arr_condition['user_id']) . "' ";
            }
        }

        /*  If Payment method is added by user this will append query */
        if (isset($arr_condition['payment_type']) && $arr_condition['payment_type'] != "") {
			if(($arr_condition['payment_type'] != '3') && ($arr_condition['payment_type'] != '19')) {
				if (strpos("WHERE", $query) < 1) {
					$query .=" AND T.payment_method_id ='" . mysql_real_escape_string($arr_condition['payment_type']) . "'";
				} else {
					$query .=" WHERE T.payment_method_id ='" . mysql_real_escape_string($arr_condition['payment_type']) . "'";
				}
			}
        }

        /*  If trade amount is added by user this will append query */
        if (isset($arr_condition['amount']) && $arr_condition['amount'] != "") {
            if (strpos("WHERE", $query) < 1) {
                $query .=" AND T.min_amount <='" . mysql_real_escape_string($arr_condition['amount']) . "' AND T.max_amount >='" . mysql_real_escape_string($arr_condition['amount']) . "'";
            } else {
                $query .=" WHERE T.min_amount <='" . mysql_real_escape_string($arr_condition['amount']) . "' AND T.max_amount >='" . mysql_real_escape_string($arr_condition['amount']) . "'";
            }
        }
		
		/*  If Payment method is added by user this will append query */
        if (isset($arr_condition['currency']) && $arr_condition['currency'] != "") {
			if (strpos("WHERE", $query) < 1) {
				$query .=" AND T.currency_id ='" . mysql_real_escape_string($arr_condition['currency']) . "'";
			} else {
				$query .=" WHERE T.currency_id ='" . mysql_real_escape_string($arr_condition['currency']) . "'";
			}
        }
		

        /* Order by distance */
        $query .=" order by T.created_on ";
        
        if (isset($arr_condition['limit']) && $arr_condition['limit'] != "") {
            $query .=" limit " . $arr_condition['limit'] . " ";
        }
        
         if (isset($arr_condition['offset']) && isset($arr_condition['limit']) && $arr_condition['offset'] != "") {
            $query .=" , " . $arr_condition['offset'] . " ";
        }

        $result = $this->db->query($query);
		//echo $this->db->last_query();
        return $result->result_array();
    }
	
	public function getBitcoinsTradeInfoCount($arr_condition) {

        $query = "SELECT T.trade_id,T.status,T.other_information,T.created_on,T.min_amount,T.max_amount,T.trade_type,U.user_name,P.method_name,P.method_url,
				 C.currency_code, G.geo_location_id,G.location, G.lattitude , G.longitude 
		FROM " . $this->db->dbprefix . "mst_trades as T 
		INNER JOIN " . $this->db->dbprefix . "payment_method as P ON T.payment_method_id = P.method_id 
		INNER JOIN " . $this->db->dbprefix . "mst_users as U ON T.user_id = U.user_id 
		INNER JOIN " . $this->db->dbprefix . "geo_location as G ON T.geo_location_id = G.geo_location_id 
		INNER JOIN " . $this->db->dbprefix . "currency_management as C ON T.currency_id = C.currency_id
		WHERE T.status='A'";

        /* If trade type then */
        if (isset($arr_condition['trade_type']) && $arr_condition['trade_type'] != "") {
            if (strpos("WHERE", $query) < 1) {
                $query .=" AND T.trade_type = '" . mysql_real_escape_string($arr_condition['trade_type']) . "' ";
            } else {
                $query .=" WHERE T.trade_type = '" . mysql_real_escape_string($arr_condition['trade_type']) . "' ";
            }
        }
		
		/* If method_url then */
        if (isset($arr_condition['method_url']) && $arr_condition['method_url'] != "") {
            if (strpos("WHERE", $query) < 1) {
                $query .=" AND P.method_url = '" . mysql_real_escape_string($arr_condition['method_url']) . "' ";
            } else {
                $query .=" WHERE P.method_url = '" . mysql_real_escape_string($arr_condition['method_url']) . "' ";
            }
        }
		
		/* If user_id then */
        if (isset($arr_condition['user_id']) && $arr_condition['user_id'] != "") {
            if (strpos("WHERE", $query) < 1) {
                $query .=" AND T.user_id = '" . mysql_real_escape_string($arr_condition['user_id']) . "' ";
            } else {
                $query .=" WHERE T.user_id = '" . mysql_real_escape_string($arr_condition['user_id']) . "' ";
            }
        }

        /*  If Payment method is added by user this will append query */
        if (isset($arr_condition['payment_type']) && $arr_condition['payment_type'] != "") {
			if(($arr_condition['payment_type'] != '3') && ($arr_condition['payment_type'] != '19')) {
				if (strpos("WHERE", $query) < 1) {
					$query .=" AND T.payment_method_id ='" . mysql_real_escape_string($arr_condition['payment_type']) . "'";
				} else {
					$query .=" WHERE T.payment_method_id ='" . mysql_real_escape_string($arr_condition['payment_type']) . "'";
				}
			}
        }

        /*  If trade amount is added by user this will append query */
        if (isset($arr_condition['amount']) && $arr_condition['amount'] != "") {
            if (strpos("WHERE", $query) < 1) {
                $query .=" AND T.min_amount <='" . mysql_real_escape_string($arr_condition['amount']) . "' AND T.max_amount >='" . mysql_real_escape_string($arr_condition['amount']) . "'";
            } else {
                $query .=" WHERE T.min_amount <='" . mysql_real_escape_string($arr_condition['amount']) . "' AND T.max_amount >='" . mysql_real_escape_string($arr_condition['amount']) . "'";
            }
        }
		
		/*  If Payment method is added by user this will append query */
        if (isset($arr_condition['currency']) && $arr_condition['currency'] != "") {
			if (strpos("WHERE", $query) < 1) {
				$query .=" AND T.currency_id ='" . mysql_real_escape_string($arr_condition['currency']) . "'";
			} else {
				$query .=" WHERE T.currency_id ='" . mysql_real_escape_string($arr_condition['currency']) . "'";
			}
        }
		

        /* Order by distance */
        $query .=" order by T.created_on ";
        
        if (isset($arr_condition['limit']) && $arr_condition['limit'] != "") {
            $query .=" limit " . $arr_condition['limit'] . " ";
        }
        
         if (isset($arr_condition['offset']) && isset($arr_condition['limit']) && $arr_condition['offset'] != "") {
            $query .=" , " . $arr_condition['offset'] . " ";
        }

        $result = $this->db->query($query);
		//echo $this->db->last_query();
        return $result->num_rows();
    }

}
