<?php
clearstatcache();

// xmlからvmafを計算する
/* 3つの階層からなる
params
fyi（xml）, metrics（json）
frames

VMAF score（json, 最後にオプション指定した値が表示）
aggregateVMAF（xml, 最後にオプション指定した値が表示）
*/


$fi = 'tes.json';
$json = file_get_contents($fi);
//$data = json_decode($json, true);

echo($json);

/*

$xml = "tes.xml";
//$vmafx = simplexml_load_file($xml);
$vitas = simplexml_load_file("tes.xml");

print_r($vitas);


*/

