<?php
require('../vendor/autoload.php');

use Intervention\Image\ImageManagerStatic as Image;

$image = Image::make('../img/content/burger.png');
$image->resize(200, null, function ($img) {
    $img->aspectRatio();
})
->rotate(90)
->text('WATERMARK',
    $image->width() / 2,
    $image->height() / 2,
    function ($font) {
        $font->color(array(255, 0, 0, 0.5));
        $font->align('center');
        $font->valign('center');
    })
->save('changed.png', 80);
echo 'success';
