<?php

// Test script untuk memverifikasi field baru di database
echo "=== TEST DATABASE USERS TABLE ===\n";

try {
    // Koneksi ke database
    $pdo = new PDO('pgsql:host=localhost;port=5432;dbname=laravel', 'laravel', 'secret');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Koneksi database berhasil\n";
    
    // Cek struktur tabel
    $stmt = $pdo->query("SELECT column_name, data_type, is_nullable, column_default 
                        FROM information_schema.columns 
                        WHERE table_name = 'users' 
                        ORDER BY ordinal_position");
    
    echo "\n=== STRUKTUR TABEL USERS ===\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo sprintf("%-15s %-15s %-10s %-20s\n", 
            $row['column_name'], 
            $row['data_type'], 
            $row['is_nullable'], 
            $row['column_default'] ?? 'NULL'
        );
    }
    
    // Cek data users
    $stmt = $pdo->query("SELECT id, name, email, tier, role, start_work, birthday, status FROM users LIMIT 5");
    
    echo "\n=== DATA USERS ===\n";
    echo sprintf("%-3s %-15s %-25s %-10s %-15s %-12s %-12s %-10s\n", 
        'ID', 'Name', 'Email', 'Tier', 'Role', 'Start Work', 'Birthday', 'Status');
    echo str_repeat('-', 100) . "\n";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo sprintf("%-3s %-15s %-25s %-10s %-15s %-12s %-12s %-10s\n",
            $row['id'],
            substr($row['name'], 0, 15),
            substr($row['email'], 0, 25),
            $row['tier'] ?? 'NULL',
            $row['role'] ?? 'NULL',
            $row['start_work'] ?? 'NULL',
            $row['birthday'] ?? 'NULL',
            $row['status'] ?? 'NULL'
        );
    }
    
    echo "\n✓ Test database berhasil!\n";
    
} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}


