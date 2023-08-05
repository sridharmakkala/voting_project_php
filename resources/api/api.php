
<?php
    session_start();
    $con = mysqli_connect('localhost','root','','e-vote');
    $json = json_decode(file_get_contents("php://input"),true);
    

    // Login
    if($json['call'] == 1){
        
        $mobile = $json['mobile'];
        $pass = $json['pass'];
        $role = $json['role'];

        $query = mysqli_query($con, "select * from register where mobile='$mobile' and password='$pass' and role='$role'");
        if(mysqli_num_rows($query)>0){
            while($data = mysqli_fetch_array($query)){
                $id = $data['id'];
            }
            $_SESSION['login'] = $id;
            echo json_encode($response['success'] = 1);
        }
        else{
            echo json_encode($response['success'] = 0);
        }

    }


    // Get user and groups data
    if($json['call'] == 2){
        
        $id = $json['id'];
        $query = mysqli_query($con, "select id, name, mobile, dob, state, city, role, address, image, votes, status from register where id='$id'");
        $query2 = mysqli_query($con, "select id, name, mobile, dob, state, city, address, image, status, votes from register where role=2");

        if(mysqli_num_rows($query)>0){
            $voter = mysqli_fetch_array($query, MYSQLI_ASSOC);
            $empty = mysqli_free_result($query);
            $groupArray = mysqli_fetch_all($query2, MYSQLI_ASSOC);
            $empty1 = mysqli_free_result($query2);
            echo json_encode([$voter, $groupArray]);
        }
       
       

    }


    // Voting
    if($json['call'] == 3){
        
        $id = $json['id'];
        $votes = $json['votes'];
        $uid = $_SESSION['login'];
        $query = mysqli_query($con, "update register set votes='$votes' where id='$id'");
        $query1 = mysqli_query($con, "update register set status=1 where id='$uid'");
        if($query and $query1){
            echo json_encode($response['success']=1);
        }
        else{
            echo json_encode($response['success']=0);
        }
       
       

    }

    // Get groups data
    if($json['call'] == 4){
        
        $query = mysqli_query($con, "select name, image, votes from register where role=2");

        if(mysqli_num_rows($query)>0){
            $groupArray = mysqli_fetch_all($query, MYSQLI_ASSOC);
            $empty1 = mysqli_free_result($query);
            echo json_encode($groupArray);
        }
        else{
            echo json_encode($response['success']=0);
        }
       
       

    }
?>