<div class="mb-4">
    <h5 class="mb-0 text-gray-800 break-word">
      <?= $param['pendidikan']==''? "Perbandingan Data Pengangguran Dan Data Pendidikan" : "Data Statistik " ?> <?= $param['tahun']==''? "" : " Tahun ".$param['tahun']; ?>
    </h5>
    <h5 class="mb-0 text-gray-800">
      Provinsi Gorontalo</h5>
    <br>
</div>
<form method="post" action="<?= base_url('perbandingan') ?>">
  <div class="form-group d-flex flex-row align-items-center" id="formpost">
    <div class="col-sm-2">
      <label for="labelTahun">Data Tahun</label>
      <select class="form-control" name="tahun" aria-describedby="deskripsiTahun" id="labelTahun" aria-label="Default select example" required>
        <option value="" <?= $param['tahun']==''? "selected" : ""; ?> disabled>Pilih Tahun</option>
        <?php foreach ($tahun as $t) : ?>
            <option value="<?= $t->tahun ?>" <?= $param['tahun'] == $t->tahun ? "selected" : ""; ?>><?= $t->tahun ?></option>
        <?php endforeach; ?>
      </select>
      <small id="deskripsiTahun" class="form-text text-muted">Data tahun yang tersedia</small>
    </div>
    <div class="col-sm-4">
      <label for="labelPendidikan">Pilih Kategori Data Untuk Pendidikan</label>
      <select class="form-control" name="pendidikan" aria-describedby="deskripsiTahun" id="labelPendidikan" aria-label="Default select example" required>
      <option value="" <?= $param['pendidikan']==''? "selected" : ""; ?> disabled>Tingkatan Pendidikan</option>
        <?php foreach ($kategori as $k) : ?>
            <option value="<?= $k->id ?>" <?= $param['pendidikan'] == $k->id ? "selected" : ""; ?>><?= $k->slug ?></option>
        <?php endforeach; ?>
      </select>
      <small id="deskripsiTahun" class="form-text text-muted">Pilih Kategori Data</small>
    </div>
    <?php if ($param['apm-apk'] !== null) { ?>
      <div class="col-sm-3" id="group-apmapk">
        <label for="label-apmapk">Pilih Tingkat Pendidikan</label>
        <select class="form-control" required="required" name="kategory-apmapk" id="label-apmapk">
          <option value="">Pilih Tingkatan</option>
          <?php foreach ($pendidikan as $k) : ?>
              <option value="<?= $k->id_pendidikan ?>" <?= $param['apm-apk'] == $k->id_pendidikan ? "selected" : ""; ?>><?= $k->keterangan ?></option>
          <?php endforeach; ?>
        </select>
        <small class="form-text text-muted" required="required">Jenjang Tingkat</small>
      </div>
    <?php } else if ($param['aps'] !== null) { ?>
      <div class="col-sm-3" id="group-aps">
        <label for="label-aps">Pilih Tingkat Umur</label>
        <select class="form-control" required="required" name="kategory-aps" id="label-aps">
          <option value="">Pilih Tingkatan</option>
          <?php foreach ($umur as $k) : ?>
              <option value="<?= $k->id_tingkat ?>" <?= $param['aps'] == $k->id_tingkat ? "selected" : ""; ?>><?= $k->keterangan ?></option>
          <?php endforeach; ?>
        </select>
        <small class="form-text text-muted" required="required">Jenjang Tingkat</small>
      </div>
    <?php }  ?>
    <div class="col-sm-1 group-submit">
        <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </div>
    <div class="col-sm-1">
        <a href="<?= base_url('perbandingan') ?>" class="btn btn-success mt-2">Refresh</a>
    </div>
  </div>
</form>

<?php if ($param['tahun'] !== null || $param['pendidikan'] !== null) { ?>
<div class="row">
    <div class="col-xl-6 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                <?php if (empty($dataPengangguran)) { ?>
                    Data Pengangguran Kosong!
                <?php } else { ?>
                    Data Pengangguran <?= $param['tahun']==''? "" : " Tahun ".$param['tahun']; ?> (%)</h6>
                <?php } ?>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="diagramPengangguran"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                <?php if (empty($dataPendidikan)) { ?>
                    Data Pendidikan Kosong!
                <?php } else { ?>
                    Data Pendidikan <?= $param['tahun']==''? "" : " Tahun ".$param['tahun']; ?> (%)</h6>
                <?php } ?>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="diagramPendidikan"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page level plugins -->
<script src="<?= base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>

<!-- //Data Jurusan -->

<script>
  const dataPengangguran = <?php echo json_encode($dataPengangguran); ?>;
  const labelPengangguran = dataPengangguran.map((item, id) => item.nama_kabupaten);
  const datasetPengangguran = dataPengangguran.map((item, id) => item.jumlah);

  const dataPendidikan = <?php echo json_encode($dataPendidikan); ?>;
  const labelPendidikan = dataPendidikan.map((item, id) => item.nama_kabupaten);
  const datasetPendidikan = dataPendidikan.map((item, id) => item.jumlah);
  
  const diagram1 = document.getElementById("diagramPengangguran");
  const diagram2 = document.getElementById("diagramPendidikan");

  diagram(diagram1, labelPengangguran, datasetPengangguran);
  diagram(diagram2, labelPendidikan, datasetPendidikan);

  function diagram(canvas, label, dataset) {
    var myBarChart = new Chart(canvas, {
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
  }
</script>

<?php } ?>

<script>
    let e = document.getElementById("labelPendidikan");
    function showUrl() {
        let category = e.options[e.selectedIndex].value;
        if (category == "2") {
            categoryPendidikan('aps');
        } else if (category == "3" || category == "4") {
            categoryPendidikan('apmapk');
        } else {
            cleanField();
        }
    }
    e.onchange = showUrl;

    function cleanField() {
        const apsGroup = document.getElementById("group-aps");
        if (apsGroup !== null) {
            apsGroup.remove();
        }
        const apmapkGroup = document.getElementById("group-apmapk");
        if (apmapkGroup !== null) {
            apmapkGroup.remove();
        }
    }

    function categoryPendidikan(category) {
        const dataUmur = <?php echo json_encode($umur); ?>;
        const dataPendidikan = <?php echo json_encode($pendidikan); ?>;

        cleanField();
        const area = document.createElement("div");
        area.setAttribute("class", "col-sm-3");
        area.setAttribute("id", "group-"+category);
        
        let title = '';
        if (category == 'aps') {
            title = "Pilih Tingkat Umur";
        } else if (category == 'apmapk') {
            title = "Pilih Tingkat Pendidikan";
        }
        const label = document.createElement("label");
        label.setAttribute("for", "label-"+category);
        const text = document.createTextNode(title);
        label.appendChild(text);
        area.appendChild(label);

        const select = document.createElement("select");
        select.setAttribute("class", "form-control");
        select.setAttribute("required", "required");
        select.setAttribute("name", "kategory-"+category);
        select.setAttribute("id", "label-"+category);
        
        const option = document.createElement("option");
        option.setAttribute("value", "");
        const req = document.createTextNode("Pilih Tingkatan");
        option.appendChild(req);
        select.appendChild(option);
        if (category == 'aps') {
            title = "Pilih Tingkat Umur";
            dataUmur.forEach((element) => {
                const option = document.createElement("option");
                option.setAttribute("value", element.id_tingkat);
                const req = document.createTextNode(element.keterangan);
                option.appendChild(req);
                select.appendChild(option);
            });
        } else if (category == 'apmapk') {
            title = "Pilih Tingkat Pendidikan";
            dataPendidikan.forEach((element) => {
                const option = document.createElement("option");
                option.setAttribute("value", element.id_pendidikan);
                const req = document.createTextNode(element.keterangan);
                option.appendChild(req);
                select.appendChild(option);
            });
        }
        const small = document.createElement("small");
        small.setAttribute("class", "form-text text-muted");
        small.setAttribute("required", "required");
        const tingkat = document.createTextNode('Jenjang Tingkat');
        small.appendChild(tingkat);
        area.appendChild(select);
        area.appendChild(small);

        const contain = document.querySelector(".group-submit");
        const form = document.querySelector("#formpost");
        form.insertBefore(area, contain);
    }
</script>