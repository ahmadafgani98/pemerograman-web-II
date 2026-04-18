<?php
$A = 123; // variabel global

function Test() {
    global $A; // mengambil variabel global
    echo "Nilai A dalam fungsi = $A <br>";
}

Test();
echo "Nilai A luar fungsi = $A <br>";
?>