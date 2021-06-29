<?php

namespace common\components;

use yii\imagine\Image;
use yii\web\UploadedFile;
use Yii;
use yii\base\Component;

/**
 * Class UploadImageComponent
 * @package common\components
 */
class UploadImageComponent extends Component
{
    public function init()
    {
        parent::init();
    }

    /**
     * @param UploadedFile $file
     * @param string $directory
     *
     * @return false|string
     */
    public function uploadFile(UploadedFile $file, string $directory)
    {
        $path = Yii::getAlias(sprintf("@frontend/web/img/%s/", $directory));

        if (!empty($file)) {
            $filePath = $path . $file->baseName . '.' . $file->extension;
            $file->saveAs($filePath);

            if ($directory == "gallery") {
//                $sizeImage = getimagesize($filePath);
//                $imageWidth = $sizeImage[0];
//                $imageHeight = $sizeImage[1];
//                $minValue = min($imageWidth, $imageHeight);

//                if ($minValue < 600) {
//                    Image::thumbnail($filePath, $minValue, $minValue)->save($filePath);
//                } else {
                    Image::thumbnail($filePath, 450, 450)->save($filePath);
//                }
            }

            return sprintf("/img/%s/%s.%s", $directory, $file->baseName, $file->extension);
        }

        return false;
    }

    /**
     * @param string $name
     */
    public function deleteFile(string $name)
    {
        $path = Yii::getAlias(sprintf("@frontend/web/%s", $name));
        unlink($path);
    }
}
