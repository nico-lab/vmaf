<?php
// PTS時間を出力する
$fp = fopen("tmp.tsv", "ab"); 
$fps = 24/1.001;
$dur = 3600;

$frames = ceil($dur*$fps); // 0frameが0PTSではないので繰り上げる、86314
//echo $frames;

//echo 1/$fps;
//echo sprintf('%.6f',86313/$fps);

for ($i = 1; $i < $frames; $i++){
	fwrite($fp, sprintf('%.6f',$i/$fps)."\n");
}
