<?php
set_time_limit(9000);
$myfile = fopen("output.txt","w") or die("unable to write to file");

#$img = "transfer/00004.png";
#$x = 80;
#$y = 141;
#$circle = 1;
$check = null;


for($i = 1; $i < 16235; $i++){
$filename = sprintf('%05d', $i);

$img = 'transfer/half/'.$filename.'.png';
#echo '<img src="'.$img.'">';
echo get_hex($img);

}

echo '<h1>complete</h1>';





function get_hex($img){
global $myfile;
for($circle =1; $circle < 9; $circle++){
        #print_r("<li>Circle: ".$circle."\n");


if($circle == 1){
        $x_axis = array(71,72,73);
}elseif($circle == 2){
        $x_axis = array(78,79,80);
}elseif($circle == 3){
        $x_axis = array(85,86,87);
 }elseif($circle == 4){
        $x_axis = array(92,93,94);
}elseif($circle == 5){
        $x_axis = array(100,101,102);
}elseif($circle == 6){
         $x_axis = array(107,108,109);
}elseif($circle == 7){
        $x_axis = array(114,115,116);
}elseif($circle == 8){
        $x_axis = array(121,122,123);
}else{
die('error bad # for circles');
}





$image = imagecreatefrompng($img);

// Calculate rgb pixel value at particular point.
$y_axis = array(141,142,143);

foreach($x_axis as $x){
$black = null; $red = null; $green = null;
foreach($y_axis as $y){
#print_r('x: '.$x.', y:'.$y);


$rgb = imagecolorat($image, $x, $y);

// Assign color name and its value.
$colors = imagecolorsforindex($image, $rgb);


$color = sprintf("#%02x%02x%02x", $colors['red'], $colors['green'], $colors['blue']); // #0d00ff
#return $color;

        #print_r($color."\n");


if($color == '#00ff00'){
        $check[] = 'green';
}elseif($color == '#000000'){
        $check[] = 'black';
}elseif($color == '#ff0000'){
        $check[] = 'red';
}else{ $check[] = 'error'; }
$nearby = NULL;



}//foreach $y
}//foreach $x

print_r($green); print_r($black); print_r($red);

if(in_array('green',$check)) {fwrite($myfile,'1'); echo '1';}
if(in_array('black',$check)) {fwrite($myfile,'0'); echo '0'; }
if(in_array('red',$check)) { fwrite($myfile,'2'); echo '2';}

$check = null; $green = null; $red = null; $black = null;

}
fwrite($myfile, ' ');
}
fclose($myfile);

?>