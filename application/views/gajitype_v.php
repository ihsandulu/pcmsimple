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
                <li class="active">Salary Type</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-md-10">
                <h1 class="page-header"> Salary Type</h1>
            </div>
            <?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>
                <form method="post" class="col-md-2">
                    <h1 class="page-header col-md-12">
                        <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                        <input type="hidden" name="gajitype_id" />
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
                                    $judul = "Update Salary Type";
                                } else {
                                    $namabutton = 'name="create"';
                                    $judul = "New Salary Type";
                                } ?>
                                <div class="lead">
                                    <h3><?= $judul; ?></h3>
                                </div>
                                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="gajitype_name">Salary Type Name:</label>
                                        <div class="col-sm-10">
                                            <input type="text" autofocus class="form-control" id="gajitype_name" name="gajitype_name" placeholder="Enter Salary Type" value="<?= $gajitype_name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="gajitype_description">Description:</label>
                                        <div class="col-sm-10">
                                            <select onchange="pilihtype();" class="form-control" id="gajitype_description" name="gajitype_description">
                                                <option value="Month" <?=($gajitype_description=="Month")?"selected":"";?>>Month</option>
                                                <option value="Period" <?=($gajitype_description=="Period")?"selected":"";?>>Period</option>
                                            </select>
                                            <script>
                                                function pilihtype(){
                                                    let gajitype_description = $("#gajitype_description").val();
                                                    if(gajitype_description=="Period"){
                                                        $(".period").show();
                                                    }else{
                                                        $(".period").hide();
                                                        $(".periode").val("");
                                                    }
                                                }
                                                $(document).ready(function(){
                                                    pilihtype();
                                                });
                                                
                                            </script>
                                        </div>
                                    </div>
                                    <div class="form-group period">
                                        <label class="control-label col-sm-2" for="gajitype_awaldate">Start:</label>
                                        <div class="col-sm-10">
                                            <input type="number" min="1" max="31" class="form-control periode" id="gajitype_awaldate" name="gajitype_awaldate" placeholder="Enter Start Date" value="<?= $gajitype_awaldate; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group period">
                                        <label class="control-label col-sm-2" for="gajitype_akhirdate">End:</label>
                                        <div class="col-sm-10">
                                            <input type="number" min="1" max="31" class="form-control periode" id="gajitype_akhirdate" name="gajitype_akhirdate" placeholder="Enter End Date" value="<?= $gajitype_akhirdate; ?>">
                                        </div>
                                    </div>
                                    <input type="hidden" name="gajitype_id" value="<?= $gajitype_id; ?>" />
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                            <button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("gajitype"); ?>">Back</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php } else { ?>
                            <?php if ($message != "") { ?>
                                <div class="alert alert-info alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong><?= $message; ?></strong><br /><?= $uploadgajitype_picture; ?>
                                </div>
                            <?php } ?>
                            <div class="box">
                                <div id="collapse4" class="body table-responsive">
                                    <table id="dataTable" class="table table-condensed table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1">Action</th>
                                                <th>Type</th>
                                                <th>Description</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $usr = $this->db
                                                ->order_by("gajitype_id", "desc")
                                                ->get("gajitype");
                                            $no = 1;
                                            foreach ($usr->result() as $gajitype) { ?>
                                                <tr>
                                                    <td style="padding-left:0px; padding-right:0px;">
                                                        <form method="post" class="col-md-6" style="padding:0px;">
                                                            <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                            <input type="hidden" name="gajitype_id" value="<?= $gajitype->gajitype_id; ?>" />
                                                        </form>

                                                        <form method="post" class="col-md-6" style="padding:0px;">
                                                            <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                            <input type="hidden" name="gajitype_id" value="<?= $gajitype->gajitype_id; ?>" />
                                                        </form>
                                                    </td>
                                                    <td><?= $gajitype->gajitype_name; ?></td>
                                                    <td><?= $gajitype->gajitype_description; ?></td>
                                                    <td><?= $gajitype->gajitype_awaldate; ?></td>
                                                    <td><?= $gajitype->gajitype_akhirdate; ?></td>
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