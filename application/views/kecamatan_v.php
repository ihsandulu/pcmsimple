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
                <li class="active">Kecamatan</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-md-10">
                <h1 class="page-header"> Kecamatan</h1>
            </div>
            <?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>
                <form method="post" class="col-md-2">
                    <h1 class="page-header col-md-12">
                        <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                        <input type="hidden" name="kecamatan_id" />
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
                                    $judul = "Update Kecamatan";
                                } else {
                                    $namabutton = 'name="create"';
                                    $judul = "New Kecamatan";
                                } ?>
                                <div class="lead">
                                    <h3><?= $judul; ?></h3>
                                </div>
                                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="kota_id">Kota:</label>
                                        <div class="col-sm-10">
                                            <select class="form-control select2" id="kota_id" name="kota_id">
                                                <option value="" <? ($kota_id == "") ? "selected" : ""; ?>>Pilih kota</option>
                                                <?php 
                                                $kota = $this->db->order_by("kota_name", "ASC")->get("kota");
                                                foreach ($kota->result() as $kota) { ?>
                                                    <option value="<?= $kota->kota_id; ?>" <?=($kota_id == $kota->kota_id) ? "selected" : ""; ?>><?= $kota->kota_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="kecamatan_name">Nama Kecamatan:</label>
                                        <div class="col-sm-10">
                                            <input type="text" autofocus class="form-control" id="kecamatan_name" name="kecamatan_name" placeholder="Enter kecamatan" value="<?= $kecamatan_name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="kecamatan_code">Kode Kecamatan:</label>
                                        <div class="col-sm-10">
                                            <input type="text" autofocus class="form-control" id="kecamatan_code" name="kecamatan_code" placeholder="Enter kecamatan" value="<?= $kecamatan_code; ?>">
                                        </div>
                                    </div>
                                    <input type="hidden" name="kecamatan_id" value="<?= $kecamatan_id; ?>" />
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                            <button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("kecamatan"); ?>">Back</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php } else { ?>
                            <?php if ($message != "") { ?>
                                <div class="alert alert-info alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong><?= $message; ?></strong><br /><?= $uploadkecamatan_picture; ?>
                                </div>
                            <?php } ?>
                            <div class="box">
                                <div id="collapse4" class="body table-responsive">
                                    <table id="dataTable" class="table table-condensed table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1">Action</th>
                                                <th>Kota</th>
                                                <th>Code</th>
                                                <th>Kecamatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $usr = $this->db
                                                ->join("kota", "kota.kota_id=kecamatan.kota_id", "left")
                                                ->order_by("kecamatan_id", "desc")
                                                ->get("kecamatan");
                                            $no = 1;
                                            foreach ($usr->result() as $kecamatan) { ?>
                                                <tr>
                                                    <td style="padding-left:0px; padding-right:0px;">
                                                        <form method="post" class="col-md-6" style="padding:0px;">
                                                            <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                            <input type="hidden" name="kecamatan_id" value="<?= $kecamatan->kecamatan_id; ?>" />
                                                        </form>

                                                        <form method="post" class="col-md-6" style="padding:0px;">
                                                            <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                            <input type="hidden" name="kecamatan_id" value="<?= $kecamatan->kecamatan_id; ?>" />
                                                        </form>
                                                    </td>
                                                    <td><?= $kecamatan->kota_name; ?></td>
                                                    <td><?= $kecamatan->kecamatan_code; ?></td>
                                                    <td><?= $kecamatan->kecamatan_name; ?></td>
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