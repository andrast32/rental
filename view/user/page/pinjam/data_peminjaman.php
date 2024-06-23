<?php 

$id_user_session = $_SESSION['id_user'];

// Query data peminjaman sesuai dengan id_user yang sedang login
$peminjaman = $mysqli->query("
    SELECT * FROM peminjaman 
    JOIN user ON peminjaman.id_user = user.id_user
    JOIN mobil ON peminjaman.id_mobil = mobil.id_mobil
    WHERE user.id_user = $id_user_session
");

$no = 0;
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Data Peminjaman | 
                            <button class="btn btn-info" data-toggle="modal" data-target="#modal-add">
                                <i class="fas fa-plus"></i>
                            </button>
                        </h3>
                    </div>

                    <div class="card-body">
                        <table id="laporan" class="table table-bordered table-hover">
                            <thead class="bg-navy">
                                <tr align="center">
                                    <th>No</th>
                                    <th>Id pinjam</th>
                                    <th>Nama</th>
                                    <th>Unit dipinjam</th>
                                    <th>Tanggal pinjam</th>
                                    <th>Tanggal kembali</th>
                                    <th>Harga sewa</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($data = mysqli_fetch_array($peminjaman)) : ?>
                                    <tr>
                                        <td align="center"><?php echo ++$no; ?></td>
                                        <td><?php echo $data['id_peminjaman']; ?></td>
                                        <td><?php echo $data['nama']; ?></td>
                                        <td><?php echo $data['merk'] . ' ' . $data['model']; ?></td>
                                        <td><?php echo $data['tanggal_pinjam']; ?></td>
                                        <td><?php echo $data['tanggal_kembali']; ?></td>
                                        <td>Rp. <?php echo number_format($data['biaya'], 2, '.', '.'); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
