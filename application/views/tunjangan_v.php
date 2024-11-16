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
                <li class="active">Upah</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-md-8">
                <h1 class="page-header"> Upah <?= $this->input->get("user_name"); ?></h1>
            </div>
            <?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>
                <form method="post" class="col-md-4">
                    <h1 class="page-header col-md-12">
                        <button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
                        <button type="button" onclick="
    if (window.opener) {
        window.opener.location.reload(); 
        setTimeout(() => window.close(), 500); // Tunggu 500 ms sebelum menutup
    } else {
        alert('Tidak dapat menemukan halaman opener.');
    }
" class="btn btn-warning btn-lg" style="float:right; margin:2px;">
                            Back
                        </button>
                        <input type="hidden" name="tunjangan_id" value="0" />
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
                                <?php
                                if (isset($_POST['edit'])) {
                                    $namabutton = 'name="change"';
                                    $judul = "Update Allowance";
                                } else {
                                    $namabutton = 'name="create"';
                                    $judul = "New Allowance";
                                } ?>
                                <div class="lead">
                                    <h3><?= $judul; ?></h3>
                                </div>
                                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="tunjangan_name">Nama Upah:</label>
                                        <div class="col-sm-10">
                                            <input type="text" autofocus class="form-control" id="tunjangan_name" name="tunjangan_name" placeholder="Enter Name" value="<?= $tunjangan_name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="tunjangan_type">Tipe:</label>
                                        <div class="col-sm-10">
                                            <select onchange="pilihtipe();" class="form-control" id="tunjangan_type" name="tunjangan_type">
                                                <option value="" <?= ($tunjangan_type == "") ? "selected" : ""; ?>>Pilih Type</option>
                                                <option value="project" <?= ($tunjangan_type == "project") ? "selected" : ""; ?>>Project</option>
                                                <option value="harian" <?= ($tunjangan_type == "harian") ? "selected" : ""; ?>>Harian</option>
                                                <option value="bulanan" <?= ($tunjangan_type == "bulanan") ? "selected" : ""; ?>>Bulanan</option>
                                                <option value="bonusomzet" <?= ($tunjangan_type == "bonusomzet") ? "selected" : ""; ?>>Bonus Omzet</option>
                                            </select>
                                            <script>
                                                function pilihtipe() {
                                                    let tipetunjangan = $("#tunjangan_type").val();
                                                    if (tipetunjangan == "bonusomzet") {
                                                        $(".omzet").show();
                                                        $(".persen").show();
                                                    }else if (tipetunjangan == "project") {
                                                        $(".omzet").hide();
                                                        $(".persen").show();
                                                    } else {
                                                        $(".omzet").hide();
                                                        $(".persen").hide();
                                                    }
                                                }
                                                $(document).ready(function() {
                                                    pilihtipe();
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="form-group omzet">
                                        <label class="control-label col-sm-2" for="tunjangan_operator">Operator Aritmetik:</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="tunjangan_operator" name="tunjangan_operator">
                                                <option value="" <?= ($tunjangan_operator == "") ? "selected" : ""; ?>>Pilih Operator</option>
                                                <option value="=" <?= ($tunjangan_operator == "=") ? "selected" : ""; ?>> = </option>
                                                <option value="<" <?= ($tunjangan_operator == "<") ? "selected" : ""; ?>>
                                                    < </option>
                                                <option value="<=" <?= ($tunjangan_operator == "<=") ? "selected" : ""; ?>>
                                                    <= </option>
                                                <option value=">" <?= ($tunjangan_operator == ">") ? "selected" : ""; ?>> > </option>
                                                <option value=">=" <?= ($tunjangan_operator == ">=") ? "selected" : ""; ?>> >= </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group omzet">
                                        <label class="control-label col-sm-2" for="tunjangan_omzet">Omzet:</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="tunjangan_omzet" name="tunjangan_omzet" placeholder="Enter Omzet" value="<?= $tunjangan_omzet; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group omzet">
                                        <label class="control-label col-sm-2" for="tunjangan_omzetakhir">s/d Omzet:<br />(optional)</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="tunjangan_omzetakhir" name="tunjangan_omzetakhir" placeholder="Enter Omzet" value="<?= $tunjangan_omzetakhir; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="tunjangan_nominal">Nominal:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="tunjangan_nominal" name="tunjangan_nominal" placeholder="Enter Nominal" value="<?= $tunjangan_nominal; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group persen">
                                        <label class="control-label col-sm-2" for="tunjangan_persen">Persentase:</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="tunjangan_persen" name="tunjangan_persen">
                                                <option value="0" <?= ($tunjangan_persen == "0") ? "selected" : "0"; ?>>Tidak</option>
                                                <option value="1" <?= ($tunjangan_persen == "1") ? "selected" : "1"; ?>>Ya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="user_id" value="<?= $this->input->get("user_id"); ?>" />
                                    <input type="hidden" name="tunjangan_id" value="<?= $tunjangan_id; ?>" />
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                            <button type="button" class="btn btn-warning col-md-offset-1 col-md-5" onClick="window.location.href='<?= site_url("tunjangan"); ?>'">Back</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php } else { ?>
                            <?php if ($message != "") { ?>
                                <div class="alert alert-info alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong><?= $message; ?></strong><br /><?= $uploadtunjangan_picture; ?>
                                </div>
                            <?php } ?>
                            <div class="box">
                                <div id="collapse4" class="body table-responsive"><?= $identity->identity_dimension; ?>
                                    <table id="dataTable" class="table table-condensed table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-md-2">Action</th>
                                                <th>No.</th>
                                                <th>Nama Upah</th>
                                                <th>Tipe</th>
                                                <th>Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $usr = $this->db
                                                ->where("user_id", $this->input->get("user_id"))
                                                ->order_by("tunjangan_name", "desc")
                                                ->get("tunjangan");
                                            $no = 1;
                                            foreach ($usr->result() as $tunjangan) { ?>
                                                <tr>
                                                    <td style="padding-left:0px; padding-right:0px;">
                                                        <form method="post" class="col-md-3" style="padding:0px;">
                                                            <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                            <input type="hidden" name="tunjangan_id" value="<?= $tunjangan->tunjangan_id; ?>" />
                                                        </form>

                                                        <form method="post" class="col-md-3" style="padding:0px;">
                                                            <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                            <input type="hidden" name="tunjangan_id" value="<?= $tunjangan->tunjangan_id; ?>" />
                                                        </form>
                                                    </td>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $tunjangan->tunjangan_name; ?></td>
                                                    <td><?= ucfirst($tunjangan->tunjangan_type); ?></td>
                                                    <td><?php
                                                        if ($tunjangan->tunjangan_type == "bonusomzet") {
                                                            $text = "Omzet ".$tunjangan->tunjangan_operator." Rp." . number_format($tunjangan->tunjangan_omzet, 0, ",", ".");
                                                            if ($tunjangan->tunjangan_omzetakhir > 0) {
                                                                $text .= " s/d Rp." . number_format($tunjangan->tunjangan_omzetakhir, 0, ",", ".");
                                                            }
                                                            $text .= ", Bonus " . $tunjangan->tunjangan_nominal;
                                                            if ($tunjangan->tunjangan_persen == 1) {
                                                                $text .= " % dari Omzet";
                                                            }
                                                        }else  if ($tunjangan->tunjangan_type == "project") {
                                                            if ($tunjangan->tunjangan_persen == 1) {
                                                                $text = number_format($tunjangan->tunjangan_nominal, 0, ",", ".")." % dari Project";
                                                            }else{
                                                                $text = number_format($tunjangan->tunjangan_nominal, 0, ",", ".");
                                                            }
                                                        } else {
                                                            $text = number_format($tunjangan->tunjangan_nominal, 0, ",", ".");
                                                        }
                                                        echo $text;
                                                        ?>
                                                    </td>
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