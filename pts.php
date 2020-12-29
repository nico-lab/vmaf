<?php
// PTS時間を出力する
$fp = fopen("foo.srt", "ab"); 
$fps = 24/1.001;
$dur = 10;

$frames = ceil($dur*$fps); // 0frameが0PTSではないので繰り上げる、86314
//echo $frames;

//echo 1/$fps;
//echo sprintf('%.6f',86313/$fps);

// $sec = 0.500500;

function sec_to_hour($sec){ // https://qiita.com/Shouin/items/b4d8d74f2ccba333365b
    $hours = floor($sec / 3600);//時間
    $minutes = floor(($sec / 60) % 60);//分
    $seconds = floor($sec % 60);//秒
    $mseconds = floor(($sec * 1000)%1000);//秒
    $hms = sprintf("%02d:%02d:%02d,%03d", $hours, $minutes, $seconds, $mseconds);
    return $hms;
}

// echo sec_to_hour($sec);


for ($i = 1; $i < $frames; $i++){
	fwrite($fp, $i."\n".sec_to_hour(($i)/$fps)." --> ".sec_to_hour(($i+1)/$fps)."\n"."foo"."\n"."\n");
}

/*



for ($i = 1; $i < $frames; $i++){
	fwrite($fp, sprintf('%.6f',$i/$fps)."\n");
}
*/