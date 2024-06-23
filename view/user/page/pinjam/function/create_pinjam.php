<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_peminjaman']) && isset($_POST['id_user']) && isset($_POST['id_mobil']) && isset($_POST['tanggal_pinjam']) && isset($_POST['tanggal_kembali']) && isset($_POST['biaya'])) {

        $id_peminjaman      = $_POST['id_peminjaman'];
        $id_user            = $_POST['id_user'];
        $id_mobil           = $_POST['id_mobil'];
        $tanggal_pinjam     = $_POST['tanggal_pinjam'];
        $tanggal_kembali    = $_POST['tanggal_kembali'];
        $biaya              = $_POST['biaya'];

        // Insert ke tabel peminjaman
        $stmt = $mysqli->prepare("INSERT INTO peminjaman(id_peminjaman, id_user, id_mobil, tanggal_pinjam, tanggal_kembali, biaya) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $id_peminjaman, $id_user, $id_mobil, $tanggal_pinjam, $tanggal_kembali, $biaya);

        if ($stmt->execute()) {
            // Update status di tabel mobil menjadi 'di sewa'
            $updateStmt = $mysqli->prepare("UPDATE mobil SET status = 'disewa' WHERE id_mobil = ?");
            $updateStmt->bind_param("i", $id_mobil);
            if ($updateStmt->execute()) {
                echo "
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data peminjaman berhasil disimpan!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.href = '?pinjam=data_peminjaman';
                        });
                    </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal memperbarui status mobil!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = '?pinjam=data_peminjaman';
                    });
                </script>";
            }
            $updateStmt->close();
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Data peminjaman gagal disimpan!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = '?pinjam=data_peminjaman';
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
                window.location.href = '?pinjam=data_peminjaman';
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
