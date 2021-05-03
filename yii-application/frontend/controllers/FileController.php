<?php

namespace frontend\controllers;

use common\models\Collection;
use common\models\Photo;
use Exception;
use igogo5yo\uploadfromurl\UploadFromUrl;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Yii;
use yii\helpers\BaseFileHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use ZipArchive;

class FileController extends Controller
{

    public function actionDownloadPhoto($photoId)
    {
        $userId = Yii::$app->user->id;
        $photo = Photo::findOne($photoId);
        $fileToDownload = $this->searchFilePath($userId, $photo->collection_id, $photo->photo_id);

        if (!$fileToDownload) {
            Yii::$app->session->setFlash("error", "Resource not found");

            return $this->redirect(array("collection/index"));
        }

        Yii::$app->getResponse()->sendFile($fileToDownload);
    }

    public function actionDownloadFavorites($collectionId)
    {
        $userId = Yii::$app->user->id;
        $collection = Collection::findOne($collectionId);
        $path = $this->getPathBase($userId, $collectionId) . "*";
        $listFiles = glob($path);
        $zipname = time() . "_" . $collection->title . ".zip";
        $zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE);

        foreach ($listFiles as $file) {
            $parts = explode(DIRECTORY_SEPARATOR, $file);
            $zip->addFile($file, end($parts));
        }

        $zip->close();
        Yii::$app->getResponse()->sendFile($zipname);
        // chmod($zipname, 0744);
        unlink($zipname);
    }

    

    private function searchFilePath($userId,  $collectionId,  $photoId)
    {
        $fileToDownload = null;
        $path = $this->getPathBase($userId, $collectionId) . "*";
        $listFiles = glob($path);

        foreach ($listFiles as $filename) {
            if (str_contains($filename, $photoId)) {
                $fileToDownload = $filename;
            }
        }

        return $fileToDownload;
    }
    private function getPathBase($userId,  $collectionId = null)
    {
        $dir = 'uploads' . DIRECTORY_SEPARATOR . $userId . DIRECTORY_SEPARATOR;
        if ($collectionId) {
            $dir .= $collectionId . DIRECTORY_SEPARATOR;
        }

        return $dir;
    }

    public static function uploadImage($url,  $userId, $collectionId,  $photoId)
    {
        $ext = self::getExtension($url);
        $path = 'uploads' . DIRECTORY_SEPARATOR . $userId . DIRECTORY_SEPARATOR . $collectionId;
        BaseFileHelper::createDirectory($path);
        $file = UploadFromUrl::initWithUrl($url);
        $file->saveAs($path . DIRECTORY_SEPARATOR . "$photoId$ext");
    }

    private static function getExtension($url)
    {
        try {
            $aux =  explode("&fm=", $url)[1];

            return "." . explode("&", $aux, 2)[0];
        } catch (Exception $e) {
            return "";
        }
    }

    public static function removeFile($userId,  $collectionId,  $photoId)
    {
        $path = 'uploads' . DIRECTORY_SEPARATOR . $userId . DIRECTORY_SEPARATOR;
        if ($collectionId) {
            $path .= $collectionId;
            if ($photoId) {
                $path .= DIRECTORY_SEPARATOR . $photoId . ".*";
            }
        }
        $listFiles = glob($path);
        $filename = null;
        foreach ($listFiles as $filename) {
            if (str_contains($filename, $photoId)) {
                $filename = $filename;
            }
        }

        if ($filename) {
            unlink($filename);
        }
    }

    public static function removeDir($userId,  $collectionId)
    {
        $dir = 'uploads' . DIRECTORY_SEPARATOR . $userId . DIRECTORY_SEPARATOR;
        if ($collectionId) {
            $dir .= $collectionId . DIRECTORY_SEPARATOR;
        }
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator(
            $it,
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }
}
