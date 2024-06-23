<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_mobil']) && isset($_POST['merk']) && isset($_POST['model']) && isset($_POST['no_plat']) && isset($_POST['tarif']) && isset($_POST['status']) && isset($_FILES['foto'])) {

        $id_mobil   = $_POST['id_mobil'];
        $merk       = $_POST['merk'];
        $model      = $_POST['model'];
        $no_plat    = $_POST['no_plat'];
        $tarif      = $_POST['tarif'];
        $status     = $_POST['status'];
        $foto       = $_FILES['foto']['name'];
        $tempFoto   = $_FILES['foto']['tmp_name'];

        if ($_FILES['foto']['error'] == 0) {
            $stmt = $mysqli->prepare("INSERT INTO mobil (id_mobil, merk, model, no_plat, tarif, status, foto) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $id_mobil, $merk, $model, $no_plat, $tarif, $status, $foto);

            if ($stmt->execute()) {
                $id_mobil = $mysqli->insert_id;

                $newFotoName = $id_mobil . '.' . pathinfo($foto, PATHINFO_EXTENSION);
                $target = "../../template/dist/img/upload/" . $newFotoName;

                if (move_uploaded_file($tempFoto, $target)) {
                    $stmt = $mysqli->prepare("UPDATE mobil SET foto = ? WHERE id_mobil = ?");
                    $stmt->bind_param("ss", $newFotoName, $id_mobil);
                    $stmt->execute();

                    echo "
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data mobil berhasil disimpan!',
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
                            text: 'Gagal mengunggah foto!',
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
                        text: 'Data mobil gagal disimpan!',
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
                    text: 'Terjadi kesalahan saat mengunggah file!',
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
