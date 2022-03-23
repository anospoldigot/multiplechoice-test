<?php 
defined('BASEPATH') OR exit();

class test extends CI_Controller {

    public function __construct () 
    {
        parent::__construct();
        $this->load->model('Form_model', 'form');
        $this->load->model('User_model', 'user');
        $this->load->model('Akses_model', 'akses');
        $this->load->model('Perusahaan_model', 'perusahaan');
    }
    
    public function index ()
    {
        $data['tests'] = $this->form->get_all()->result();
        $data['perusahaan'] = $this->perusahaan->get_all()->result();
        $this->load->view('admin/test/index', $data);
    }

    public function destroy ($id_form)
    {

        $this->form->delete(['id_form' => $id_form]);

        $this->session->set_flashdata('success', 'Berhasil menghapus test');

        redirect('admin/test');
    }

    public function set_akses () 
    {
        $id_perusahaan = $this->input->post('id_perusahaan');

        $where = [
            'id_perusahaan' => $id_perusahaan,
            'id_form' => $this->input->post('id_form')
        ];

        $akses = $this->akses->delete($where);
        
        $users = $this->user->get_where(['id_perusahaan' => $id_perusahaan])->result();

        $data= [];

            foreach ($users as $key => $value) {
                $data[] = [
                    'id_perusahaan' => $id_perusahaan,
                    'id_form' => $this->input->post('id_form'),
                    'id_user' => $value->id_user,
                    'akses' => 0,
                    'status' => 0,
                    'total_submit' => 0
                ];

            }

        $this->akses->insert_batch($data);

        $this->session->set_flashdata('success', 'Berhasil memberi akses ke perusahaan');
        redirect('admin/test');
            
    }

    public function tarik_akses ()
    {
        $id_perusahaan = $this->input->post('id_perusahaan');

        $where = [
            'id_perusahaan' => $id_perusahaan,
            'id_form' => $this->input->post('id_form')
        ];

        $akses = $this->akses->delete($where);
        
        $this->session->set_flashdata('success', 'Berhasil menarik akses ke perusahaan');
        
        redirect('admin/test');
    }
}







?>