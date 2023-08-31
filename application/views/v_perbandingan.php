<div class="mb-4">
    <h5 class="mb-0 text-gray-800 break-word">
        Perbandingan Data Pengangguran Dan Data Pendidikan : Data Statistik <span id="th"></span>
    </h5>
    <h5 class="mb-0 text-gray-800">
        Provinsi Gorontalo</h5>
    <br>
</div>



<div class="form-group d-flex flex-row align-items-center" id="formpost">

    <div class="col-sm-2">
        <label for="labelTahun">Data Tahun</label>
        <select class="form-control" id="tahun" name="tahun" aria-describedby="deskripsiTahun" id="labelTahun" aria-label="Default select example" required>
            <option value="">Pilih Tahun</option>
            <?php foreach ($tahun as $t) : ?>
                <option value="<?= $t->tahun ?>"><?= $t->tahun ?></option>
            <?php endforeach; ?>
        </select>
        <span id="tahunError" style="color: red;"></span><br>
        <small id="deskripsiTahun" class="form-text text-muted">Data tahun yang tersedia</small>
    </div>

    <div class="col-sm-4" id="group-apmapk">
        <label for="label-apmapk">Pilih Wilayah</label>
        <select class="form-control" required="required" id="wilayah" name="wilayah" id="label-apmapk">
            <option value="">Pilih Wilayah</option>
            <?php foreach ($wilayah as $w) : ?>
                <option value="<?= $w->id_kabupaten ?>"><?= $w->nama_kabupaten ?></option>
            <?php endforeach; ?>
        </select>
        <span id="wilayahError" style="color: red;"></span><br>
        <small class="form-text text-muted" required="required">Wilayah</small>
    </div>



    <div class="col-sm-3" id="group-apmapk">
        <label for="label-apmapk">Pilih Tingkat Pendidikan</label>
        <select class="form-control" required="required" id="pendidikan" name="pendidikan" id="label-apmapk">
            <option value="">Pilih Tingkatan</option>
            <?php foreach ($pendidikan as $k) : ?>
                <option value="<?= $k->id_pendidikan ?>"><?= $k->keterangan ?></option>
            <?php endforeach; ?>
        </select>
        <span id="pendidikanError" style="color: red;"></span><br>
        <small class="form-text text-muted" required="required">Jenjang</small>
    </div>


    <div class="col-sm-1 group-submit">
        <button id="loadChart" class="btn btn-primary mt-2">Submit</button>
    </div>
    <div class="col-sm-1">
        <a href="<?= base_url('perbandingan') ?>" class="btn btn-success mt-2">Refresh</a>
    </div>
</div>


<div class="card" id="card">
    <div class="row">
        <div class="col-6">
            <div class="card-body">

                <div class="chart-area">
                    <canvas id="grafik" width="500" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-6" id="ket">
            <div class="card-body">
                <br>
                <br>
                <br>
                <table>
                    <thead class="text-left">
                        <tr>
                            <th><button class="btn btn-xs btn-dark"></button> JP </th>
                            <th>:</th>
                            <th> Jumlah Penduduk</th>
                        </tr>
                        <tr>
                            <th><button class="btn btn-xs btn-secondary"></button> TPT </th>
                            <th>:</th>
                            <th> Tingkat Pengangguran Terbuka</th>
                        </tr>
                        <tr>
                            <th><button class="btn btn-xs btn-info"></button> APM </th>
                            <th>:</th>
                            <th> Angka Partisipasi Murni</th>
                        </tr>
                        <tr>
                            <th><button class="btn btn-xs btn-success"></button> APK </th>
                            <th>:</th>
                            <th> Angka Partisipasi Kasar</th>
                        </tr>
                    </thead>
                </table>


            </div>
        </div>
    </div>
</div>



<script src="<?= base_url('assets'); ?>/chart.js"></script>
<script src="<?= base_url('assets'); ?>/jquery.min.js"></script>


<script>
    $(document).ready(function() {
        var chart;
        $('#ket').hide();
        $('#card').hide();
        $("#loadChart").click(function() {
            var tahun = $("#tahun").val();
            var wilayah = $("#wilayah").val();
            var pendidikan = $("#pendidikan").val();
            var hasError = false;
            if (!tahun) {
                hasError = true;
                $("#tahunError").text("Wajib diisi");
            } else {
                $("#tahunError").text("");
            }

            if (!wilayah) {
                hasError = true;
                $("#wilayahError").text("Wajib diisi");
            } else {
                $("#wilayahError").text("");
            }

            if (!pendidikan) {
                hasError = true;
                $("#pendidikanError").text("Wajib diisi");
            } else {
                $("#pendidikanError").text("");
            }

            if (hasError) {
                return;
            }



            $.ajax({
                type: "POST",
                url: "<?= base_url('dashboard/showPerbandingan') ?>",
                data: {
                    tahun: tahun,
                    wilayah: wilayah,
                    pendidikan: pendidikan
                },
                success: function(data) {
                    $('#ket').show();
                    $('#card').show();
                    console.log(data.data);

                    if (chart) {
                        chart.destroy();
                    }
                    var ctx = document.getElementById('grafik').getContext('2d');

                    var angka = data.data[0];
                    $('#th').html("Tahun " + angka.tahun);



                    chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['JP', 'TPT', 'APM', 'APK'],
                            datasets: [{
                                label: 'Data : ' + angka.nama_kabupaten + '  (%)',
                                data: [angka.pdk, angka.tpt, angka.apm, angka.apk],
                                backgroundColor: [
                                    '#9C1313)',
                                    '#7B7B7B',
                                    '#01ADF6',
                                    '#17a673'
                                ],
                                borderColor: [
                                    '#9C1313)',
                                    '#7B7B7B',
                                    '#01ADF6',
                                    '#17a673'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            });
        });
    });
</script>
</body>

</html>