<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perusahaan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
        $this->load->model('User_model', 'user');
        $this->load->model('Perusahaan_model', 'perusahaan');
        $this->load->model('Form_model', 'form');
        $this->load->model('Akses_model', 'akses');
        $this->load->helper('security');
        if ($this->session->userdata('status') != 'admin') {
            echo '<script>alert("Silahkan Login Untuk Mengakses Halaman ini")</script>';
            redirect('admin/login', 'refresh');
        }
    }

    /**
     * menampilkan list perusahaan
     *
     * @return void
     */
    public function index()
    {
        $data['page_title'] = "List Perusahaan | Program Form";
        $data['perusahaan'] =  $this->perusahaan->get_all()->result();

        $this->load->view('admin/perusahaan/list', $data);
    }
    /**
     * menampilkan list form perusahaan
     *
     * @return void
     */
    public function list_form($id)
    {
        $data['page_title'] = "List Perusahaan | Program Form";
        $data['list_form'] =  $this->form->get_akses($id)->result();
        $data['form'] =  $this->form->get_all()->result();
        $data['perusahaan'] =  $this->akses->get_where(['id_perusahaan'=>$id])->row();

        $this->load->view('admin/perusahaan/list_form', $data);
    }

    /**
     * menyimpan data perusahaan
     *
     * @return void
     */
    public function save()
    {

        // mengatur form validasi nama_perusahaan
        $this->form_validation->set_rules(
            'nama_perusahaan',
            'Perusahaan',
            'required|is_unique[perusahaan.nama_perusahaan]',
            array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => 'This %s already exists.'
            )
        );

        // mengatur error delimiter
        $this->form_validation->set_error_delimiters('<span style="font-size: 10px;color:red">', '</span>');

        // jika form validasi tidak lolos
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Perusahaan sudah tersedia');
            redirect('admin/perusahaan');
        } else {
            // mengambil data inputan user
            $perusahaan['nama_perusahaan'] = $this->input->post('nama_perusahaan');

            $this->perusahaan->save($perusahaan);

            //menambah akses perusahaan
            $id_perusahaan = $this->db->insert_id();
            $form = $this->form->get_all()->result();
            foreach ($form as $data) {
                $data = array(
                    'id_perusahaan' => $id_perusahaan,
                    'id_form' => $data->id_form,
                    'akses' => 0,
                );
                $this->akses->save($data);
            }
            $this->session->set_flashdata('msg', 'Perusahaan berhasil di simpan');
            redirect('admin/perusahaan');
        }
    }
    /**
     * menyimpan data perusahaan
     *
     * @return void
     */
    public function add_list_akses_form()
    {
        // mengatur form validasi nama_perusahaan
        $uri = $this->input->post('uri', true);
        $form_check = $this->form->check_form($this->input->post('id_perusahaan', true), $this->input->post('form', true));
        if ($form_check->num_rows() > 0) {
            $this->session->set_flashdata('error', 'Form sudah tersedia');
            redirect('admin/perusahaan/list_form/' . $uri);
        } else {
            // mengambil data inputan user
            $data = array(
                'id_perusahaan' => $this->input->post('id_perusahaan', true),
                'id_form' => $this->input->post('form', true),
                'akses' => 0,
            );
            $this->akses->save($data);
            $this->session->set_flashdata('msg', 'Form berhasil di simpan');
            redirect('admin/perusahaan/list_form/' . $uri);
        }
    }

    /**
     * ubah akses form
     *
     * @return void
     */
    public function akses_form_allow($id_akses, $uri)
    {
        // mengambil data inputan user
        $data = array(
            'id_akses' => $id_akses,
            'akses' => 1,
        );
        $this->akses->update($data);
        $this->session->set_flashdata('msg', 'Akses berhasil di ubah');
        redirect('admin/perusahaan/list_form/' . $uri);
    }

    public function akses_form_denied($id_akses, $uri)
    {
        // mengambil data inputan user
        $data = array(
            'id_akses' => $id_akses,
            'akses' => 0,
        );
        $this->akses->update($data);
        $this->session->set_flashdata('msg', 'Akses berhasil di ubah');
        redirect('admin/perusahaan/list_form/' . $uri);
    }

    public function akses_allow_all($id_perusahaan, $uri)
    {
        // mengambil data inputan user
        $data = array(
            'akses' => 1,
        );
        $where = array('id_perusahaan' => $id_perusahaan);
        $this->akses->update_where($data, $where);
        $this->session->set_flashdata('msg', 'Akses berhasil di ubah');
        redirect('admin/perusahaan/list_form/' . $uri);
    }

    public function akses_denied_all($id_perusahaan, $uri)
    {
        // mengambil data inputan user
        $data = array(
            'akses' => 0,
        );
        $where = array('id_perusahaan' => $id_perusahaan);
        $this->akses->update_where($data, $where);
        $this->session->set_flashdata('msg', 'Akses berhasil di ubah');
        redirect('admin/perusahaan/list_form/' . $uri);
    }

    /**
     * mengambil data perusahaan untuk di edit
     *
     * @param integer $id
     *
     * @return void
     */
    public function edit($id)
    {
        $data = $this->perusahaan->get_where(['id_perusahaan' => $id])->row();
        echo json_encode($data);
    }

    /**
     * mengupdate data user
     *
     * @return void
     */
    public function update()
    {
        // mengatur form validasi
        $this->form_validation->set_rules(
            'nama_perusahaan',
            'Perusahaan',
            'required|is_unique[perusahaan.nama_perusahaan]',
            array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => 'This %s already exists.'
            )
        );

        // mengatur error delimiter
        $this->form_validation->set_error_delimiters('<span style="font-size: 10px;color:red">', '</span>');

        // jika form validasi tidak lolos
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Perusahaan sudah tersedia');
            redirect('admin/perusahaan');
        } else {
            // mengatur menngambil data inputan user
            $data = array(
                'id_perusahaan' => $this->input->post('id', true),
                'nama_perusahaan' => $this->input->post('nama_perusahaan', true)
            );

            $this->perusahaan->update($data);
            $this->session->set_flashdata('msg', 'Data berhasil diupdate');
            redirect('admin/perusahaan');
        }
    }

    /**
     * menghapus data perusahaan
     *
     * @param [type] $id_perusahaan
     *
     * @return void
     */
    public function delete($id_perusahaan)
    {
        $this->perusahaan->delete(['id_perusahaan' => $id_perusahaan]);
        $this->perusahaan->delete_user(['id_perusahaan' => $id_perusahaan]);
        $this->session->set_flashdata('msg', 'Data Perusahaan Berhasil Di Hapus');
        redirect('admin/perusahaan');
    }
}
