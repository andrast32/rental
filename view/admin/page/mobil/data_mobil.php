<?php 
if (isset($_GET['id_mobil']) && is_numeric($_GET['id_mobil'])) {
    $id_mobil = $_GET['id_mobil'];

    $stmt_select = $mysqli->prepare("SELECT foto FROM mobil WHERE id_mobil = ?");
    $stmt_select->bind_param("i", $id_mobil);
    $stmt_select->execute();
    $stmt_select->bind_result($foto);
    $stmt_select->fetch();
    $stmt_select->close();

    $stmt_delete = $mysqli->prepare("DELETE FROM mobil WHERE id_mobil = ?");
    $stmt_delete->bind_param("i", $id_mobil);

    if ($stmt_delete->execute()) {
        $foto_path = "../../template/dist/img/upload" . $foto;
        if (file_exists($foto_path)) {
            unlink($foto_path);
        }
        echo '
        <script>
            swal.fire({
                icon: "Success",
                title: "Berhasil",
                text: "Data mobil telah berhasil dihapus!",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "?mobil=data_mobil";
                }
        });
        </script>';
    } else {
        echo '
        <script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Data mobil gagal dihapus",
            });
        </script>
        ';
    }

    $stmt_delete->close();
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Data mobil | 
                            <button class="btn btn-info" data-toggle="modal" data-target="#modal-add">
                                <i class="fas fa-plus"></i>
                            </button>
                        </h3>
                        <a href="#" class="float-right btn btn-info">
                            <i class="fas fa-file-download"></i>
                        </a>
                    </div>

                    <div class="card-body">
                        <table id="laporan" class="table table-bordered table-hover">
                            <thead class="bg-navy">
                                <tr align="center">
                                    <th>No</th>
                                    <th>Merk</th>
                                    <th>Model</th>
                                    <th>Plat nomer</th>
                                    <th>Tarif</th>
                                    <th>Status</th>
                                    <th>Foto</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php 
                                    $mobil = $mysqli->query("SELECT * FROM mobil WHERE id_mobil");

                                    $no = 0;
                                    while ($data = mysqli_fetch_array($mobil)) {
                                        $no++;
                                ?>
                                    <tr>
                                        <td align="center"><?php echo $no?></td>
                                        <td><?php echo $data ['merk']?></td>
                                        <td><?php echo $data ['model']?></td>
                                        <td><?php echo $data ['no_plat']?></td>
                                        <td>Rp. <?php echo number_format($data['tarif'], 2, '.', '.') ?></td>
                                        <td>
                                            <p class="<?php echo ($data['status'] == 'disewa') ? 'bg-warning' : 'bg-success'; ?> text-white text-center">
                                                <?php echo $data['status']; ?>
                                            </p>
                                        </td>
                                        <td align="center"><img src="../../template/dist/img/upload/<?php echo $data ['foto'] ?>" alt="foto mobil" width="90"></td>
                                        <td align="center">
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-edit-<?php echo $data['id_mobil']?>">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button type="button" class="btn btn-danger" onclick="deleteMobil(<?php echo $data ['id_mobil']?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
    $mobil = $mysqli->query("SELECT * FROM mobil WHERE id_mobil");

    while ($data = mysqli_fetch_array($mobil)) {
?>
<div class="modal fade" id="modal-edit-<?php echo $data['id_mobil']?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Data</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="?mobil=function/update_data" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="id_mobil">Id Mobil <span class="text-danger">*</span></label>
                        <input type="text" name="id_mobil" id="id_mobil" class="form-control" value="<?php echo $data['id_mobil']?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="merk">Merk Mobil <span class="text-danger">*</span></label>
                        <input type="text" name="merk" id="merk" class="form-control" placeholder="Masukan merk mobil" aria-required="true" value="<?php echo $data['merk']?>">
                    </div>

                    <div class="form-group">
                        <label for="model">Model Mobil <span class="text-danger">*</span></label>
                        <input type="text" name="model" id="model" class="form-control" placeholder="Masukan model mobil" aria-required="true" value="<?php echo $data['model']?>">
                    </div>

                    <div class="form-group">
                        <label for="no_plat">Plat Nomor Mobil <span class="text-danger">*</span></label>
                        <input type="text" name="no_plat" id="no_plat" class="form-control" placeholder="Masukan plat nomor mobil" aria-required="true" value="<?php echo $data['no_plat']?>">
                    </div>

                    <div class="form-group">
                        <label for="tarif">Tarif Sewa Mobil <span class="text-danger">*</span></label>
                        <input type="text" name="tarif" id="tarif" class="form-control" placeholder="Masukan tarif sewa mobil perhari" aria-required="true" value="<?php echo $data['tarif']?>">
                    </div>

                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control">
                            <option value="disewa" <?php if ($data['status'] == 'disewa') echo 'Selected'?> >DIsewa</option>
                            <option value="tersedia" <?php if ($data['status'] == 'tersedia') echo 'Selected'?> >Tersedia</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto Mobil <span class="text-danger">*</span></label>
                        <input type="file" name="foto" id="foto" class="form-control" aria-required="true">
                        <br>
                        <p class="text-info">Foto sebelum di edit</p>
                        <img src="../../template/dist/img/upload/<?php echo $data['foto']?>" alt="foto mobil" width="150" style="margin-top: 10px;">
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
<?php }?>

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
                <form action="?mobil=function/create_data" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_mobil" id="id_mobil">

                    <div class="form-group">
                        <label for="merk">Merk Mobil <span class="text-danger">*</span></label>
                        <input type="text" name="merk" id="merk" class="form-control" placeholder="Masukan merk mobil" aria-required="true">
                    </div>

                    <div class="form-group">
                        <label for="model">Model Mobil <span class="text-danger">*</span></label>
                        <input type="text" name="model" id="model" class="form-control" placeholder="Masukan model mobil" aria-required="true">
                    </div>

                    <div class="form-group">
                        <label for="no_plat">Plat Nomor Mobil <span class="text-danger">*</span></label>
                        <input type="text" name="no_plat" id="no_plat" class="form-control" placeholder="Masukan plat nomor mobil" aria-required="true">
                    </div>

                    <div class="form-group">
                        <label for="tarif">Tarif Sewa Mobil <span class="text-danger">*</span></label>
                        <input type="text" name="tarif" id="tarif" class="form-control" placeholder="Masukan tarif sewa mobil perhari" aria-required="true">
                    </div>

                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control">
                            <option value="disewa">DIsewa</option>
                            <option value="tersedia">Tersedia</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto Mobil <span class="text-danger">*</span></label>
                        <input type="file" name="foto" id="foto" class="form-control" aria-required="true">
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


<?php 
include "config/notif.php";
?>