<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer_research extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('form_model', 'form');
        $this->load->model('isi_form_model', 'isi_form');
    }

    private function check_user()
    {
        if ($this->session->userdata('status') != 'user') {
            echo '<script>alert("Silahkan Login Untuk Mengakses Halaman ini")</script>';
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $this->check_user();

        // mengambil tipe form
        $form = $this->form->get_where(['nama_form' => 'Customer Research'])->row();
        // mengecek apakah si user sudah mengisi form atau belum
        $where = [
            'id_form' => $form->id_form,
            'id_user' => $this->session->userdata('id')
        ];
        $isi = $this->isi_form->get_where($where)->row();

        if (isset($isi)) {
            redirect('form/customer_research/show/' . $isi->id_isi);
        }

        $data['page_title'] = 'Customer Research';
        $this->load->view('form/customer_research', $data);
    }

    public function save()
    {
        $this->check_user();

        // mengambil tipe form
        $form = $this->form->get_where(['nama_form' => 'Customer Research'])->row();

        // mengambil data dari inputan user
        $data['tujuan'] = $this->input->post('tujuan');
        $data['goal']   = $this->input->post('goal');

        // data yang akan di masukan ke db
        $form_uo['isi'] = json_encode($data); // mengencode data inputan user
        $form_uo['id_form'] = $form->id_form; // id dari tipe form yang akan di masukan
        $form_uo['id_user'] = $this->session->userdata('id');
 
        $this->isi_form->save($form_uo);
        redirect('/form/customer_research/show/' . $this->db->insert_id());
    }

    public function show($id_isi_form)
    {
        // mengambil data dari db
        $data_form = $this->isi_form->get_where(['id_isi' => $id_isi_form])->row();

        // mengdecode data isi dari form hasil generate dari db
        $form = json_decode($data_form->isi);

        // mengambil data dari inputan user
        $data['tujuan'] = $form->tujuan;
        $data['goal']   = $form->goal;

        $data['page_title'] = 'Show Form Customer Research';
        $data['id_isi'] = $data_form->id_isi;

        // var_dump($data);
        // die();
        $this->load->view('show/customer_research', $data);
    }

    public function pdf($id_isi)
    {
        // mengambil data dari db
        $data_form = $this->isi_form->get_where(['id_isi' => $id_isi])->row();

        // mengdecode data isi dari form hasil generate dari db
        $form = json_decode($data_form->isi);

        // menyiapkan data untuk di tampilkan ke view
        $data['tujuan'] = $form->tujuan;
        $data['goal']   = $form->goal;

        // var_dump($data);
        // die();
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "Customer Research-" . date('d M Y') . ".pdf";

        $this->pdf->load_view('pdf/customer_research', $data);
    }
}
