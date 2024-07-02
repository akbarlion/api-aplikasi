<?php
require APPPATH . 'libraries/Authentication.php';
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

// use chriskacerguis\RestServer\Format;
use chriskacerguis\RestServer\RestController;
use Reservation\Libraries\Authentication;

class Aplikasi extends RestController
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_aplikasi', 'model');
    }


    // GET
    public function user_get()
    {
        $users = $this->model->get_data('user_login');
        if ($users) {
            $this->response([
                'status' => 200,
                'message' => 'Berhasil Menampilkan Data',
                'data' => $users
            ], self::HTTP_OK);
        } else {
            $this->response([
                'status' => 404,
                'message' => 'Gagal Menampilkan Data'
            ], self::HTTP_NOT_FOUND);
        }
    }
    public function mahasiswa_get()
    {
        $mahasiswa = $this->model->select_select_join_3table_type(
            'data_mahasiswa.ID as ID, data_mahasiswa.NAMA_MAHASISWA, data_mahasiswa.NIM,jurusan_mst.PROGRAM_STUDI as PRODI, fakultas_mst.FAKULTAS_NAME as FAKULTAS',
            'data_mahasiswa',
            'jurusan_mst',
            'data_mahasiswa.PROGDI_ID = jurusan_mst.ID',
            'left',
            'fakultas_mst',
            'data_mahasiswa.FAKULTAS_ID = fakultas_mst.ID',
            'left',
            'data_mahasiswa.IS_ACTIVE = 1'
        );
        if ($mahasiswa) {
            $this->response([
                'status' => 200,
                'message' => 'Berhasil Menampilkan Data',
                'data' => $mahasiswa
            ], self::HTTP_OK);
        } else {
            $this->response([
                'status' => 404,
                'message' => 'Gagal Menampilkan Data'
            ], self::HTTP_NOT_FOUND);
        }
    }
    public function prodi_get()
    {
        $prodi = $this->model->get_data('jurusan_mst');
        if ($prodi) {
            $this->response([
                'status' => 200,
                'message' => 'Berhasil Menampilkan Data',
                'data' => $prodi
            ], self::HTTP_OK);
        } else {
            $this->response([
                'status' => 404,
                'message' => 'Data Tidak Ada'
            ], self::HTTP_NOT_FOUND);
        }
    }

    public function fakultas_get()
    {
        $fakultas = $this->model->get_data('fakultas_mst');
        if ($fakultas) {
            $this->response([
                'status' => 200,
                'message' => 'Berhasil Menampilkan Data',
                'data' => $fakultas
            ], self::HTTP_OK);
        } else {
            $this->response([
                'status' => 404,
                'message' => 'Data Not Found'
            ], self::HTTP_NOT_FOUND);
        }
    }


    // POST
    public function login_post(
    ) {
        $param = $this->post();
        $USERNAME = $param['USERNAME'];
        $PASSWORD = md5($param['PASSWORD']);
        $validateLogin = $this->model->checking_user($USERNAME, $PASSWORD);
        if ($validateLogin) {
            $this->response([
                'result' => 200,
                'message' => 'Berhasil Login',
                'data' => $validateLogin
            ], self::HTTP_OK);
        } else {
            $this->response([
                'result' => 401,
                'message' => 'Gagal Login'
            ], self::HTTP_UNAUTHORIZED);
        }
    }

    public function insertUser_post()
    {
        $param = $this->post();
        $USERNAME = $param['USERNAME'];
        $PASSWORD = md5($param['PASSWORD']);
        $CREATED_AT = date('Y-m-d H:i:s');

        $data_insert = [
            'USERNAME' => $USERNAME,
            'PASSWORD' => $PASSWORD,
            'CREATED_AT' => $CREATED_AT,
        ];

        $check_user_exist = $this->model->select_where('user_login', array('USERNAME' => $USERNAME));
        if ($check_user_exist) {
            $this->response([
                'result' => 400,
                'message' => 'Username sudah ada',
            ], self::HTTP_BAD_REQUEST);
        } else {
            $insertData = $this->model->insert_data('user_login', $data_insert);
            if ($insertData) {
                $this->response([
                    'status' => 200,
                    'message' => 'Berhasil Menambahkan Username',
                    'data' => $insertData
                ], self::HTTP_OK);
            } else {
                $this->response([
                    'status' => 400,
                    'message' => 'Gagal Menambahkan User'
                ], self::HTTP_BAD_REQUEST);
            }
        }
    }

    public function insertJurusan_post()
    {
        $param = $this->post();
        $PROGRAM_STUDI = $param['PROGRAM_STUDI'];
        $FAKULTAS_ID = $param['FAKULTAS_ID'];
        $data_inserting = [
            'PROGRAM_STUDI' => $PROGRAM_STUDI,
            'FAKULTAS_ID' => $FAKULTAS_ID,
        ];
        $data_checking = $this->model->select_where('jurusan_mst', $data_inserting);
        if ($data_checking) {
            $this->response([
                'status' => 401,
                'message' => 'Data Sudah Ada'
            ], self::HTTP_BAD_REQUEST);
        } else {
            $inserting = $this->model->insert_data('jurusan_mst', $data_inserting);
            if ($inserting) {
                $this->response([
                    'status' => 200,
                    'message' => 'Berhasil Insert Data',
                    'data' => $inserting
                ], self::HTTP_OK);
            } else {
                $this->response([
                    'status' => 401,
                    'message' => 'Gagal Insert Data'
                ], self::HTTP_BAD_REQUEST);
            }
        }
    }

    public function insertMahasiswa_post()
    {
        $param = $this->post();
        $NAMA_MAHASISWA = $param['NAMA_MAHASISWA'];
        $NIM = $param['NIM'];
        $FAKULTAS_ID = $param['FAKULTAS_ID'];
        $PROGDI_ID = $param['PROGDI_ID'];
        $data_insert = [
            'NAMA_MAHASISWA' => $NAMA_MAHASISWA,
            'NIM' => $NIM,
            'FAKULTAS_ID' => $FAKULTAS_ID,
            'PROGDI_ID' => $PROGDI_ID,
            'IS_ACTIVE' => '1'
        ];

        $data_checking = $this->model->select_where('data_mahasiswa', $data_insert);
        if ($data_checking) {
            $this->response([
                'status' => 406,
                'message' => 'Data Sudah Ada'
            ], self::HTTP_NOT_ACCEPTABLE);
        } else {
            $data_insert = $this->model->insert_data('data_mahasiswa', $data_insert);
            if ($data_insert) {
                $this->response([
                    'status' => 200,
                    'message' => 'Berhasil Insert Data',
                    'data' => $data_insert
                ], self::HTTP_OK);
            } else {
                $this->response([
                    'status' => 401,
                    'message' => 'Gagal Insert Data'
                ], self::HTTP_BAD_REQUEST);
            }
        }
    }

    public function deleteMahasiswa_post()
    {
        $param = $this->post();
        $NIM = $param['NIM'];
        $deleting_data = $this->model->update_data('data_mahasiswa', array('IS_ACTIVE' => '0'), array('NIM' => $NIM));
        if ($deleting_data) {
            $this->response([
                'status' => 200,
                'message' => 'Berhasil Mengubah Data',
                'data' => $deleting_data
            ], self::HTTP_OK);
        } else {
            $this->response([
                'status' => 401,
                'message' => 'Gagal Mengubah Data'
            ], self::HTTP_BAD_REQUEST);
        }
    }

    public function editMahasiswa_post()
    {
        $param = $this->post();
        $ID = $param['ID'];
        $NAMA_MAHASISWA = $param['NAMA_MAHASISWA'];
        $NIM = $param['NIM'];
        $PROGDI_ID = $param['PROGDI_ID'];
        $FAKULTAS_ID = $param['FAKULTAS_ID'];
        $data_editing = [
            'NAMA_MAHASISWA' => $NAMA_MAHASISWA,
            'NIM' => $NIM,
            'FAKULTAS_ID' => $FAKULTAS_ID,
            'PROGDI_ID' => $PROGDI_ID,
            'IS_ACTIVE' => '1'
        ];
        $updating = $this->model->update_data('data_mahasiswa', $data_editing, array('ID' => $ID));
        if ($updating) {
            $this->response([
                'status' => 200,
                'message' => 'Berhasil Mengubah Data',
                'data' => $updating
            ], self::HTTP_OK);
        } else {
            $this->response([
                'status' => 401,
                'message' => 'Gagal Update Data'
            ], self::HTTP_BAD_REQUEST);
        }

    }

    public function deleteMahasiswaSelected_post()
    {
        $param = $this->post();
        $ID = $param['ID'];
        $ID_string = implode(',', $ID);
        $update = $this->model->update_data('data_mahasiswa', array('IS_ACTIVE' => '0'), "ID IN ($ID_string)");
        if ($update) {
            $this->response([
                'status' => 200,
                'message' => 'Berhasil Mengubah Data',
                'data' => $update
            ], self::HTTP_OK);
        } else {
            $this->response([
                'status' => 401,
                'message' => 'Gagal Mengubah Data'
            ], self::HTTP_BAD_REQUEST);
        }
    }



}