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
use Image;
use DB;
use Mockery\Exception;

class UploadController extends BaseController
{
    public function upload(Request $request)
    {
        $std_width = 640;
        $std_height = 360;
        $image = $request->file('image');
        $video = $request->file('video');
        $token = $request->session()->get('home_user');
        $is_cover = $request->input('isCover') ?? 0;
        DB::beginTransaction();
        try {
            if ($image && $image->isValid()) {
                $file = $image;
                $mime_type = $file->getClientMimeType();
                list($media_type, $ext) = explode("/", $mime_type);
            } else if ($video && $video->isValid()) {
                $file = $video;
                $mime_type = $file->getClientMimeType();
                list($media_type, $ext) = explode("/", $mime_type);
                if ($media_type != 'video' && ($ext != 'mp4' || $ext != 'mov' || $ext != 'quicktime')) {
                    return $this->Error(-1, 'Wrong Video Type');
                }
                $is_cover = 1;
            } else {
                return $this->Error(-1, 'Upload Failed');
            }

            $media_size = $file->getSize();
            $temp_path = $file->getPathname();
            $save_file = get_new_file_name($file, ($token . time()));
            $storage_path = storage_path('app/public/upload');
            $media_url = asset('storage/upload/') . DIRECTORY_SEPARATOR . $save_file;
            if ($media_type == 'image') {
                $save_path = $storage_path . DIRECTORY_SEPARATOR . $save_file;
                $image = Image::make($temp_path);
                $height = $image->height();
                $width = $image->width();

                if ($height < $width) {
                    $height = $std_height;
                    $width = $std_width;
                } else {
                    $height = ceil($height) / 2;
                    $width = ceil($width / 2);
                }

                $image->resize($width, $height)->save($save_path);

            } else {
                $save_path = $file->move($storage_path, $save_file)->getPathname();
            }

            $media = new Media();
            $media->media_url = $media_url;
            $media->media_path = $save_path;
            $media->media_type = $media_type;
            $media->media_size = $media_size;
            $media->is_cover = $is_cover;
            $media->save();
            DB::commit();
            return $this->Success(array(
                'media_id' => $media->id,
                'url' => $media_url,
                'height' => $height ?? $std_height,
                'width' => $width ?? $std_width,
                'type' => $media_type
            ));
        } catch (Exception $e){
            DB::rollBack();
            return $this->Error(-1,$e->getMessage());
        }
    }

}