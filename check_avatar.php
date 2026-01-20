<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';

$users = \App\Models\User::select('id', 'name', 'avatar', 'provider')->limit(5)->get();

echo "Users Avatar Check:\n";
echo str_repeat("=", 80) . "\n";

foreach($users as $user) {
    echo sprintf("ID: %d | Name: %-20s | Avatar: %-20s | Provider: %s\n", 
        $user->id, 
        $user->name, 
        $user->avatar ?? 'NULL', 
        $user->provider ?? 'NULL'
    );
}

echo str_repeat("=", 80) . "\n";
echo "Total users: " . \App\Models\User::count() . "\n";
