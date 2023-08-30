<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <meta name="description" content="">
    <meta name="Statistika" content="">

    <title><?= $title; ?> | Badan Pusat Statistika</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets'); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets'); ?>/css/sb-admin-2.min.css" rel="stylesheet">
    <style type="text/css">
        @media only screen and (max-width: 400px) {
            p {
                font-size: 1rem;
            }
        }
    </style>
    <?php if ($open == 'masyarakat') { ?>
        <link href="<?= base_url('assets'); ?>/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
    <?php } ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                </div>
                <div class="sidebar-brand-text mx-1"><?= $user ?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <?php foreach ($menu as $m) : ?>
                <li class="nav-item <?= $m['url'] == $open ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?= base_url($m['url']); ?>">
                        <i class="<?= $m['icon']; ?>"></i>
                        <span><?= $m['nama_menu']; ?></span>
                    </a>
                </li>

                <hr class="sidebar-divider">
            <?php endforeach; ?>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- head text -->
                    <div>
                        <p class="my-auto" style="font-size: 1.5rem;">Sebaran Tingkat Pengangguran Di Provinsi Gorontalo</p>
                    </div>
                    <!-- head text -->
                    <ul class="navbar-nav ml-auto mt-auto">
                        <li class="">
                            <a href="#" data-toggle="modal" data-target="#logoutModal" style="text-decoration: none; font-size: 20px; color: green;">
                                <p><i class="fas fa-sign-out-alt fa-sm fa-fw text-gray-400"></i> Logout</p>
                            </a>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <?php $this->load->view($content_page);?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&nbsp;&nbsp;Copyright &copy; 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Anda Yakin Ingin Keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" Untuk Keluar Dari Sesi Login Anda</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-success" href="<?= base_url('logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets'); ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets'); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

    <?php if ($open == 'masyarakat') { ?>
        <script src="<?= base_url('assets'); ?>/vendor/jquery/bootstrap-datepicker.js"></script>
        <script>
            $("#datepicker").datepicker({
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years"
            });
        </script>
    <?php } ?>
    <?php if ($open == 'pengangguran' || $open == 'pendidikan') { ?>
        <script>
            function passWilayah(params) {
                document.getElementById('wilayah-keterangan').value = params.options[params.selectedIndex].text;
            }
        </script>
    <?php } ?>
</body>

</html>