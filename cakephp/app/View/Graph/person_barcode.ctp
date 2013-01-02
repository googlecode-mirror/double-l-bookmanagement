<?php
	$img_type = 1; //PNG
	$thickness = 30;
	$color_black = new FColor(0,0,0);
	$color_white = new FColor(255,255,255);
	$resolution = 1;
	$font_size = 2;
	$checksum = 0;
	$img_width = 250;
	$img_height = 110;
	header("Content-type: image/png");
	$code_generated = new code39($thickness,$color_black,$color_white, $resolution, $strText, $font_size, $checksum);
	$drawing = new FDrawing(1024,1024,'',$color_white);
	$drawing->init();
	$drawing->add_barcode($code_generated);
	$drawing->draw_all();
	$im = $drawing->get_im();
	$im_bg = imagecreatefrompng(IMAGES.'english_card.png');
	list($bg_width, $bg_height) = getimagesize(IMAGES.'english_card.png');
	$im2 = imagecreate($img_width,$img_height);
	//$im2 = imagecreate($code_generated->lastX,$code_generated->lastY);
	//$im2 = imagecreate($code_generated->lastX,$code_generated->lastY+ 20);
	$background = imagecolorallocate($im2, 255, 255, 255);
	if ($strText != 'Error') {
		imagecopyresized($im2, $im_bg, 0, 0, 0, 0, $img_width, ($img_width/$bg_width) * $bg_height, $bg_width, $bg_height);
		imagecopyresized($im2, $im, 0+($img_width -10 -$code_generated->lastX)/2, 68, 0, 0, $code_generated->lastX, $code_generated->lastY, $code_generated->lastX, $code_generated->lastY);
		$imagebox = calculateTextBox("分校：".$strSchool,APP.'Vendor'.DS.'fonts'.DS.'fireflysung.ttf',10,0);
		$im = imagecreate($img_width -10,$imagebox["height"] + 2);
		imagefill($im, 0,0, imagecolorallocate($im,$strColor['r'],$strColor['g'],$strColor['b'])); 
		imagettftext($im, 10, 0, 12, 12,  imagecolorallocate ($im,0,0,0), APP.'Vendor'.DS.'fonts'.DS.'fireflysung.ttf', "分校：".$strSchool);
		imagecopyresized($im2, $im, 5, 26, 0, 0,$img_width -10,$imagebox["height"] + 2, $img_width -10,$imagebox["height"] + 2);
		$imagebox = calculateTextBox("姓名：".$strName,APP.'Vendor'.DS.'fonts'.DS.'fireflysung.ttf',10,0);
		$im = imagecreate($img_width -10,$imagebox["height"] + 2);
		imagefill($im, 0,0, imagecolorallocate($im,$strColor['r'],$strColor['g'],$strColor['b'])); 
		imagettftext($im, 10, 0, 12, 12,  imagecolorallocate ($im,0,0,0), APP.'Vendor'.DS.'fonts'.DS.'fireflysung.ttf', "姓名：".$strName);
		imagecopyresized($im2, $im, 5, $imagebox["height"] + 26, 0, 0,$img_width -10,$imagebox["height"] + 2, $img_width -10,$imagebox["height"] + 2);
		$imagebox = calculateTextBox("學號：".$strText,APP.'Vendor'.DS.'fonts'.DS.'fireflysung.ttf',10,0);
		$im = imagecreate($img_width -10,$imagebox["height"] + 2);
		imagefill($im, 0,0, imagecolorallocate($im,$strColor['r'],$strColor['g'],$strColor['b'])); 
		imagettftext($im, 10, 0, 12, 12,  imagecolorallocate ($im,0,0,0), APP.'Vendor'.DS.'fonts'.DS.'fireflysung.ttf', "學號：".$strText);
		imagecopyresized($im2, $im, 5, ($imagebox["height"] + 2)*2 + 26, 0, 0,$img_width -10,$imagebox["height"] + 2, $img_width -10,$imagebox["height"] + 2);
	}
	$drawing->set_im($im2);
	$drawing->finish($img_type);
	
	
	
	function calculateTextBox($text,$fontFile,$fontSize,$fontAngle) {
		/************
		simple function that calculates the *exact* bounding box (single pixel precision).
		The function returns an associative array with these keys:
		left, top:  coordinates you will pass to imagettftext
		width, height: dimension of the image you have to create
		*************/
		$rect = imagettfbbox($fontSize,$fontAngle,$fontFile,$text);
		$minX = min(array($rect[0],$rect[2],$rect[4],$rect[6]));
		$maxX = max(array($rect[0],$rect[2],$rect[4],$rect[6]));
		$minY = min(array($rect[1],$rect[3],$rect[5],$rect[7]));
		$maxY = max(array($rect[1],$rect[3],$rect[5],$rect[7]));
	   
		return array(
			"left"   => abs($minX) - 1,
			"top"    => abs($minY) - 1,
			"width"  => $maxX - $minX,
			"height" => $maxY - $minY,
			"box"    => $rect
		);
	}
?>