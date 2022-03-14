<!DOCTYPE html>
<html lang="en">

<head>
<?php $data['page_title'] = 'List Submit'; $this->load->view('layout/head', $data) ?>
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
                                <div class="card-header">
                                    <h3 class="card-title">List Test</h3>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="datatable-with-export" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Nama Peserta</th>
                                                <th>Email</th>
                                                <th>Nilai Tertinggi</th>
                                                <th>Total Submit</th>
                                                <th>Status</th>
                                                <!-- <th>Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $key => $value) : ?>
                                                <tr>
                                                    <td><?= $key+1 ?></td>
                                                    <td><?= $value->nama_user ?></td>
                                                    <td><?= $value->email_user ?></td>
                                                    <td><?= $value->nilai ?></td>
                                                    <td><?= $value->total_submit  ?></td>
                                                    <td>
                                                    <?php if($value->status == 0): ?>
                                                        <span class="badge badge-danger">Belum Mulai</span>
                                                    <?php elseif($value->status == 1): ?>
                                                        <span class="badge badge-warning">Belum Lulus</span>
                                                    <?php elseif($value->status == 2): ?>
                                                        <span class="badge badge-success">Lulus</span>
                                                    <?php endif; ?>    
                                                    </td>
                                                    <!-- <td>
                                                        <a href="" class="btn btn-sm btn-primary">Generate Report</a>
                                                    </td> -->
                                                </tr>
                                            <?php endforeach; ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
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
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable-with-export').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    // 'copyHtml5',
                    'excelHtml5',
                    // 'csvHtml5',
                    // 'pdfHtml5'
                ]
            } );
        } );
    </script>
</body>

</html>