    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
            <!-- page heading -->
            <?= $this->session->flashdata('message'); ?>
            <!-- Content Row -->
    <div class="row right">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-5 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                                    Jumlah Penduduk Provinsi Gorontalo</div>
                                <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $jumlah; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>
