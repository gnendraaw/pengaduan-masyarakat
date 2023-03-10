<?php

class Pengaduan extends Controller {
    public function index()
    {
        Middleware::onlyNotLoggedIn();

        $aduan = $this->model('aduan_model')->getAllAduan();
        
        $data = [
            'title' => 'Pengaduan',
            'controller' => 'pengaduan',
            'aduan' => $aduan,
        ];

        $this->view('templates/header', $data);
        $this->view('pengaduan/index', $data);
        $this->view('templates/footer');
    }

    public function create()
    {
        Middleware::onlyNotLoggedIn();

        $data = [
            'title' => 'Ajukan Pengaduan',
            'controller' => 'pengaduan',
        ];

        $this->view('templates/header', $data);
        $this->view('pengaduan/create');
        $this->view('templates/footer', $data);
    }

    public function detail($id = null)
    {
        Middleware::onlyNotLoggedIn();

        $aduan = $this->model('aduan_model')->getAduanById($id);

        $data = [
            'title' => 'Detail Laporan',
            'controller' => 'pengaduan',
            'aduan' => $aduan,
        ];

        $this->view('templates/header', $data);
        $this->view('pengaduan/detail', $data);
        $this->view('templates/footer', $data);
    }

    public function search()
    {
        Middleware::onlyNotLoggedIn();

        $key = $_POST['search'];

        $aduan = $this->model('aduan_model')->getAduanByJudulOrAduan($key);
        $data = [
            'title' => 'Pengaduan',
            'controller' => 'pengaduan',
            'aduan' => $aduan,
        ];

        $this->view('templates/header', $data);
        $this->view('pengaduan/index', $data);
        $this->view('templates/footer');
    }

    public function store()
    {
        Middleware::onlyNotLoggedIn();

        $data = [
            'nama' => $_POST['nama'],
            'email' => $_POST['email'],
            'judul' => $_POST['judul'],
            'aduan' => $_POST['aduan'],
        ];

        if ($this->model('aduan_model')->addAduan($data) > 0)
        {
            $_SESSION['success']['msg'] = 'laporan berhasil terkirim!';
            $this->directTo();
        }
        else 
        {
            $_SESSION['error']['msg'] = 'terjadi kesalahan!';
            $this->directTo('/pengaduan');
        }
    }

    private function validateLength($data, $minLength) 
    {
        return strlen($data) >= $minLength;
    }
}