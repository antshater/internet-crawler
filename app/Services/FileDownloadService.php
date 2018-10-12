<?php

namespace App\Services;

class FileDownloadService {
    public function download($url) {
        return file_get_contents($url);
    }
}
