<div class="mb-4">
    <h5 class="mb-0 text-gray-800 break-word">
      <?= $param['pendidikan']==''? "Data Tingkat Pendidikan yang terdiri dari APS, APM, dan APK se-Provinsi Gorontalo" : "Data pendidikan berdasarkan ".$param['pendidikan']; ?> <?= $param['tahun']==''? "" : " Tahun ".$param['tahun']; ?>
    </h5>
    <h5 class="mb-0 text-gray-800">
      <?= $param['wilayah'] !== null? $param['nama'] : ''; ?> Provinsi Gorontalo</h5>
    <br>
</div>
<form method="post" action="<?= base_url('pendidikan') ?>">
  <div class="form-group d-flex flex-row align-items-center">
    <div class="col-sm-4">
      <label for="labelPendidikan">Kategori</label>
      <select class="form-control" name="pendidikan" aria-describedby="deskripsiTahun" id="labelPendidikan" aria-label="Default select example" required>
      <option value="" <?= $param['pendidikan']==''? "selected" : ""; ?> disabled>Tingkatan Pendidikan</option>
        <?php foreach ($kategori as $k) : ?>
            <option value="<?= $k->id ?>" <?= $param['pendidikan'] == $k->id ? "selected" : ""; ?>><?= $k->slug ?></option>
        <?php endforeach; ?>
      </select>
      <small id="deskripsiTahun" class="form-text text-muted">Pilih Kategori Data</small>
    </div>
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
      <select class="form-control" name="wilayah" onchange="passWilayah(this)" aria-describedby="deskripsiTahun" id="labelWilayah" aria-label="Default select example" required>
      <option value="" <?= $param['wilayah']==''? "selected" : ""; ?> disabled>Pilih Tingkatan Daerah</option>
        <?php foreach ($kabupaten as $m) : ?>
            <option value="<?= $m->id_kabupaten ?>" <?= $param['wilayah'] == $m->id_kabupaten ? "selected" : ""; ?>><?= $m->nama_kabupaten ?></option>
        <?php endforeach; ?>
      </select>
      <input type="hidden" value="" id="wilayah-keterangan" name="nama_wilayah">
      <small id="deskripsiTahun" class="form-text text-muted">Sortir per wilayah</small>
    </div>  
    <div class="col-sm-1">
        <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </div>
    <div class="col-sm-1">
        <a href="<?= base_url('pendidikan') ?>" class="btn btn-success mt-2">Refresh</a>
    </div>
  </div>
</form>
    <?php if ($param['tahun'] !== null || $param['wilayah'] !== null || $param['pendidikan'] !== null) {
      $this->load->view('v_diagram', $data['data'] = $data);
      }
    ?>