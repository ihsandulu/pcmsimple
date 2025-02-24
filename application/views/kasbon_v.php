<!doctype html>
<html>

<head>
    <?php
    require_once("meta.php");
    $dari = date("Y-m-d");
    $ke = date("Y-m-d");
    if (isset($_REQUEST["dari"])) {
        $dari = $_REQUEST["dari"];
        $ke = $_REQUEST["ke"];
    }
    ?>
    <style>
        .ket {
            margin-top: 20px;
        }

        .judket {
            color: #AE5700;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            padding: 5px;
            padding-top: 15px;
            border-top: #FFF solid 3px;
            border-bottom: #FFC891 dashed 1px;
        }

        .isiket {
            color: #753A00;
        }
    </style>
    <style>
        .toggle-container {
            display: flex;
            align-items: left;
            justify-content: left;
            margin-top: 20px;
        }

        .toggle-switch {
            position: relative;
            width: 80px;
            height: 34px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #007bff;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #28a745;
        }

        input:checked+.slider:before {
            transform: translateX(46px);
        }

        .toggle-label {
            font-size: 1.2rem;
            font-weight: bold;
            margin: 0 10px;
        }
    </style>

</head>

<body class="  ">
    <?php require_once("header.php"); ?>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#"><svg class="glyph stroked home">
                            <use xlink:href="#stroked-home"></use>
                        </svg></a></li>
                <li class="active">kasbon Kasbon</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-md-10">
                <h1 class="page-header"> Kasbon</h1>
            </div>
            <?php if (!isset($_POST['new']) && !isset($_POST['edit']) && !isset($_GET['report'])) { ?>
                <form method="POST" class="col-md-2">
                    <h1 class="page-header col-md-12">
                        <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                    </h1>
                    <input type="hidden" name="kasbon_id" />
                </form>
            <?php } ?>
            <?php if (isset($_GET['report'])) { ?>
                <form target="_blank" action="<?= site_url("kasbonprint"); ?>" method="get" class="col-md-2">
                    <h1 class="page-header col-md-12">
                        <button name="new" class="btn btn-warning btn-block btn-lg fa fa-print" value="OK" style=""> Print</button>
                        <input type="hidden" name="dari" value="<?= $this->input->get("dari"); ?>" />
                        <input type="hidden" name="ke" value="<?= $this->input->get("ke"); ?>" />
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
                                    $judul = "Update Kasbon";
                                } else {
                                    $namabutton = 'name="create"';
                                    $judul = "Create Kasbon";
                                } ?>
                                <div class="lead">
                                    <h3><?= $judul; ?></h3>
                                </div>
                                <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="kasbon_pengirim">Date:</label>
                                        <div class="col-sm-10">
                                            <?php if ($kasbon_date == "") {
                                                $kasbon_date = date("Y-m-d");
                                            } else {
                                                $kasbon_date = $kasbon_date;
                                            } ?>
                                            <input class="form-control date" type="text" name="kasbon_date" id="kasbon_date" value="<?= $kasbon_date; ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="user_id">User:</label>
                                        <div class="col-sm-10">
                                            <select class="select2 form-control" name="user_id" id="user_id">
                                                <option value="" <?= ($user_id == "") ? "selected" : ""; ?>>--Select User--</option>
                                                <?php $user = $this->db->join("position", "position.position_id=user.position_id", "left")->order_by("user_name")->get("user");
                                                foreach ($user->result() as $user) { ?>
                                                    <option value="<?= $user->user_id; ?>" <?= ($user_id == $user->user_id) ? "selected" : ""; ?>><?= $user->user_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <script>
                                                $("#user_id").change(function() {
                                                    let username = $("#user_id option:selected").text();
                                                    // alert(username);
                                                    $("#kasbon_remarks").val("Kasbon for " + username);
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="kasbon_amount">Amount:</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="number" name="kasbon_amount" id="kasbon_amount" value="<?= $kasbon_amount; ?>" />
                                        </div>
                                    </div>

                                    <div class="container text-center form-group">
                                        <label class="control-label col-sm-2" for="kasbon_amount">From:</label>
                                        <div class="toggle-container col-sm-10">
                                            <label class="toggle-switch">
                                                <input type="checkbox" id="kasbon_cash" name="kasbon_cash" value="<?= $kasbon_cash; ?>">
                                                <span class="slider"></span>
                                            </label>
                                            <span class="toggle-label" id="cashLabel">Petty Cash</span>
                                        </div>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            <?php $checked = ($kasbon_cash == "kas_id") ? "true" : "false"; ?>
                                            <?php $tchecked = ($kasbon_cash == "kas_id") ? "Big Cash" : "Petty Cash"; ?>
                                            $("#kasbon_cash").prop('checked', <?= $checked; ?>);
                                            $('#cashLabel').text('<?= $tchecked; ?>');
                                            $('#kasbon_cash').change(function() {
                                                if ($(this).prop('checked')) {
                                                    $('#cashLabel').text('Big Cash');
                                                    $('#kasbon_cash').val('kas_id');
                                                } else {
                                                    $('#cashLabel').text('Petty Cash');
                                                    $('#kasbon_cash').val('petty_id');
                                                }
                                            });
                                        });
                                    </script>
                                    <input type="hidden" name="petty_id" id="petty_id" value="<?= $petty_id; ?>">
                                    <input type="hidden" name="kas_id" id="kas_id" value="<?= $kas_id; ?>">

                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="kasbon_remarks">Remarks:</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="kasbon_remarks" id="kasbon_remarks"><?= $kasbon_remarks; ?></textarea>
                                            <script>
                                                CKEDITOR.replace('kasbon_remarks');
                                            </script>
                                        </div>
                                    </div>

                                    <input class="form-control" type="hidden" name="kasbon_id" id="kasbon_id" value="<?= $kasbon_id; ?>" />
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                            <button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("kasbon"); ?>">Back</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php } else { ?>
                            <?php if ($message != "") { ?>
                                <div class="alert alert-info alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong><?= $message; ?></strong><br /><?= $uploadkasbon_picture; ?>
                                </div>
                            <?php } ?>
                            <div class="box">
                                <div style="margin-bottom:30px; border-radius:5px; background-color:#FEEFC2; padding:15px;">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label for="email">From:</label>
                                            <input type="text" class="form-control date" name="dari" value="<?= $dari; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="pwd">To:</label>
                                            <input type="text" class="form-control date" name="ke" value="<?= $ke; ?>">
                                        </div>
                                        <?php if (isset($_GET['report'])) { ?>
                                            <input type="hidden" name="report" value="ok">
                                        <?php } ?>
                                        <button style="margin-right:30px;" type="submit" class="btn btn-default">Search</button>
                                    </form>
                                    <div style="clear:both;"></div>

                                </div>

                                <div id="collapse4" class="body table-reskasbonnsive">
                                    <table id="dataTablee" class="table table-condensed table-hover">
                                        <thead>
                                            <tr>

                                                <th class="col-md-1">Action</th>
                                                <th style="text-align:left;">Date</th>
                                                <th style="text-align:left;">User</th>
                                                <th style="text-align:right;">Nominal</th>
                                                <th style="text-align:right;">Remarks</th>
                                                <th style="text-align:center;">Kas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($_GET['dari'])) {
                                                $this->db->where("kasbon_date >=", $this->input->get("dari"));
                                            } else {
                                                $this->db->where("kasbon_date >=", date("Y-m-d"));
                                            }

                                            if (isset($_GET['ke'])) {
                                                $this->db->where("kasbon_date <=", $this->input->get("ke"));
                                            } else {
                                                $this->db->where("kasbon_date <=", date("Y-m-d"));
                                            }
                                            $usr = $this->db
                                                ->join("user", "user.user_id=kasbon.user_id", "left")
                                                ->join("position", "position.position_id=user.position_id", "left")
                                                ->order_by("kasbon.kasbon_id desc, user.user_name asc")
                                                ->get("kasbon");
                                            $no = 1;
                                            //echo $this->db->last_query();
                                            foreach ($usr->result() as $kasbon) {
                                                if ($kasbon->kas_id > 0) {
                                                    $kas = "Big Cash";
                                                } else {
                                                    $kas = "Petty Cash";
                                                }
                                            ?>
                                                <tr>
                                                    <td>
                                                        <form method="post" class="col-md-6" style="padding:0px;">
                                                            <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                            <input type="hidden" name="kasbon_id" value="<?= $kasbon->kasbon_id; ?>" />
                                                        </form>

                                                        <form method="post" class="col-md-6" style="padding:0px;">
                                                            <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                            <input type="hidden" name="kasbon_id" value="<?= $kasbon->kasbon_id; ?>" />
                                                            <input type="hidden" name="kas_id" value="<?= $kasbon->kas_id; ?>" />
                                                            <input type="hidden" name="petty_id" value="<?= $kasbon->petty_id; ?>" />
                                                        </form>
                                                    </td>
                                                    <td><?= $kasbon->kasbon_date; ?></td>
                                                    <td style="text-align:left;"><?= $kasbon->user_name; ?> (<?= $kasbon->position_name; ?>)</td>
                                                    <td style="text-align:left;"><?= number_format($kasbon->kasbon_amount, 0, ",", "."); ?></td>
                                                    <td style="text-align:left;"><?= $kasbon->kasbon_remarks; ?></td>
                                                    <td style="text-align:left;"><?= $kas; ?></td>
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
        <script>
            $(document).ready(function() {
                $("#dataTablee").DataTable({
                    dom: 'Bfrtip', // Menampilkan tombol
                    buttons: [{
                        extend: 'print',
                        text: 'Print',
                        className: 'btn btn-warning text-white',
                        exportOptions: {
                            columns: ':not(:first-child)' 
                        }
                    }]
                });
            });
        </script>

</body>

</html>