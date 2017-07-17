<?php
	if (isset($status)) {
		if ($status == "success") {
			echo '{"status":0,"session_id":"'.$session_id.'","additional":"'.$additional.'","data":'.json_encode($query).'}';
		}
		else{
			echo '{"status":-1,"additional":"'.$additional.'","message":"手机号码或者密码错误!"}';
		}
	}
	else{
		echo '{"status":-1,"additional":"'.$additional.'","message":"status is failure!"}';
	}
?>