<!-- Content Row -->
<form method="POST" action="<?= base_url('simpan-data'); ?>" class="col-sm-9 mx-auto bg-light shadow p-5 mb-4 rounded" id="formpost">
    <?= $this->session->flashdata('message'); ?>
    <div class="d-sm-flex align-items-center justify-content-center mb-4">
        <h6 class="h4 text-center mb-0 text-gray-800">Input Data Pengangguran dan Pendidikan Provinsi Gorontalo</h6>
    </div>
    <div class="form-group">
        <label for="labelKategori">Kategori Data :</label>
        <select class="form-control" name="kategori" aria-describedby="deskripsiTahun" id="labelKategori" aria-label="Default select example" required>
        <option value="" selected disabled>Kategori</option>
        <?php foreach ($kategori as $k) : ?>
            <option value="<?= $k->id ?>" ><?= $k->keterangan ?></option>
        <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group group-tahun">
        <label for="datepicker">Tahun Data :</label>
        <input type="text" class="form-control" name="date" id="datepicker" required />
        <small id="totalJumlah" class="form-text text-muted">Tahun data statistik</small>
    </div>
    <div class="form-group">
        <label for="labelWilayah">Wilayah</label>
        <select class="form-control" name="wilayah" id="labelWilayah" required>
        <option value="" selected disabled>Pilih Kabupaten</option>
        <?php foreach ($kabupaten as $m) : ?>
            <option value="<?= $m->id_kabupaten ?>" ><?= $m->nama_kabupaten ?></option>
        <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="inputTotal">Akumulasi Data :</label>
        <input type="number" onKeyPress="if(this.value.length==9) return false;" min="0" step=".01" class="form-control" id="inputTotal" aria-describedby="totalJumlah" name="total" placeholder="0" required="required">
        <small id="totalJumlah" class="form-text text-muted">Total data statistik</small>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
    let e = document.getElementById("labelKategori");
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
        area.setAttribute("class", "form-group");
        area.setAttribute("id", "group-"+category);
        
        let title = '';
        if (category == 'aps') {
            title = "Pilih Tingkat Umur";
            dataUmur.forEach((element) => {
                const option = document.createElement("option");
                option.setAttribute("value", element.id_tingkat);
                const req = document.createTextNode(element.umur);
                option.appendChild(req);
            });
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
        area.appendChild(select);

        const contain = document.querySelector(".group-tahun");
        const form = document.querySelector("#formpost");
        form.insertBefore(area, contain);
    }
</script>