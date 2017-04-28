<?php
$dir = "/Assets/file-ref/";

// Open a directory, and read its contents
if (is_dir($dir)){
  echo  '<h3>Downloaded Images</h3>
		  <h4>Image Name &nbsp; &#x25BE;</h4>';
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      echo '<br><input type="radio" name="image" value="' .$file .'">&nbsp;'.$file;
    }
    closedir($dh);
  }
}
?>