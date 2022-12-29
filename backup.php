<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();

$titulo = "backup-" . date("d-m-Y");
/*
$rootPath = realpath('assets');

$zip = new ZipArchive();
$zip->open('backup/' . $titulo . '.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);

foreach ($files as $name => $file) {
    if (!$file->isDir()) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);
        $zip->addFile($filePath, $relativePath);
    }
}

$zip->close();
*/

$dbBackup = new Clases\DBBackup;
$tables = '*';
$dbBackup->backupDatabase($tables = '*', 'backup');

?>