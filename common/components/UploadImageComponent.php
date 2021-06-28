<?php

namespace common\components;

use yii\web\UploadedFile;
use Yii;
use yii\base\Component;
use yii\base\Exception;
use yii\helpers\FileHelper;

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
     * @return string|null
     *
     * @throws Exception
     */
    public function uploadFile(UploadedFile $file, string $directory)
    {
        $path = Yii::getAlias(sprintf("@frontend/web/img/%s/", $directory));

        if (!empty($file)) {
            if (FileHelper::createDirectory($path, $mode = 0775, $recursive = true)) {
                $file->saveAs($path . $file->baseName . '.' . $file->extension);

                return sprintf("/img/%s/%s.%s", $directory, $file->baseName, $file->extension);
            }
        }
        return null;
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
