<?php

function validateImage($base64Image)
{
    // Check if empty
    if (empty($base64Image)) {
        return ['valid' => false, 'message' => 'Gambar tidak boleh kosong'];
    }

    // Check file size (max 5MB)
    $imageData = base64_decode(str_replace('data:image/jpeg;base64,', '', $base64Image));
    $size = strlen($imageData);
    if ($size > 5 * 1024 * 1024) {
        return ['valid' => false, 'message' => 'Ukuran gambar maksimal 5MB'];
    }

    // Check image dimensions
    $tempFile = tmpfile();
    fwrite($tempFile, $imageData);
    $path = stream_get_meta_data($tempFile)['uri'];

    $imageInfo = getimagesize($path);
    fclose($tempFile);

    if ($imageInfo === false) {
        return ['valid' => false, 'message' => 'Format gambar tidak valid'];
    }

    return ['valid' => true, 'data' => $imageData];
}
