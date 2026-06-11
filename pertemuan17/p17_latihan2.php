<?php
// PERBAIKAN: Bersih dari HTML/echo di atasnya 
header("Location: test.php");

exit(); // Praktik terbaik untuk menghentikan eksekusi script setelah redirect
?>