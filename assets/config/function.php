<?php

//session_start();

//require 'dbconn.php';


//input data
function validate($inputData){
    global $conn;

    $validateData = mysqli_real_escape_string($conn, $inputData);
    return trim($validateData);
}


//website title name settings
function webSetting($columnName){
    $setting = getById('settings', 1);
    if($setting['status'] == 200){
        return $setting['data'][$columnName];
    }
}


//website title name settings
function socialMedia($columnName){
    $setting = getById('social_media', 1);
    if($setting['status'] == 200){
        return $setting['data'][$columnName];
    }
}


//logout session
function logoutSession(){
    unset($_SESSION['auth']);
    unset($_SESSION['loggedInUserRole']);
    unset($_SESSION['loggedInUser']);
}


//get location like .php and message
function redirect($url, $status){
    $_SESSION['status'] = $status;
    header('location: '.$url);
    exit(0);
}


//get count or count the total in dashboard
function getCount($tableName){

    global $conn;

    $table = validate($tableName);
    $query = "SELECT * FROM $table";
    $result = mysqli_query($conn, $query);
    $totalCount = mysqli_num_rows($result);
    return $totalCount;
}



//alert message
function alertMessage(){
    if(isset($_SESSION['status'])){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                '.$_SESSION['status'].'
            </div>';
        unset($_SESSION['status']);
    }
}


//edit data
function checkParamId($paramType){
    if(isset($_GET[$paramType])){
        if($_GET[$paramType] != null){
            return $_GET[$paramType];
        }
        else{
            return 'No id found';
        }
    }
    else{
        return 'No id given';
    }
}


//fetch data 
function getAll($tableName){
    global $conn;

    $table = validate($tableName);

    $query = "SELECT * FROM $table";
    $result = mysqli_query($conn, $query);
    return $result;
}


//get user id
function getById($tableName, $id){
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if($result){
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $response = [
                'status' => 200,
                'message' => 'Fetched data',
                'data' => $row
            ];
            return $response;
        }
        else{
            $response = [
                'status' => 404,
                'message' => 'No Data Record'
            ];
            return $response;
        }
    }
    else{
        $response = [
            'status' => 500,
            'message' => 'Something Went Wrong'
        ];
        return $response;
    }
}


//delete query
function deleteQuery($tableName, $id){
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "DELETE FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result;
}




















?>