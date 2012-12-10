<?php
	$img_type = 1; //PNG
	$thickness = 30;
	$color_black = new FColor(0,0,0);
	$color_white = new FColor(255,255,255);
	$resolution = 1;
	$font_size = 2;
	$checksum = 0;
	header("Content-type: image/png");
	$code_generated = new code39($thickness,$color_black,$color_white,$resolution, $strText, $font_size, $checksum);
	$drawing = new FDrawing(1024,1024,'',$color_white);
	$drawing->init();
	$drawing->add_barcode($code_generated);
	$drawing->draw_all();
	$im = $drawing->get_im();
	$im2 = imagecreate($code_generated->lastX,$code_generated->lastY);
	//$im2 = imagecreate($code_generated->lastX,$code_generated->lastY+ 20);
	$background = imagecolorallocate($im2, 255, 255, 255);
	imagecopyresized($im2, $im, 0, 0, 0, 0, $code_generated->lastX, $code_generated->lastY, $code_generated->lastX, $code_generated->lastY);
	$text_color = imagecolorallocate($im, 233, 14, 91);
	//imagestring($im2, 1, 5, $code_generated->lastY,  "哥大", $text_color);
	$drawing->set_im($im2);
	$drawing->finish($img_type);
?>