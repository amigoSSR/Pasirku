<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
$stmt = $pdo->query('SHOW DATABASES;');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $db = $row['Database'];
    try {
        $res = $pdo->query("SHOW TABLES IN `$db` LIKE 'informasi_akun'");
        if ($res && $res->rowCount() > 0) {
            echo "Found in: $db\n";
        }
    } catch (Exception $e) {}
}
