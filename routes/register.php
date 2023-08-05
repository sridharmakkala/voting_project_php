

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->

  <title>E-voting - Registration</title>
  <link rel="stylesheet" href="../resources/Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../resources/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../resources/css/stylesheet.css">
    <link rel="stylesheet" href="../resources/Jquery/jquery-ui.css">
    <script src="../resources/Jquery/jquery-3.5.1.js"></script>
    <script src="../resources/Jquery/jquery-ui.js"></script>
    <script src="../resources/Bootstrap/js/bootstrap.min.js"></script>
    <script src="../resources/js/sweetalert.min.js"></script>
</head>

<body>

<?php
    include('header.php');
?>

<div id="bodySection">
    <div class="container">
        <div class="row py-4">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="loginSection" class="text-center">
                    <h4>Registration</h4>
                    <br>
                    <form id="regForm" enctype="multipart/form-data">
                        <div class="form-row py-1 px-5">
                            <div class="form-group col-md-6">
                                <input name="name" type="text" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <input name="mobile" type="text" maxlength="10" class="form-control" placeholder="Mobile" required>
                            </div>
                        </div>
                        <div class="form-row py-1 px-5">
                            <div class="form-group col-md-6">
                                <input name="state" type="text" class="form-control" placeholder="State" required>
                            </div>
                            <div class="form-group col-md-6">
                                <input name="city" type="text" class="form-control" placeholder="City" required>
                            </div>
                        </div>
                        <div class="form-row py-1 px-5">
                            <div class="form-group col-md-6">
                                <input name="pass" type="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group col-md-6">
                                <input name="cpass" type="password" class="form-control" placeholder="Confirm password" required>
                            </div>
                        </div>
                        <div class="form-row py-1 px-5">
                            <div class="form-group col-md-4">
                                <input id="datepicker" name="dob" type="text" class="form-control" placeholder="Date of Birth" required>
                            </div>
                            <div class="form-group col-md-8">
                                <input name="address" type="text" class="form-control" placeholder="Address" required>
                            </div>
                        </div>
                        <div class="form-row py-1 px-5">
                            <div class="form-group col-md-4">
                                <select class="form-control" name="role" style="border: 1px solid #6ab04c; border-radius:5px">
                                    <option value="1">Voter</option>
                                    <option value="2">Group</option>
                                </select>
                            </div>
                            <div class="form-group col-md-8">
                            <div class="input-group mb-3" id="imageBox">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="image" id="inputGroupFile01" required>
                                    <label class="custom-file-label" for="inputGroupFile01">Image / Group symbol</label>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row py-1 px-5">
                            <div class="form-group col-md-3"></div>
                            <div class="form-group col-md-6">
                            <input type="submit" class="form-control btn btn-success" id="btnn" name="regbtn" value="Register">
                            </div>
                            <div class="form-group col-md-3"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row py-1" id="pArea">
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        
        $("#datepicker").datepicker({
        maxDate : 0,
        changeMonth : true,
        changeYear : true,
        yearRange : "1950:2020"
        });

        $("#regForm").on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url : '../api/register.php',
                type : 'POST',
                data : new FormData(this),
                contentType : false,
                cache : false,
                processData : false,
                success : function(data){
                    console.log(data);
                    if(data == 1){
                        swal({
                            title: "Registration successfull!",
                            text: "You are registered on E-voting panel!",
                            icon: "success",
                            button: "OK!",
                    }).then((value)=>{
                        window.location = '../index.php';
                    });
                    }
                    else if(data==3){
                        swal({
                            title: "Passwords do not match!",
                            text: "Password and Confirm password does not match!",
                            icon: "error",
                            button: "OK!",
                    });
                    }
                    else if(data==4){
                        swal({
                            title: "User already exists!",
                            text: "Mobile number is already taken. Try another!",
                            icon: "error",
                            button: "OK!",
                    });
                    }
                    else if(data==5){
                        swal({
                            title: "Invalid Mobile No!",
                            text: "No. should start with 7-9 and 10 digits compulsary!",
                            icon: "error",
                            button: "OK!",
                    });
                    }
                    else{
                        swal({
                            title: "Error!",
                            text: "Some error occured!",
                            icon: "error",
                            button: "OK!",
                    });
                    }
                }
            });
        });
    });
  

</script>

</body>

</html>