<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/Database.php';

$user = new User();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (empty($email) || empty($password))
        {
            echo json_encode([
                'status' => 'error',
                'message' => 'All fields are required'
            ]);
        }
        $isExist =  $user->login($email,$password);
        if($isExist)
        {
            $_SESSION['user'] = [
              'id' => $isExist['id'],
              'name' => $isExist['name'],
              'email' => $isExist['email']
            ];

            echo json_encode([
                'status' => 'success',
                'message' => 'Login Successfully'
            ]);
        }
        else
        {
            echo json_encode([
                'status' => 'error',
                'message' => "email doesn't exist"
            ]);
        }
    }
}
catch (PDOException $e)
{
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid Method Request'
    ]);
}