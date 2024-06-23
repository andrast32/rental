<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_mobil']) && isset($_POST['merk']) && isset($_POST['model']) && isset($_POST['no_plat']) && isset($_POST['tarif']) && isset($_POST['status'])) {

        $id_mobil   = $_POST['id_mobil'];
        $merk       = $_POST['merk'];
        $model      = $_POST['model'];
        $no_plat    = $_POST['no_plat'];
        $tarif      = $_POST['tarif'];
        $status     = $_POST['status'];
        $foto       = isset($_FILES['foto']) ? $_FILES['foto']['name'] : '';
        $tempFoto   = isset($_FILES['foto']) ? $_FILES['foto']['tmp_name'] : '';

        $updateFoto = '';
        if (!empty($foto)) {
            $newFotoName = $id_mobil . '.' . pathinfo($foto, PATHINFO_EXTENSION);
            $target = "../../template/dist/img/upload/" . $newFotoName;

            if (move_uploaded_file($tempFoto, $target)) {
                $updateFoto = ", foto = '$newFotoName'";
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal mengunggah foto!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = '?mobil=data_mobil';
                    });
                </script>";
                exit; // Exit if failed to upload photo
            }
        }

        $stmt = $mysqli->prepare("UPDATE mobil SET merk = ?, model = ?, no_plat = ?, tarif = ?, status = ? $updateFoto WHERE id_mobil = ?");
        $stmt->bind_param("sssssi", $merk, $model, $no_plat, $tarif, $status, $id_mobil);

        if ($stmt->execute()) {
            echo "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data mobil berhasil diupdate!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = '?mobil=data_mobil';
                    });
                </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Data mobil gagal diupdate!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = '?mobil=data_mobil';
                });
            </script>";
        }
        $stmt->close();
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data tidak lengkap!',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = '?mobil=data_mobil';
            });
        </script>";
    }
} else {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Metode tidak valid!',
            });
        </script>";
}
?>
