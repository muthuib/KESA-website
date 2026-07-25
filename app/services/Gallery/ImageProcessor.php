<?php

namespace App\Services\Gallery;

use App\Models\GalleryPhoto;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageProcessor
{
    /**
     * Image size configuration.
     */
    private array $sizes = [

        'thumbnail' => [

            'width'   => 300,
            'height'  => 220,
            'fit'     => true,
            'quality' => 85,

        ],

        'small' => [

            'width'   => 800,
            'height'  => null,
            'fit'     => false,
            'quality' => 90,

        ],

        'medium' => [

            'width'   => 1400,
            'height'  => null,
            'fit'     => false,
            'quality' => 90,

        ],

        'large' => [

            'width'   => 2200,
            'height'  => null,
            'fit'     => false,
            'quality' => 92,

        ]

    ];

    /**
     * Main processing method.
     */
    public function process(GalleryPhoto $photo)
    {
        $event = $photo->event;

        $original = public_path($photo->original_path);

        if (!File::exists($original)) {

            throw new \Exception(
                "Original image not found."
            );

        }

        $image = Image::make($original);

        /*
         * Automatically fix camera orientation.
         */

        $image->orientate();

        /*
         * Save metadata.
         */

        $photo->update([

            'width'     => $image->width(),

            'height'    => $image->height(),

            'mime_type' => $image->mime()

        ]);

        /*
         * Ensure folders exist.
         */

        $this->verifyFolders($event->slug);

        /*
         * Generate thumbnail.
         */

        $this->generateThumbnail(

            clone $image,

            $photo,

            $event->slug

        );

       $this->generateSmall(
            clone $image,
            $photo,
            $event->slug
        );

        $this->generateMedium(
            clone $image,
            $photo,
            $event->slug
        );

        $this->generateLarge(
            clone $image,
            $photo,
            $event->slug
        );

        return true;
    }
    protected function generateSmall(
    $image,
    GalleryPhoto $photo,
    $slug
    )
    {
        $config = $this->sizes['small'];

        $destination = public_path(
            "gallery/{$slug}/small/{$photo->file_name}"
        );

        $this->resize(
            $image,
            $config['width'],
            $config['quality'],
            $destination
        );

        $photo->update([
            'small_path' =>
                "gallery/{$slug}/small/{$photo->file_name}"
        ]);
    }

    protected function generateMedium(
    $image,
    GalleryPhoto $photo,
    $slug
    )
    {
        $config = $this->sizes['medium'];

        $destination = public_path(
            "gallery/{$slug}/medium/{$photo->file_name}"
        );

        $this->resize(
            $image,
            $config['width'],
            $config['quality'],
            $destination
        );

        $photo->update([
            'medium_path' =>
                "gallery/{$slug}/medium/{$photo->file_name}"
        ]);
    }

    protected function generateLarge(
    $image,
    GalleryPhoto $photo,
    $slug
    )
    {
        $config = $this->sizes['large'];

        $destination = public_path(
            "gallery/{$slug}/large/{$photo->file_name}"
        );

        $this->resize(
            $image,
            $config['width'],
            $config['quality'],
            $destination
        );

        $photo->update([
            'large_path' =>
                "gallery/{$slug}/large/{$photo->file_name}"
        ]);
    }
    /**
     * Verify gallery folders.
     */
    protected function verifyFolders($slug)
    {
        $folders = [

            'originals',

            'thumbnails',

            'small',

            'medium',

            'large'

        ];

        foreach ($folders as $folder) {

            $path = public_path(

                "gallery/{$slug}/{$folder}"

            );

            if (!File::exists($path)) {

                File::makeDirectory(

                    $path,

                    0755,

                    true

                );

            }

        }
    }

    /**
     * Generate thumbnail.
     */
    protected function generateThumbnail(
        $image,
        GalleryPhoto $photo,
        $slug
    ) {

        $config = $this->sizes['thumbnail'];

        $image->fit(

            $config['width'],

            $config['height']

        );

        $destination = public_path(

            "gallery/{$slug}/thumbnails/{$photo->file_name}"

        );

        $image->save(

            $destination,

            $config['quality']

        );

        $photo->update([

            'thumbnail_path' =>

                "gallery/{$slug}/thumbnails/{$photo->file_name}"

        ]);

    }

    /**
     * Generic resize helper.
     */
    protected function resize(
    $image,
    $width,
    $quality,
    $destination
    )
    {
        /*
        * Never enlarge images.
        */
        if ($image->width() <= $width) {

            $image->save(
                $destination,
                $quality
            );

            return;
        }

        $image->resize(

            $width,

            null,

            function ($constraint) {

                $constraint->aspectRatio();

                $constraint->upsize();

            }

        );

        $image->save(
            $destination,
            $quality
        );
    }

    /**
     * Return image configuration.
     */
    public function sizes()
    {
        return $this->sizes;
    }
    public function processEvent($event)
    {
        $photos = $event->photos;

        foreach ($photos as $photo) {

            try {

                $this->process($photo);

            } catch (\Throwable $e) {

                logger()->error(

                    "Gallery processing failed",

                    [

                        'photo_id' => $photo->id,

                        'error' => $e->getMessage()

                    ]

                );

            }

        }

        return true;
    }

}