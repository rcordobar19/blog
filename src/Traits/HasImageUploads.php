<?php


namespace MetaGameTechnologies\Blog\Traits;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use MetaGameTechnologies\Blog\Http\Requests\PostImageUploadRequest;

trait HasImageUploads
{
    public function upload(PostImageUploadRequest $request)
    {
        $file = $request->file('file');
        $fileName = implode('.', [ uniqid(), $file->extension() ]);
        $storagePath = '/public/images/blog/';

        Storage::disk('local')->putFileAs($storagePath, $file, $fileName);

        $thumbnailPath = $this->createThumbnail($file, $storagePath, 690, 332);

        return response()->json([
            'preview_image_path' => $thumbnailPath,
            'post_image_path' => Storage::url('images/blog/' . $fileName),
            'message' => __('File Uploaded.')
        ]);
    }

    protected function createThumbnail($file, $storagePath, $width, $height)
    {
        $fileName = implode('.', [ uniqid(), $file->extension() ]);
        $filePath = $storagePath . $fileName;

        $image = Image::make($file);
        $image->crop($width, $height);

        Storage::disk('local')->put($filePath, (string) $image->encode());

        return Storage::url('images/blog/' . $fileName);
    }
}