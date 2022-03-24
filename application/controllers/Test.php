<?php 

class Test extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
        $this->load->model('Form_model', 'form');
        $this->load->model('Isi_form_model', 'isi_form');
        $this->load->model('Akses_model', 'akses');
        if ($this->session->userdata('status') != 'user') {
            echo '<script>alert("Silahkan Login Untuk Mengakses Halaman ini")</script>';
            redirect('/login', 'refresh');
        }
    }

    public function dashboard ()
    {
        $this->load->view('test/dashboard');
    }


    public function index (){
        // $where = [
        //     'id_user' => $this->session->userdata('id'),
        //     'form.is_pretest' => 1
        // ];

        // $join = [
        //     ['form', 'form.id_form = isi_form.id_form']
        // ];

        // $check_test = $this->isi_form->get_join_where('*', $join ,$where)->result();
        // if(empty($check_test)){
        //     echo '<script>
        //         alert("Selesaikan pretest dahulu");
        //         window.location.href="' . site_url('test/pretest') .'"
        //     </script>';
        // }

        $where = ['id_user' => $this->session->userdata('id')];

        $id_perusahaan = $this->user->get_where($where)->row()->id_perusahaan;


        $join = [
            ['akses', 'akses.id_form = form.id_form'],
            ['isi_form', 'isi_form.id_form = form.id_form'],
        ];

        $where = [
            'akses.id_perusahaan' => $id_perusahaan,
            'is_pretest' => 0,
            'akses.id_user' => $this->session->userdata('id')
        ];

        $select = 'form.id_form, isi_form.nilai, form.nama_form, akses.status, akses.akses, total_submit';

        
        $data['form'] = $this->form->get_test($select, $join, $where, 'form.id_form')->result();

        $this->load->view('test/index', $data);

    }

    public function show ($id_form) 
    {   
        // $where = [
        //     'id_form' => $id_form+1,
        //     'id_user' => $this->session->userdata('id')
        // ];

        // $cek_data = $this->isi_form->get_where($where)->num_rows();

        
        // $data['soal'] = $this->form->get_where(['id_form' => $id_form])->row();

        // if($cek_data == 0 && $data['soal']->is_pretest == 0){
        //     echo '<script>
        //         alert("Kerjakan pretest dahulu");
        //         window.location.href = "' . site_url('test/pretest') . '"
        //     </script>';
        // }

        $where = [
            'id_form' => $id_form,
            'id_user' => $this->session->userdata('id')
        ];

        $data['total_submit'] = $this->isi_form->get_where($where)->num_rows();

        $data['soal'] = $this->form->get_where(['id_form' => $id_form])->row();
        // var_dump($data);

        $this->load->view('test/show', $data);
    }

    public function store ()
    {
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


        $where = [
            'id_form' => $this->input->post('id_form'),
            'id_user' => $this->session->userdata('id')
        ];

        if($this->input->post('is_remed') == 'true' && $isi_form['nilai'] >= 70){

            $isi_form['nilai'] = 70;
            $isi_form['is_repeat'] = 1;
            $this->akses->update_where(['status' => 2], $where);
        }else if($this->input->post('is_remed') == '' && $isi_form['nilai'] >= 70){
            $this->akses->update_where(['status' => 2], $where);
        }else{
            $this->akses->update_where(['status' => 1 ], $where);
        }


        $isi_form['isi'] =  json_encode($isi_form['isi']);
        $isi_form['submit_ke'] = $this->input->post('total_submit') + 1;
        $this->isi_form->save($isi_form);


        $cek_data = $this->isi_form->get_where($where)->num_rows();

        if($cek_data == 2 || $cek_data == 4 || $cek_data == 6 || $cek_data == 9){

            $update = [
                'akses' => 0,
                'total_submit' => $this->input->post('total_submit') + 1
            ];

            $this->akses->update_where($update,$where);
        }else{
            $update = [
                'total_submit' => $this->input->post('total_submit') + 1
            ];

            $this->akses->update_where($update,$where);
        }

        $this->session->set_flashdata('success', 'Berhasil menginput form');

        redirect('/test');
    }

    public function pretest ()
    {

        // $where = [
        //     'id_user' => $this->session->userdata('id'),
        //     'form.is_pretest' => 1
        // ];

        // $join = [
        //     ['form', 'form.id_form = isi_form.id_form']
        // ];

        // $check_test = $this->isi_form->get_join_where('*', $join ,$where)->result();
        // if(empty($check_test)){
        //     echo '<script>
        //         alert("Selesaikan pretest dahulu");
        //         window.location.href="' . site_url('test/pretest') .'"
        //     </script>';
        // }

        $where = ['id_user' => $this->session->userdata('id')];

        $id_perusahaan = $this->user->get_where($where)->row()->id_perusahaan;


        $join = [
            ['akses', 'akses.id_form = form.id_form'],
            ['isi_form', 'isi_form.id_form = form.id_form'],
        ];

        $where = [
            'akses.id_perusahaan' => $id_perusahaan,
            'is_pretest' => 1,
            'akses.id_user' => $this->session->userdata('id')
        ];

        $select = 'form.id_form, isi_form.nilai, form.nama_form, akses.status, akses.akses';
        $data['form'] = $this->form->get_test($select, $join, $where, 'form.id_form')->result();

        $this->load->view('test/pretest', $data);
    }

    public function history ($id_form)
    {
        $data['history'] = $this->db
            ->select('*')
            ->from('user')
            ->join('akses', 'akses.id_user = user.id_user', 'left')
            ->join('isi_form', 'isi_form.id_user = user.id_user', 'left')
            ->where([
                'akses.id_form' => $id_form,
                'akses.id_user' => $this->session->userdata('id'),
            ])
            ->get()
            ->result();
        $this->load->view('test/history', $data);
    }

}


?>