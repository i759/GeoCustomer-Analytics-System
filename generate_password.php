<?php

$password = "Admin@123";

echo "<h3>Generated Password Hash</h3>";
echo "<p>" . password_hash($password, PASSWORD_DEFAULT) . "</p>";