<?php 

class Test extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
        $this->load->model('Form_model', 'form');
        $this->load->model('Isi_form_model', 'isi_form');
    }

    public function index (){
        $where = ['id_user' => $this->session->userdata('id')];

        $id_perusahaan = $this->user->get_where($where)->row()->id_perusahaan;


        $join = [
            ['akses', 'akses.id_form = form.id_form'],
            ['isi_form', 'isi_form.id_form = form.id_form']
        ];

        $where = [
            'akses.id_perusahaan' => $id_perusahaan,
            'is_pretest' => 0
        ];

        $select = 'form.id_form, isi_form.nilai, form.nama_form';
        $data['form'] = $this->form->get_test($select, $join, $where, 'form.id_form')->result();

        $this->load->view('test/index', $data);

    }

    public function show ($id_form) 
    {
        $data['soal'] = $this->form->get_where(['id_form' => $id_form])->row();

        $this->load->view('test/show', $data);
    }

    public function store ()
    {
        // print_r($this->input->post('is_remed'));
        // die();
        $isi_form['benar'] = 0;
        $isi_form['salah'] = 0;

        $isi_form['isi'] = [];
        $isi_form['id_form'] = $this->input->post('id_form');
        $isi_form['id_user'] = $this->session->userdata('id');

        for ($key=0; $key < $this->input->post('count') ; $key++) { 
            if($this->input->post('pilihan'.$key) == $this->input->post('answer_key'.$key)){
                $isi_form['benar']+=1;
            }else{
                $isi_form['salah']+=1;
            }

            $push = [
                'pertanyaan' => $this->input->post('pertanyaan'.$key),
                'jawaban' => $this->input->post('answer_key'.$key),
                'benar' => [
                    $this->input->post('answer_key'.$key) => $this->input->post('answer_val'.$key),
                ]
            ];

            array_push($isi_form['isi'], $push);
        }

        $isi_form['nilai'] =  ($isi_form['benar'] / ($isi_form['benar']+$isi_form['salah'])) * 100;

        if($this->input->post('is_remed') == 'true' && $isi_form['nilai'] >= 70){

            $isi_form['nilai'] = 70;

        }
        $isi_form['isi'] =  json_encode($isi_form['isi']);
        
        $this->isi_form->save($isi_form);
        
        $this->session->set_flashdata('success', 'Berhasil menginput form');

        redirect('/test');
        
    }

    public function pretest ()
    {

        $where = [
            'id_perusahaan' => $this->session->userdata('id_perusahaan'),
            'is_pretest' => 1
        ];

        $join = [
            ['akses', 'akses.id_form = form.id_form']
        ];

        $tests = $this->form->get_join_where('*', $join, $where)->row();
        // print_r($tests);
        if(empty($tests)){
            $data['message'] = 'Pretest belum ada';
        }else{
            $where = [
                'id_user' => $this->session->userdata('id'),
                'id_form' => $tests->id_form
            ];
    
            $count = $this->isi_form->get_where($where)->num_rows();
    
            if($count > 0){
                echo "<script>
                        alert('Anda sudah menyelesaikan pretest');
                        window.location.href='" . site_url('/test') . "';
                    </script>";
            }else{
                $data['test'] = $tests;
            }
        }
        $this->load->view('test/pretest', $data);

    }

}


?>