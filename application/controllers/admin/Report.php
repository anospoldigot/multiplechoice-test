<?php 

// require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Report extends CI_Controller {
    
    public function excel ($id_form)
    {
        $data =  $this->db
            ->select('count(isi_form.id_form) as total_submit, user.nama_user, user.email_user, akses.status, akses.akses, isi_form.nilai')
            ->select_max('nilai')
            ->from('user')
            ->join('akses', 'akses.id_user = user.id_user', 'left')
            ->join('isi_form', 'isi_form.id_user = user.id_user', 'left')
            ->where('user.id_perusahaan', $this->input->get('key'))
            ->group_by('user.id_user')
            ->get()
            ->result();
        

        $abjad = ['a', 'b', 'c', 'd', 'e', 'f'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        foreach ($data as $key => $value) {
            $sheet->setCellValue($abjad[$key] . ($key+1), 'No');
            $sheet->setCellValue($abjad[$key] . ($key+1), 'Nama');
            $sheet->setCellValue($abjad[$key] . ($key+1), 'Email');
            $sheet->setCellValue($abjad[$key] . ($key+1), 'Total Submit');
            $sheet->setCellValue($abjad[$key] . ($key+1), 'Nilai Tertinggi');
            $sheet->setCellValue($abjad[$key] . ($key+1), 'Status');
        }

        $writer = new Xlsx($spreadsheet);

        $writer->save('assets/report/hello-world.xlsx');


        // redirect(base_url('assets/report/hello-world.xlsx'));

        // echo '<script>
        //         window.location.href = "'. base_url('assets/report/hello-world.xlsx') .'"
        // </script>';

        $this->session->set_flashdata('report' . $id_form, 'assets/report/hello-world.xlsx');
        redirect('admin/perusahaan/list_test/' . $this->input->get('current'));
    }

    public function excel_peruser ()
    {
        
    }
}

?>