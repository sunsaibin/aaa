<?php
	if (intval($effect)>0) {
		echo '{"status":0,"additional":"exist","effect":'.$effect.'}';
	}
	else{
		echo '{"status":0,"additional":"nonexist","effect":'.$effect.'}';
	}
?>