<?php if($custList) {
	foreach ($custList as $key => $value) {
?>
	<div class="userGroup">
		<h3><?=strtoupper($key);?></h3>
		<?php foreach($value as $customer) {?>
			<div class="assign_userlist">
			<input name="chkCustomer[]" type="checkbox" value="<?=$customer['customer_id'];?>" <?=(in_array($customer['customer_id'], $assign_list))?"checked":""?> /><label><?=$customer['name']?></label>
		</div>
		<?php }?>
	</div>
<?php }}?>