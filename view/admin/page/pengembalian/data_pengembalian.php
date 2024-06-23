<?php 
$item = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_peminjaman'])) {
        $id_peminjaman = $_POST['id_peminjaman'];

        $stmt = $mysqli->prepare("SELECT * FROM peminjaman 
                                    JOIN user ON peminjaman.id_user = user.id_user
                                    JOIN mobil ON peminjaman.id_mobil = mobil.id_mobil
                                    WHERE id_peminjaman = ?");
        $stmt->bind_param("s", $id_peminjaman);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $item = $result->fetch_assoc();
        } else {
            echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Id yang anda masukan tidak ditemukan, harap periksa kembali',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = '?pengembalian=data_pengembalian';
                    });
                </script>
            ";
        }
        $stmt->close();
    } elseif (isset($_POST['return_id_peminjaman'])) {
        $return_id_peminjaman = $_POST['return_id_peminjaman'];
        $return_id_mobil = $_POST['return_id_mobil'];

        $stmt = $mysqli->prepare("UPDATE mobil SET status = 'tersedia' WHERE id_mobil = ?");
        $stmt->bind_param("s", $return_id_mobil);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $stmt->close();

            $stmt = $mysqli->prepare("DELETE FROM peminjaman WHERE id_peminjaman = ?");
            $stmt->bind_param("s", $return_id_peminjaman);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Mobil berhasil dikembalikan dan data peminjaman dihapus',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.href = '?pengembalian=data_pengembalian';
                        });
                    </script>
                ";
            } else {
                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan saat menghapus data peminjaman',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.href = '?pengembalian=data_pengembalian';
                        });
                    </script>
                ";
            }
            $stmt->close();
        } else {
            echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat mengupdate status mobil',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = '?pengembalian=data_pengembalian';
                    });
                </script>
            ";
        }
    }
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Pengembalian Mobil yang disewa
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <label for="id">Masukan Id peminjaman <span class="text-danger">*</span></label>
                            <input type="text" name="id_peminjaman" id="id_peminjaman" class="form-control" required>
                            <br>
                            <input type="submit" value="Submit" class="btn btn-info float-right">
                        </form>
                    </div>

                    <?php if ($item) :?>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Pengembalian</h3>
                            </div>

                            <div class="card-body p-0">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Nama</th>
                                            <th>Unit yang dipinjam</th>
                                            <th>Tanggal pinjam</th>
                                            <th>Tanggal kembali</th>
                                            <th>Biaya</th>
                                            <th style="width: 40px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $item['id_peminjaman']?></td>
                                            <td><?php echo $item['nama']?></td>
                                            <td>
                                                <?php echo $item['merk']?>
                                                <?php echo $item['model']?> |
                                                <?php echo $item['no_plat']?>
                                            </td>
                                            <td><?php echo $item['tanggal_pinjam']?></td>
                                            <td><?php echo $item['tanggal_kembali']?></td>
                                            <td>Rp. <?php echo number_format($item['biaya'])?></td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="hidden" name="return_id_peminjaman" value="<?php echo $item['id_peminjaman'] ?>">
                                                    <input type="hidden" name="return_id_mobil" value="<?php echo $item['id_mobil'] ?>">
                                                    <button type="submit" class="btn btn-success">Kembali</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</section>
