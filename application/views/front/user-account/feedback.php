<div class="page_holder">
    <div class="page_inner">
        <div class="page_head">
            <h2>Browse feedback for <?php echo $arr_user_data['user_name'];?></h2>
        </div>
        <div class="wallet_section">
            <div class="send_bitcoin">
                <div class="send_bitcoin_in invite_friend_in">                    
                    <div class="info_send">
					<?php  foreach($arr_feedback_list as $feedback) { ?>                        
						<div class="feedback-row">
							<small><?php echo date('d m,Y H:i:s', strtotime($feedback['updated_on'])); ?></small>
							<p>+ <?php echo nl2br($feedback['feedback_comment']);?> <?php if($feedback['trade_volume'] != '') {?><span class="label-warning"><?php echo $feedback['trade_volume']; ?></span><?php } ?></p>
						</div>
					<?php } ?>
                    </div>
                </div>    
				<?php if (count($arr_feedback_list) > 0) { ?>
					<p><?php echo $links; ?></p>
				<?php } ?>            	
            </div>                
        </div>
    </div>
</div>
</section>