<?php
// Download admin avatar menggunakan UI Avatars API
$url = "https://ui-avatars.com/api/?name=Admin+Satu&background=1ba34a&color=ffffff&size=200&bold=true&font-size=0.4";
$destination = "public/assets/images/user/admin-avatar.jpg";

$image = file_get_contents($url);
if ($image !== false) {
    file_put_contents($destination, $image);
    echo "Avatar admin berhasil dibuat: $destination\n";
} else {
    echo "Gagal download avatar. Menggunakan avatar default.\n";
    // Fallback: copy avatar existing
    copy("public/assets/images/user/avatar-5.jpg", $destination);
    echo "Avatar admin (fallback): $destination\n";
}
