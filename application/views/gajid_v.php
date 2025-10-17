<!doctype html>
<html>

<head>
    <?php
    require_once("meta.php");
    $month = date("n");
    if (isset($_REQUEST["month"])) {
        $month = $_REQUEST["month"];
    }

    //bulan		
    $bulan_array = array(0 => "Bulan", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    ?>
</head>

<body class="  ">
    <?php require_once("header.php"); ?>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#"><svg class="glyph stroked home">
                            <use xlink:href="#stroked-home"></use>
                        </svg></a></li>
                <li class="active">Payroll Detail</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-md-8">
                <h1 class="page-header">Payroll Detail</h1>
            </div>
            <?php if (!isset($_POST['new']) && !isset($_POST['edit']) && !isset($_GET['report'])) { ?>
                <form method="post" class="col-md-4">
                    <h1 class="page-header col-md-12">
                        <button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
                        <button type="button" onclick="tutup();" class="btn btn-warning btn-lg" style="float:right; margin:2px;">
                            Back
                        </button>
                        <input type="hidden" name="gajid_id" />
                    </h1>
                </form>
            <?php } ?>
        </div><!--/.row-->


        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php if (isset($_POST['new']) || isset($_POST['edit']) && !isset($_GET['report'])) { ?>
                            <div class="">
                                <?php if (isset($_POST['edit'])) {
                                    $namabutton = 'name="change"';
                                    $judul = "Update Payroll Detail";
                                } else {
                                    $namabutton = 'name="create"';
                                    $judul = "New Payroll Detail";
                                } ?>
                                <div class="lead">
                                    <h3><?= $judul; ?></h3>
                                </div>
                                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="gajid_name">Nama:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="gajid_name" value="<?= $gajid_name; ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="gajid_nominal">Nominal:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="gajid_nominal" value="<?= $gajid_nominal; ?>" />
                                            <input type="hidden" class="form-control" name="gajidnominal" value="<?= $gajid_nominal; ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="gajid_type">Type:</label>
                                        <div class="col-sm-10">
                                            <select type="text" autofocus class="form-control" id="gajid_type" name="gajid_type">
                                                <option value="0" <?= ($gajid_type == "0") ? "selected" : ""; ?>>Upah</option>
                                                <option value="1" <?= ($gajid_type == "1") ? "selected" : ""; ?>>Biaya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="gajid_hari">Hari Masuk:</label>
                                        <div class="col-sm-10">
                                            <input type="number" min="0" class="form-control" name="gajid_hari" value="<?= $gajid_hari; ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="gajid_basic">Basic Salary:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="gajid_basic" value="<?= $gajid_basic; ?>" />
                                        </div>
                                    </div>



                                    <input type="hidden" name="gajid_id" value="<?= $gajid_id; ?>" />
                                    <input type="hidden" name="gaji_id" value="<?= $this->input->get("gaji_id"); ?>" />
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                            <button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("gajid"); ?>">Back</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php } else { ?>
                            <?php if ($message != "") { ?>
                                <div class="alert alert-info alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong><?= $message; ?></strong><br /><?= $uploadgajid_picture; ?>
                                </div>
                            <?php } ?>
                            <div class="box">
                                <div style="margin-bottom:30px; border-radius:5px; background-color:#FEEFC2; padding:15px;">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label for="email">From:</label>
                                            <select name="month" class="form-control">
                                                <?php for ($x = 1; $x <= 12; $x++) { ?>
                                                    <option value="<?= $x; ?>" <?= ($month == $x) ? "selected" : ""; ?>><?= $bulan_array[$x]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <?php if (isset($_GET['report'])) { ?>
                                            <input type="hidden" name="report" value="ok">
                                        <?php } ?>
                                        <button style="margin-right:30px;" type="submit" class="btn btn-default">Search</button>
                                        <?php if (isset($_GET['report'])) { ?>
                                            <a target="_blank" href="<?= site_url("gajid_list_print?report=ok&month=" . $month); ?>" class="btn btn-success fa fa-print"></a> <?php } ?>
                                    </form>

                                </div>
                                <div id="collapse4" class="body table-responsive">
                                    <table id="dataTable" class="table table-condensed table-hover">
                                        <thead>
                                            <tr>
                                                <?php if (!isset($_GET['report'])) { ?>
                                                    <th class="col-md-2">Action</th>
                                                <?php } ?>
                                                <th>No.</th>
                                                <th>Name</th>
                                                <th>Nominal</th>
                                                <th>Type</th>
                                                <th>Days</th>
                                                <th>Basic Salary</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $usr = $this->db
                                                ->where("gaji_id", $this->input->get("gaji_id"))
                                                ->order_by("gajid_id", "desc")
                                                ->get("gajid");
                                            // echo $this->db->last_query();
                                            $no = 1;
                                            foreach ($usr->result() as $gajid) {
                                                $type = array("Upah", "Biaya");
                                            ?>
                                                <tr>
                                                    <?php if (!isset($_GET['report'])) { ?>
                                                        <td style="padding-left:0px; padding-right:0px;">
                                                            <form method="post" class="col-md-3" style="padding:0px;">
                                                                <button class="btn  btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                                <input type="hidden" name="gajid_id" value="<?= $gajid->gajid_id; ?>" />
                                                                <input type="hidden" name="gajid_nominal" value="<?= $gajid->gajid_nominal; ?>" />
                                                            </form>

                                                            <form method="post" class="col-md-3" style="padding:0px;" onsubmit="return confirmDelete()">
                                                                <button class="btn  btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                                <input type="hidden" name="gajid_id" value="<?= $gajid->gajid_id; ?>" />
                                                            </form>

                                                            <script>
                                                                function confirmDelete() {
                                                                    return confirm("Apakah Anda yakin ingin menghapus data ini?");
                                                                }
                                                            </script>
                                                        </td>
                                                    <?php } ?>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $gajid->gajid_name; ?></td>
                                                    <td>
                                                        Nominal : <?= number_format($gajid->gajid_nominal, 0, ",", "."); ?>
                                                        <?php
                                                        if ($gajid->gajid_omzet > 0) { ?>
                                                            <br />Omzet : <?= number_format($gajid->gajid_omzet, 0, ",", "."); ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?= $type[$gajid->gajid_type]; ?></td>
                                                    <td><?= $gajid->gajid_hari; ?></td>
                                                    <td><?= number_format($gajid->gajid_basic, 0, ",", "."); ?></td>
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
    </div>
    <!-- /#wrap -->
    <?php require_once("footer.php"); ?>
</body>

</html>