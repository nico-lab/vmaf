<?php
// PTSŽžŠÔ‚ðo—Í‚·‚é
$fp = fopen("foo.srt", "ab"); 
$fps = 24/1.001;
$dur = 10;

$frames = ceil($dur*$fps); // 0frame‚ª0PTS‚Å‚Í‚È‚¢‚Ì‚ÅŒJ‚èã‚°‚éA86314
//echo $frames;

//echo 1/$fps;
//echo sprintf('%.6f',86313/$fps);

// $sec = 0.500500;

function sec_to_hour($sec){ // https://qiita.com/Shouin/items/b4d8d74f2ccba333365b
    $hours = floor($sec / 3600);//ŽžŠÔ
    $minutes = floor(($sec / 60) % 60);//•ª
    $seconds = floor($sec % 60);//•b
    $mseconds = floor(($sec * 1000)%1000);//•b
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