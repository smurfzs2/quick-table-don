<?php
include $_SERVER['DOCUMENT_ROOT'] . "/version.php";
$path = $_SERVER['DOCUMENT_ROOT'] . "/" . v . "/Common Data/";
set_include_path($path);
ini_set("display_errors", "on");

include("../jovit_connection.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=dSevice-width, initial-scale=1.0">

    <!-- Boothstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Data Tables -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/scroller/2.1.0/js/dataTables.scroller.min.js"></script>



    <title>Quick Table</title>
</head>

<body>

    <?php

    if (isset($_POST['search'])) {

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $birthday = $_POST['birthday'];
        $department = $_POST['department'];


        $query = "SELECT * FROM `tbl_jovit` INNER JOIN `hr_department` ON tbl_jovit.departmentId=hr_department.departmentId WHERE ";


        if ($firstName != "") {
            $query .= " firstName LIKE '%$firstName%' AND ";
        }
        if ($lastName != "") {
            $query .=  " lastName LIKE '%$lastName%' AND ";
        }

        if ($birthday != "") {
            $query .= " birthDate LIKE '%$birthday%' AND ";
        }

        if ($address != "") {
            $query .= " address LIKE '%$address%' AND ";
        }

        if ($gender != "") {
            $query .= " gender LIKE '%$gender%' AND ";
        }

        if ($department != "") {
            $query .= " departmentName LIKE '%$department%' AND ";
        }

        $query = substr($query, 0, -4);
    } else {
        $query = "SELECT * FROM `tbl_jovit` INNER JOIN `hr_department` ON tbl_jovit.departmentId=hr_department.departmentId";
    }


    $records = $conn->query($query);
    $totalRecords = $records->num_rows;


    function getDepartment($db)
    {
        $query = "SELECT * FROM `hr_department` ORDER BY departmentName ASC";
        return $result = mysqli_query($db, $query);
    }


    function filterTable($query)
    {
        $connect = mysqli_connect("localhost", "root", "arktechdb", "ojtDatabase");

        if (!$connect) {
            die("Connection failed: " . mysqli_connect_error());
        }

        echo "Query being executed: " . $query . "<br>"; // Output the query being executed

        $filter_Result = mysqli_query($connect, $query);
        return $filter_Result;
    }
    ?>

     <!-- Insert Modal -->
     <div class="modal fade" id="modalTrigger" tabindex="-1" aria-labelledby="modalTriggerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTriggerLabel">Add Details Here</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <form action="jovit_actions.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" name="firstName" placeholder="Enter First Name" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" name="lastName" placeholder="Enter Last Name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Birth Date</label>
                            <input type="date" class="form-control" name="birthDate" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" name="address" placeholder="Enter Your Address" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Gender</label>
                        </div>
                        <div class="form-group mb-3">

                            <input type="radio" name="gender" class="" value="0" id="male" required>
                            <label for="male">Male</label>

                        </div>
                        <div class="form-group mb-3">
                            <input type="radio" name="gender" class="" value="1" id="female" required>
                            <label for="male">Female</label>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="saveBtn" class="btn btn-dark">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- SEARCH BARS -->
    
    <h4 class="text-center">QUICK TABLE</h4>
    <div class="card border-dark">



        <div class="row">
            <div class="col-md-12">
                <form action="jovit_index2.php" method="POST" id="formSubmit">
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="Search by First Name" name="firstName" value="<?php if (isset($_POST['firstName'])) {
                                                                                                                                    echo $_POST['firstName'];
                                                                                                                                } ?>" form="formSubmit" />
                        <input type="search" class="form-control" placeholder="Search by Last Name" name="lastName" value="<?php if (isset($_POST['lastName'])) {
                                                                                                                                echo $_POST['lastName'];
                                                                                                                            } ?>" form="formSubmit" />
                        <input type="search" class="form-control" placeholder="Search by Address" name="address" value="<?php if (isset($_POST['address'])) {
                                                                                                                            echo $_POST['address'];
                                                                                                                        } ?>" form="formSubmit" />
                        <select class="form-control" name="gender" form="formSubmit">
                            <option value="" selected disabled>Search b
                                <?php
                                if (isset($_POST['gender'])) {
                                    echo $_POST['gender'] ? 'Male' : 'Female';
                                } else {
                                    echo "Gender";
                                }
                                ?>
                            </option>
                            <option value="0">Male</option>
                            <option value="1">Female</option>
                            </option>

                        </select>
                        <input type="date" class="form-control" placeholder="Search by Birthday" name="birthday" value="<?php if (isset($_POST['birthday'])) {
                                                                                                                            echo $_POST['birthday'];
                                                                                                                        } ?>" form="formSubmit" />


                        <select class="form-control" name="department" form="formSubmit">
                            <option value="" disabled <?php if (!isset($_POST['departmentName'])) echo 'selected'; ?>>Department</option>
                            <?php
                            $department = getDepartment($conn);

                            if (mysqli_num_rows($department) > 0) {
                                foreach ($department as $item) {
                            ?>
                                    <option value="<?= $item['departmentName']; ?>" <?php if (isset($_POST['departmentName']) && $_POST['departmentName'] === $item['departmentName']) echo 'selected'; ?>>
                                        <?= $item['departmentName']; ?>
                                    </option>
                            <?php
                                }
                            }
                            ?>
                        </select>

                        <button type="submit" name="search" class="btn btn-dark" form="formSubmit">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- buttons -->
        <div class="card-header border-dark">
            <td colspan="8">Total Records: <?php echo $totalRecords; ?></td>
            <div class="float-end">

                <a href="jovit_clustered.php" class="csv btn btn-dark"><i class="fas fa-chart-pie"></i> CLUSTERED</a>
                <a href="jovit_barGraph.php" class="csv btn btn-dark"><i class="fas fa-chart-bar"></i> BAR GRAPH</a>
                <a href="jovit_pieChart.php" class="csv btn btn-dark"><i class="fas fa-chart-pie"></i> PIE CHART</a>
                <a href="jovit_pdf.php" class="btn btn-dark"><i class="fas fa-print"></i> PDF</a>
                <a href="jovit_csv.php" class="csv btn btn-dark"><i class="fas fa-print"></i> CSV</a>
                <button type="button" class="btn btn-dark ms-2" data-bs-toggle="modal" data-bs-target="#modalTrigger">
    <i class="fas fa-plus me-2"></i> Add
</button>



            </div>
        </div>
        <!-- TABLES -->
        <!-- tables -->
        <div class="card-body">
            <table id="userTable1" class="table table-striped table-hover table-bordered   text-center">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">FIRST NAME</th>
                        <th scope="col">LAST NAME</th>
                        <th scope="col">GENDER</th>
                        <th scope="col">BIRTH DATE</th>
                        <th scope="col">ADDRESS</th>
                        <th scope="col">DEPARTMENT</th>
                        <th scope="col">ACTIONS</th>
                    </tr>
                </thead>

                <tbody>
                <tbody>



                </tbody>
            </table>
        </div>


        <script>
            jQuery(document).ready(function($) {
                $('#userTable1').DataTable({

                    "bLengthChange": false,
                    "processing": true,
                    "searching": true,
                    "serverSide": true,
                    "ordering": false,
                    "paging": false,
                    "info": false,
                    "sDom": "lrti",
                    "ajax": {
                        url: "jovit_ajax.php", // json datasource (another file)
                        type: "POST", // method, the default is GET
                        data: {
                            "query": "<?php echo $query; ?>",
                            "totalRecords": "<?php echo $totalRecords; ?>",
                        },
                        error: function(data) { // error handling
                            console.log(data);
                        }
                    },

                    paging: true,
                    deferRender: true,
                    scrollY: 450,
                    scrollcollapse: false,
                    scroller: true,
                    buttons: ['createState', 'savedStates']
                });

                {}
            });


            function refreshPage() {
                window.location.reload();
            }
        </script>

        <!-- Bootstrap JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>