<!-- Default box -->
<div class="card card-solid">
    <div class="card-body pb-0">
        <div class="row">
            <?php 
                $mobil = $mysqli->query("SELECT * FROM mobil");
                while ($data = mysqli_fetch_array($mobil)) {
            ?>
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                    <div class="card bg-light d-flex flex-fill">
                        <div class="card-header text-muted border-bottom-0">
                            <?php echo $data['status'] ?>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b><?php echo $data['merk'] ?></b></h2>
                                    <p class="text-muted text-sm"><b>Model: </b> <?php echo $data['model'] ?> </p>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small"><span class="fa-li"><i class="fas fa-dollar-sign"></i></span> Harga sewa: Rp. <?php echo number_format($data['tarif']) ?></li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone : +62 123-123-1</li>
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="../../template/dist/img/upload/<?php echo $data['foto'] ?>" alt="user-avatar" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <button data-toggle="modal" data-target="#pesan-<?php echo $data['id_mobil']?>" class="btn btn-sm btn-primary <?php echo $data['status'] == 'disewa' ? 'disabled' : '' ?>">
                                    <i class="fas fa-user"></i> Sewa
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

<?php 
    $mobil = $mysqli->query("SELECT * FROM mobil");
    while ($data = mysqli_fetch_array($mobil)) {
        if ($data['status'] !== 'disewa') {
?>
<div class="modal fade" id="pesan-<?php echo $data['id_mobil']?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Sewa Mobil</h3>
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
                        <select name="id_mobil" id="id_mobil" class="form-control" readonly>
                            <option value="<?php echo $data['id_mobil']?>" data-tarif="<?php echo $data['tarif']; ?>" selected>
                                <?php echo $data['merk'] . ' ' . $data['model'] . ' (' . $data['no_plat'] . ')' ?>
                            </option>
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
<?php } } ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modals = document.querySelectorAll('.modal');

    modals.forEach(modal => {
        const idMobilSelect = modal.querySelector('#id_mobil');
        const tanggalPinjamInput = modal.querySelector('#tanggal_pinjam');
        const tanggalKembaliInput = modal.querySelector('#tanggal_kembali');
        const biayaInput = modal.querySelector('#biaya');

        function updateBiaya() {
            const tarif = idMobilSelect.options[0].getAttribute('data-tarif');
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

        tanggalPinjamInput.addEventListener('change', updateBiaya);
        tanggalKembaliInput.addEventListener('change', updateBiaya);
    });
});
</script>
