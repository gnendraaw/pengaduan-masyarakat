<?php

class Login extends Controller {
    public function index()
    {
        Middleware::onlyNotLoggedIn();

        $this->view('templates/auth/header');
        $this->view('login/index');
        $this->view('templates/auth/footer');
    }

    public function sign()
    {
        Middleware::onlyNotLoggedIn();

        $data = [
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ];

        // encrypt password
        $data['password'] = md5($data['password']);

        $user = $this->model('petugas_model')->getPetugasByEmailAndPassword($data);

        // if user founded then set session based on founded data
        if ($user)
        {
            unset($_SESSION['user']);

            $_SESSION['user'] = [
                'id_petugas' => $user['id_petugas'],
                'nama_petugas' => $user['nama_petugas'],
                'username' => $user['username'],
                'email' => $user['email'],
                'telp' => $user['telp'],
                'id_level' => $user['id_level'],
            ];

            $this->directTo('/login');
        }
        $this->directTo('/login');
    }
}