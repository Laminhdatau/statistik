<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_data extends CI_Model
{
  public function getKategori()
  {
    $query = $this->db->get('t_kategori')
      ->where('id_kategori != 0')->result();
    return $query;
  }

  public function getKabupaten()
  {
    $query = $this->db->get('t_kabupaten')->result();
    return $query;
  }

  public function getDataTahun()
  {
    $this->db->distinct();
    $this->db->select('tahun');
    $this->db->order_by('tahun', 'ASC');
    $query = $this->db->get('t_data_statistika')->result();
    return $query;
  }

  public function getPendidikan()
  {
    $this->db->where('id_pendidikan !=', 0);
    $query = $this->db->get('t_tingkat_pendidikan')->result();
    return $query;
  }

  public function getUmur()
  {
    $this->db->where('id_tingkat !=', 0);
    $query = $this->db->get('t_tingkat_umur')->result();
    return $query;
  }

  public function getKategoriPendidikan()
  {
    $this->db->where('id NOT IN (0,1)');
    $query = $this->db->get('t_kategori')->result();
    return $query;
  }

  public function getDataPengangguran($param = null)
  {
    if ($param['tahun'] == '' && $param['wilayah'] == '') {
      // get default data
      $data = '';
    } elseif ($param['tahun'] == '') {
      $this->db->select('jumlah, tahun, t_kabupaten.nama_kabupaten');
      $this->db->where('id_kategori =', 1);
      $this->db->where('id_wilayah =', $param['wilayah']);
      $this->db->from('t_data_statistika');
      $this->db->join('t_kabupaten', 't_data_statistika.id_wilayah = t_kabupaten.id_kabupaten');
      $this->db->order_by('t_kabupaten.nama_kabupaten', 'ASC');
      $data = $this->db->get()->result();
    } elseif ($param['wilayah'] == '') {
      $this->db->select('jumlah, tahun, t_kabupaten.nama_kabupaten');
      $this->db->where('id_kategori =', 1);
      $this->db->where('tahun =', $param['tahun']);
      $this->db->from('t_data_statistika');
      $this->db->join('t_kabupaten', 't_data_statistika.id_wilayah = t_kabupaten.id_kabupaten');
      $this->db->order_by('t_kabupaten.nama_kabupaten', 'ASC');
      $data = $this->db->get()->result();
    } else {
      // get all data
      $this->db->select('jumlah, tahun, t_kabupaten.nama_kabupaten');
      $this->db->where('id_kategori =', 1);
      $this->db->where('id_wilayah =', $param['wilayah']);
      $this->db->where('tahun =', $param['tahun']);
      $this->db->from('t_data_statistika');
      $this->db->join('t_kabupaten', 't_data_statistika.id_wilayah = t_kabupaten.id_kabupaten');
      $this->db->order_by('t_kabupaten.nama_kabupaten', 'ASC');
      $data = $this->db->get()->result();
    }

    return $data;
  }

  public function getDataPendidikan($param = null)
  {
    // var_dump($param);
    if ($param['pendidikan'] == 2) {
      $this->db->select('jumlah, tahun, t_kabupaten.nama_kabupaten, t_tingkat_umur.umur');
      $this->db->order_by('t_tingkat_umur.id_tingkat', 'ASC');
    } elseif ($param['pendidikan'] == 3 || $param['pendidikan'] == 4) {
      $this->db->select('jumlah, tahun, t_kabupaten.nama_kabupaten, t_tingkat_pendidikan.pendidikan');
      $this->db->order_by('t_tingkat_pendidikan.id_pendidikan', 'ASC');
    }
    $this->db->select('jumlah, tahun, t_kabupaten.nama_kabupaten');
    $this->db->where('id_kategori =', $param['pendidikan']);
    $this->db->where('id_wilayah =', $param['wilayah']);
    $this->db->where('tahun =', $param['tahun']);
    $this->db->from('t_data_statistika');
    $this->db->join('t_kabupaten', 't_data_statistika.id_wilayah = t_kabupaten.id_kabupaten');
    $this->db->join('t_tingkat_umur', 't_data_statistika.id_umur = t_tingkat_umur.id_tingkat');
    $this->db->join('t_tingkat_pendidikan', 't_data_statistika.id_pendidikan = t_tingkat_pendidikan.id_pendidikan');
    $data = $this->db->get()->result();
    // echo "<pre>";
    // var_dump($data);
    // die();
    return $data;
  }

  public function getDataPendidikanPerTingkat($param = null)
  {
    // var_dump($param);
    if ($param['pendidikan'] == 2) {
      $this->db->select('jumlah, tahun, t_kabupaten.nama_kabupaten, t_tingkat_umur.umur');
    } elseif ($param['pendidikan'] == 3 || $param['pendidikan'] == 4) {
      $this->db->select('jumlah, tahun, t_kabupaten.nama_kabupaten, t_tingkat_pendidikan.pendidikan');
    }
    if ($param['aps'] !== null) {
      $this->db->where('id_umur =', $param['aps']);
    } elseif ($param['apm-apk'] !== null) {
      $this->db->where('t_tingkat_pendidikan.id_pendidikan =', $param['apm-apk']);
    }
    if ($param['tahun'] !== null) {
      $this->db->select('jumlah, tahun, t_kabupaten.nama_kabupaten');
      $this->db->where('id_kategori =', $param['pendidikan']);
      $this->db->where('tahun =', $param['tahun']);
      $this->db->from('t_data_statistika');
      $this->db->join('t_kabupaten', 't_data_statistika.id_wilayah = t_kabupaten.id_kabupaten');
      $this->db->join('t_tingkat_umur', 't_data_statistika.id_umur = t_tingkat_umur.id_tingkat');
      $this->db->join('t_tingkat_pendidikan', 't_data_statistika.id_pendidikan = t_tingkat_pendidikan.id_pendidikan');
      $this->db->order_by('t_kabupaten.nama_kabupaten', 'ASC');
      $data = $this->db->get()->result();
    } else {
      $data = '';
    }
    return $data;
  }

  public function getDataPengangguranPerTahun($param = null)
  {
    if ($param['tahun'] !== null) {
      $this->db->select('jumlah, tahun, t_kabupaten.nama_kabupaten');
      $this->db->where('id_kategori =', 1);
      $this->db->where('tahun =', $param['tahun']);
      $this->db->from('t_data_statistika');
      $this->db->join('t_kabupaten', 't_data_statistika.id_wilayah = t_kabupaten.id_kabupaten');
      $this->db->order_by('t_kabupaten.nama_kabupaten', 'ASC');
      $data = $this->db->get()->result();
    } else {
      $data = '';
    }
    return $data;
  }

  public function insertData($param)
  {
    try {
      $this->db->set('id_data', 'UUID()', false);
      $this->db->set('jumlah', (float)$param['total'], false);
      $this->db->set('id_kategori', (int)$param['kategori'], false);
      $this->db->set('tahun', $param['date']);
      $this->db->set('id_wilayah', (int)$param['wilayah'], false);
      if ($param["kategori"] == "2") {
        $this->db->set('id_umur', (int)$param['kategory-aps'], false);
      }
      if ($param["kategori"] == "3") {
        $this->db->set('id_pendidikan', (int)$param['kategory-apmapk'], false);
      }
      $this->db->insert('t_data_statistika');
      $code = 200;
      return $code;
    } catch (\Throwable $th) {
      $code = 500;
      return $code;
    }
  }





  //MODIF JOBDESK MIN

  public function getPerbandingan($params = null)
  {
    if ($params != null) {
      // Lakukan query ke database sesuai parameter

      $query = $this->db->query('
      SELECT
          ds.id_wilayah,
          ds.tahun,
          sum(CASE WHEN ds.id_kategori = 0 THEN ds.jumlah END) AS pdk,
          sum(CASE WHEN ds.id_kategori = 1 THEN ds.jumlah END) AS tpt,
          sum(CASE WHEN ds.id_kategori = 3 THEN ds.jumlah END) AS apm,
          sum(CASE WHEN ds.id_kategori = 4 THEN ds.jumlah END) AS apk,
          k.nama_kabupaten
      FROM
          t_data_statistika ds
      JOIN
          t_kabupaten k ON k.id_kabupaten = ds.id_wilayah
      JOIN
          t_tingkat_pendidikan p ON p.id_pendidikan=ds.id_pendidikan
          
    
      WHERE
          ds.id_wilayah = "' . $params['wilayah'] . '"
          AND ds.id_pendidikan in(0, "' . $params['pendidikan'] . '")
          AND ds.tahun = "' . $params['tahun'] . '"
      GROUP BY
          ds.id_wilayah,
          ds.tahun,
          k.nama_kabupaten
      ORDER BY
          ds.tahun;
    ');

      return $query->result();
    }
  }
}
