<?php 
include "../../controller/koneksi.php";

include "config/style/head.php";
include "config/style/navbar.php";
?>

        <!-- content Start -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Sewa Mobil</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <?php 
                    include "config/control.php";
                ?>
            </section>

        </div>

        <!-- content Ends -->

<?php 
include "config/style/footer.php";
include "config/style/Script.php";
?>