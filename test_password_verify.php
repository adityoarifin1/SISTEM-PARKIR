<?php
$plain_password = '12345';
$hashed_password = '$2y$10$t0Ek7wut3qgs4AQTVBuuFeJGBwMaZORdZFE6BQLmsKKfG2So4USce';

if(password_verify($plain_password, $hashed_password)) {
    echo "✅ PASSWORD VERIFICATION SUCCESS!\n";
    echo "Plain text '12345' matches the bcrypt hash\n";
} else {
    echo "❌ PASSWORD VERIFICATION FAILED!\n";
}
?>