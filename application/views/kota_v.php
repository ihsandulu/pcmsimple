<!doctype html>
<html>

<head>
    <?php
    require_once("meta.php"); ?>
</head>

<body class="  ">
    <?php require_once("header.php"); ?>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#"><svg class="glyph stroked home">
                            <use xlink:href="#stroked-home"></use>
                        </svg></a></li>
                <li class="active">Kota</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-md-10">
                <h1 class="page-header"> Kota</h1>
            </div>
            <?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>
                <form method="post" class="col-md-2">
                    <h1 class="page-header col-md-12">
                        <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                        <input type="hidden" name="kota_id" />
                    </h1>
                </form>
            <?php } ?>
        </div><!--/.row-->


        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                            <div class="">
                                <?php if (isset($_POST['edit'])) {
                                    $namabutton = 'name="change"';
                                    $judul = "Update Kota";
                                } else {
                                    $namabutton = 'name="create"';
                                    $judul = "New Kota";
                                } ?>
                                <div class="lead">
                                    <h3><?= $judul; ?></h3>
                                </div>
                                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="provinsi_id">Provinsi:</label>
                                        <div class="col-sm-10">
                                            <select class="form-control select2" id="provinsi_id" name="provinsi_id">
                                                <option value="" <?=($provinsi_id == "") ? "selected" : ""; ?>>Pilih Provinsi</option>
                                                <?php $provinsi = $this->db->order_by("provinsi_name", "ASC")->get("provinsi");
                                                foreach ($provinsi->result() as $provinsi) { ?>
                                                    <option value="<?= $provinsi->provinsi_id; ?>" <? ($provinsi_id == $provinsi->provinsi_id) ? "selected" : ""; ?>><?= $provinsi->provinsi_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="kota_name">Nama Kota:</label>
                                        <div class="col-sm-10">
                                            <input type="text" autofocus class="form-control" id="kota_name" name="kota_name" placeholder="Enter kota" value="<?= $kota_name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="kota_code">Kode Kota:</label>
                                        <div class="col-sm-10">
                                            <input type="text" autofocus class="form-control" id="kota_code" name="kota_code" placeholder="Enter kota" value="<?= $kota_code; ?>">
                                        </div>
                                    </div>
                                    <input type="hidden" name="kota_id" value="<?= $kota_id; ?>" />
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                            <button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("kota"); ?>">Back</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php } else { ?>
                            <?php if ($message != "") { ?>
                                <div class="alert alert-info alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong><?= $message; ?></strong><br /><?= $uploadkota_picture; ?>
                                </div>
                            <?php } ?>
                            <div class="box">
                                <div id="collapse4" class="body table-responsive">
                                    <table id="dataTable" class="table table-condensed table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1">Action</th>
                                                <th>Provinsi</th>
                                                <th>Code</th>
                                                <th>Kota</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $usr = $this->db
                                                ->join("provinsi", "provinsi.provinsi_id=kota.provinsi_id", "left")
                                                ->order_by("kota_id", "desc")
                                                ->get("kota");
                                            $no = 1;
                                            foreach ($usr->result() as $kota) { ?>
                                                <tr>
                                                    <td style="padding-left:0px; padding-right:0px;">
                                                        <form method="post" class="col-md-6" style="padding:0px;">
                                                            <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                            <input type="hidden" name="kota_id" value="<?= $kota->kota_id; ?>" />
                                                        </form>

                                                        <form method="post" class="col-md-6" style="padding:0px;">
                                                            <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                            <input type="hidden" name="kota_id" value="<?= $kota->kota_id; ?>" />
                                                        </form>
                                                    </td>
                                                    <td><?= $kota->provinsi_name; ?></td>
                                                    <td><?= $kota->kota_code; ?></td>
                                                    <td><?= $kota->kota_name; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- /#wrap -->
        <?php require_once("footer.php"); ?>
</body>

</html>