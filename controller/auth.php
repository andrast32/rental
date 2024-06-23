<?php 
session_start();

include "koneksi.php";

if ($mysqli->connect_error) {
    die("Koneksi gagal :" . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $query = "SELECT * FROM user WHERE username='$username'";
    $result = $mysqli->query($query);

    if ($result) {
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                $_SESSION['id_user']        = $row['id_user'];
                $_SESSION['username']       = $row['username'];
                $_SESSION['nama']           = $row['nama'];
                $_SESSION['alamat']         = $row['alamat'];
                $_SESSION['no_telp']        = $row['no_telp'];
                $_SESSION['no_sim']         = $row['no_sim'];
                $_SESSION['level']          = $row['level'];

                if ($row['level'] == 'Admin') {
                    header("Location: ../view/admin/index.php");
                } else {
                    header("Location: ../view/user/index.php");
                }
                exit();
            } else {
                $error_message = "Username atau password anda salah.";
            }
        } else {
            $error_message = "Username atau password anda salah.";
        }
    } else {
        $error_message = "Terjadi kesalahan dalam memeriksa akun anda.";
    }
}
?>