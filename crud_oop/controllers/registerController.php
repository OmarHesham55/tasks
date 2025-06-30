<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/Database.php';
$user = new User();

if($_SERVER['REQUEST_METHOD'] === "POST")
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!$name || !$email || !$password)
    {
        echo json_encode([
            'status' => 'error',
            'message' => 'All fields are required'
        ]);
        exit;
    }
    if($user->isEmailExist($email))
    {
        json_encode([
            'status' => 'error',
            'message' => 'Mail is already exist'
        ]);
    }
    else
    {
        $res = $user->addUser($name,$email,$password);
        if($res)
        {
            echo json_encode([
                'status' => 'success',
                'message' => 'User Registered Successfully'
            ]);
        }
        else
        {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to register'
            ]);
        }
    }

}
else
{
    echo json_encode([
        'status' => 'error',
        'message' => 'invalid request method'
    ]);
}