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
        $order = ['nama_perusahaan', 'ASc'];
        $data['page_title'] = "List Perusahaan | Program Form";
        $data['perusahaan'] =  $this->perusahaan->get_all_order($order)->result();

        $this->load->view('admin/perusahaan/list', $data);
    }
    /**
     * menampilkan list form perusahaan
     *
     * @return void
     */
    public function list_form($id)
    {

        $join = [
            ['perusahaan', 'perusahaan.id_perusahaan = akses.id_perusahaan'],
            ['form', 'form.id_form = akses.id_form']
        ];

        $where = ['perusahaan.id_perusahaan' => $id];
        $order = ['form.nama_form', 'ASC'];

        $data['page_title'] = "List Perusahaan | Program Form";
        $data['list_form'] =  $this->akses->get_join_where_order('*', $join, $where, $order)->result();
        $data['form'] =  $this->form->get_all()->result();
        $data['perusahaan'] =  $this->perusahaan->get_where(['id_perusahaan' => $id])->row();

        $this->load->view('admin/perusahaan/list_form', $data);
    }
    

    public function list_test($id_perusahaan)
    {

        $join = [
            ['akses', 'akses.id_form = form.id_form'],
        ];

        $where = [
            'akses.id_perusahaan' => $id_perusahaan,
        ];

        $select = '*';
        $data['list_test'] = $this->form->admin_get_test($select, $join, $where, 'form.id_form')->result();
        
        $this->load->view('admin/perusahaan/list_test', $data);
    }

    public function test ($id_form)
    {   
        $data['test'] = $this->form->get_where(['id_form' => $id_form])->row();

        $this->load->view('admin/perusahaan/show_test', $data);
    }

    public function list_batch ($id_form)
    {
        $data['batchs'] = $this->db
            ->select('*')
            // ->select('count(if(isi_form.id_form = "' . $id_form. '", isi_form.id_form, NULL)) as total_submit, user.nama_user, user.email_user, akses.status, akses.akses, isi_form.nilai, isi_form.id_form, submit_ke')
            ->from('user')
            ->join('akses', 'akses.id_user = user.id_user', 'left')
            ->join('isi_form', 'isi_form.id_user = user.id_user', 'left')
            ->where([
                'user.id_perusahaan' => $this->input->get('key'),
                'user.batch !=' => null,
                'akses.id_form' => $id_form,
            ])
            ->group_by('user.batch')
            ->get()
            ->result();
        $data['id_form'] = $id_form;
        $this->load->view('admin/perusahaan/list_batch', $data);
    }

    public function list_submit ($id_form) 
    {
        // $join = [
        //     ['isi_form', 'isi_form.id_user = user.id_user']
        // ];

        // $where = [
        //     'isi_form.id_form' => $id_form
        // ];


        $data['users'] = $this->db
            ->select('count(if(isi_form.id_form = "' . $id_form. '", isi_form.id_form, NULL)) as total_submit, user.nama_user, user.email_user, akses.status, akses.akses, isi_form.nilai, akses.id_form, submit_ke, user.id_user, user.nilai_terakhir, user.batch')
            // ->select('count(if(isi_form.id_form = "' . $id_form. '", isi_form.id_form, NULL)) as total_submit, user.nama_user, user.email_user, akses.status, akses.akses, isi_form.nilai, isi_form.id_form, submit_ke')
            ->from('user')
            ->join('akses', 'akses.id_user = user.id_user', 'left')
            ->join('isi_form', 'isi_form.id_user = user.id_user', 'left')
            ->where([
                'user.id_perusahaan' => $this->input->get('key'),
                'user.batch' => $this->input->get('batch'),
                'akses.id_form' => $id_form,
            ])
            ->group_by('user.id_user')
            ->order_by('status', 'desc')
            ->get()
            ->result();
        $this->load->view('admin/perusahaan/user_submit', $data);
    }

    public function ajax_list_submit($id_form)
    {   
        
    //     $this->load->library('datatables');
    //     $this->datatables->add_column('foto', '<img src="http://www.rutlandherald.com/wp-content/uploads/2017/03/default-user.png" width=20>', 'foto');
    //     $this->datatables->select('nama_lengkap,email,no_hp');
    //     $this->datatables->add_column('action', anchor('karyawan/edit/.$1','Edit',array('class'=>'btn btn-danger btn-sm')), 'id_pegawai');
    //     $this->datatables->from('karyawan');
    //    return print_r($this->datatables->generate());
        $data = $this->db
            ->select('count(if(isi_form.id_form = "' . $id_form. '", isi_form.id_form, NULL)) as total_submit, user.nama_user, user.email_user, akses.status, akses.akses, isi_form.nilai, akses.id_form, submit_ke, user.id_user, user.nilai_terakhir, user.batch')
            // ->select('count(if(isi_form.id_form = "' . $id_form. '", isi_form.id_form, NULL)) as total_submit, user.nama_user, user.email_user, akses.status, akses.akses, isi_form.nilai, isi_form.id_form, submit_ke')
            ->from('user')
            ->join('akses', 'akses.id_user = user.id_user', 'left')
            ->join('isi_form', 'isi_form.id_user = user.id_user', 'left')
            ->where([
                'user.id_perusahaan' => $this->input->get('key'),
                'akses.id_form' => $id_form,
            ])
            ->group_by('user.id_user')
            ->get()
            ->result();

        echo json_encode($data);
    }

    public function pusher ()
    {
        // require __DIR__ . '/vendor/autoload.php';

        $this->load->library('pusher');
        $this->pusher->sendEvent();
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
        $this->user->delete(['id_perusahaan' => $id_perusahaan]);
        $this->session->set_flashdata('msg', 'Data Perusahaan Berhasil Di Hapus');
        redirect('admin/perusahaan');
    }

    public function detail_submit_user($id_form)
    {   
        $this->load->model('isi_form_model', 'isi_form');

        $where = [ 
            'user.id_user' => $this->input->get('key'),
            'id_form' => $id_form
        ];

        $join = [
            ['user', 'user.id_user = isi_form.id_user']
        ];

        $data['history'] = $this->isi_form->get_join_where('*', $join, $where)->result();

        $this->load->view('admin/perusahaan/detail_submit_user', $data);
    }
}
