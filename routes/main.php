<?php
    session_start();

    if(!isset($_SESSION['login'])){
        header('location:../index.php');
    }
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->

  <title>E-voting - Main Panel</title>
  <link rel="stylesheet" href="../resources/Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../resources/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../resources/css/stylesheet.css">
    <script src="../resources/Jquery/jquery-3.5.1.js"></script>
    <script src="../resources/Bootstrap/js/bootstrap.min.js"></script>
    <script src="../resources/js/sweetalert.min.js"></script>
</head>

<body>

<div id="headerSection" class="sticky-top">
    <div class="container" >
        <div class="row align-items-center">
            <div class="col-md-10 text-center pt-3">
                <p id="brand">Online Voting System <i class="fas fa-vote-yea"></i></p>
            </div>
            <div class="col-md-2 text-center pt-3">
                <h5><a style="color:white; text-decoration:none" href="logout.php">Logout <i class="fa fa-user-circle"></i></a></h5>
            </div>
        </div>
    </div>
</div>

<div id="bodySection">
    <div class="container">
        <div class="row py-4">
            <div class="col-md-4 py-1">
                <div id="infoSection" style="padding: 5px;border: 1px solid #6ab04c;background-color: white; border-radius: 10px;">
                    <div id="info"></div>
                </div>
            </div>
            <div class="col-md-8 py-1">
                <div id="groupSection" style="padding: 5px;border: 1px solid #6ab04c;background-color: white; border-radius: 10px;">
                    <div id="group" class="p-1"></div>
                </div>
            </div>
        </div>
        <div class="row py-1" id="pArea">
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        getData();
    });

    function voteFun(votes, name, id){
        var id = id;
        var votes = parseInt(votes)+1;
        var name = name;
        
        swal({
            title: 'You want to go with '+name+'?',
            text: "Once you voted you won't be able to vote again!",
            icon: "warning",
            buttons: ['Cancel', 'Confirm'],
            dangerMode: true,
            })
            .then((vote) => {
            if (vote) {
                voteDone(id , votes, name);
            } else {
                swal("Think again and vote for best one!");
            }
        });
    }

    function voteDone(id, votes, name){

        $.ajax({
            url : '../api/api.php',
            type : 'POST',
            dataType : 'json',
            contentType : 'application/json',
            data : JSON.stringify({
                call : 3,
                votes : votes,
                id : id
            }),
            success : function(data){
                if(data==1){
                    swal({
                            title: "Thank You!",
                            text: 'Your vote is successfully given to '+name,
                            icon: "success",
                            button: "OK!",
                    });
                    getData();
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
    }

    function getData(){
        var id = <?php echo $_SESSION['login'] ?>;
        $.ajax({
            url : '../api/api.php',
            type : 'POST',
            dataType : 'json',
            contentType : 'application/json',
            data : JSON.stringify({
                call : 2,
                id : id,
            }),
            success : function(data){
                console.log(data);
                var voter = data[0];
                var votes = (voter.votes>0 || voter.role==2) ? '<div class="form-row pl-3"><div class="form-group col-3"><h4>Votes</h4></div><div class="form-group text-center col-2">:</div><div class="form-group col-7"><h4>'+voter.votes+'</h4></div></div>' : '';
                var groupsArray = data[1];
                var groupsInfo = '';
                var status = voter.status==0 ? '<b style="color:red">Not Voted</b>' : '<b style="color:green">Voted</b>';
                var voterInfo = '<center><h5 class="py-3">'+voter.name+'</h5>'+
                            '<img src="../uploads/'+voter.image+'" height="100" width="100"></center><br>'+
                            '<form>'+
                                '<div class="form-row pl-3">'+
                                    '<div class="form-group col-3"><b>Name</b></div>'+
                                    '<div class="form-group col-1">:</div>'+
                                        '<div class="form-group col-8">'
                                        +voter.name+
                                        '</div>'+
                                '</div>'+
                                '<div class="form-row pl-3">'+
                                    '<div class="form-group col-3"><b>Mobile</b></div>'+
                                    '<div class="form-group col-1">:</div>'+
                                        '<div class="form-group col-8">'
                                        +voter.mobile+
                                        '</div>'+
                                '</div>'+
                                '<div class="form-row pl-3">'+
                                    '<div class="form-group col-3"><b>D.O.B.</b></div>'+
                                    '<div class="form-group col-1">:</div>'+
                                        '<div class="form-group col-8">'
                                        +voter.dob+
                                        '</div>'+
                                '</div>'+
                                '<div class="form-row pl-3">'+
                                    '<div class="form-group col-3"><b>State</b></div>'+
                                    '<div class="form-group col-1">:</div>'+
                                        '<div class="form-group col-8">'
                                        +voter.state+
                                        '</div>'+
                                '</div>'+
                                '<div class="form-row pl-3">'+
                                    '<div class="form-group col-3"><b>City</b></div>'+
                                    '<div class="form-group col-1">:</div>'+
                                        '<div class="form-group col-8">'
                                        +voter.city+
                                        '</div>'+
                                '</div>'+
                                '<div class="form-row pl-3">'+
                                    '<div class="form-group col-3"><b>Address</b></div>'+
                                    '<div class="form-group col-1">:</div>'+
                                        '<div class="form-group col-8">'
                                        +voter.address+
                                        '</div>'+
                                '</div>'+
                                '<div class="form-row pl-3">'+
                                    '<div class="form-group col-3"><b>Status</b></div>'+
                                    '<div class="form-group col-1">:</div>'+
                                        '<div class="form-group col-8">'
                                           +status+ 
                                        '</div>'+
                                '</div>'+votes+
                            '</form>';

                            if(groupsArray.length>0){
                                $.each(groupsArray, function(i, d){
                                var button = voter.status==0 ? '<button type="button" class="btn btn-success" onclick="voteFun(\''+d.votes+'\',\''+d.name+'\',\''+d.id+'\')">Vote</button>' : '<button type="button" class="btn btn-success" disabled>Vote</button>';
                                i++;
                                console.log(d);
                                groupsInfo+='<div class="text-center" style="border:1px solid black;background-color: #f1f2f6; margin-bottom:10px; padding:4px; border-radius:10px">'+
                                                '<form>'+
                                                    '<div class="form-row align-items-center">'+
                                                        '<div class="form-group col-sm-1"><b>'+i+'</b></div>'+
                                                        '<div class="form-group col-sm-6"><b>'+d.name+'</b></div>'+
                                                        '<div class="form-group col-sm-3"><img src="../uploads/'+d.image+'" height="60" width="60"></div>'+
                                                        '<div class="form-group col-sm-2">'+button+'</div>'+
                                                    '</div>'+
                                                '</form>'+
                                            '</div>';
                                });   
                            }
                            else{
                                groupsInfo='<p class="text-center py-1"><b>No groups available at present.</b></p>';
                            }
                                   
                            
                $("#info").html(voterInfo);
                $("#group").html(groupsInfo);
             }
            
        });
    }
</script>

</body>

</html>