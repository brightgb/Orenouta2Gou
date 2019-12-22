<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\ImageProc;

class ImageController extends Controller
{
    private $size;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * getBaseFile URLからベース画像パスを取得
     * @param  string $file_name [description]
     * @return string
     */
    private function getBaseFile(string $file_name)
    {
        $fileInfo = pathinfo($file_name);
        $f = explode('_', $fileInfo['filename']);
        $extension = empty($fileInfo['extension'])? '.jpg': '.'. $fileInfo['extension'];
        $original_path = $f[0] . $extension;
        $si = '';
        if (!empty($f[1])) {
            $si = array_search( $f[1], config('constKey.IMG_SIZE'));
            if (empty($si)) {
                abort(404);
            }
        }
        $this->size = $si;
        return $original_path;
    }

    /**
     * Show the performer paid images.
     * @return image
     */
    public function noImage(Request $request, $file)
    {
        $original_path = $this->getBaseFile($file);
        $imgProc = new ImageProc();
        return $imgProc->no_image($this->size)->response();
    }

    /**
     * Show the member profile images.
     * @return image
     */
    public function memberProfileImage(Request $request, $year, $mday, $file)
    {
        $original_path = $year. DIRECTORY_SEPARATOR. $mday. DIRECTORY_SEPARATOR;
        $original_path .= $this->getBaseFile($file);

        $imgProc = new ImageProc();
        $imgProc->setDir(config('constKey.MEMBER_PROFILE_IMG_DIR'));

        return $imgProc->imgPublicCache($original_path, $this->size)->response();
    }

    /**
     * Show the performer free images.
     * @return image
     */
    public function performerProfileImage(Request $request, $year, $mday, $file)
    {
        $original_path = $year. DIRECTORY_SEPARATOR. $mday. DIRECTORY_SEPARATOR;
        $original_path .= $this->getBaseFile($file);

        $imgProc = new ImageProc();
        $imgProc->setDir(config('constKey.PERFORMER_IMG_FREE_DIR'));

        return $imgProc->imgPublicCache($original_path, $this->size)->response();
    }

    /**
     * Show the performer premium images.
     * @return image
     */
    public function performerPremiumImage(Request $request, $year, $mday, $file)
    {
        $original_path = $year. DIRECTORY_SEPARATOR. $mday. DIRECTORY_SEPARATOR;
        $original_path .= $this->getBaseFile($file);

        $imgProc = new ImageProc();
        $imgProc->setDir(config('constKey.PERFORMER_IMG_PAID_DIR'));

        return $imgProc->imgPublicCache($original_path, $this->size, 25)->response();
    }
}