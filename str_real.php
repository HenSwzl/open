<?php
//截取2个字符串间的字符串
substr($str, strlen($start_str)+strpos($str, $start_str),(strlen($str) - strpos($str, $end_str))*(-1));