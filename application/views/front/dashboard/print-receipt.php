<html>
<head>
	<title></title>
	<style>
		.left {
			float: left;
			padding-right: 10px;
			width: 50%;
		}
		.right {
			padding:10px;
		}
		th {
			border: 1px solid #808080;
			margin: 0;
			padding: 5px;
		}
		td {
			border: 1px solid #808080;
			margin: 0;
			padding: 5px;
		}
	</style>
</head>
<h2>Cryptosi.com Contact #<?php echo $arr_trade_request_details['transaction_id']?></h2>
<div class="left">

<table>
	<tbody><tr>
		<th>Created</th>
		<td><?php echo date('d M,Y H:i:s', strtotime($arr_trade_request_details['created_on']));?></td>
	</tr>
	<tr>
		<th>Seller</th>
		<td><?php echo $arr_seller_data['user_name']; ?></td>
	</tr>
	<tr>
		<th>Buyer</th>
		<td><?php echo $arr_buyer_data['user_name']; ?></td>
	</tr>
	<tr>
		<th>Amount</th>
		<td><?php echo $arr_trade_request_details['fiat_currency']; ?> <?php echo $arr_currency_details['currency_code']; ?> = <?php echo $arr_trade_request_details['btc_amount']; ?> BTC </b></td>
	</tr>
</tbody></table>


<div class="right">
	<h3>Messaging</h3>
	
		<?php foreach($arr_trade_chat_details as $chat) { ?>
		<small>			
			 <strong><?php echo date('d M,Y H:i:s', strtotime($chat['created_on']));?>
			 <?php echo $chat['user_name']; ?></strong> : <?php echo nl2br($chat['contact_message']); ?>
		</small>
		<hr>
		<?php } ?>
		
	</div>
	
</div>