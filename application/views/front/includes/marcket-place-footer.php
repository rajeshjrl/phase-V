<div class="footer_top">
    <div class="footer_left">
        <div class="footer_left_in">
            <div class="page_inner">
                <div class="latest_update">
                    <div class="latest_update_head"><?php echo lang('latest_updated_bitcoin_sell_ads'); ?></div>
                    <div class="latest_update_data">
                        <?php 
							$this->load->model("common_model");
							$current_date = date('Y-m-d H:i:s');
							
							foreach($arrInfo_sell_ads_latest as $latest_sell) { 
							$username = $latest_sell['user_name'];
							if($latest_sell['trade_type'] == 'sell_o'){
							$payment_method = $latest_sell['method_name'];}
							$location = explode(",",$latest_sell['location']);
							$trade_id = $latest_sell['trade_id'];					

							$current_date = date('Y-m-d H:i:s');
							$created_date = $latest_sell['created_on'];
							$interval = abs(strtotime($created_date) - strtotime($current_date)); 
							$minutes   = round($interval / 60);
						?>
						<div class="latest_update_content">
                            <div class="content_text"><a href="<?php echo base_url();?>buy-sell-bitcoin/<?php echo $trade_id;?>"><?php echo $username. ':'. $payment_method.' '.end($location);?></a></div>
                            <div class="content_time"><?php echo $minutes;?> minuites</div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>            
    </div>
    <div class="footer_right">
        <div class="footer_right_in">
            <div class="page_inner">
                <div class="latest_update">
                    <div class="latest_update_head"><a href="<?php echo $global['blog_link']; ?>" target="_blank">Cryptosi.com news<span class="rss">&nbsp;</span></a></div>
                    <div class="latest_update_data">
						<?php foreach($arr_blogpost as $post) { ?>
                        <div class="latest_update_content">
                            <div class="content_text"><a href="<?php echo $post['link'];?>" target="_blank"><?php echo $post['title']?></a></div>
                            <div class="content_time"><?php echo date('d M,Y',strtotime($post['updated'])); ?></div>
                        </div>
						<?php } ?>
                    </div>
                </div>
            </div>
        </div>            
    </div>
</div>
<div class="footer_top">
    <div class="left_footer">
        <div class="footer_left_in">
            <a href="<?php echo base_url(); ?>buy-bitcoins" class="find_links"><?php echo lang('find_ads_and_buy_bitcoins_near_you'); ?> »</a>
        </div>
    </div>
    <div class="right_footer">
        <div class="footer_right_in">
            <a href="<?php echo $global['blog_link']; ?>" target="_blank" class="find_links"><?php echo lang('read_more_at'); ?> <span>Cryptosi.com blog</span></a>
        </div>
    </div>
</div>