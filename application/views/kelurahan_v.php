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
                <li class="active">Kelurahan</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-md-10">
                <h1 class="page-header"> Kelurahan</h1>
            </div>
            <?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>
                <form method="post" class="col-md-2">
                    <h1 class="page-header col-md-12">
                        <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                        <input type="hidden" name="kelurahan_id" />
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
                                    $judul = "Update Kelurahan";
                                } else {
                                    $namabutton = 'name="create"';
                                    $judul = "New Kelurahan";
                                } ?>
                                <div class="lead">
                                    <h3><?= $judul; ?></h3>
                                </div>
                                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="kecamatan_id">Kecamatan:</label>
                                        <div class="col-sm-10">
                                            <select class="form-control select2" id="kecamatan_id" name="kecamatan_id">
                                                <option value="" <?= ($kecamatan_id == "") ? "selected" : ""; ?>>Pilih Kecamatan</option>
                                                <?php $kecamatan = $this->db->order_by("kecamatan_name", "ASC")->get("kecamatan");
                                                foreach ($kecamatan->result() as $kecamatan) { ?>
                                                    <option value="<?= $kecamatan->kecamatan_id; ?>" <?=($kecamatan_id == $kecamatan->kecamatan_id) ? "selected" : ""; ?>><?= $kecamatan->kecamatan_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="kelurahan_name">Nama Kelurahan:</label>
                                        <div class="col-sm-10">
                                            <input type="text" autofocus class="form-control" id="kelurahan_name" name="kelurahan_name" placeholder="Enter kelurahan" value="<?= $kelurahan_name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="kelurahan_code">Kode Kelurahan:</label>
                                        <div class="col-sm-10">
                                            <input type="text" autofocus class="form-control" id="kelurahan_code" name="kelurahan_code" placeholder="Enter kelurahan" value="<?= $kelurahan_code; ?>">
                                        </div>
                                    </div>
                                    <input type="hidden" name="kelurahan_id" value="<?= $kelurahan_id; ?>" />
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                            <button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("kelurahan"); ?>">Back</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php } else { ?>
                            <?php if ($message != "") { ?>
                                <div class="alert alert-info alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong><?= $message; ?></strong><br /><?= $uploadkelurahan_picture; ?>
                                </div>
                            <?php } ?>
                            <?php 
                            if(isset($_GET["kota_id"])){
                                $kota_id=$_GET["kota_id"];
                            }else{
                                $kota_id="";
                            }
                            if(isset($_GET["kecamatan_id"])){
                                $kecamatan_id=$_GET["kecamatan_id"];
                            }else{
                                $kecamatan_id="";
                            }
                            ?>
                            <div class="box">
                                <form class="form-inline" action="">
                                    <div class="form-group">
                                        <label for="kota">Kota:</label>
                                        <select onchange="pilihkecamatan();" class="form-control select2" id="kota_id" name="kota_id">
                                            <option value="" <?=($kota_id=="")?"selected":"";?>>Pilih Kota</option>
                                            <?php                                            
                                            if(isset($_GET["kota_id"])){$kota_id=$this->input->get("kota_id");}else{$kota_id=0;}
                                            $kota = $this->db->order_by("kota_name", "ASC")->get("kota");
                                            foreach ($kota->result() as $kota) { ?>
                                                <option value="<?= $kota->kota_id; ?>" <?=($kota_id==$kota->kota_id)?"selected" : ""; ?>><?= $kota->kota_name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <script>
                                            function pilihkecamatan() {
                                                let kota_id = $("#kota_id").val();
                                                // alert("<?= base_url("api/pilihkecamatan"); ?>?kota_id="+kota_id+"&kecamatan_id=0");
                                                $.get("<?= base_url("api/pilihkecamatan"); ?>", {
                                                        kota_id: kota_id,
                                                        kecamatan_id:'0'
                                                    })
                                                    .done(function(data) {
                                                        $("#kecamatan_id").html(data);
                                                    });
                                            }
                                        </script>
                                    </div>
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan:</label>
                                        <select class="form-control select2" id="kecamatan_id" name="kecamatan_id">
                                            <option value="" <?= ($kecamatan_id == "") ? "selected" : ""; ?>>Pilih Kecamatan</option>
                                            <?php 
                                            $kecamatan = $this->db->order_by("kecamatan_name", "ASC")
                                            ->where("kota_id",$kota_id)
                                            ->get("kecamatan");
                                            foreach ($kecamatan->result() as $kecamatan) { ?>
                                                <option value="<?= $kecamatan->kecamatan_id; ?>" <?=($kecamatan_id == $kecamatan->kecamatan_id) ? "selected" : ""; ?>><?= $kecamatan->kecamatan_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-default">Submit</button>
                                </form>
                                <div id="collapse4" class="body table-responsive">
                                    <table id="dataTable" class="table table-condensed table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1">Action</th>
                                                <th>Kecamatan</th>
                                                <th>Code</th>
                                                <th>Kelurahan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php                                             
                                            if(isset($_GET["kecamatan_id"])){$kecamatan_id=$this->input->get("kecamatan_id");}else{$kecamatan_id=0;}
                                            $usr = $this->db
                                                ->join("kecamatan", "kecamatan.kecamatan_id=kelurahan.kecamatan_id", "left")
                                                ->where("kelurahan.kecamatan_id",$kecamatan_id)
                                                ->order_by("kelurahan.kelurahan_id", "desc")
                                                ->get("kelurahan");
                                                // echo $this->db->last_query();
                                            $no = 1;
                                            foreach ($usr->result() as $kelurahan) { ?>
                                                <tr>
                                                    <td style="padding-left:0px; padding-right:0px;">
                                                        <form method="post" class="col-md-6" style="padding:0px;">
                                                            <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                            <input type="hidden" name="kelurahan_id" value="<?= $kelurahan->kelurahan_id; ?>" />
                                                        </form>

                                                        <form method="post" class="col-md-6" style="padding:0px;">
                                                            <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                            <input type="hidden" name="kelurahan_id" value="<?= $kelurahan->kelurahan_id; ?>" />
                                                        </form>
                                                    </td>
                                                    <td><?= $kelurahan->kecamatan_name; ?></td>
                                                    <td><?= $kelurahan->kelurahan_code; ?></td>
                                                    <td><?= $kelurahan->kelurahan_name; ?></td>
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