<?php 
include "regis.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rental Mobil | Register</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="../template/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="../template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="../template/dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="../template/index2.html"><b>Rental</b>Mobil</a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                    <p class="login-box-msg">Register a new membership</p>

                    <?php if (isset($error_message)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif ;?>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                        <input type="hidden" class="form-control" placeholder="id_user" name="id_user" id="id_user" readonly>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Username" name="username" id="username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Full name" name="nama" id="nama">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Alamat" name="alamat" id="alamat">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-map-marked-alt"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="no telpon" name="no_telp" id="no_telp">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-phone-square"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="No SIM" name="no_sim" id="no_sim">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="far fa-address-card"></span>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" placeholder="lavel" name="level" id="level" value="User" readonly>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>

                    </form>

                    <div class="social-auth-links text-center"></div>

                    <a href="login.php" class="text-center">I already have a membership</a>
            </div>
        </div>
    </div>

<script src="../template/plugins/jquery/jquery.min.js"></script>
<script src="../template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../template/dist/js/adminlte.min.js"></script>
<script src="../template/plugins/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>
