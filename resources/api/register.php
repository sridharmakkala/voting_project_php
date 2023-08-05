<?php
    $con = mysqli_connect('localhost','root','','e-vote');

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $pass = $_POST['pass'];
        $cpass = $_POST['cpass'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $role = $_POST['role'];
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $check = mysqli_query($con, "select * from register where mobile='$mobile' ");

        if($pass!==$cpass){
            echo json_encode($response['success'] = 3);        
        }
        else if(mysqli_num_rows($check)>0){
            echo json_encode($response['success'] = 4);
        }
        else if(!preg_match('/^[7-9][0-9]{9}+$/', $mobile)) {
            echo json_encode($response['success'] = 5);
        }
        else
        {
            $query = mysqli_query($con, "insert into register (name, mobile, state, password, city, dob, address, role, image, votes, status) values('$name','$mobile','$state','$pass','$city','$dob','$address','$role','$image',0, 0)");
            $upload = move_uploaded_file($tmp_name,"../uploads/$image");
    
            if($query and $upload){
                echo json_encode($response['success']=1);
            }
            else{
                echo json_encode($response['success']=0);
            }
        }

       
    }

?>