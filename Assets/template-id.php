<?php

	if(isset($_GET['name']))
		$name = $_GET['name'];
		$step = $_GET['step'];

	echo '<div class="qemu">
		  <font color="red">*&nbsp;</font><b>important</b>
		  <br>convert image to valid format with QEMU tool.
		  </div>
		  <h3>'.$name .'</h3>
		  <div class="scroll">';

	echo '<form method="post" class="form form--ovf">
		  <h4>Step 1.</h4>Upload the OVF descriptor to initiate this template..
		  <br>
		  <input type="submit" name="upload-ovf" value="upload">';
	if($step == 1)
		echo '<font color="green">&#10004;</font>';
    echo '</form>';

    if($step == 1)
    	echo '<form method="post" class="form form--file">
			  <h4>Step 2.</h4>Upload reference file to complete the upload procedure (vmdk format).
			  <br>
			  <input type="submit" name="upload-file" value="upload">
			  </form>';
    
    if($step == 2)
    	echo '<form method="post" class="form form--file">
			  <h4>Step 2.</h4>Upload reference file to complete the upload procedure (vmdk format).
			  <br>
			  <input type="submit" name="upload-file" value="upload">
			  <font color="green">&#10004;</font>
			  </form>
    		  Well done..'.$name .'template is ready to deploy';

    echo '</div>';  	  


?>	