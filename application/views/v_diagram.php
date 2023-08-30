<div class="row">
    <div class="col-xl-6 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                <?php if (empty($data)) { ?>
                    Data Kosong!
                <?php } else { ?>
                    Data <?= $param['wilayah'] !== null? $param['nama'] : ''; ?> <?= $param['tahun']==''? "" : " Tahun ".$param['tahun']; ?> (%)</h6>
                <?php } ?>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page level plugins -->
<script src="<?= base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>

<!-- //Data Jurusan -->

<script>
    const data = <?php echo json_encode($data); ?>;
    <?php if ($view == 'pendidikan') {?>
        <?php if ($param['pendidikan']=="2") { ?>
            const label = data.map((item, id) => item.umur + ' tahun');
        <?php } else { ?>
            const label = data.map((item, id) => item.pendidikan);
            <?php } ?>
    <?php } else if ($view == 'pengangguran') { ?>
        <?php if ($param['tahun']==null) { ?>
            const label = data.map((item, id) => item.tahun);
        <?php } else { ?>
            const label = data.map((item, id) => item.nama_kabupaten);
            <?php } ?>
    <?php }?>
    const dataset = data.map((item, id) => item.jumlah);
    
    var ctb = document.getElementById("myBarChart");
    var myBarChart = new Chart(ctb, {
        type: 'bar',
        data: {
            labels: label,
            datasets: [{
                label: '(%)',
                data: dataset,
                backgroundColor: ['#000000', '#46CEAD', '#AC92EA', '#EB87BF', '#9ED36A', '#FECD57', '#FB6D51', '#EC5564', '#E5E8EC', '#646C77'],
                hoverBackgroundColor: [''],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(100,100,200)",
                bodyFontColor: "#fff",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });
</script>


<!-- Data Kegiatan -->