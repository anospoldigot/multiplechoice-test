<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Form extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
        $this->load->model('User_model', 'user');
        $this->load->model('Perusahaan_model', 'perusahaan');
        $this->load->model('Form_model', 'form');
        $this->load->model('Isi_form_model', 'isi_form');
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
        $data['page_title'] = "List Form | Program Form";
        $data['form'] =  $this->form->get_all_order(['nama_form', 'ASC'])->result();

        $this->load->view('admin/form/list', $data);
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
                $this->form->new_akses($data);
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
            $this->form->new_akses($data);
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
            'akses' => 1,
        );
        $this->form->ubah_akses($data, $id_akses);
        $this->session->set_flashdata('msg', 'Akses berhasil di ubah');
        redirect('admin/perusahaan/list_form/' . $uri);
    }
    public function akses_form_denied($id_akses, $uri)
    {
        // mengambil data inputan user
        $data = array(
            'akses' => 0,
        );
        $this->form->ubah_akses($data, $id_akses);
        $this->session->set_flashdata('msg', 'Akses berhasil di ubah');
        redirect('admin/perusahaan/list_form/' . $uri);
    }
    public function akses_allow_all($id_perusahaan, $uri)
    {
        // mengambil data inputan user
        $data = array(
            'akses' => 1,
        );
        $this->form->ubah_akses_all($data, $id_perusahaan);
        $this->session->set_flashdata('msg', 'Akses berhasil di ubah');
        redirect('admin/perusahaan/list_form/' . $uri);
    }
    public function akses_denied_all($id_perusahaan, $uri)
    {
        // mengambil data inputan user
        $data = array(
            'akses' => 0,
        );
        $this->form->ubah_akses_all($data, $id_perusahaan);
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
        $this->session->set_flashdata('msg', 'Data Perusahaan Berhasil Di Hapus');
        redirect('admin/perusahaan');
    }
    public function download_form($id_form)
    {
        $form = $this->form->get_where(['id_form' => $id_form])->row();
        $nama_form = strtolower(str_replace(' ', '_', $form->nama_form));

        redirect('pdf_form/' . $nama_form . ".pdf");
    }

    public function show_form($id_user, $id_form)
    {
        $join = [
            ['form', 'form.id_form = isi_form.id_form'],
            ['user', 'user.id_user = isi_form.id_user']
        ];

        $where = ['isi_form.id_user' => $id_user, 'isi_form.id_form' => $id_form];

        $data = $this->isi_form->get_join_where($join, $where)->row();
        $nama_form = strtolower(str_replace(' ', '_', $data->nama_form));

        redirect('form/' . $nama_form . '/' . 'show' . '/' . $data->id_isi);
    }

    public function create () {
        $data['perusahaan'] = $this->perusahaan->get_all()->result();
        $this->load->view('admin/form/create', $data);
    }

    public function store () 
    {
        if($this->input->post('type') > 0){
            $form['is_pretest'] = 1;

            $where = [
                'akses.id_perusahaan' => $this->input->post('id_perusahaan'),
                'form.is_pretest' => 1
            ];

            $join = [
                ['akses', 'akses.id_form = form.id_form']
            ];

            $count = $this->form->get_join_where('*', $join, $where)->row();

            if(count($count) > 0){
                $this->form->delete(['id_form' => $count->id_form]);
            }
        }

        $this->load->model('Akses_model', 'akses');
        
        $form ['nama_form'] = $this->input->post('nama_form');
        $form['created_at'] = date('Y-m-d h:i:s');

        $form['isi']  = [];
        foreach($this->input->post('a') as $key => $value){
            $push = [
                    'pertanyaan' => $this->input->post('pertanyaan' . ($key+1)),
                    'pilihan' => [
                        'a' => $this->input->post('a')[$key],
                        'b' => $this->input->post('b')[$key],
                        'c' => $this->input->post('c')[$key],
                        'd' => $this->input->post('d')[$key]
                    ],
                    'jawaban' => $this->input->post('jawaban' . ($key+1))
                ];

            array_push($form['isi'], $push);
                
        }
        $form['isi']  = json_encode($form['isi']);
        $id_form = $this->form->insert_id($form);

        $user = $this->user->get_where(['id_perusahaan' => $this->input->post('id_perusahaan')])->result();
        $users = [];
        foreach ($user as $value){
            $users[] = [
                'id_perusahaan' => $this->input->post('id_perusahaan'),
                'id_form' => $id_form,
                'akses' => 0
            ];
        }
        
        $this->akses->insert_batch($users);        

        redirect('admin/form');
    }


}
