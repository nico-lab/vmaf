<?php
# ファイル名とオプションをforeeachを回してコマンドを作る
/*
php opt-cmd.php

入力ファイルとパスログ、オプション変更
適宜ビットレートとその割合
*/

$fpe = fopen("enc_cmd.txt", "ab"); 
$fpv = fopen("vmaf_cmd.txt", "ab"); 

$in_path = ""; // 同じ場所、もしくは相対パスにする
$in_path = "E:\\4k検証\\HZGD-146\\split\\4k\\";
// value1 https://qiita.com/shuntaro_tamura/items/784cfd61f355516dfff0
$in_file[] = array("fname" => "udh_video0000_15kbps_2pass_sameBitrateMaxrate_qmin3_qmax32_shoot0_test1.mp4", "logname" => "000");
$in_file[] = array("fname" => "udh_video0001_15kbps_2pass_sameBitrateMaxrate_qmin3_qmax32_shoot0_test1.mp4", "logname" => "001");
$in_file[] = array("fname" => "udh_video0021_15kbps_2pass_sameBitrateMaxrate_qmin3_qmax32_shoot0_test1.mp4", "logname" => "021");
$in_file[] = array("fname" => "udh_video0022_15kbps_2pass_sameBitrateMaxrate_qmin3_qmax32_shoot0_test1.mp4", "logname" => "022");
$in_file[] = array("fname" => "udh_video0023_15kbps_2pass_sameBitrateMaxrate_qmin3_qmax32_shoot0_test1.mp4", "logname" => "023");
$in_file[] = array("fname" => "udh_video0097_15kbps_2pass_sameBitrateMaxrate_qmin3_qmax32_shoot0_test1.mp4", "logname" => "097");
$in_file[] = array("fname" => "udh_video0220_15kbps_2pass_sameBitrateMaxrate_qmin3_qmax32_shoot0_test1.mp4", "logname" => "220");
$in_file[] = array("fname" => "udh_video0221_15kbps_2pass_sameBitrateMaxrate_qmin3_qmax32_shoot0_test1.mp4", "logname" => "221");
$in_file[] = array("fname" => "udh_video0222_15kbps_2pass_sameBitrateMaxrate_qmin3_qmax32_shoot0_test1.mp4", "logname" => "222");
// ファイル名とパスログを書き込むのを省力化したい
// https://docs.google.com/spreadsheets/d/1zcTHgCedCDec83QYmCMhMc-AdT3fCi3NhJswBBe5VIE/edit#gid=0

$ch_opt_name = " -aq-mode ";
$ch_opt_name_ = "aq_mode"; // 出力フォルダ名
// value0
$ch_opt = array(
    0,
    1,
    2,
    3,
);
//echo "mkdir ".$ch_opt_name_."\n";
fwrite($fpe, "mkdir ".$ch_opt_name_."\n");

/* bitrate考察
https://docs.google.com/spreadsheets/d/1tczTBu3IAIizFiGEtVW7Sy7uZnMqHpm2-TrzRchxO6k/edit#gid=1575227514 BPP
https://docs.google.com/spreadsheets/d/15ddn9hd9nz5HYboAkYW2zCv6665Bt9NmdOFwTyeGdDw/edit#gid=0 公式bv上昇
*/
$bitrate = 1800;
$bminratio = 0.5;
$bmaxratio = 1.45;
$bv = "-b:v ";
$bmi = "k -minrate ";
$bma = "k -maxrate ";
$bitrate_opt = $bv.$bitrate.$bmi.$bitrate*$bminratio.$bma.$bitrate*$bmaxratio."k -passlogfile ";
// ビットレート変更対応

$ff_path = "ffmpeg";
$def_pre_opt = " -report -i ";
$def_opt = " -vf scale=w=1920:h=1080:sws_flags=spline+accurate_rnd:in_range=tv:out_range=tv -c:v libvpx-vp9 -pass 2 -speed 2 -quality good -g 60 -keyint_min 60 -threads 16 -tile-columns 3 -row-mt 1 -frame-parallel 1 -auto-alt-ref 1 -lag-in-frames 16 -arnr-maxframes 5 -arnr-strength 3 -pix_fmt yuv420p -color_primaries bt709 -color_trc bt709 -colorspace bt709 -color_range tv -an -crf 31 ";

foreach ($ch_opt as $value0){
    foreach ($in_file as $value1){
        $out_name = " ".$ch_opt_name_."\\".$ch_opt_name_.$value0."_".$value1['logname'];
        $out_name_mp4 = $out_name.".mp4";
        $vmaf_opt = " -filter_complex \"[0:v]settb=1/AVTB,setpts=PTS-STARTPTS[main];[1:v]settb=1/AVTB,setpts=PTS-STARTPTS[ref];[main][ref]scale2ref=flags=bicubic,libvmaf=vmaf_4k_v0.6.1.pkl:log_fmt=csv:log_path=".$ch_opt_name_."/".$ch_opt_name_.$value0."_".$value1['logname'].".csv\" -an -f null -";
        // モデルの変更有
        $enc_cmd = $ff_path.$def_pre_opt.$in_path.$value1['fname'].$def_opt.$bitrate_opt.$value1['logname'].$ch_opt_name.$value0.$out_name_mp4."\n";
    
        fwrite($fpe, $enc_cmd);
        //echo $out_name_mp4."\n";
        //echo $vmaf_opt."\n";
        $vmaf_cmd = $ff_path.$def_pre_opt.$out_name_mp4." -i ".$in_path.$value1['fname'].$vmaf_opt."\n";
        fwrite($fpv, $vmaf_cmd);
        $bitrate_cmd = "CheckBitrate -l 1 ".$out_name_mp4."\n";
        fwrite($fpv, $bitrate_cmd);

    }
}

// TODO
// Rコピペ用を作る
// 1passログ出力
// h264設定

// done
// vmaf出力コマンドを作る
// bitrate変更コマンド

/*

*/
