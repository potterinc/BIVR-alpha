<?php
require_once('conn.php');
if (isset($_REQUEST['ref'])) {
    // Sanitize Name and Email
    $firstname = mysqli_escape_string($conn, $_REQUEST['firstname']);
    $lastname = mysqli_escape_string($conn, $_REQUEST['lastname']);
    $email = mysqli_escape_string($conn, $_REQUEST['email']);

    $sub = "INSERT INTO islander (
        f_name,l_name, i_email, i_tel, 
        shells, amt, tx_ref, tx_status,
        tx_id, sub_date
    ) VALUES(
        '" . $firstname . "','" . $lastname . "','" . $email . "','" . $_REQUEST['phone'] . "',
        " . $_REQUEST['shells'] . "," . intval($_REQUEST['amount']) / 100 . ",'" . $_REQUEST['ref'] . "',
        '" . $_REQUEST['txStatus'] . "','" . $_REQUEST['txID'] . "',
        '" . $_REQUEST['date'] . "'
        )";

    $result = $conn->query($sub);
    if ($result == TRUE) {
        $res['msg'] = 'Your download will start automatically';
        $res['status'] = TRUE;
        print(json_encode($res));
    }
}
