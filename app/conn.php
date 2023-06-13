<?php
// Konfiguracja połączenia z bazą danych PostgreSQL
$host = 'postgres';
$port = '5432';
$dbname = 'apokalipsa';
$user = 'docker';
$password = 'docker';

// Utworzenie połączenia
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    echo "Błąd połączenia z bazą danych.";
    exit;
}
?>