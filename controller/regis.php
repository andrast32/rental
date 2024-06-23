<?php
session_start(); 
include "koneksi.php";

if ($mysqli->connect_error) {
    die("Koneksi gagal :" . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_user']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['nama']) && isset($_POST['alamat']) && isset($_POST['no_telp']) && isset($_POST['no_sim']) && isset($_POST['level'])) {

        $id_user    = $_POST['id_user'];
        $username   = $_POST['username'];
        $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $nama       = $_POST['nama'];
        $alamat     = $_POST['alamat'];
        $no_telp    = $_POST['no_telp'];
        $no_sim     = $_POST['no_sim'];
        $level      = $_POST['level'];

        $stmt = $mysqli->prepare("INSERT INTO user(id_user, username, password, nama, alamat, no_telp, no_sim, level) VALUES (?,?,?,?,?,?,?,?)");

        $stmt->bind_param("ssssssss", $id_user, $username, $password, $nama, $alamat, $no_telp, $no_sim, $level);

        // Execute the statement
        if ($stmt->execute()) {
            // Close the statement
            $stmt->close();
            // Close the database connection
            $mysqli->close();
            
            // Redirect to login.php
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Terjadi kesalahan saat menyimpan user. Silakan coba lagi.";
        }
    } else {
        $error_message = "Terjadi kesalahan pada query SQL. Silakan coba lagi.";
    }
} else {
    $error_message = "Data tidak lengkap. Harap lengkapi semua field.";
}
?>