<?php
namespace Lvlfr\Documentation\Services\DocUpdaterInterface;

use \Lvlfr\Documentation\Services\DocUpdaterInterface;
use \Config;

class File implements DocUpdaterInterface {

    public $tmpDir;
    public $filePath;

    public function __construct()
    {

        $this->tmpDir = value(Config::get('LvlfrDocumentation::docs.admin.tmpDir'));
        $this->filePath = value(Config::get('LvlfrDocumentation::docs.admin.filePath'));
        $this->putFilesIn = $this->tmpDir . '/docs';
    }

    protected function getContent()
    {

        if (!file_exists($this->filePath)) {
            throw new \Exception("The file '".$this->filePath."' does not exist.", 1);
            
        }
        copy($this->filePath, $this->tmpDir . '/doc_last.zip');

        $zip = new \ZipArchive();
        $res = $zip->open($this->tmpDir . '/doc_last.zip');
        if ($res === true) {

            $dir = $this->putFilesIn;
            $it = new \RecursiveDirectoryIterator($dir);
            $files = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);
            foreach($files as $file) {
                if ($file->getFilename() === '.' || $file->getFilename() === '..') {
                    continue;
                }
                if ($file->isDir()){
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            rmdir($dir);
            mkdir($dir);

            $zip->extractTo($this->putFilesIn);
            $zip->close();
        } else {
            throw new \Exception("Unable to unzip doc", 1);
        }
    }

    protected function copyContent()
    {
        $copyTo = base_path().Config::get('LvlfrDocumentation::docs.path');
        dd($copyTo);

        recursiveCopy($this->putFilesIn . '/documentation-master', $copyTo);
    }

    public function performUpdate()
    {
        $this->getContent();
        $this->copyContent();
    }

}