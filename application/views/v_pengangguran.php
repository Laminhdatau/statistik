<div class="mb-4">
    <h3 class="mb-0 text-gray-800">Data Tingkat Pengangguran Terbuka (TPT)</h3>
    <br>
    <h5 class="mb-0 text-gray-800"><?= $param['wilayah'] !== null? $param['nama'] : ''; ?> <?= $param['tahun']==''? "" : " Tahun ".$param['tahun']; ?></h5>
    <h5 class="mb-0 text-gray-800">Provinsi Gorontalo</h5>
</div>
<form method="post" action="<?= base_url('pengangguran') ?>">
  <div class="form-group d-flex flex-row align-items-center">
    <div class="col-sm-2">
      <label for="labelTahun">Tahun</label>
      <select class="form-control" name="tahun" aria-describedby="deskripsiTahun" id="labelTahun" aria-label="Default select example" required>
        <option value="" <?= $param['tahun']==''? "selected" : ""; ?> disabled>Pilih Tahun</option>
        <?php foreach ($tahun as $t) : ?>
            <option value="<?= $t->tahun ?>" <?= $param['tahun'] == $t->tahun ? "selected" : ""; ?>><?= $t->tahun ?></option>
        <?php endforeach; ?>
      </select>
      <small id="deskripsiTahun" class="form-text text-muted">Data tahun yang tersedia</small>
    </div>
    <div class="col-sm-4">
      <label for="labelWilayah">Wilayah</label>
      <select class="form-control" onchange="passWilayah(this)" name="wilayah" aria-describedby="deskripsiTahun" id="labelWilayah" aria-label="Default select example">
      <option value="" <?= $param['wilayah']==''? "selected" : ""; ?> disabled>Pilih Tingkatan Daerah</option>
        <?php foreach ($kabupaten as $m) : ?>
            <option value="<?= $m->id_kabupaten ?>" <?= $param['wilayah'] == $m->id_kabupaten ? "selected" : ""; ?>><?= $m->nama_kabupaten ?></option>
        <?php endforeach; ?>
      </select>
      <input type="hidden" value="" id="wilayah-keterangan" name="nama_wilayah">
      <small id="deskripsiTahun" class="form-text text-muted">Sortir per wilayah</small>
    </div>  
    <div class="col-sm-4 col-xs-4">
        <button type="submit" class="btn btn-primary mt-2">Tampilkan</button>
        <a href="<?= base_url('pengangguran') ?>" class="btn btn-success mt-2">Refresh</a>
    </div>
  </div>
</form>

    <?php if ($param['tahun'] !== null || $param['wilayah'] !== null ) {
      $this->load->view('v_diagram', $data['data'] = $data);
      }
    ?>