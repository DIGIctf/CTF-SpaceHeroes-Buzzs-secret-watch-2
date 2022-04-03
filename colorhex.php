<?php
set_time_limit(9000); //prevent PHP from triggering max_execution

$myfile = fopen("output.txt","w") or die("unable to write to file"); //create output.txt this is where the data will be exported to

$check = null;

//runs a loop to check all of the images exported from video 00001-16234.png 
for($i = 1; $i < 16235; $i++){ 
$filename = sprintf('%05d', $i); //each filename has leading zeros i.e. 00005.png we need to keep those.

$img = 'transfer/half/'.$filename.'.png'; //location
#echo '<img src="'.$img.'">'; //not needed for production but used for testing to see if the image corresponds with the output
echo get_hex($img); //runs function
}

echo '<h1>Script complete</h1>';



function get_hex($img){
global $myfile;
        
//there are 8 locations of circles on the image that produces a binary output
        
for($circle =1; $circle < 9; $circle++){
        #print_r("<li>Circle: ".$circle."\n"); //used for development not for production

//get x-axis coordinates. can't rely on one pixel so we are checking a 3x3 grid to see if it has any hits        
        
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
$y_axis = array(141,142,143); //these are static unlike the x-axis which are dynamic

foreach($x_axis as $x){
$black = null; $red = null; $green = null;
	foreach($y_axis as $y){
        


	$rgb = imagecolorat($image, $x, $y);

	$colors = imagecolorsforindex($image, $rgb); // Assign color name and its value.


	$color = sprintf("#%02x%02x%02x", $colors['red'], $colors['green'], $colors['blue']); // #0d00ff

	#print_r('x: '.$x.', y:'.$y); //used for development not for production
	#print_r($color."\n"); //used for development not for production


	if($color == '#00ff00'){
	$check[] = 'green';
	}elseif($color == '#000000'){
	$check[] = 'black';
	}elseif($color == '#ff0000'){
	$check[] = 'red';
	}else{ $check[] = 'error'; }
	$nearby = NULL;



	}// $y
}// $x

print_r($green); print_r($black); print_r($red);

//output	
if(in_array('green',$check)) {fwrite($myfile,'1'); echo '1';}
if(in_array('black',$check)) {fwrite($myfile,'0'); echo '0'; }
if(in_array('red',$check)) { fwrite($myfile,'2'); echo '2';}

$check = null; $green = null; $red = null; $black = null;

}
fwrite($myfile, ' ');
}
fclose($myfile);

?>
