<?php

namespace App\Library;

use Intervention\Image\ImageManagerStatic;

class MovieProc
{
    public const MOVIE_DIR = 'movie'.DIRECTORY_SEPARATOR;
    public const THUMB_DIR = 'thumb'.DIRECTORY_SEPARATOR;

    public $base_movie_dir;
    public $base_thumb_dir;
    public $save_dir = '';

    public $thumb_file = '';

    /**
     * MovieProc constructor.
     */
    public function __construct()
    {
        $this->base_movie_dir = storage_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.self::MOVIE_DIR;
        $this->base_thumb_dir = storage_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.self::THUMB_DIR;
    }

    /**
     * 保存先のフォルダの設定
     *
     * @param $dir_name
     */
    public function setDir($dir_name)
    {
        $this->save_dir = $dir_name.DIRECTORY_SEPARATOR;
    }


    /**
     * 動画アップロード
     *
     * @param $upload_file
     * @return string
     */
    public function movieUpload($upload_file)
    {
        //保存先のディレクトリ、ファイル名生成
        $this->save_dir .= date('Y/md').DIRECTORY_SEPARATOR;
        $movie_path = $this->base_movie_dir.$this->save_dir;

        if (!file_exists($movie_path)) {
            \File::makeDirectory($movie_path, 0777, true);
        }
        $file_name = date('His').substr(md5(time().rand()),0,6);

        //動画保存とサムネイル作成
        $upload_file->move($movie_path, $file_name.'.'.$upload_file->getClientOriginalExtension());
        $this->createThumbnail($file_name, $upload_file->getClientOriginalExtension());

        $uploaded_file = $this->save_dir.$file_name;
        return $uploaded_file.'.'.$upload_file->getClientOriginalExtension();
    }

    /**
     * Thumbnail作成
     *
     * @param $movie_name
     * @param $movie_extension
     */
    private function createThumbnail($movie_name, $movie_extension)
    {
        $thumb_path = $this->base_movie_dir.$this->save_dir.'thumb/';

        //保存先のディレクトリ作成
        if (!file_exists($thumb_path)) {
            \File::makeDirectory($thumb_path, 0777, true);
        }

        //Thumbnail作成
        $ffmpeg = config('app.ffmpeg');
        $movie_file = $this->base_movie_dir.$this->save_dir.$movie_name.'.'.$movie_extension;
        $thumb = $thumb_path.$movie_name.'.jpg';
        $getFromSecond = 1;
        $cmd = "$ffmpeg -i $movie_file -an -ss $getFromSecond $thumb";

        shell_exec($cmd);

        $this->thumb_file = $this->save_dir.'thumb/'.$movie_name.'.jpg';
    }


    /**
     * 画像キャッシュを作成
     *
     * @param $thumb_file
     * @param $size
     * @return string
     */
    private function createThumbCache($thumb_file, $size, $private)
    {
        $originalPath = $this->base_movie_dir.$thumb_file;
        if(!file_exists($originalPath)){
            return null;
        }


        $cacheName = '_'. config('constKey.IMG_SIZE.'. $size);
        $pathInfo = pathinfo($thumb_file);

        if($private) {
            $cachePath = $this->base_movie_dir.$pathInfo['dirname'].DIRECTORY_SEPARATOR;
        } else {
            $cachePath = $this->base_thumb_dir.$pathInfo['dirname'].DIRECTORY_SEPARATOR;
        }

        if(!file_exists($cachePath)) {
            \File::makeDirectory($cachePath, 0777, true);
        }

        $cacheFile = $cachePath.$pathInfo['filename'].$cacheName.'.'.$pathInfo['extension'];

        list($cacheX, $cacheY) = explode('x', config('constKey.IMG_SIZE.'.$size));

        $originImage = ImageManagerStatic::make($originalPath);
        $cacheImage = ImageManagerStatic::canvas($cacheX, $cacheY, '#ffffff');

        //アスペクト
        if ($originImage->width() > $originImage->height()) {
            $originImage->widen($cacheX);
        } else {
            $originImage->heighten($cacheY);
        }
        $cacheImage->insert($originImage, 'center');

        //ロゴ
        if(!$private) {
            $logo = $this->insertionStrPosition($size);
            $f_size = $logo['size'];
            $cacheImage->text( config('app.name'), $cacheX/2+$logo['x'], $cacheY-$logo['y'], function($font) use ($f_size) {
                $font->file(public_path('fonts/Kokoro.otf'));
                $font->size($f_size);
                $font->color('#000000');
                $font->align('left');
                $font->valign('buttom');
                $font->angle(0);
            });
        }

        $cacheImage->save($cacheFile);

        if ($private) {
            return $cacheImage;
        }

        $pathInfo = pathinfo($thumb_file);
        return $pathInfo['dirname'].DIRECTORY_SEPARATOR.$pathInfo['filename'].$cacheName.'.'.$pathInfo['extension'];
    }


    /**
     * キャッシュ画像URL生成
     *
     * @param $thumb_file
     * @param string $size
     * @return string
     */
    public function thumbPublicCacheUrl($thumb_file, $size='m')
    {
        $con_size = config('constKey.IMG_SIZE.'.$size);
        if (empty($con_size)) {
            $size = 'm';
        }
        $thumb_cache_file = str_replace('.', '_'.config('constKey.IMG_SIZE.'.$size).'.',$thumb_file);
        if(!file_exists($this->base_thumb_dir.DIRECTORY_SEPARATOR.$thumb_cache_file)) {
            $thumb_cache_file = $this->createThumbCache($thumb_file, $size, false);
        }

        //ベース画像がない場合
        if(empty($thumb_cache_file)){
            $no_image_file = config('constKey.NO_IMAGE_PATH');
            return '/storage/image/'.str_replace('.', '_'.config('constKey.IMG_SIZE.'.$size).'.',$no_image_file);
        }

        return '/storage/thumb/'.$thumb_cache_file;
    }

    /**
     * 自分の動画のサムネイル取得
     *
     * @param $thumb_file
     * @param string $size
     * @return mixed|string
     */
    public function thumbPrivateCache($thumb_file, $size='m')
    {
        $con_size = config('constKey.IMG_SIZE.'.$size);
        if (empty($con_size)) {
            $size = 'm';
        }
        $thumb_cache_file = str_replace('.', '_'.config('constKey.IMG_SIZE.'.$size).'.',$thumb_file);
        if(file_exists($this->base_movie_dir.DIRECTORY_SEPARATOR.$thumb_cache_file)) {
            return ImageManagerStatic::make($this->base_movie_dir.DIRECTORY_SEPARATOR.$thumb_cache_file);
        } else {
            $thumb_cache_file = $this->createThumbCache($thumb_file, $size, true);
        }

        //ベース画像がない場合
        if(empty($thumb_cache_file)){
            $imgProc = new ImageProc();
            return $imgProc->no_image($size);
        }

        return $thumb_cache_file;
    }


    /**
     * 動画再生
     *
     * @param $movie_file
     */
    public function moviePlay($movie_file)
    {
        $video_file = $this->base_movie_dir.DIRECTORY_SEPARATOR.$movie_file;
        if(!file_exists($video_file)) {
            return abort(404);
        }

        $fp = @fopen($video_file, 'rb');

        $mime_type = mime_content_type($video_file);
        $size = filesize($video_file);      // File size
        $length = $size;                    // Content length
        $start = 0;                         // Start byte
        $end = $size - 1;                   // End byte

        header("Content-Type: $mime_type");
        header("Accept-Ranges: 0-$length");
        if(isset($_SERVER['HTTP_RANGE'])) {

            $c_start = $start;
            $c_end   = $end;

            list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
            if (strpos($range, ',') !== false) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $start-$end/$size");
                exit;
            }
            if ($range == '-') {
                $c_start = $size - substr($range, 1);
            }else{
                $range = explode('-', $range);
                $c_start = $range[0];
                $c_end   = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
            }
            $c_end = ($c_end > $end) ? $end : $c_end;
            if ($c_start > $c_end || $c_start > $size -1 || $c_end >= $size) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $start-$end/$size");
                exit;
            }
            $start  = $c_start;
            $end    = $c_end;
            $length = $end - $start + 1;
            fseek($fp, $start);
            header('HTTP/1.1 206 Partial Content');
        }

        header("Content-Range: bytes $start-$end/$size");
        header("Content-Length: ".$length);


        $buffer = 1024 * 8;
        while(!feof($fp) && ($p = ftell($fp)) <= $end) {

            if ($p + $buffer > $end) {
                $buffer = $end - $p + 1;
            }
            set_time_limit(0);
            echo fread($fp, $buffer);
            flush();
        }

        fclose($fp);
        exit();
    }


    /**
     * 動画読み込み
     */
    public function readVideoFile($movie_file)
    {
        $video_file = $this->base_movie_dir.DIRECTORY_SEPARATOR.$movie_file;
        if(!file_exists($video_file)) {
            return abort(404);
        }
        $fp = @fopen($video_file, 'rb');
        $mime_type = mime_content_type($video_file);
        $size = filesize($video_file); 
        header("Content-Type: $mime_type");
        $content = fread($fp, $size);
        fclose($fp);
        echo $content;
    }


    /**
     * 動画削除
     *
     * @param $movie_file
     */
    public function movieDel($movie_file)
    {
        $this->deleteThumb($movie_file);

        //オリジナル動画削除
        \File::delete($this->base_movie_dir.$movie_file);
    }


    /**
     * サムネイル画像削除
     *
     * @param $movie_file
     */
    private function deleteThumb($movie_file)
    {
        $path_info = pathinfo($movie_file);

        //キャッシュ画像削除
        foreach(config('constKey.IMG_SIZE') as $key => $val) {
            $cache_file = $this->base_thumb_dir.$path_info['dirname'].DIRECTORY_SEPARATOR.self::THUMB_DIR.$path_info['filename'].'_'.$val.'.jpg';
            \File::delete($cache_file);

            $cache_file = $this->base_movie_dir.$path_info['dirname'].DIRECTORY_SEPARATOR.self::THUMB_DIR.$path_info['filename'].'_'.$val.'.jpg';
            \File::delete($cache_file);
        }

        //オリジナル画像削除
        $original_thumb = $this->base_movie_dir.$path_info['dirname'].DIRECTORY_SEPARATOR.self::THUMB_DIR.$path_info['filename'].'.jpg';
        \File::delete($original_thumb);
    }



    /**
     * [insertionStr description]
     * @return [type] [description]
     */
    private function insertionStrPosition($size)
    {
        //フォント
        switch ($size) {
            case 's':
                $font_size = 11;
                $pos_x = 18;
                $pos_y = 2;
                break;
            case 'm':
                $font_size = 16;
                $pos_x = 33;
                $pos_y = 6;
                break;
            case 'l':
                $font_size = 32;
                $pos_x = 78;
                $pos_y = 10;
                break;
            case 'xl':
                $font_size = 48;
                $pos_x = 98;
                $pos_y = 20;
                break;
            default:
                $font_size = 11;
                $pos_x = 33;
                $pos_y = 6;
        }
        return ['size'=>$font_size, 'x'=>$pos_x, 'y'=>$pos_y];
    }
}