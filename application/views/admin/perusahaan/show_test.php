<!DOCTYPE html>
<html lang="en">

<head>
<?php $data['page_title'] = $test->nama_form; $this->load->view('layout/head', $data) ?>
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
                    <div class="row">
                        <!-- left column -->
                        <div class="col-12">
                        <div class="card">
                                <div class="card-header"><?= $test->nama_form ?></div>
                                <div class="card-body">
                                        <ol>
                                            <?php foreach(json_decode($test->isi) as $key => $value): ?>
                                                <li>
                                                <div class="form-group">
                                                    <input type="hidden" name="pertanyaan<?=$key?>" value="<?= $value->pertanyaan ?>">
                                                    <label for=""><?= $value->pertanyaan ?></label>
                                                    <div class="form-group">
                                                        <?php foreach($value->pilihan as $k => $val): ?>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="pilihan<?=$key?>" id="pilihan<?=$k?><?=$key?>" value="<?=$k?>">
                                                                <label class="form-check-label" for="pilihan<?=$k?><?=$key?>">
                                                                    <span class="font-weight-bold text-uppercase"><?= $k ?>. </span><?= $val ?>
                                                                </label>
                                                            </div>
                                                            <?php endforeach; ?>
                                                        <span>Jawaban : <?=$value->jawaban?>. <?=$value->pilihan->{$value->jawaban}?></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endforeach; ?>
                                        </ol>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <!--/.col (left) -->
                    </div>
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

</body>

</html>