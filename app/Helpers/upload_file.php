<?php

use \Illuminate\Support\Facades\File;

if (!function_exists('upload_image')) {
    /**
     * @param $file [tên file trùng tên input]
     * @param array $extend [định dạng file có thể upload được]
     * @return array|int [tham số trả về là mảng - nếu có lỗi trả về int]
     */
    function upload_image($file, $folder = '', array $extend = array())
    {
        $code = 1;
        // lấy đường dẫn ảnh
        $baseFilename = public_path() . '/uploads/' . $_FILES[$file]['name'];

        $size = $_FILES[$file]['size'];
        $size = round($size / (1024), 1);

        // thông tin file
        $info = new SplFileInfo($baseFilename);

        // đuôi file
        $ext = strtolower($info->getExtension());

        // kiểm tra dạng file
        if (!$extend)
            $extend = ['png', 'jpg', 'jpeg', 'webp', 'gif'];

        if (!in_array($ext, $extend))
            return $data['code'] = 0;

        // tên file mới
        $nameFile = trim(str_replace('.' . $ext, '', strtolower($info->getFilename())));
        $filename = date('Y-m-d__') . \Illuminate\Support\Str::slug($nameFile) . '.' . $ext;;

        // thư mục góc để upload
        $path = public_path() . '/uploads/' . date('Y/m/d/');

        if ($folder)
            $path = public_path() . '/' . $folder . '/' . date('Y/m/d/');

        if (!File::exists($path))
            @mkdir($path, 0777, true);

        // di chuyển vào thư mục upload
        move_uploaded_file($_FILES[$file]['tmp_name'], $path . $filename);
        $data = [
            'name' => $filename,
            'code' => $code,
            'ext' => $ext,
            'path' => $path,
            'size' => $size,
            'path_img' => 'uploads/' . $filename
        ];
        return $data;
    }
}

if (!function_exists('pare_url_file')) {
    function pare_url_file($image, $folder = 'uploads')
    {
        if (!$image) {
            return '/images/preloader.png';
        }
        $explode = explode('__', $image);

        if (isset($explode[0])) {
            $time = str_replace('_', '/', $explode[0]);
            return '/' . $folder . '/' . date('Y/m/d', strtotime($time)) . '/' . $image;
        }
    }
}

if (!function_exists('get_data_user')) {
    function get_data_user($type, $field = 'id')
    {
        return Auth::guard($type)->user() ? Auth::guard($type)->user()->$field : '';
    }
}
