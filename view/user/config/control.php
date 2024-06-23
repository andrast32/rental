<?php 
error_reporting(error_reporting() & ~E_NOTICE );
include "../../controller/koneksi.php";

if(isset($_GET['mobil'])) {
    include "config/style/sidebar/side_data.php";
    include ("page/mobil/".$_GET['mobil'].".php");
}

elseif(isset($_GET['pinjam'])) {
    include "config/style/sidebar/side_pinjam.php";
    include ("page/pinjam/".$_GET['pinjam'].".php");
}

elseif(isset($_GET['user'])) {
    include "config/style/sidebar/side_user.php";
    include ("page/user/".$_GET['user'].".php");
}

elseif(isset($_GET['pengembalian'])) {
    include "config/style/sidebar/side_pengembalian.php";
    include ("page/pengembalian/".$_GET['pengembalian'].".php");
}

else {
    include "config/style/sidebar/sidehome.php";
    include "config/dashboard.php";
}
?>