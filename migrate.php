<?php

$inputPath = './old_translations/';
$outputPath = './new_translations/';

function write($path, $data) {
    if (!file_exists(dirname($path))) { // Checks if directory path to file exists
        if (!@mkdir(dirname($path), 0755, true)) {
            throw new Exception('Can\'t create directory '.dirname($path));
        }
    }

    return file_put_contents($path, $data);
}

// List contents of $inputPath and filter out directories 
$files = array_filter(scandir($inputPath), function($file) use ($inputPath) {
    return is_file($inputPath . $file);
});
// Get the language prefixes$languageCode = strtolower($languageCode);
$languageCodes = array_unique(array_map(function($name) {
    return explode('.', $name)[0];
}, $files));


foreach ($languageCodes as $languageCode) {
    $filePath = $inputPath . $languageCode . '.php';
    $fileContents = include $filePath;
    $outputFilePath = $outputPath . $languageCode . '.json';
    write($outputFilePath, json_encode($fileContents, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    break;
}