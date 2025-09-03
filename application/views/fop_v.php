<!doctype html>
<html>

<head>
    <?php
    require_once("meta.php");


    if (isset($_REQUEST["awal"])) {
        $dari = "";
        $ke = "";
    } elseif (isset($_REQUEST["dari"])) {
        $dari = $_REQUEST["dari"];
        $ke = $_REQUEST["ke"];
    } else {
        $dari = date("Y-m-d");
        $ke = date("Y-m-d");
    }
    if (isset($_REQUEST["project"])) {
        $project = $_REQUEST["project"];
    } else {
        $project = "";
    }
    if (isset($_REQUEST["bulan"])) {
        $bulan = $_REQUEST["bulan"];
    } else {
        $bulan = "3";
    }
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
                <li class="active">Followup Customer</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-md-10">
                <h1 class="page-header"> Followup Customer</h1>
            </div>
            
        </div><!--/.row-->


        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">                       
                        <?php
                        if (isset($_POST['new']) || isset($_POST['edit'])) {
                        ?>
                            <div class="">
                                <?php if (isset($_POST['edit'])) {
                                    $namabutton = 'name="change"';
                                    $judul = "Update Invoice";
                                } else {
                                    $namabutton = 'name="create"';
                                    $judul = "Create Invoice";
                                } ?>
                                <div class="lead">
                                    <h3><?= $judul; ?></h3>
                                </div>
                                <form id="formupdate" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                    <?php if ($inv_no != "") { ?>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="inv_no">Invoice No.:</label>
                                            <div class="col-sm-10" align="left">
                                                <input type="text" id="inv_no" name="inv_no" class="form-control" value="<?= $inv_no; ?>">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if ($identity->identity_project == 1) { ?>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="inv_showproduct">Show product from :</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="inv_showproduct" id="inv_showproduct">
                                                    <option value="0" <?= ($inv_showproduct == "0") ? "selected" : ""; ?>>Pilih product yg akan ditampilkan</option>
                                                    <option value="1" <?= ($inv_showproduct == "1") ? "selected" : (($inv_showproduct == "0" && $identity->identity_showproduct == "1") ? "selected" : ""); ?>>From Master Product</option>
                                                    <option value="2" <?= ($inv_showproduct == "2") ? "selected" : (($inv_showproduct == "0" && $identity->identity_showproduct == "2") ? "selected" : ""); ?>>From Project</option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="inv_date">Date:</label>
                                        <div class="col-sm-10" align="left">
                                            <input type="text" name="inv_date" class="date form-control" value="<?= ($inv_date != "" && $inv_date != "0000-00-00") ? $inv_date : date("Y-m-d"); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="inv_duedate">Due Date:</label>
                                        <div class="col-sm-10" align="left">
                                            <input type="text" name="inv_duedate" class="date form-control" value="<?= ($inv_duedate != "" && $inv_duedate != "0000-00-00") ? $inv_duedate : date("Y-m-d"); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="inv_status">Status:</label>
                                        <div class="col-sm-10">
                                            <select id="inv_status" name="inv_status" class="form-control">
                                                <option value="0" <?= ($inv_status == "0") ? "selected" : ""; ?>>Jadi</option>
                                                <option value="1" <?= ($inv_status == "1") ? "selected" : ""; ?>>Tunda</option>
                                                <option value="2" <?= ($inv_status == "2") ? "selected" : ""; ?>>Batal</option>
                                            </select>
                                        </div>
                                    </div>

                                    <?php
                                    $identity_project = $this->db->get("identity")->row()->identity_project;
                                    if ($identity_project != 1) { ?>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="customer_id">Customer:<br /><a target="_blank" href="<?= base_url("customer"); ?>" class="btn btn-warning">New Customer</a></label>
                                            <div class="col-sm-10">
                                                <datalist id="customer">
                                                    <?php $uni = $this->db
                                                        ->get("customer");
                                                    foreach ($uni->result() as $customer) { ?>
                                                        <option id="<?= $customer->customer_id; ?>" value="<?= $customer->customer_name; ?>">
                                                        <?php } ?>
                                                </datalist>
                                                <input id="customerid" onClick="a(this)" onChange="a(this)" class="form-control" list="customer" value="<?= $customer_name; ?>" autocomplete="off">
                                                <input type="hidden" list="customer" id="customer_id1" name="customer_id" value="<?= $customer_id; ?>">

                                                <script>
                                                    function a(a) {
                                                        var opt = $('option[value="' + $(a).val() + '"]');
                                                        $("#customer_id1").val(opt.attr('id'));
                                                    }
                                                </script>

                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="inv_discount">Discount:</label>
                                        <div class="col-sm-10" align="left">
                                            <input type="number" name="inv_discount" class="form-control" value="<?= $inv_discount; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="inv_ppn">PPN:</label>
                                        <div class="col-sm-10" align="left">
                                            <?php if ($inv_ppn == 1) {
                                                $c = 'checked="checked"';
                                            } else {
                                                $c = '';
                                            } ?>
                                            <input type="checkbox" style="width:25px; height:25px;" name="inv_ppn" value="1" <?= $c; ?>>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="inv_payment">Payment:</label>
                                        <div class="col-sm-10" align="left">
                                            <textarea name="inv_payment" id="inv_payment"></textarea>
                                            <script>
                                                ClassicEditor
                                                    .create(document.querySelector('#inv_payment'))
                                                    .then(editor => {
                                                        editor.setData('<?= $inv_payment; ?>');
                                                        editor.ui.view.editable.element.style.height = '120px';
                                                    })
                                                    .catch(error => {
                                                        console.error(error);
                                                    });
                                            </script>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="inv_storekeeper">Storekeeper:</label>
                                        <div class="col-sm-10" align="left">
                                            <input type="text" name="inv_storekeeper" class="form-control" value="<?= $inv_storekeeper; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="inv_approved">Approved By:</label>
                                        <div class="col-sm-10" align="left">
                                            <input type="text" name="inv_approved" class="form-control" value="<?= $inv_approved; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="inv_receiver">Receiver:</label>
                                        <div class="col-sm-10" align="left">
                                            <input type="text" name="inv_receiver" class="form-control" value="<?= $inv_receiver; ?>">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="inv_note">Note:</label>
                                        <div class="col-sm-10" align="left">
                                            <textarea name="inv_note" id="inv_note"></textarea>
                                            <script>
                                                ClassicEditor
                                                    .create(document.querySelector('#inv_note'))
                                                    .then(editor => {
                                                        editor.setData('<?= $inv_note; ?>');
                                                        editor.ui.view.editable.element.style.height = '120px';
                                                    })
                                                    .catch(error => {
                                                        console.error(error);
                                                    });
                                            </script>
                                        </div>
                                    </div>



                                    <?php
                                    if ($identity->identity_simple == 1) {
                                    ?>

                                        <hr />

                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="unit_id">Payment:</label>
                                            <div class="col-sm-10">

                                                <select name="methodpayment_id" class="form-control">
                                                    <?php $met = $this->db->get("methodpayment");
                                                    foreach ($met->result() as $meth) { ?>
                                                        <option value="<?= $meth->methodpayment_id; ?>" <?= ($meth->methodpayment_id == $methodpayment_id) ? "selected" : ""; ?>>
                                                            <?= $meth->methodpayment_name; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <hr />

                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="sjkeluar_pengirim">Pengirim:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="sjkeluar_pengirim" id="sjkeluar_pengirim" value="<?= $sjkeluar_pengirim; ?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="sjkeluar_penerima">Penerima:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="sjkeluar_penerima" id="sjkeluar_penerima" value="<?= $sjkeluar_penerima; ?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="sjkeluar_ekspedisi">Ekspedisi/Kendaraan:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="sjkeluar_ekspedisi" id="sjkeluar_ekspedisi" value="<?= $sjkeluar_ekspedisi; ?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="sjkeluar_nopol">No. Pol:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="sjkeluar_nopol" id="sjkeluar_nopol" value="<?= $sjkeluar_nopol; ?>" />
                                            </div>
                                        </div>

                                    <?php } ?>

                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="inv_picture">Faktur:</label>
                                        <div class="col-sm-10" align="left">
                                            <input type="file" class="form-control" id="inv_picture" name="inv_picture"><br />
                                            <?php if ($inv_picture != "") {
                                                $user_image = "assets/images/inv_picture/" . $inv_picture;
                                            } else {
                                                $user_image = "assets/img/user.gif";
                                            } ?>
                                            <img id="inv_picture_image" width="100" height="100" src="<?= base_url($user_image); ?>" />
                                            <script>
                                                function readURL(input) {
                                                    if (input.files && input.files[0]) {
                                                        var reader = new FileReader();

                                                        reader.onload = function(e) {
                                                            $('#inv_picture_image').attr('src', e.target.result);
                                                        }

                                                        reader.readAsDataURL(input.files[0]);
                                                    }
                                                }

                                                $("#inv_picture").change(function() {
                                                    readURL(this);
                                                });
                                            </script>
                                        </div>
                                    </div>

                                    <input type="hidden" name="inv_no" value="<?= $this->input->post("inv_no"); ?>" />
                                    <input type="hidden" name="project_id" value="<?= ($project_id > 0) ? $project_id : "0"; ?>" />
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button <?php if ($identity->identity_simple == 1) { ?>type="button" onClick="updatesimpleinv()" <?php } else { ?> type="submit" <?php } ?> id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                            <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= site_url("inv"); ?>">Back</a>
                                        </div>
                                    </div>
                                </form>
                                <script>
                                    function updatesimpleinv() {
                                        $.get("<?= site_url("api/updatesimpleinv"); ?>", $('#formupdate').serialize())
                                            .done(function(data) {
                                                var customer_id = 0,
                                                    vendor_id = 0,
                                                    project_id = 0,
                                                    inv_no = '';
                                                $.each(data, function(a, b) { //alert(a+"="+b);
                                                    if (a == 'customer_id') {
                                                        customer_id = b;
                                                    }
                                                    if (a == 'vendor_id') {
                                                        vendor_id = b;
                                                    }
                                                    if (a == 'project_id') {
                                                        project_id = b;
                                                    }
                                                    if (a == 'inv_no') {
                                                        inv_no = b;
                                                    }
                                                });
                                                $('#formupdate').hide();
                                                //alert(customer_id+"/"+vendor_id+"/"+project_id+"/"+inv_no);
                                                $.get("<?= site_url("api/productsimpleinv"); ?>", {
                                                        customer_id: customer_id,
                                                        vendor_id: vendor_id,
                                                        project_id: project_id,
                                                        inv_no: inv_no
                                                    })
                                                    .done(function(data) {
                                                        $('#formproduct').html(data);
                                                        $('#formproduct').show();
                                                        tampilproduct(inv_no);
                                                        $('#listproduct').show();
                                                    });
                                            });
                                    }
                                </script>

                            </div>

                            <div id="formproduct" style="display:none;">

                            </div>
                            <div id="listproduct">

                            </div>
                            <div id="formpayment" style="display:none;">

                            </div>
                            <div id="listpayment">

                            </div>
                            <script>
                                function tampilproduct(inv_no) {
                                    $.get("<?= site_url("api/tampilproduct"); ?>", {
                                            inv_no: inv_no
                                        })
                                        .done(function(data) {
                                            $("#productid").val("");
                                            $("#invproduct_price").val("");
                                            $("#listproduct").html(data);
                                        });
                                }
                            </script>
                        <?php } else { ?>
                            <?php if ($message != "") {
                                $display = "display:block;";
                            } else {
                                $display = "display:none;";
                            } ?>
                            <div id="message" class="alert alert-info alert-dismissable" style="<?= $display; ?>">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong id="messageisi"><?= $message; ?></strong>
                            </div>
                            <div class="box">
                                <div style="margin-bottom:30px; border-radius:5px; background-color:#FEEFC2; padding:15px;">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <select class="form-control" name="bulan">
                                                <option value="3" <?= ($bulan == "3") ? "selected" : ""; ?>>3 Bulan</option>
                                                <option value="5" <?= ($bulan == "5") ? "selected" : ""; ?>>5 Bulan</option>
                                            </select>
                                        </div>
                                        <?php if (isset($_GET['report'])) { ?>
                                            <input type="hidden" name="report" value="ok">
                                        <?php } ?>
                                        <button style="margin-right:30px;" type="submit" class="btn btn-default">Search</button>

                                        <script>
                                            function listinv() {
                                                $("#listinv").attr("href", "<?= site_url("listinvoiceprint?from="); ?>" + $("#dari").val() + "&to=" + $("#ke").val());
                                            }
                                        </script>
                                    </form>
                                </div>
                                <div id="collapse4" class="body table-responsive">
                                    <script>
                                        $('#dataTableinv1').DataTable({
                                            dom: 'Bfrtip',
                                            buttons: [{
                                                extend: 'excelHtml5',
                                                text: 'Export Excel',
                                                title: 'Invoice Data'
                                            }],
                                            ordering: false, // <- matikan sorting bawaan DataTables
                                            "iDisplayLength": 100
                                        });
                                    </script>
                                    <div id="test"></div>
                                    <table id="dataTableinv1" class="table table-condensed table-hover">
                                        <thead>
                                            <tr>
                                                <th class="">Action</th>
                                                <th>No.</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Invoice No. </th>
                                                <th>Customer</th>
                                                <?php if ($identity->identity_project == "1") { ?>
                                                    <th>Project</th>
                                                <?php } ?>
                                                <th>PO No.</th>
                                                <th>Amount</th>
                                                <th>Payment</th>
                                                <th>Receivables (Piutang) </th>
                                                <th>Craftsman</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $tinvoice = 0;
                                            $tpembayaran = 0;
                                            $tpiutang = 0;

                                            $lock = $this->db->get("identity")->row()->identity_lockproduct;


                                            if (isset($_GET['project'])) {
                                                switch ($_GET['project']) {
                                                    case "OK":
                                                        $this->db->where("project_id >", "0");
                                                        break;
                                                    case "Non":
                                                        $this->db->where("project_id", "0");
                                                        break;
                                                    default:
                                                        break;
                                                }
                                            }

                                            //satu customer satu project
                                            if ($this->session->userdata("user_project") != "" && $lock == 1) {
                                                $this->db->where("inv.project_id", $this->session->userdata("user_project"));
                                            }

                                            //simple payment
                                            if ($identity->identity_simple == 1) {
                                                $this->db->join("sjkeluar", "sjkeluar.inv_no=inv.inv_no", "left");
                                            }

                                            //project
                                            if ($identity->identity_project == 1) {
                                                $this->db->join("project", "project.project_id=inv.project_id", "left");
                                            }

                                            $usr = $this->db
                                                ->select("*,customer.customer_id, customer.customer_name, MAX(inv.inv_date) as last_order_date")
                                                ->join("invproduct", "invproduct.inv_no = inv.inv_no", "left")
                                                ->join("product", "product.product_id = invproduct.product_id", "left")
                                                ->join("branch", "branch.branch_id = inv.branch_id", "left")
                                                ->join("customer", "customer.customer_id = inv.customer_id", "left")
                                                ->group_start()
                                                ->like("product.product_name", "Cuci AC")
                                                ->or_like("product.product_name", "Cuci Besar AC")
                                                ->group_end()
                                                ->group_by("customer.customer_id")
                                                ->having("last_order_date <", date('Y-m-d', strtotime('-' . $bulan . ' months')))
                                                ->order_by("inv.inv_date", "asc")
                                                ->get("inv");


                                            // echo $this->db->last_query();
                                            $no = 1;
                                            foreach ($usr->result() as $inv) {
                                                if ($inv->inv_ppn == 1) {
                                                    $inv->inv_ppn = 10 / 100;
                                                } else {
                                                    $inv->inv_ppn = 0;
                                                }


                                                if ($inv->inv_pph == 1) {
                                                    $inv->inv_pph = 2 / 100;
                                                } else {
                                                    $inv->inv_pph = 0;
                                                }
                                                $status = array("Jadi", "Tunda", "Batal");
                                                $foll = array("", "(Followup)");
                                            ?>
                                                <tr>
                                                    <td style="text-align:center; ">
                                                        <div class="row">
                                                            <a data-toggle="tooltip" title="Follow Up" target="_blank" href="https://wa.me/<?= $inv->customer_wa; ?>" class="btn btn-sm btn-success col-6">
                                                                <span class="fa fa-whatsapp" style="color:white;"></span>
                                                            </a>
                                                            <button id="c<?= $inv->inv_id; ?>" onclick="rfolup('<?= $inv->inv_id; ?>',1)" data-toggle="tooltip" title="Sudah Followup" class="btn btn-sm btn-success  col-6">
                                                                <span class="fa fa-check" style="color:white;"></span>
                                                            </button>
                                                            <button id="s<?= $inv->inv_id; ?>" onclick="rfolup('<?= $inv->inv_id; ?>',0)" data-toggle="tooltip" title="Belum Followup" class="btn btn-sm btn-danger  col-6">
                                                                <span class="fa fa-times" style="color:white;"></span>
                                                            </button>
                                                            <script>
                                                                $(document).ready(function() {
                                                                    folup(<?= $inv->inv_id; ?>, <?= $inv->inv_fop; ?>)
                                                                });
                                                            </script>
                                                        </div>
                                                    </td>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $inv->inv_date; ?></td>
                                                    <td><?= $status[$inv->inv_status]; ?> <span id="sfoll<?= $inv->inv_id; ?>"><?= $foll[$inv->inv_fop]; ?></span></td>
                                                    <td><?= $inv->inv_no; ?></td>
                                                    <td>
                                                        <?= ucwords($inv->customer_name ?? ''); ?>
                                                    </td>
                                                    <?php if ($identity->identity_project == "1") {
                                                        if ($this->session->userdata("position_id") == 1 || $this->session->userdata("position_id") == 2 || $this->session->userdata("position_id") == 5 || $this->session->userdata("position_id") == 7) {
                                                            $disproject = '';
                                                        } else {
                                                            $disproject = 'disabled="disabled"';
                                                        }
                                                    ?>
                                                        <td>
                                                            <select <?= $disproject; ?> class="form-control" id="project" onChange="inputprojectinvoice(this.value,'<?= $inv->inv_no; ?>')">
                                                                <option value="0">Select Project</option>
                                                                <?php $pr = $this->db->get("project");
                                                                foreach ($pr->result() as $project) { ?>
                                                                    <option value="<?= $project->project_id; ?>" <?= ($inv->project_id == $project->project_id) ? "selected" : ""; ?>><?= $project->project_name; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <script>
                                                                function inputprojectinvoice(a, b) {
                                                                    $.get("<?= site_url("api/inputproject_invoice"); ?>", {
                                                                            project_id: a,
                                                                            inv_no: b
                                                                        })
                                                                        .done(function(data) {
                                                                            //inputpoc_invoice('0',b);
                                                                            window.location.href = '<?= current_url(); ?>?message=' + data;
                                                                            $("#messageisi").html(data);
                                                                            $("#message").show();
                                                                            setTimeout(function() {
                                                                                $("#message").hide();
                                                                            }, 2000);
                                                                        });
                                                                }
                                                            </script>
                                                        </td>
                                                    <?php } ?>
                                                    <td>
                                                        <?= $inv->inv_no; ?>
                                                    </td>
                                                    <td><?php
                                                        $i = $this->db
                                                            ->where("inv_no", $inv->inv_no)
                                                            ->get("invproduct");
                                                        $invoice = 0;
                                                        $discount = 0;
                                                        $to = 0;
                                                        if ($inv->inv_showproduct <= 1) {
                                                            foreach ($i->result() as $i) {
                                                                $to += ($i->invproduct_qty * $i->invproduct_price);
                                                            }
                                                        } else {
                                                            $to = $inv->project_budget;
                                                        }
                                                        $discount = $inv->inv_discount;
                                                        $to -= $discount;
                                                        $inv_ppn = $to * $inv->inv_ppn;
                                                        $invoice = $to + $inv_ppn;
                                                        $p = $this->db
                                                            ->join("invpayment", "invpaymentproduct.invpayment_no=invpayment.invpayment_no", "left")
                                                            ->where("inv_no", $inv->inv_no)
                                                            ->get("invpaymentproduct");
                                                        //echo $this->db->last_query();
                                                        $pembayaran = 0;
                                                        foreach ($p->result() as $p) {
                                                            $pembayaran += ($p->invpaymentproduct_qty * $p->invpaymentproduct_amount);
                                                        }
                                                        echo number_format($invoice, 2, ".", ",");
                                                        $tinvoice += $invoice;
                                                        $tpembayaran += $pembayaran;
                                                        $piutang = $invoice - $pembayaran;
                                                        $tpiutang += $piutang;
                                                        ?></td>
                                                    <td><?= number_format($pembayaran, 2, ".", ","); ?></td>
                                                    <td>
                                                        <?= number_format($piutang, 2, ".", ","); ?></td>

                                                    <td>
                                                        <?php
                                                        $tukang = $this->db
                                                            ->join("user", "user.user_id=task.user_id", "left")
                                                            ->where("inv_no", $inv->inv_no)
                                                            ->get("task");
                                                        foreach ($tukang->result() as $row) {
                                                            echo $row->user_name . " (" . $row->task_time . "), ";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <script>
                                        $("#tinvoice").html("Rp <?= number_format($tinvoice, 2, ".", ","); ?>");
                                        $("#tpembayaran").html("Rp <?= number_format($tpembayaran, 2, ".", ","); ?>");
                                        $("#tpiutang").html("Rp <?= number_format($tpiutang, 2, ".", ","); ?>");

                                        function rfolup(id, fop) {
                                            $.get("<?= base_url("api/fop"); ?>", {
                                                    id: id,
                                                    fop: fop
                                                })
                                                .done(function(data) {
                                                    // $("#test").text(data);
                                                });
                                            folup(id, fop);
                                        }

                                        function folup(id, fop) {
                                            if (fop == 1) {
                                                $("#c" + id).hide();
                                                $("#s" + id).show();
                                                $("#sfoll" + id).html("(Followup)");
                                            } else {
                                                $("#c" + id).show();
                                                $("#s" + id).hide();
                                                $("#sfoll" + id).html("");
                                            }
                                        }
                                    </script>


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