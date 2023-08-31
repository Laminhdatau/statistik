<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->user = $this->session->userdata('user');
        if (empty($this->user)) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert"><i class="fas fa-exclamation-triangle"> Anda harus login terlebih dahulu!</i></div>');
            redirect('login');
        }
        $this->user["id_role"] === '1' ? $this->username = 'Admin' : $this->username = 'Pemerintah';
        $this->load->model('m_data');
        $this->load->model('m_access');
        $this->menu = $this->m_access->menu();
    }

    private $user;
    private $username;
    private $menu;

    private function content($menu, $param = null)
    {
        $data['data'] = null;
        $data['user'] = $this->username;
        $data['menu'] = $this->menu;
        $data['open'] = $menu;
        switch ($menu) {
            case 'home':
                $data['jumlah'] = '1.160.600';
                break;
            case 'masyarakat':
                if ($this->user["id_role"] === '2') {
                    $msg = "Anda tidak punya akses ke menu ini!";
                    $ref = base_url('home');
                    echo "<script LANGUAGE='JavaScript'>
                        alert('" . $msg . "');
                        window.location.href = '" . $ref . "';
                    </script>";
                }
                $data['kabupaten'] = $this->m_data->getKabupaten();
                $data['kategori'] = $this->m_data->getKategori();
                $data['umur'] = $this->m_data->getUmur();
                $data['pendidikan'] = $this->m_data->getPendidikan();
                break;
            case 'pendidikan':
                $data['data'] = $this->m_data->getDataPendidikan($param);
                $data['param'] =  $param;
                $data['kabupaten'] = $this->m_data->getKabupaten();
                $data['tahun'] = $this->m_data->getDataTahun();
                $data['kategori'] = $this->m_data->getKategoriPendidikan();
                break;
            case 'perbandingan':
                $data['param'] =  $param;
                $data['tahun'] = $this->m_data->getDataTahun();
                $data['pendidikan'] = $this->m_data->getPendidikan();
                $data['wilayah'] = $this->m_data->getKabupaten();
                break;
            case 'pengangguran':
                $data['data'] = $this->m_data->getDataPengangguran($param);
                $data['kabupaten'] = $this->m_data->getKabupaten();
                $data['tahun'] = $this->m_data->getDataTahun();
                $data['param'] =  $param;
                break;
            default:
                break;
        }
        $data['view'] =  $menu;
        $data['title'] = 'Halaman ' . ucfirst($menu);
        $data['content_page'] = "v_" . $menu;
        $this->load->view("v_template", $data);
    }


    public function data_perbandingan()
    {
        $params['tahun'] = $this->input->post('tahun');
        $params['wilayah'] = $this->input->post('wilayah');
        $params['pendidikan'] = $this->input->post('pendidikan');

        $data['grafik_data'] = $this->m_data->getPerbandingan($params);

        $this->content('perbandingan', $data);
    }

    public function showPerbandingan()
    {
        $params['tahun'] = $this->input->post('tahun');
        $params['wilayah'] = $this->input->post('wilayah');
        $params['pendidikan'] = $this->input->post('pendidikan');

        $grafik_data = $this->m_data->getPerbandingan($params);

        $response = array(
            'success' => true,
            'data' => $grafik_data
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }




    public function index()
    {
        $this->content('home');
    }

    public function home()
    {
        $this->content('home');
    }

    public function data_pengangguran()
    {
        $this->form_validation->set_rules('tahun', 'tahun', 'trim');
        $this->form_validation->set_rules('wilayah', 'wilayah', 'trim');
        $param['tahun'] = $this->input->post('tahun');
        $param['wilayah'] = $this->input->post('wilayah');
        $param['nama'] = $this->input->post('nama_wilayah');
        $this->content('pengangguran', $param);
    }

    public function data_pendidikan()
    {
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|trim');
        $this->form_validation->set_rules('pendidikan', 'Pendidikan', 'required|trim', array('required|trim' => 'Pilih data kategori!'));
        $this->form_validation->set_rules('wilayah', 'Wilayah', 'required|trim');
        $param['tahun'] = $this->input->post('tahun');
        $param['pendidikan'] = $this->input->post('pendidikan');
        $param['wilayah'] = $this->input->post('wilayah');
        $param['nama'] = $this->input->post('nama_wilayah');
        $this->content('pendidikan', $param);
    }



    public function data_masyarakat()
    {
        $this->content('masyarakat');
    }




    public function save_akumulatif()
    {
        $post = $this->input->post(null, true);
        $code = $this->m_data->insertData($post);
        if ($code == 200) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil menambah data!</div>');
        } elseif ($code == 500) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Terjadi kesalahan!</div>');
        }
        redirect('masyarakat');
    }
}
