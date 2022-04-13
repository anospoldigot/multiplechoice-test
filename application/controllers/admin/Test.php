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
        
        $usersCompany = $this->akses->get_where($where)->result();

        $existUser = [];
        
        foreach($usersCompany as $value){
            array_push($existUser, $value->id_user);
        }
        if(empty($existUser)){
            $users = $this->db
                ->where('id_perusahaan', $id_perusahaan)
                ->get('user')
                ->result();  
        }else{
            $users = $this->db
                ->where('id_perusahaan', $id_perusahaan)
                ->where_not_in('id_user', $existUser)
                ->get('user')
                ->result();  
        }


        $data= [];

            foreach ($users as $key => $value) {
                $data[] = [
                    'id_perusahaan' => $id_perusahaan,
                    'id_form' => $this->input->post('id_form'),
                    'id_user' => $value->id_user,
                    'akses' => 0,
                    'status' => 0,
                    'total_submit' => 0,
                    'min_nilai' => $this->input->post('min_nilai')
                ];

            }

        if(count($data) > 0){
             $this->akses->insert_batch($data);
        }

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

    public function generateUser()
    {
		$file = $_FILES['csv']['tmp_name'];

		// Medapatkan ekstensi file csv yang akan diimport.
		$ekstensi  = explode('.', $_FILES['csv']['name']);

		// Tampilkan peringatan jika submit tanpa memilih menambahkan file.
		if (empty($file)) {
			echo 'File tidak boleh kosong!';
		} else {
			// Validasi apakah file yang diupload benar-benar file csv.
			if (strtolower(end($ekstensi)) === 'csv' && $_FILES["csv"]["size"] > 0) {

				$i = 0;
				$handle = fopen($file, "r");
				while (($row = fgetcsv($handle, 2048))) {
					$i++;
					if ($i == 1) continue;

					// Data yang akan disimpan ke dalam databse
					$coachee['nama_user'] = $row[1];
					$coachee['email_user'] = strtolower($row[2]);
					$coachee['password_user'] = password_hash(strtolower($row[4]), PASSWORD_DEFAULT);
					$coachee['username'] =  strtolower($row[3]);
					$coachee['id_perusahaan'] = 2;
					$coachee['batch'] = 3;
                    $this->db->insert('user', $coachee);
					// Simpan data ke database.
					// $this->AdminModel->saveCoachee($coachee);
				}
                
				fclose($handle);
				$this->session->set_flashdata('coachee', 'Berhasil Menyimpan Data Coachee');
				// redirect('admin/coachee/list/' . $coachee['company_id'], 'refresh
                echo "mueheheheh";
			} else {
				echo 'Format file tidak valid!';
			}
		}
    }

    public function mueheh(){
        $this->load->view('mueheh');
    }
}







?>