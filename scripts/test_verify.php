<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\SuratController;

$s = \App\Models\Surat::first();
$r = Request::create('/surat/verify', 'GET', [
    'sid' => $s->id,
    'ts' => now()->toDateTimeString(),
]);

$controller = new SuratController();
// call private helper via reflection to compute expected hash
$ref = new ReflectionMethod($controller, 'renderSuratBody');
$ref->setAccessible(true);
$rendered = $ref->invoke($controller, $s);
$sig = hash('sha256', $s->id . '|' . $s->jenis_surat . '|' . $rendered . '|' . (config('app.key') ?? ''));
$r->query->set('sig', $sig);

$controller = new SuratController();
$response = $controller->verifySignature($r);

$html = $response->render();
file_put_contents(__DIR__ . '/verify_out.html', $html);
echo "Wrote scripts/verify_out.html\n";