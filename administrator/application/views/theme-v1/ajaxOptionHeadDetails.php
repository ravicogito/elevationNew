<?php if(isset($optionheadlist)){?>
    <label id="cname">Option Head Name</label>
       <select name="option_head" id="option_head" class="form-control">
        <option value="">Select Option Head</option>
        <?php foreach($optionheadlist as $val){?>
                <option value="<?php echo $val['option_meta_head_id'];?>"><?php echo $val['option_meta_head_name'];?></option>
        <?php }?>
      </select> 
<?php }?>



