<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/11
 * Time: 21:15
 */

namespace App\Http\Controllers\Home;


use App\Http\Model\Media;
use Illuminate\Http\Request;

class UploadController extends BaseController
{
    public function upload(Request $request)
    {
        $image = $request->file('image');
        $video = $request->file('video');
        if ($image && $image->isValid()){
            $file = $image;
        }

        if ($video && $video->isValid()){
            $file = $video;
        }

        $media_size = $file->getSize();
        $mime_type = $file->getClientMimeType();
        list($media_type, $ext) = explode("/", $mime_type);
        $save_file = get_new_file_name($file);
        $path = $file->move(storage_path('app/public/upload'), $save_file);
        $media_path = $path->getPathname();
        $media_url = asset('storage/upload/') . DIRECTORY_SEPARATOR . $save_file;

        $media = new Media();
        $media->media_url = $media_url;
        $media->media_path = $media_path;
        $media->media_type = $media_type;
        $media->media_size = $media_size;
        $media->save();

        return $this->Success(array('media_id' =>$media->id, 'url' => $media_url));
    }

}