<?php
// Memicu error karena mengirimkan teks ke browser sebelum fungsi header() [cite: 155, 156]
echo "<p>Hallo Apa kabar?</p>";
header("Location: test.php");
?>