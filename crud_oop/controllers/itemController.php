<?php
header('Content-Type: application/json');
session_start();

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Item.php';

$items = new Item();
$db = new Database();
$user_id = null;

/*********************** Checking **********************/

if(!isset($_SESSION['user']) && !isset($_POST['action']))
{
    echo json_encode([
        'status' => 'error',
        'message' => 'session expired || action field does not exist'
    ]);
    exit;
}
$user_id = $_SESSION['user']['id'];

//if(!isset($_POST['action'])){
//    echo json_encode([
//        'status' => 'error',
//        'message' => "Action field doesn't exist"
//    ]);
//    exit;
//}

try {

    /********* Add Item **********/

    if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add')
    {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';

        if(!empty($title) && !empty($description))
        {
            $item = $items->addItem($title,$description,$user_id);
            if($item)
            {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Item Added Successfully'
                ]);
            }
            else
            {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Item Failed to add'
                ]);
            }
        }
        else
        {
            echo json_encode([
                'status' => 'error',
                'message' => 'All fields are required'
            ]);
        }
        exit;
    }


    if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'edit')
    {
        $itemId = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        if(!empty($title) && !empty($description))
        {
            $updated = $items->updateItem($itemId,$user_id,$title,$description);

            if($updated)
            {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Updated Successfully'
                ]);
            }
            else
            {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Updating failed'
                ]);
            }
        }
        else {
            echo json_encode([
                'status' => 'error',
                'message' => 'check Updating Fields'
            ]);
        }

        exit;
    }


    /********************* Delete Item **********************/

    if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete')
    {
        $deleted = $items->deleteItem($_POST['id'],$user_id);
        if($deleted)
        {
            echo json_encode([
                'status' => 'success',
                'message' => 'Item Deleted Successfully'
            ]);
        }
        else
        {
            echo json_encode([
                'status' => 'error',
                'message' => 'failed to delete the item'
            ]);
        }
        exit;
    }


    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        $itemsList = $items->getAllItems($user_id);
        echo json_encode([
            'status' => 'success',
            'data' => $itemsList
        ]);
        exit;
    }

    echo json_encode([
    'status' => 'error',
    'message' => 'Method invalid'
    ]);

}
catch (PDOException $e)
{
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

