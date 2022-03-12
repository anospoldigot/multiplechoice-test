<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('layout/head') ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php $this->load->view('layout/navbar') ?>

        <?php $this->load->view('layout/sidebar') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <!-- <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>General Form</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">General Form</li>
                            </ol>
                        </div>
                    </div> -->
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- <div class="mb-3">
                        <button class="btn btn-sm btn-success" onclick="tambahsoal()">Tambah Soal</button>
                        <button class="btn btn-sm btn-danger" onclick="hapussoal()">Hapus Soal</button>
                    </div>
                    <div class="row">
                        left column
                        <div class="col-12" id="soal-wrapper">
                            <div class="form-group">
                                <label for="pertanyaan1" class="form-label">Soal 1</label>
                                <textarea class="form-control" name="pertanyaan1" id="pertanyaan1" cols="30" rows="3" required></textarea>
                            </div>
                        </div>
                        /.col
                        /.col (left)
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit Form</button>
                    </div> -->
                    <div class="mb-3">
                        <button type="button" class="btn btn-success" onclick="tambahsoal()">Tambah Soal</button>
                        <button type="button" class="btn btn-danger" onclick="hapussoal()">Hapus Soal</button>
                    </div>
                    <form action="<?= site_url('admin/form/store') ?>" method="post">
                        <div class="form-group">
                            <label for="nama_form">Judul</label>
                            <input type="text" name="nama_form" id="nama_form" class="form-control" placeholder="Judul">
                        </div>
                        <div class="form-group">
                            <label for="nama_perusahaan">Perusahaan</label>
                            <select name="id_perusahaan" id="id_perusahaan" class="form-control">
                                <?php foreach($perusahaan as $value): ?>
                                    <option value="<?= $value->id_perusahaan ?>"><?= $value->nama_perusahaan ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="0">Post Test</option>
                                <option value="1">Pretest</option>
                            </select>
                        </div>
                        <div id="soal-wrapper">
                            <div class="soal mb-5">
                                <div class="form-group">
                                    <label for="pertanyaan1">Pertanyaan 1</label>
                                    <input type="text" name="pertanyaan1" id="pertanyaan1" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="pilihan1">Pilihan Pertanyaan 1</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">A</span>
                                        </div>
                                        <input type="text" class="form-control" name="a[]" placeholder="Pilihan A">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">B</span>
                                        </div>
                                        <input type="text" class="form-control" name="b[]" placeholder="Pilihan B">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">C</span>
                                        </div>
                                        <input type="text" class="form-control" name="c[]" placeholder="Pilihan C">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">D</span>
                                        </div>
                                        <input type="text" class="form-control" name="d[]" placeholder="Pilihan D">
                                    </div>
                                    <div class="form-group">
                                        <label for="jawaban1">Jawaban</label>
                                        <select name="jawaban1" id="jawaban1" class="form-control">
                                             <option value="a">A</option>               
                                             <option value="b">B</option>               
                                             <option value="c">C</option>               
                                             <option value="d">D</option>               
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2021 Korpora Consulting.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php $this->load->view('layout/script') ?>
    <script>
        // const tambahsoal = function (){
        //     $('#soal-wrapper').append(`<div class="form-group">
        //                         <label for="pertanyaan${ $('#soal-wrapper .form-group').length + 1}" class="form-label">Soal ${ $('#soal-wrapper .form-group').length + 1}</label>
        //                         <textarea class="form-control" name="pertanyaan${ $('#soal-wrapper .form-group').length + 1}" id="pertanyaan${ $('#soal-wrapper .form-group').length + 1}" cols="30" rows="3" required></textarea>
        //                     </div>`);
        // }
        
        // const hapussoal = function () {
        //     $('#soal-wrapper .form-group')[$('#soal-wrapper .form-group').length - 1].remove()
        // }
        const tambahsoal = function () {
            $('#soal-wrapper').append(`<div class="soal mb-5">
                            <div class="form-group">
                                <label for="pertanyaan${ $('#soal-wrapper .soal').length + 1 }">Pertanyaan ${ $('#soal-wrapper .soal').length + 1 }</label>
                                <input type="text" name="pertanyaan${ $('#soal-wrapper .soal').length + 1 }" id="pertanyaan${ $('#soal-wrapper .soal').length + 1 }" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="pilihan${ $('#soal-wrapper .soal').length + 1 }">Pilihan Pertanyaan ${ $('#soal-wrapper .soal').length + 1 }</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon${ $('#soal-wrapper .soal').length + 1 }">A</span>
                                    </div>
                                    <input type="text" class="form-control" name="a[]" placeholder="Pilihan A">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon${ $('#soal-wrapper .soal').length + 1 }">B</span>
                                    </div>
                                    <input type="text" class="form-control" name="b[]" placeholder="Pilihan B">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon${ $('#soal-wrapper .soal').length + 1 }">C</span>
                                    </div>
                                    <input type="text" class="form-control" name="c[]" placeholder="Pilihan C">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon${ $('#soal-wrapper .soal').length + 1 }">D</span>
                                    </div>
                                    <input type="text" class="form-control" name="d[]" placeholder="Pilihan D">
                                </div>
                                <div class="form-group">
                                    <label for="jawaban${ $('#soal-wrapper .soal').length + 1 }">Jawaban</label>
                                    <select name="jawaban${ $('#soal-wrapper .soal').length + 1 }" id="jawaban${ $('#soal-wrapper .soal').length + 1 }" class="form-control">
                                         <option value="a">A</option>               
                                         <option value="b">B</option>               
                                         <option value="c">C</option>               
                                         <option value="d">D</option>               
                                    </select>
                                </div>
                            </div>
                        </div>`);
        }
    </script>

</body>

</html>