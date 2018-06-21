<ul id="country-list">
<?php
foreach($result as $location) {
?>
<li style="color:black" onClick="selectCountry('<?php echo $location["location_name"]; ?>','<?php echo $location['location_id']; ?>');" id="<?php echo $location['location_id']; ?>"><?php echo $location["location_name"]; ?></li>
<?php } ?>
</ul>