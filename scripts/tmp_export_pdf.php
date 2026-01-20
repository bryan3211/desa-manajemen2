<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Surat;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

$surat = Surat::first();
if (!$surat) {
    echo "No surat found in DB\n";
    exit(1);
}

$admin = \App\Models\User::where('role', 'admin')->first();
if (!$admin) {
    $admin = \App\Models\User::create([
        'name' => 'Auto Admin',
        'email' => 'admin+auto@example.test',
        'password' => bcrypt('password'),
        'role' => 'admin'
    ]);
}

auth()->login($admin);

$controller = new \App\Http\Controllers\SuratController();
$response = $controller->exportPdf($surat->id);

// Try to capture response content and save it to a file
$path = __DIR__ . '/surat_test.pdf';
try {
    if (method_exists($response, 'getContent')) {
        $content = $response->getContent();
        file_put_contents($path, $content);
    } else {
        // Streamed responses may require output buffering
        ob_start();
        $response->send();
        $content = ob_get_clean();
        file_put_contents($path, $content);
    }
} catch (\Exception $e) {
    echo "Error saving PDF: " . $e->getMessage() . PHP_EOL;
}

if (file_exists($path) && filesize($path) > 0) {
    echo "PDF generated: $path (size: " . filesize($path) . ")\n";
} else {
    echo "Failed to generate PDF or file empty\n";
}
