<?php 

require '../assets/config/function.php';


$paraResult = checkParamId('id');
if(is_numeric($paraResult)){

    $registrationId = validate($paraResult);

    $registration = getById('registration', $registrationId);
    if($registration['status'] == 200){

        $registrationDeleteRes = deleteQuery('registration', $registrationId);
        if($registrationDeleteRes){
            redirect('registration.php', 'Registration Deleted Successfully');
        }
        else{
            redirect('registration.php', 'Something Went Wrong');
        }
    }
    else{
        redirect('registration.php', $registration['message']);
    }
}
else{
    redirect('registration.php', $paraResult);
}

?>