<?php
	$use_font = APP.'Vendor'.DS.'fonts'.DS.'mingliu.ttc';
	$use_font1 = APP.'Vendor'.DS.'fonts'.DS.'arial.ttf';
	$img_type = 1; //PNG
	$thickness = 30;
	$color_black = new FColor(0,0,0);
	$color_white = new FColor(255,255,255);
	$resolution = 1;
	$font_size = 4;
	$checksum = 0;
	$img_width = 250;
	$img_height = 152;
	header("Content-type: image/png");
	$code_generated = new code39($thickness,$color_black,$color_white, $resolution, $strText, $font_size, $checksum);
	$drawing = new FDrawing(1024,1024,'',$color_white);
	$drawing->init();
	$drawing->add_barcode($code_generated);
	$drawing->draw_all();
	$im = $drawing->get_im();
	$im2 = imagecreate($img_width,$img_height);
	//$im2 = imagecreate($code_generated->lastX,$code_generated->lastY);
	//$im2 = imagecreate($code_generated->lastX,$code_generated->lastY+ 20);
	$background = imagecolorallocate($im2, 255, 255, 255);
	if ($strText != 'Error') {
		imagecopyresized($im2, $im, 4+($img_width -10 -$code_generated->lastX)/2-10, 25, 0, 0, $code_generated->lastX, $code_generated->lastY, $code_generated->lastX, $code_generated->lastY);
		$strBrench = '哥大英語'.$strBrench;
		$imagebox = calculateTextBox($strBrench,$use_font,12,0);
		$im = imagecreate($img_width -10,$imagebox["height"] + 5);
		imagefill($im, 0,0, imagecolorallocate($im,$strColor['r'],$strColor['g'],$strColor['b'])); 
		imagettftext($im, 12, 0, 2+($img_width -10 -$imagebox["width"])/2, 16,  imagecolorallocate ($im,0,0,0), $use_font, $strBrench);
		imagecopyresized($im2, $im, 4, 0, 0, 0,$img_width -10,$imagebox["height"] + 5, $img_width -10,$imagebox["height"] + 5);
		$imagebox = calculateTextBox(str_replace(' ','1',$strTitle),$use_font,12,0);
		$im = imagecreate($img_width -6,$imagebox["height"] + 5);
		imagefill($im, 0,0, imagecolorallocate($im,$strColor['r'],$strColor['g'],$strColor['b'])); 
		imagettftext($im, 12, 0, 2+($img_width -10 -$imagebox["width"])/2, 13,  imagecolorallocate ($im,0,0,0), $use_font, $strTitle);
		imagecopyresized($im2, $im, 4, 30 + $code_generated->lastY, 0, 0,$img_width -10,$imagebox["height"] + 5, $img_width -6,$imagebox["height"] + 5);
		//imagestring($im2, 1, 5, $code_generated->lastY,  "哥大", $text_color);
		if ($ad == 1) {
			$ad = "(AD)";
			$imagebox = calculateTextBox($ad,$use_font,12,0);
			$im = imagecreate($imagebox["width"] + 5,$imagebox["height"] + 5);
			imagefill($im, 0,0, imagecolorallocate($im,255,255,255)); 
			imagettftext($im, 12, 0, 0, 16,  imagecolorallocate ($im,0,0,0), $use_font, $ad);
			imagecopyresized($im2, $im, 200, 30, 0, 0,$imagebox["width"] + 5,$imagebox["height"] + 5, $imagebox["width"] + 5,$imagebox["height"] + 5);
		}
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