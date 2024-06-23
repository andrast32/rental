<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data User</h3>
                    </div>

                    <div class="card-body">
                        <table id="table" class="table table-bordered table-hover">
                            <thead class="bg-navy">
                                <tr align="center">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No telpon</th>
                                    <th>No SIM</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php 
                                $user = $mysqli->query("SELECT * FROM user WHERE id_user");
                                $no = 0;
                                while ($data = mysqli_fetch_array($user)) {
                                    $no++
                                ?>
                                    <tr>
                                        <td align="center"><?php echo $no?></td>
                                        <td><?php echo $data ['nama']?></td>
                                        <td><?php echo $data ['alamat']?></td>
                                        <td><?php echo $data ['no_telp']?></td>
                                        <td><?php echo $data ['no_sim']?></td>
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