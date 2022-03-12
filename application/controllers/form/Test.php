<?php 

class Test extends CI_Controller {

    public function construct ()
    {
        parent::__construct();
        $this->load->model('Form_model', 'form');
        $this->load->model('User_model', 'user');

        
    }
    public function pre ()
    {
        
    }

    public function post ()
    {
        
    }

    public function index ()
    {
        $where = ['id_user' => $this->session->userdata('id')];

        $id_perusahaan = $this->user->get_where($where)->row()->id_perusahaan;


        $join = [
            ['akses', 'akses.id_form = form.id_form'],
        ];

        $where = [
            'akses.id_perusahaan' => $id_perusahaan,
            'is_pretest' => 0
        ];

        $data['form'] = $this->form->get_join_where('*', $join, $where)->result();

        $this->load->view('form/index', $data);
    }
}


?>