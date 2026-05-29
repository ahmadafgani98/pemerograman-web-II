<?php
session_start();

if (isset($_POST['Login'])) {

    $user = $_POST['user'];
    $pass = $_POST['pass'];

    // pemeriksaan login
    if ($user == "halim" && $pass == "123") {

        // membuat session
        $_SESSION['login'] = $user;

        echo "<h1>Anda berhasil LOGIN</h1>";
        echo "<h2>Klik <a href='session2.php'>di sini</a> untuk menuju ke halaman pemeriksaan session</h2>";

    } else {

        echo "<h2>Username atau Password salah!</h2>";
    }
}
?>

<html>
<head>
    <title>Login Here...</title>
</head>
<body>

<form action="" method="post">
    <h2>Login Here...</h2>

    Username :
    <input type="text" name="user"><br><br>

    Password :
    <input type="password" name="pass"><br><br>

    <input type="submit" name="Login" value="Log In">
</form>

</body>
</html>