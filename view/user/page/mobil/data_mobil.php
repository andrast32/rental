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
