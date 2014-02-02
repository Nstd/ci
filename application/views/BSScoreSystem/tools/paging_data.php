<input type="hidden" name="<?php echo $paging_class_name;?>.orderBy" id="<?php echo $paging_class_name;?>.orderBy" value="<?php if(isset($orderBy)) echo $orderBy; ?>">
<input type="hidden" name="<?php echo $paging_class_name;?>.offset" id="<?php echo $paging_class_name;?>.offset" value="<?php if(isset($pageid) && isset($limit)) echo ($pageid-1)*$limit; else echo 1; ?>">
<input type="hidden" name="<?php echo $paging_class_name;?>.limit" id="<?php echo $paging_class_name;?>.limit" value="<?php if(isset($limit)) echo $limit; else echo 10; ?>">
<input type="hidden" name="<?php echo $paging_class_name;?>.count" id="<?php echo $paging_class_name;?>.count" value="<?php if(isset($count)) echo $count; ?>">
