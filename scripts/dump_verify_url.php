<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$s = \App\Models\Surat::first();
$rendered = (new \App\Http\Controllers\SuratController())->renderSuratBody($s);
$verify_url = url('/surat/verify') . '?sid=' . $s->id . '&ts=' . urlencode(now()->toDateTimeString()) . '&sig=' . hash('sha256', $s->id . '|' . $s->jenis_surat . '|' . $rendered . '|' . (config('app.key') ?? ''));

echo $verify_url . PHP_EOL;