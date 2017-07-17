<?php
	if (isset($query) && count($query)) {
		echo '{"status":0,"message":"'.$message.'","data":'.json_encode($query).'}';
	}
	else{
		echo '{"status":-1,"message":"'.$message.'","data":""}';
	}
?>