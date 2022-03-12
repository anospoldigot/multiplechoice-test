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
                    <p id="demo"></p>

                    <div class="row">
                        <!-- left column -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">Selamat mengerjakan</div>
                                <div class="card-body">
                                    <form action="<?= site_url('test/store') ?>" method="post">
                                        <input type="hidden" name="count" value="<?= count(json_decode($soal->isi)) ?>">
                                        <input type="hidden" name="id_form" value="<?=$soal->id_form?>">
                                        <input type="hidden" name="is_remed" value="<?= $this->input->get('repeat') ?>">
                                        <ol>
                                            <?php foreach(json_decode($soal->isi) as $key => $value): ?>
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
                                                            <input type="hidden" name="answer_key<?=$key?>" value="<?=$value->jawaban?>">
                                                            <input type="hidden" name="answer_val<?=$key?>" value="<?=$value->pilihan->{$k}?>">
                                                        <?php endforeach; ?>
                                                        
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endforeach; ?>
                                        </ol>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
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

    <!-- Display the countdown timer in an element -->

    <script>
        // Set the date we're counting down to
        var countDownDate = new Date("15:00").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("demo").innerHTML =
        minutes + "m " + seconds + "s ";

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRED";
        }
        }, 1000);
    </script>

</body>

</html>