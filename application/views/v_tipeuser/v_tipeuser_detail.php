<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-sm-6">
                <h2 class="title">Tipe User</h2>
                <p class="sub-title">SIMBMS (Sistem Informasi Bank Mini Sekolah)</p>
            </div>
            <!-- /.col-sm-6 -->
            <!-- <div class="col-sm-6 right-side">
                <a class="btn bg-black toggle-code-handle tour-four" role="button">Toggle Code!</a>
            </div> -->
            <!-- /.col-sm-6 text-right -->
        </div>
        <!-- /.row -->
        <div class="row breadcrumb-div">
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a></li>
                    <li class="active">Data Master</li>
                    <li class="active">Tipe User</li>
                </ul>
            </div>
            <!-- /.col-sm-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <section class="section">
        <div class="container-fluid">
            <div class="row ">

                <div class="col-md-5">

                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5>Detail Tipe User</h5>
                            </div>
                        </div>
                        <div class="panel-body p-20">
                            <table class="table">
                                <tr>
                                    <td>
                                        Tipe User
                                    </td>
                                    <td>
                                        :
                                    </td>

                                    <td><?= $tipeuser['tipeuser'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                </tr>
                            </table>
                            <a href="<?= base_url('tipeuser') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <a href="<?= base_url('tipeuser-ubah/') . $tipeuser['id_tipeuser'] ?>" class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</a>
                            <a href="<?= base_url('TipeUser/hapus/') . $tipeuser['id_tipeuser'] ?>" class="btn btn-danger" onclick="return confirm('Yakin Mau Dihapus ?')"><i class="fa fa-trash"> Hapus</i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.section -->
</div>
<!-- /.main-page -->
<!-- /.right-sidebar -->

</div>
<!-- /.content-container -->
</div>