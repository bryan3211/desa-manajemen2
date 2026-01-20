<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $svg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(180)->generate('test');
    // SVG is text/XML; embed as data URI (url-encoded or base64) — using base64
    echo 'data:image/svg+xml;base64,' . base64_encode($svg) . PHP_EOL;
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
