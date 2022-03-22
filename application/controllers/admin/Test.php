<?php 
defined('BASEPATH') OR exit();

class test extends CI_Controller {

    public function __construct () 
    {
        parent::__construct();
        $this->load->model('Form_model', 'form');
        $this->load->model('Akses_model', 'akses');
    }
    
    public function index ()
    {
        $data['tests'] = $this->form->get_all()->result();

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
        $id_perusahaan = $this->input->get('id_perusahaan');

        // $this->db
        //     ->where_in('id_perusahaan', $id_perusahaan)
        //     ->delete('akses');
        
        $data= [];

            foreach ($id_perusahaan as $key => $value) {
                $data[] = [
                    'id_perusahaan' => $value
                ];

            }

        var_dump($data);
        // $this->db->insert_batch()
            
    }
}







?>