<?php

require_once 'database/master.php';

$users = getUsers();

$categories = getFreshLatexCategories();

date_default_timezone_set('Asia/Bangkok');
$date = date('Y-m-d');

$purchaseInfo = getPpPurchaseInfo($date);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userSelection = $_POST["userSelection"];
    $freshLatexWeight = $_POST["freshLatexWeight"];
    $percentageObtained = isset($_POST["percentageObtained"]) ? $_POST["percentageObtained"] : 0;
    $dryRubber = $_POST["dryRubber"];
    $totalPrice = $_POST["totalPrice"];

    // Check if any of the fields are empty
    if (empty($userSelection) || empty($freshLatexWeight) || empty($dryRubber) || empty($totalPrice)) {
        echo "<script>
                    alert('กรุณากด Calculate ก่อน.');
                    window.location.href = 'latex.php';
                </script>";
    } else {
        // Save data to the database
        $result = SavePpPurchaseInfo($userSelection, $freshLatexWeight, $percentageObtained, $dryRubber, $totalPrice);

        if ($result == 1) {
            header("Refresh:0");
        } else {
            echo "<script>
                        alert('Error: $result');
                        window.location.href = 'latex.php';
                    </script>";
        }
    }
}



// if (isset($_POST['submit'])) {
//     $price = $_POST['price'];
//     $price_unit_eng = $_POST['price_unit_eng'];
//     $price_unit_loc = $_POST['price_unit_loc'];
//     $weight_unit_eng = $_POST['weight_unit_eng'];
//     $weight_unit_loc = $_POST['weight_unit_loc'];

//     $result = insertFreshLatexCategory($price, $price_unit_eng, $price_unit_loc, $weight_unit_eng, $weight_unit_loc);

//     if ($result === true) {
//         echo "<script>
//                     Swal.fire({
//                         title: 'Success!',
//                         text: 'Data inserted successfully.',
//                         icon: 'success',
//                         showCancelButton: false,
//                         confirmButtonText: 'OK'
//                     }).then(() => {
//                         window.location.href = 'index.php';
//                     });
//                 </script>";
//     } else {
//         echo $result;
//         // echo "<script>Swal.fire('Error!', '$error', 'error');</script>";
//     }
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Latex</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom styles for this template -->
    <link href="css/sb.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="css/style.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'components/sidebar.html'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'components/topbar.html'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                    <p class="mb-4">Insert Example.</p>

                    <!-- Insert form -->
                    <form class="user" method="post" action="">
                        <div class="form-group">
                            <label for="pricePerKilogram">ราคาน้ำยางวันนี้ (Bath)</label>
                            <?php $selectedCategory = (!empty($categories)) ? $categories[0] : null; ?>
                            <input type="text" class="form-control" id="pricePerKilogram" name="pricePerKilogram" value="<?php echo htmlspecialchars($selectedCategory['price'] ?? '0'); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="userSelection">เลือกลูกค้า</label>
                            <select class="form-control" id="userSelection" name="userSelection" placeholder="Select User" required>
                                <?php foreach ($users as $user) : ?>
                                    <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['username']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="freshLatexWeight">น้ำหนักน้ำยางสด (Kilogram)</label>
                                <input type="text" class="form-control" id="freshLatexWeight" name="freshLatexWeight" placeholder="Enter weight" required>
                            </div>

                            <div class="col-sm-6">
                                <label for="percentageObtained">เปอร์เซ็นต์ที่ทำได้ (%)</label>
                                <input type="text" class="form-control" id="percentageObtained" name="percentageObtained" placeholder="Enter percentage" required>
                            </div>
                        </div>

                        <!-- Calculated fields for reference -->
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label>ยางแห้ง</label>
                                <input type="text" class="form-control" id="dryRubber" name="dryRubber" readonly required>
                            </div>
                            <div class="col-sm-6">
                                <label>จำนวนเงินที่ได้รับ (Bath)</label>
                                <input type="text" class="form-control" id="totalPrice" name="totalPrice" readonly required>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary btn-block" onclick="calculateValues();" id="calculateButton">
                            Calculate
                        </button>
                        <button type="submit" class="btn btn-success btn-block" onclick="saveData();" id="saveButton">
                            Save
                        </button>


                    </form>

                    <!-- End of insert form -->

                    <!-- DataTales Example -->
                    <div class="card shadow my-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>วันที่</th>
                                            <th>ชื่อลูกค้า</th>
                                            <th>น้ำหนักน้ำยางสด</th>
                                            <th>เปอร์เซ็นต์ที่ทำได้</th>
                                            <th>ยางแห้ง</th>
                                            <th>ยอดเงินที่ต้องจ่าย</th>
                                            <th>การทำงาน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($purchaseInfo as $info) : ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($info['create_date']); ?></td>
                                                <td><?php echo htmlspecialchars($info['username']); ?></td>
                                                <td><?php echo htmlspecialchars(number_format($info['weighed'], 2)); ?></td>
                                                <td><?php echo htmlspecialchars(number_format($info['percentage'], 2)); ?></td>
                                                <td><?php echo htmlspecialchars(number_format($info['rubber_dry'], 2)); ?></td>
                                                <td><?php echo htmlspecialchars(number_format($info['price_total'], 2)); ?></td>
                                                <td>
                                                    <a href="edit.php?id=<?php echo $info['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                                    <a href="delete.php?id=<?php echo $info['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#printModal<?php echo $info['id']; ?>">Print</button>
                                                </td>
                                            </tr>


                                        <?php endforeach; ?>
                                    </tbody>
                                    <!-- modal print receipt -->
                                    <?php
                                    foreach ($purchaseInfo as $info) :
                                        include 'modal/print.php';
                                    endforeach;
                                    ?>
                                    <!-- end modal print receipt -->

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include 'components/footer.html'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/admin.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <!-- Calculate values -->
    <script src="js/service.js"></script>

</body>

</html>