<?php

namespace App\Services;

use App\Models\Media;
use App\Traits\FilesUploadTrait;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    use FilesUploadTrait;

    public function addMedia($files, int $mediaType)
    {
        if(empty($files))
            return;
        $fileInfo = [];
        $fileInfo['mediaType'] = $mediaType;
        $outputFiles = [];
        if(is_array($files)){
            foreach($files as $file){
                $fileInfo['filename'] = $file->getClientOriginalName();
                $outputFiles[] = $this->create($file, $fileInfo);
            }
            return $outputFiles;
        }
        else{
            $fileInfo['filename'] = $files->getClientOriginalName();
            return $this->create($files, $fileInfo);
        }
    }

    public function create($file, $fileInfo)
    {
        $path = $this->saveFile($fileInfo['filename'], $file, true);
        $media = Media::create([
            'url' => $path,
            'media_type_id' => $fileInfo['mediaType'],
        ]);
        return $media;
    }
    public function delete($mediaId)
    {
        $media = Media::find($mediaId);
        if($media){
            $filename = explode('/', $media->url)[2];
            Storage::disk('public')->delete($filename);
            $media->delete();
            return true;
        }
        return false;
    }
    public function getUrl($mediaId)
    {
        $media = Media::find($mediaId);
        if($media){
            return Storage::path($media->url);
        }
        return null;
    }

}
