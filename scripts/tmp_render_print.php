<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Surat;
use App\Http\Controllers\SuratController;

$surat = Surat::first();
if (!$surat) {
    echo "No surat found in DB\n";
    exit(1);
}

// Ensure an admin user is authenticated
$admin = \App\Models\User::where('role', 'admin')->first();
if (!$admin) {
    // create a minimal admin user if none exists (will persist)
    $admin = \App\Models\User::create([
        'name' => 'Auto Admin',
        'email' => 'admin+auto@example.test',
        'password' => bcrypt('password'),
        'role' => 'admin'
    ]);
}

auth()->login($admin);

$controller = new SuratController();
$response = $controller->printView($surat->id);

$html = $response->render();
file_put_contents(__DIR__ . '/rendered_print.html', $html);
echo "Rendered to scripts/rendered_print.html\n";
