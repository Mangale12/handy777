<?php
session_start();

 $width = 135;
        $height = 50;
        $font_size = 20;
        $font = "verdana.ttf";
        $font = realpath($font);
        $chars_length = 4;

        $captcha_characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $image = imagecreatetruecolor($width, $height);
        $bg_color = imagecolorallocate($image, 85, 108, 138);
        $font_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image, 0, 0, $width, $height, $bg_color);

        //background random-string-random-pos
        $hori_line = round($height / 8);
        $vert_line = round($width / 8);
        $random_string = '.';
        $color = imagecolorallocate($image, 255, 255, 255);
        for ($i = 0; $i < $vert_line; $i++) {
            for ($j = 0; $j < $hori_line; $j++) {
                $random_letter = $random_string[rand(0, strlen($random_string) - 1)];
                imagestring($image, rand(1, 2), rand(0, $width), rand(0, $height), $random_letter, $color);
            }
        }

        $xw = ($width / $chars_length);
        $x = 0;
        $font_gap = $xw / 2 - $font_size / 2;
        $digit = '';
        for ($i = 0; $i < $chars_length; $i++) {
            $letter = $captcha_characters[rand(0, strlen($captcha_characters) - 1)];
            $digit .= $letter;
            if ($i == 0) {
                $x = 0;
            } else {
                $x = $xw * $i;
            }
            imagettftext($image, $font_size, rand(-20, 20), $x + $font_gap, rand(22, $height - 5), $font_color, $font, $letter);
        }

        // record token in session variable
        $_SESSION['captcha_token'] = strtolower($digit);

        // display image
        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);

?>