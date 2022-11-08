<?php 

    include ('../config/db_connect.php');

    session_start();

    // Check request id parameter
    if (isset($_GET['idnv'])) {
        $idnv = mysqli_real_escape_string($connection, $_GET['idnv']);
        $sql_employee = "SELECT IDNV, HoTen, DiaChi, nv.IDPB FROM nhanvien nv INNER JOIN phongban pb ON nv.IDPB = pb.IDPB WHERE IDNV = '$idnv'";
        $result_employee = mysqli_query($connection, $sql_employee);
        $employee = mysqli_fetch_assoc($result_employee);

        $sql_department = "SELECT IDPB, TenPB, MoTa FROM phongban";
        $result_departments = mysqli_query($connection, $sql_department);
        $listDepartments = mysqli_fetch_all($result_departments, MYSQLI_ASSOC);

        mysqli_free_result($result_employee);
        mysqli_free_result($result_departments);
        mysqli_close($connection);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form cập nhật nhân viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <style>
        html {
            font-size: 62,5%;
        }
        #main {
            margin: 8px 40px;
        }
        .center {
            text-align: center;
            font-size: 1.6rem;
        }
        .mt-8 {
            margin-top: 8px;
        }
        .mt-16 {
            margin-top: 16px;
        }
        .mr-44 {
            margin-right: 44px;
        }
        #main > div {
            vertical-align: middle;
            text-align: center;
        }
        .controls {
            display: flex;
            justify-content: center;
        }
        .controls > * {
            margin: 0 4px;
        }
        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }
        .show-message {
            animation: fadeOut 2.2s linear;
        }
    </style>
</head>
<body>
    <div id="main">
        <h4 class="center mt-16">Cập nhật nhân viên</h4>
        <?php if(isset($_SESSION['status_error'])) : ?>
            <div class="alert alert-danger alert-dismissible show-message" style="margin: 16px 3.5%;">
                <button class="close" data-dismiss="alert" aria-label="close">&times;</button>
                <strong>
                    <?php 
                        echo $_SESSION['status_error'];
                        unset($_SESSION['status_error']);
                    ?>
                </strong>
            </div>             
        <?php endif; ?>
        <form action="xulycapnhatNV.php?idnv=<?php echo $employee['IDNV']; ?>" method="POST" name="form_update_employee" class="mt-16 needs-validation" novalidate>
            <div class="form-group">
                <label for="idnv">Mã nhân viên:</label>
                <input type="text" class="form-control" value="<?php echo $employee['IDNV']; ?>" id="idnv" name="idnv" disabled>
                <div class="valid-feedback">Hợp lệ</div>
                <div class="invalid-feedback">Trường này không được để trống</div>
            </div>
            <div class="form-group">
                <label for="name">Họ và tên:</label>
                <input type="text" class="form-control" value="<?php echo $employee['HoTen']; ?>" id="name" name="name" required>
                <div class="valid-feedback">Hợp lệ</div>
                <div class="invalid-feedback">Trường này không được để trống</div>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ:</label>
                <input type="text" class="form-control" value="<?php echo $employee['DiaChi']; ?>" id="address" name="address" required>
                <div class="valid-feedback">Hợp lệ</div>
                <div class="invalid-feedback">Trường này không được để trống</div>
            </div>
            <div class="form-group">
                <label for="list-department">Chọn phòng ban:</label>
                <select class="form-control" name="idpb" id="list-department">
                    <?php foreach($listDepartments as $department) : ?>
                        <option value="<?php echo htmlspecialchars($department['IDPB']); ?>" <?php echo ($employee['IDPB'] == $department['IDPB']) ? "selected" : ""; ?>>
                            <?php echo htmlspecialchars($department['MoTa']); ?> (<?php echo htmlspecialchars($department['TenPB']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="controls">
                <a href="capnhatNV.php" type="button" class="btn btn-primary">Back</a>
                <button type="reset" class="btn btn-secondary">Hủy</button> 
                <button type="submit" class="btn btn-success" style="margin-right: 8px">Lưu</button>
            </div>
        </form>
    </div>
    
    <script>
        (() => {
            'use strict';
            window.addEventListener('load', function() {
                // Get the forms we want to add validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        $(document).ready(() => {
            setTimeout(() => {
                $('.close').click();
            }, 2200);
        });
    </script>
</body>
</html>