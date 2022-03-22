<?php 
defined('BASEPATH') OR exit();

class test extends CI_Controller {

    public function __construct () 
    {
        parent::__construct();
        $this->load->model('Form_model', 'form');
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
}







?>