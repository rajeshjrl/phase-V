<section id="content" class="cms dashboard user_profile">
    <div class="page_holder">
        <div class="page_inner">
            <div class="page_head">
                <h2><?php echo $arr_user_data['user_name']; ?></h2>                
            </div>
            <div class="wallet_section">
                <div class="send_bitcoin">
                    <div class="send_bitcoin_in invite_friend_in">
                        <div class="page_head">
                            <h5>Information of <?php echo $arr_user_data['user_name']; ?></h5>
                        </div>
                        <div class="info_send user_info">
                            <div class="info_fieldset greay">
                                <div class="label"><strong>Trade volume</strong></div>
                                <div class="label_data">Less than 25 BTC </div>
                            </div>
                            <div class="info_fieldset white">
                                <div class="label"><strong>Number of confirmed trades</strong></div>
                                <div class="label_data"><strong>0</strong>…with <strong>0</strong> different partners
                                </div>
                            </div>
                            <div class="info_fieldset greay">
                                <div class="label"><strong>Feedback score </strong></div>
                                <div class="label_data"><strong>N/A %</strong></div>
                            </div>
                            <div class="info_fieldset white">
                                <div class="label"><strong>Account created</strong></div>
                                <?php
                                $timestamp_start = strtotime(date('Y-m-d H:i:s'));
                                $timestamp_end = strtotime($arr_user_data['register_date']);
                                $difference = abs($timestamp_end - $timestamp_start);
                                $weekday = date('N', $difference);
                                $day = date('d', $difference);
                                $month = date('y', $difference)
                                ?>
                                <div class="label_data"><?php echo $month . ' month, ' . $weekday . ' weeks, ' . $day . ' days'; ?>  ago</div>
                            </div>
                            <div class="info_fieldset greay">
                                <div class="label"><strong>Last seen</strong></div>
                                <?php
                                $current_date = strtotime(date('Y-m-d'));
                                $last_logout = strtotime($arr_user_login_details['last_logout']);
                                $minutes = round(abs($current_date - $last_logout) / (60 * 24));
                                ?>
                                <div class="label_data"><?php echo $minutes; ?> minutes ago</div>
                            </div>
                            <div class="info_fieldset white">
                                <div class="label"><strong>Language</strong></div>
                                <div class="label_data">English</div>
                            </div>
                            <div class="info_fieldset greay">
                                <div class="label"><strong>Email</strong></div>
                                <?php if ($arr_user_data['email_verified'] == '1') { ?>
                                    <div class="label_data"><span class="verify">&nbsp;</span>Verified</div>
                                <?php } else { ?>
                                    <div class="label_data"><span class="not_verify">&nbsp;</span>Not Verified</div>
                                <?php } ?>
                            </div> 
                            <div class="info_fieldset greay">
                                <div class="label"><strong>Trust</strong></div>
                                <div class="label_data">Trusted by <strong><?php echo $trusted_count; ?></strong> people</div>
                            </div> 
                            <div class="info_fieldset white">
                                <div class="label"><strong>Block</strong></div>
                                <div class="label_data">Blocked by <strong>0</strong> people</div>
                            </div>              	
                        </div>
                    </div>                	
                </div>

                <?php if ((count($current_user_trust_on_selected) > 0) && (count($selected_user_trust_on_current) > 0)) { ?>



                    <?php if ($current_user_trust_on_selected[0]['status'] == 'T' && $selected_user_trust_on_current[0]['status'] == 'T') { ?>
                        <div class="send_bitcoin right">
                            <div class="send_bitcoin_in">
                                <button class="user_trust">Already trusting <?php echo $arr_user_data['user_name']; ?></button>
                                <p>Already mutually trusting <?php echo $arr_user_data['user_name']; ?></p>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($current_user_trust_on_selected[0]['status'] == 'T' && $selected_user_trust_on_current[0]['status'] != 'T') { ?>
                        <div class="send_bitcoin right">
                            <div class="send_bitcoin_in">
                                <button class="user_trust">Already trusting <?php echo $arr_user_data['user_name']; ?></button>
                                <p>Already trusting <?php echo $arr_user_data['user_name']; ?>, but <?php echo $arr_user_data['user_name']; ?> does not trust you yet.</p>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($current_user_trust_on_selected[0]['status'] != 'T' && $selected_user_trust_on_current[0]['status'] == 'T') { ?>
                        <form id="frm_update_feedback" name="frm_update_feedback" class="send_bitcoin right" method="post" action="<?php echo base_url(); ?>trusted/feedback/<?php echo $arr_user_list[0]['trust_id']; ?>">
                            <div class="">
                                <div class="send_bitcoin_in">
                                    <button type="submit" class="user_trust" name="rating" value="T" id="rating_5">Trust <?php echo $arr_user_data['user_name']; ?></button>
                                    <p>You do not currently trust <?php echo $arr_user_data['user_name']; ?></p>
                                </div>
                            </div>
                        </form>
                    <?php } ?>



                    <form id="frm_update_feedback" name="frm_update_feedback" method="post" action="<?php echo base_url(); ?>trusted/feedback/<?php echo $arr_user_list[0]['trust_id']; ?>">
                        <div class="send_bitcoin">
                            <div class="send_bitcoin_in invite_friend_in">
                                <div class="page_head">
                                    <h5>Update your feedback for <?php echo $arr_user_data['user_name']; ?></h5>
                                </div>
                                <div class="info_send user_info"> <span>Trader rating</span> </div>
                                <div class="radio_container trust_feedback needs_message">
                                    <label for="rating_1">
                                        <input type="radio" name="rating" value="T" id="rating_1" <?php if ($arr_user_list[0]['status'] == 'T') echo "checked"; ?> />
                                        Trustworthy</label>
                                    <label for="rating_2">
                                        <input type="radio" name="rating" value="P" id="rating_2" <?php if ($arr_user_list[0]['status'] == 'P') echo "checked"; ?> />
                                        Positive</label>
                                    <label for="rating_3">
                                        <input type="radio" name="rating" value="N" id="rating_3" <?php if ($arr_user_list[0]['status'] == 'N') echo "checked"; ?> />
                                        Neutral</label>
                                    <label for="rating_4">
                                        <input type="radio" name="rating" value="D" id="rating_4" <?php if ($arr_user_list[0]['status'] == 'D') echo "checked"; ?>/>
                                        Distrust and block</label>
                                    <label for="rating_5">
                                        <input type="radio" name="rating" value="B" id="rating_5" <?php if ($arr_user_list[0]['status'] == 'B') echo "checked"; ?>/>
                                        Block without feedback</label>
                                </div>
                                <fieldset class="button">
                                    <input type="submit" name="btn_register" id="btn_register" value="Update Feedback">
                                </fieldset>
                            </div>
                        </div>

                    </form>

                <?php } elseif (count($current_user_trust_on_selected) > 0) { ?>

                    <div class="send_bitcoin right">
                        <div class="send_bitcoin_in">
                            <button class="user_trust">Already trusting <?php echo $arr_user_data['user_name']; ?></button>
                            <p>Already trusting <?php echo $arr_user_data['user_name']; ?>, but <?php echo $arr_user_data['user_name']; ?> does not trust you yet.</p>
                        </div>
                    </div>

                <?php } elseif (count($selected_user_trust_on_current) > 0) { ?>

                    <form id="frm_update_feedback" name="frm_update_feedback" class="send_bitcoin right" method="post" action="<?php echo base_url(); ?>trusted/feedbackRequest/<?php echo $selected_user_trust_on_current[0]['trust_id']; ?>">			
                        <div class="">
                            <div class="send_bitcoin_in">
                                <button type="submit" class="user_trust" name="rating" value="T" id="">Trust <?php echo $arr_user_data['user_name']; ?></button>
                                <input type="hidden" name="user_id" id="user_id" value="<?php echo $arr_user_data['user_id']; ?>" />
                                <input type="hidden" name="user_email" id="user_email" value="<?php echo $arr_user_data['user_email']; ?>" />
                                <p>You do not currently trust <?php echo $arr_user_data['user_name']; ?></p>
                            </div>
                        </div>				
                    </form>

                <?php } else { ?>
					
					<form id="frm_update_feedback" name="frm_update_feedback" class="send_bitcoin right" method="post" action="<?php echo base_url(); ?>trusted-contacts/invite-friend">			
                        <div class="send_bitcoin right">
                            <div class="send_bitcoin_in">
                                <button type="submit" class="user_trust" name="rating" value="T" id="" name="btn_invite">Trust <?php echo $arr_user_data['user_name']; ?></button>
                                <input type="hidden" name="user_id" id="user_id" value="<?php echo $arr_user_data['user_id']; ?>" />
                                <input type="hidden" name="friends_email" id="friends_email" value="<?php echo $arr_user_data['user_email']; ?>" />
                                <p>You do not currently trust <?php echo $arr_user_data['user_name']; ?></p>
                            </div>
                        </div>				
                    </form>
					
				<?php } ?>

            </div>

            <div class="wallet_section">
                <div class="send_bitcoin">
                    <div class="send_bitcoin_in invite_friend_in">
                        <div class="page_head">
                            <h5>No confirmed feedback</h5>
                        </div>
                        <div class="info_send user_info">
                            <span><?php echo $arr_user_data['user_name']; ?> has not yet feedback from anyone with considerable trade volume.</span>              	
                        </div>
                    </div>                	
                </div>
                <div class="send_bitcoin right">
                    <div class="send_bitcoin_in invite_friend_in">
                        <div class="page_head">
                            <h5>Unconfirmed feedback</h5>
                        </div>
                        <div class="info_send user_info">
                            <span>Feedback left by users with low trade volume. Unconfirmed feedback doesn't affect the feedback score.</span>              	
                            <span><a class="comment" href="javascript:void(0);"><span>&nbsp;</span>Show unconfirmed feedback </a></span>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>
