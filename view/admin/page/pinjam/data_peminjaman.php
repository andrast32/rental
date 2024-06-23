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
                                <?php 
                                    $peminjaman = $mysqli->query("
                                    SELECT * FROM peminjaman 
                                        JOIN user ON peminjaman.id_user = user.id_user
                                        JOIN mobil ON peminjaman.id_mobil = mobil.id_mobil");

                                        $no = 0;

                                        while ($data = mysqli_fetch_array($peminjaman)) {
                                            $no++;        
                                ?>
                                    <tr>
                                        <td align="center"><?php echo $no; ?></td>
                                        <td><?php echo $data['id_peminjaman']; ?></td>
                                        <td><?php echo $data['nama']; ?></td>
                                        <td><?php echo $data['merk'] . ' ' . $data['model']; ?></td>
                                        <td><?php echo $data['tanggal_pinjam']; ?></td>
                                        <td><?php echo $data['tanggal_kembali']; ?></td>
                                        <td>Rp. <?php echo number_format($data['biaya'], 2, '.', '.'); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Data</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="?pinjam=function/create_pinjam" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_peminjaman" id="id_peminjaman">

                    <div class="form-group">
                        <label for="id_user">Pilih nama user <span class="text-danger">*</span></label>
                        <select name="id_user" id="id_user" class="form-control" required>
                            <option value="">Pilih User</option>
                        <?php 
                            $user = $mysqli->query("SELECT * FROM user ORDER BY id_user");
                            while ($d_user = mysqli_fetch_array($user)) {
                        ?>
                            <option value="<?php echo $d_user['id_user']; ?>"><?php echo $d_user['nama']; ?></option>
                        <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_mobil">Pilih Unit yang akan disewa <span class="text-danger">*</span></label>
                        <select name="id_mobil" id="id_mobil" class="form-control" required>
                            <option value="">Pilih Unit</option>
                        <?php 
                            $mobil = $mysqli->query("SELECT * FROM mobil ORDER BY id_mobil");
                            while ($d_mobil = mysqli_fetch_array($mobil)) {
                                if ($d_mobil['status'] !== 'disewa') {
                        ?>
                            <option value="<?php echo $d_mobil['id_mobil']; ?>" data-tarif="<?php echo $d_mobil['tarif']; ?>">
                                <?php echo $d_mobil['merk'] . ' ' . $d_mobil['model'] . ' ' . $d_mobil['no_plat']; ?>
                            </option>
                        <?php 
                                }
                            } 
                        ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_pinjam">Tanggal pinjam <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_kembali">Tanggal kembali <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="biaya">Biaya Sewa <span class="text-danger">*</span></label>
                        <input type="text" name="biaya" id="biaya" class="form-control" readonly>
                    </div>

                    <div class="modal-footer">
                        <input type="reset" value="Reset" class="btn btn-warning">
                        <input type="submit" value="Submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const idMobilSelect = document.getElementById('id_mobil');
    const tanggalPinjamInput = document.getElementById('tanggal_pinjam');
    const tanggalKembaliInput = document.getElementById('tanggal_kembali');
    const biayaInput = document.getElementById('biaya');

    function updateBiaya() {
        const selectedOption = idMobilSelect.options[idMobilSelect.selectedIndex];
        const tarif = selectedOption.getAttribute('data-tarif');
        const tanggalPinjam = new Date(tanggalPinjamInput.value);
        const tanggalKembali = new Date(tanggalKembaliInput.value);

        if (tarif && tanggalPinjam && tanggalKembali && tanggalKembali >= tanggalPinjam) {
            const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
            const diffDays = Math.round(Math.abs((tanggalKembali - tanggalPinjam) / oneDay)) + 1; // Including both start and end day
            const totalBiaya = diffDays * tarif;
            biayaInput.value = totalBiaya;
        } else {
            biayaInput.value = '';
        }
    }

    idMobilSelect.addEventListener('change', updateBiaya);
    tanggalPinjamInput.addEventListener('change', updateBiaya);
    tanggalKembaliInput.addEventListener('change', updateBiaya);
});
</script>

<?php 
include "config/notif.php";
?>