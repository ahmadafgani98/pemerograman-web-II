<?php
$a = 10;

if ($a < 0) {
    // Jika $a negatif, teks dicetak dan header() tidak dieksekusi (Aman)
    echo "Nilai A negatif";
} else {
    // Jika $a positif, tidak ada teks yang tercetak sebelumnya, redirect sukses 
    header("Location: test.php");
    exit();
}
?>