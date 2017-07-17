<?php
	if (intval($effect)>0) {
		echo '{"status":1,"additional":"'.$additional.'","effect":'.$effect.'}';
	}
	else{
		if (isset($message)) {
			echo '{"status":-1,"additional":"'.$additional.'","message":"'.$message.'"}';
		}
		else{
			echo '{"status":-1,"additional":"'.$additional.'","message":"操作失败!"}';
		}
	}
?>