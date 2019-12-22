<?php

namespace App\Library;

use Intervention\Image\ImageManagerStatic;
use Intervention\Image\Image;

class ImageProc
{
    public const IMAGE_DIR = 'image'. DIRECTORY_SEPARATOR;

    public $base_dir;
    public $save_dir = '';
    public $public_cache_dir = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->base_dir = storage_path(). DIRECTORY_SEPARATOR. 'app'. DIRECTORY_SEPARATOR. self::IMAGE_DIR;
        $this->public_cache_dir = storage_path(). DIRECTORY_SEPARATOR. 'app'. DIRECTORY_SEPARATOR. 'public'. DIRECTORY_SEPARATOR. ImageProc::IMAGE_DIR;
    }

    /**
     * setDir 保存先フォルダの設定
     * @param string $dir_name
     */
    public function setDir(string $dir_name)
    {
        $this->save_dir = $dir_name. DIRECTORY_SEPARATOR;
    }

    /**
     * imgUpload 画像を生成
     * @param  file   $img_file
     * @param  array  $trim     画像トリミング情報 [x y w h r f]
     * @return string           保存ファイル名
     */
    private function create($img_file, $dir, $file_name, $trim=[])
    {
        $image = ImageManagerStatic::make($img_file);
        //トリミング
        if (!empty($trim['w']) && !empty($trim['h'])) {
            $image->crop($trim['w'], $trim['h'], $trim['x'], $trim['y']);
        }
        //画像回転
        if (!empty($trim['r'])) {
            $image->rotate(-$trim['r']);
        }
        //画像反転
        if (!empty($trim['f'])) {
            if($trim['f'] == -1) {
                $image->flip();
            }
        }

        //画像を保存
        $image->save($dir. $file_name);

        return $this->save_dir. $file_name;
    }

    /**
     * deleteCashe キャッシュ画像の削除
     * @param  string  $file_name ファイル名
     * @param  boolean  $base_del
     */
    private function deleteCashe($file_name, $base_del=true)
    {
        //ベース画像削除
        if ($base_del) {
            \File::delete($this->base_dir. $file_name);
            \File::delete($this->base_dir. str_replace( '.', '_prv.', $file_name));
        }
        //キャッシュ画像削除
        foreach(config('constKey.IMG_SIZE') as $key => $val) {
            $cache_name = str_replace( '.', '_'. $val. '.', $file_name);
            \File::delete($this->base_dir. $cache_name);
            \File::delete($this->public_cache_dir. $cache_name);

            $cache_filter_name = str_replace( '.', '_'. $val. '_filter.', $file_name);
            \File::delete($this->base_dir. $cache_filter_name);
            \File::delete($this->public_cache_dir. $cache_filter_name);
        }
        return;
    }

    /**
     * imgUpload 初期、画像アップロード
     * @param  file   $uplode_file
     * @param  int    $img_stat
     * @param  array  $trim        画像トリミング情報 [x y w h r f]
     * @return string              保存ファイル名
     */
    public function imgUpload($uplode_file, $img_stat, $trim=[])
    {
        //保存先ディレクトリ、ファイル名生成
        $this->save_dir .= date('Y/md'). DIRECTORY_SEPARATOR;
        $s_dir = $this->base_dir. $this->save_dir;

        if (!file_exists($s_dir)) {
            \File::makeDirectory($s_dir, 0777, true);
        }
        $file_name = date('His'). substr(md5(time().rand()), 0, 6). '.'. $uplode_file->getClientOriginalExtension();

        //ベース画像を作成
        $base_file = $file_name;
        if ($img_stat !== config('constKey.IMG_STAT.RELEASE')) {
            $base_file = str_replace( '.', '_prv.', $base_file);
        }
        $this->create($uplode_file, $s_dir, $base_file, $trim);

        //編集用にオリジナルファイルを保存
        $uplode_file->move($s_dir, str_replace( '.', '_org.', $file_name));

        return $this->save_dir. $file_name;
    }


    /**
     * tempImg作成、保存済みの画像のコピーtemp
     * @param $file_name
     * @param $img_stat
     * @param array $trim
     * @return string
     */
    public function imgUploadFromPath($file_name, $img_stat , $trim=[])
    {
        $this->save_dir .= date('Y/md'). DIRECTORY_SEPARATOR;
        $s_dir = $this->base_dir. $this->save_dir;
        if (!file_exists($s_dir)) {
            \File::makeDirectory($s_dir, 0777, true);
        }

        $pathInfo = pathinfo($file_name);
        $new_file_name = date('His'). substr(md5(time().rand()), 0, 6). '.'. $pathInfo['extension'];
        $base_file = $new_file_name;

        if ($img_stat !== config('constKey.IMG_STAT.RELEASE')) {
            $base_file = str_replace( '.', '_prv.', $base_file);
        }


        //image_create
        $image = $this->getOriginalImg($file_name);


        //編集用にオリジナルファイルをコピー
        $image->save($s_dir. str_replace( '.', '_org.', $new_file_name), 90);

        $read = $this->base_dir. $file_name;
        if (!file_exists($read)) {
            $read = str_replace( '.', '_prv.', $read);
        }
        $image = ImageManagerStatic::make($read);

        //トリミング
        if (!empty($trim['w']) && !empty($trim['h'])) {
            $image->crop($trim['w'], $trim['h'], $trim['x'], $trim['y']);
        }
        //画像回転
        if (!empty($trim['r'])) {
            $image->rotate(-$trim['r']);
        }
        //画像反転
        if (!empty($trim['f'])) {
            if($trim['f'] == -1) {
                $image->flip();
            }
        }

        //画像を保存
        $image->save($s_dir. $base_file);
        return $this->save_dir. $new_file_name;
    }

    /**
     * imgChange 画像編集
     * @param  string $uplode_file ファイル名
     * @param  array  $trim        画像トリミング情報 [x y w h r f]
     */
    public function imgChange($file_name, $img_stat, $trim=[])
    {
        //非公開時の名前
        $private_name = str_replace( '.', '_prv.', $file_name);

        //ベース画像の名前
        $base_name = $file_name;
        if ($img_stat !== config('constKey.IMG_STAT.RELEASE')) {
            $base_name = $private_name;
        }

        //キャッシュを作成するベース画像名の変更
        if ($img_stat !== config('constKey.IMG_STAT.RELEASE')) {
            if(!\File::exists($this->base_dir. $private_name)){
                \File::move($this->base_dir. $file_name, $this->base_dir. $private_name);
            }
        } else {
            if(!\File::exists($this->base_dir. $file_name)){
                \File::move($this->base_dir. $private_name, $this->base_dir. $file_name);
            }
        }

        //画像ファイルの編集がない場合、ここで終了
        if( empty(array_sum($trim)) ) {
            return;
        }

        $pathBaseInfo = pathinfo($base_name);
        $s_path = $this->base_dir. $pathBaseInfo['dirname']. DIRECTORY_SEPARATOR;

        //リサイズ無し、回転だけ変更した場合はベース画像を回転しておわり
        if( $trim['x']+$trim['y']+$trim['w']+$trim['h'] === 0 ) {
            $this->deleteCashe($file_name, false);
            $oImg = ImageManagerStatic::make($s_path. $pathBaseInfo['basename']);
            $this->create($oImg, $s_path, $pathBaseInfo['basename'], $trim);
            return;
        }

        //古い画像を削除し、
        $this->deleteCashe($file_name);
        //オリジナル画像から新しいベース画像を作成
        $pathInfo = pathinfo($file_name);
        $oImg = ImageManagerStatic::make($s_path. str_replace( '.', '_org.', $pathInfo['basename']));
        $this->create($oImg, $s_path, $pathBaseInfo['basename'], $trim);
    }

    /**
     * imgDel 画像削除
     * @param  [type] $uplode_file [description]
     * @return string              [description]
     */
    public function imgDel($file_name)
    {
        //キャッシュ画像削除
        $this->deleteCashe($file_name);
        //オリジナル画像削除
        \File::delete($this->base_dir. str_replace( '.', '_org.', $file_name));
    }

    /**
     * getOriginalImg 画像ファイル名
     * @return file   image
     */
    public function getOriginalImg($file)
    {
        $read = $this->base_dir. str_replace( '.', '_org.', $file);
        if (!file_exists($read)) {
            \Log::info('オリジナル画像無い：'. $originalpath);
            return self::no_image('xl');
        }
        return ImageManagerStatic::make($read);
    }

    /**
     * [imgPublicCache 公開フォルダに画像キャッシュ作成]
     * @param  string $original [description]
     * @param  string $size     [description]
     * @param  int    $effect   [description]
     * @param  string $bgcolor  [description]
     * @return [type]           [description]
     */
    public function imgPublicCache($original, $size, $effect=0, $bgcolor='#ffffff')
    {
        return $this->makeCasheImg($original, $size, $effect, $bgcolor, false);
    }

    /**
     * imgPrivateCache 非公開フォルダに画像キャッシュ作成.
     * @param  string $original [description]
     * @param  string $size     [description]
     * @param  int    $effect   [description]
     * @param  string $bgcolor  [description]
     * @return [type]           [description]
     */
    public function imgPrivateCache($original, $size, $effect=0, $bgcolor='#ffffff')
    {
        if (!file_exists($this->base_dir. $this->save_dir. $original)) {
            $original = str_replace( '.', '_prv.', $original);
        }
        return $this->makeCasheImg($original, $size, $effect, $bgcolor, true);
    }

    /**
     * [no_image description]
     * @param  [type] $size [description]
     * @return [type]       [description]
     */
    public function no_image($size)
    {
        $file = public_path(). DIRECTORY_SEPARATOR. config('constKey.NO_IMAGE_PATH');
        if (empty($size)) {
            $noimageCache = $this->public_cache_dir. config('constKey.NO_IMAGE_PATH');
            if (file_exists($noimageCache)) {
                return ImageManagerStatic::make($noimageCache);
            }
            $cashenoImage = ImageManagerStatic::make($file);
            $cashenoImage->save($noimageCache);
            return $cashenoImage;
        }

        $size = empty(config('constKey.IMG_SIZE.'. $size))? 's': $size;
        $noimageCache = $this->public_cache_dir. str_replace( '.', '_'. config('constKey.IMG_SIZE.'. $size). '.', config('constKey.NO_IMAGE_PATH'));
        //キャッシュ画像アリ
        if (file_exists($noimageCache)) {
            return ImageManagerStatic::make($noimageCache);
        }
        //キャッシュ作成
        $noimage = ImageManagerStatic::make($file);
        list($cacheX, $cacheY) = explode('x', config('constKey.IMG_SIZE.'. $size));
        $cashenoImage = ImageManagerStatic::canvas($cacheX, $cacheY, '#ffffff');
        if ($noimage->width() > $noimage->height()) {
            $noimage->widen($cacheX);
        } else {
            $noimage->heighten($cacheY);
        }
        $cashenoImage->insert($noimage, 'center');
        $cashenoImage->save($noimageCache);

        return $cashenoImage;
    }

    /**
     * makeCasheImg 画像キャッシュ作成
     * @param  string $original [description]
     * @param  string $size     [description]
     * @param  int    $effect   [description]
     * @param  string $bgcolor  [description]
     * @param  bool   $private
     * @return [type]           [description]
     */
    private function makeCasheImg($original, $size, $effect, $bgcolor, $private)
    {
        $originalpath = $this->base_dir. $this->save_dir. $original;
        if (!file_exists($originalpath)) {
            \Log::info('ベース画像無い：'. $originalpath);
            return self::no_image($size);
        }

        if (empty(config('constKey.IMG_SIZE.'. $size))) {
            \Log::info('サイズが無い：'. '['. $size. ']'. $originalpath);
            return self::no_image($size);
        }

        $cacheName = '_'. config('constKey.IMG_SIZE.'. $size);
        if (!empty($effect)) {
            $cacheName .= '_filter';
        }
        $cacheDir = '';
        if ($private) {
            //非公開ディレクトリへ作成
            $pathInfo = pathinfo($originalpath);
        } else {
            //公開ディレクトリへ作成
            $pathInfo = pathinfo($original);
            $cacheDir = $this->public_cache_dir. $this->save_dir;
        }
        $cacheDir .= $pathInfo['dirname'];
        $cacheFile = $cacheDir. DIRECTORY_SEPARATOR. $pathInfo['filename'].  $cacheName. '.'. $pathInfo['extension'];
        $cacheFile = str_replace( '_prv', '', $cacheFile);;

        //キャッシュ画像アリ
        if (file_exists($cacheFile)) {
            return ImageManagerStatic::make($cacheFile);
        }
        //キャッシュディレクトリが無ければ作成
        if (!file_exists($cacheDir)) {
            \File::makeDirectory($cacheDir, 0777, true);
        }

        \Log::debug('キャッシュ画像作成：'. $cacheFile);
        list($cacheX, $cacheY) = explode('x', config('constKey.IMG_SIZE.'. $size));
        $orignImage = ImageManagerStatic::make($originalpath);
        $casheImage = ImageManagerStatic::canvas($cacheX, $cacheY, $bgcolor);
        //アスペクト
        if ($orignImage->width() > $orignImage->height()) {
            $orignImage->widen($cacheX);
        } else {
            $orignImage->heighten($cacheY);
        }
        //エフェクト
        if ($effect) {
            $orignImage->blur($effect);
            $orignImage->pixelate($effect);
        }
        $casheImage->insert($orignImage, 'center');

        //ロゴ
/*        if (!$private) {
            $logo = $this->insertionStrPosition($size);
            $f_size = $logo['size'];
            $casheImage->text( config('app.name'), $cacheX/2+$logo['x'], $cacheY-$logo['y'], function($font) use ($f_size) {
                $font->file(public_path('fonts/Kokoro.otf'));
                $font->size($f_size);
                $font->color('#000000');
                $font->align('left');
                $font->valign('buttom');
                $font->angle(0);
            });
        }*/
        $casheImage->save($cacheFile);

        return $casheImage;
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

    /**
     * [seedingDummyImg シーディング用画像]
     * @param  [type] $dummy_file [description]
     * @param  [type] $filesystem [description]
     * @return [type]             [description]
     */
    public function seedingDummyImg($dummy_file)
    {
        //保存先ディレクトリ、ファイル名生成
        $ym = date('Y/md'). DIRECTORY_SEPARATOR;
        $dummy_s_dir = $this->base_dir. $this->save_dir. $ym;
        if (!file_exists($dummy_s_dir)) {
            \File::makeDirectory($dummy_s_dir, 0777, true);
        }
        $pathInfo = pathinfo($dummy_file);
        $dummy_make_name = date('His'). substr(md5(time().rand().rand()), 0, 6). '.'. $pathInfo['extension'];
        //ダミー画像から新しいベース画像を作成
        $dImg = ImageManagerStatic::make($dummy_file);
        $this->create($dImg, $dummy_s_dir, $dummy_make_name, []);
        $this->create($dImg, $dummy_s_dir, str_replace( '.', '_org.', $dummy_make_name), []);

        return $this->save_dir. $ym. $dummy_make_name;
    }

    /**
     * [seedingCleanDir シーディング以外では呼ばない事]
     * @return [type]      [description]
     */
    public function seedingCleanDir()
    {
        \File::cleanDirectory($this->base_dir. $this->save_dir);
        \File::cleanDirectory($this->public_cache_dir. $this->save_dir);
    }

    /**
     * imageCacheUrl キャッシュ画像URL生成 
     * @param  string $file    [description]
     * @param  string $size    [description]
     * @param  int    $filter  [description]
     * @return string          [description]
     */
    static public function imageCacheUrl( $file, $size='m', $filter=0)
    {
        if (empty($file)) {
            $file = config('constKey.NO_IMAGE_PATH');
        }
        $con_size = config('constKey.IMG_SIZE.'. $size);
        if (empty($con_size)) {
            $size = 'm';
        }
        $file = str_replace( '.', '_'. config('constKey.IMG_SIZE.'. $size). '.', $file);

        if ($filter) {
            $file = str_replace( '.', '_filter.', $file);
        }

        return '/storage/'. ImageProc::IMAGE_DIR. $file;
    }

    /**
     * adminCacheUrl キャッシュ画像URL生成 [ブレードからコール]
     * @param  string $file    [description]
     * @param  string $size    [description]
     * @param  int    $filter  [description]
     * @return string          [description]
     */
    static public function adminCacheUrl( $file, $size='m', $filter=0)
    {
        if (empty($file)) {
            return self::imageCacheUrl( null);
        }
        $con_size = config('constKey.IMG_SIZE.'. $size);
        if (empty($con_size)) {
            $size = 'm';
        }
        $file = str_replace( '.', '_'. config('constKey.IMG_SIZE.'. $size). '.', $file);

        if ($filter) {
            $file = str_replace( '.', '_filter.', $file);
        }

        return '/admin/api/storage/'. $file;
    }
}
