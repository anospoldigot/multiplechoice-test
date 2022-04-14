<?php

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
        $this->load->model('User_model', 'user');
        $this->load->model('Perusahaan_model', 'perusahaan');
        $this->load->model('Isi_form_model', 'isi_form');
        $this->load->helper('security');
        if ($this->session->userdata('status') != 'admin') {
            echo '<script>alert("Silahkan Login Untuk Mengakses Halaman ini")</script>';
            redirect('admin/login', 'refresh');
        }
    }

    /**
     * menampilkan list dari perusahaan sesuai dengan id perusahaan
     *
     * @param int $id_perusahaan id dari perusahaan
     *
     * @return void
     */
    public function list($id_perusahaan)
    {
        $join = array(
            ['perusahaan', 'perusahaan.id_perusahaan = user.id_perusahaan']
        );
        $where = ['user.id_perusahaan' => $id_perusahaan];
        $order = ['user.nama_user', 'ASC'];
        // mengambil data user sesuai dengan id perusahaan dan di join data usernya dengan perusahaan
        $data['user']      = $this->user->get_join_where_order('*', $join, $where, $order)->result();
        $data['page_title'] = "List User Perusahaan | Program Form";

        $data['batch'] = $this->db->where($where)->group_by('batch')->get('user')->num_rows() ?? 0;

        // var_dump($data);
        $this->load->view('admin/user/list', $data);
    }
    /**
     * menampilkan list form yang telah diisi oleh user
     *
     * @param int $id_user id dari user
     *
     * @return void
     */
    public function list_form($id_user)
    {
        $select = 'form.id_form, form.nama_form, isi_form.isi,isi_form.id_user as user_id, user.id_user';
        $join = [
            ['form', 'akses.id_form = form.id_form'],
            ['perusahaan', 'perusahaan.id_perusahaan= akses.id_perusahaan'],
            ['user', 'user.id_perusahaan = perusahaan.id_perusahaan'],
            ['isi_form', 'isi_form.id_form = form.id_form AND isi_form.id_user = user.id_user'],
        ];

        $where = [
            'user.id_user' => $id_user
        ];
        $order = ['isi_form.isi', 'ASC'];
        // mengambil data form sesuai dengan id user
        $data['form']      = $this->user->get_join_where_form($select, $join, $where, $order)->result();
        $data['page_title'] = "List Form User | Program Form";

        // var_dump($data);
        $this->load->view('admin/user/list_form', $data);
    }

    /**
     * menyimpan data user
     *
     * @return void
     */
    public function save()
    {
        // mengatur form validasii email
        $this->form_validation->set_rules(
            'email_user',
            'Email',
            'required|is_unique[user.email_user]',
            array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => 'This %s already exists.'
            )
        );

        // mengatur error delimiter
        $this->form_validation->set_error_delimiters('<span style="font-size: 10px;color:red">', '</span>');

        // jika  form validasi tidak lolos 
        if ($this->form_validation->run() == FALSE) {
            $user['id_perusahaan'] = $this->input->post('id_perusahaan'); // mengambil data id perusahaan yang di input untuk kembali ke halaman list user perusahaan
            $this->session->set_flashdata('error', 'Email sudah Di Gunakan');
            redirect('admin/user/list/' . $user['id_perusahaan']); // kembali ke halaman list user perusahaan
        } else {
            // mengambil data inputan user
            $user['nama_user'] = $this->input->post('nama_user');
            $user['email_user'] = $this->input->post('email_user');
            $user['password_user'] = password_hash($this->input->post('password_user'), PASSWORD_DEFAULT);
            $user['id_perusahaan'] = $this->input->post('id_perusahaan'); // mengambil data id perusahaan yang di input untuk kembali ke halaman list user perusahaan

            $this->session->set_flashdata('msg', 'User berhasil di simpan');
            $this->user->save($user);
            redirect('admin/user/list/' . $user['id_perusahaan']);
        }
    }

    /**
     * mengambil data user untuk di edit
     *
     * @param int $id
     *
     * @return void
     */
    public function edit($id_user)
    {

        // mengambil data user sesuai dengan id user dan di join data usernya dengan perusahaan
        $data = $this->user->get_join_where(
            '*',
            [['perusahaan', 'perusahaan.id_perusahaan = user.id_perusahaan']],
            ['user.id_user' => $id_user]
        )->row();

        echo json_encode($data);
    }

    /**
     * mengupdate data user
     *
     * @return void
     */
    public function update()
    {


        // mengatur eror delimiter
        $this->form_validation->set_error_delimiters('<span style="font-size: 10px;color:red">', '</span>');

        // mengambil data id_peruusahaan untuk kembali ke halamman list user
        $data['id_perusahaan'] = $this->input->post('id_perusahaan');

        // jika form validasi tidak lolos

        // mengambil data inputan user
        $data['id_user'] = $this->input->post('id_user');
        $data['nama_user'] = $this->input->post('nama_user');
        $data['email_user'] = $this->input->post('email_user');

        // mengecek apakah password di update
        if ($this->input->post('password_user', true) == null) {
            $data['password_user'] = $this->input->post('password_lama', true);
        } else {
            $data['password_user'] = password_hash($this->input->post('password_user', true), PASSWORD_DEFAULT);
        }

        // update data dan kembali ke halaman list user
        $this->user->update($data);
        $this->session->set_flashdata('msg', 'Data berhasil diupdate');
        redirect('admin/user/list/' . $data['id_perusahaan']);
    }
    /**
     * reset form user
     *
     * @return void
     */
    public function reset_form($id_form, $uri, $id_user)
    {
        $where = [
            'id_form' => $id_form,
            'id_user' => $id_user
        ];
        // update data dan kembali ke halaman list user
        $this->isi_form->delete($where);
        $this->session->set_flashdata('msg', 'Data berhasil direset');
        redirect('admin/user/list_form/' . $uri);
    }

    /**
     * menghapus data user
     *
     * @param [type] $id_user
     *
     * @return void
     */
    public function delete($id_user)
    {
        // mengambil data user yang id_perusahaan akan di gunakan untuk kembali ke halaman list user
        $data = $this->user->get_where(['id_user' => $id_user])->row();

        $this->user->delete(['id_user' => $id_user]);
        $this->session->set_flashdata('msg', 'Data Berhasil Di Hapus');
        redirect('admin/user/list/' . $data->id_perusahaan);
    }
}
