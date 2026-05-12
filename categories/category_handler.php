<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$conn = new mysqli("localhost", "root", "", "library_management_system");
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed']);
    exit();
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {

    case 'add':
        $id   = trim($_POST['category_id']);
        $name = trim($_POST['category_name']);
        $date = date('Y-m-d H:i:s');

        if (!preg_match('/^C\d+$/', $id)) {
            echo json_encode(['status' => 'error', 'message' => 'Category ID must be like C001']);
            exit();
        }
        if (empty($name)) {
            echo json_encode(['status' => 'error', 'message' => 'Category name is required']);
            exit();
        }

        $check = $conn->prepare("SELECT category_id FROM bookcategory WHERE category_id=?");
        $check->bind_param("s", $id);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Category ID already exists']);
            exit();
        }
        $check->close();

        $stmt = $conn->prepare("INSERT INTO bookcategory VALUES (?,?,?)");
        $stmt->bind_param("sss", $id, $name, $date);
        $stmt->execute()
            ? print(json_encode(['status' => 'success', 'message' => 'Category added!']))
            : print(json_encode(['status' => 'error', 'message' => 'Failed to add']));
        $stmt->close();
        break;

    case 'get_all':
        $result = $conn->query("SELECT * FROM bookcategory ORDER BY category_id ASC");
        $data = [];
        while ($row = $result->fetch_assoc()) $data[] = $row;
        echo json_encode(['status' => 'success', 'data' => $data]);
        break;

    case 'update':
        $old  = trim($_POST['old_category_id']);
        $id   = trim($_POST['category_id']);
        $name = trim($_POST['category_name']);
        $date = date('Y-m-d H:i:s');

        if (!preg_match('/^C\d+$/', $id)) {
            echo json_encode(['status' => 'error', 'message' => 'Category ID must be like C001']);
            exit();
        }
        if (empty($name)) {
            echo json_encode(['status' => 'error', 'message' => 'Category name is required']);
            exit();
        }

        if ($old !== $id) {
            $check = $conn->prepare("SELECT category_id FROM bookcategory WHERE category_id=?");
            $check->bind_param("s", $id);
            $check->execute();
            $check->store_result();
            if ($check->num_rows > 0) {
                echo json_encode(['status' => 'error', 'message' => 'Category ID already exists']);
                exit();
            }
            $check->close();
        }

        $stmt = $conn->prepare("UPDATE bookcategory SET category_id=?, category_Name=?, date_modified=? WHERE category_id=?");
        $stmt->bind_param("ssss", $id, $name, $date, $old);
        $stmt->execute()
            ? print(json_encode(['status' => 'success', 'message' => 'Category updated!']))
            : print(json_encode(['status' => 'error', 'message' => 'Failed to update']));
        $stmt->close();
        break;

    case 'delete':
        $id   = trim($_POST['category_id']);
        $stmt = $conn->prepare("DELETE FROM bookcategory WHERE category_id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute()
            ? print(json_encode(['status' => 'success', 'message' => 'Category deleted!']))
            : print(json_encode(['status' => 'error', 'message' => 'Failed to delete']));
        $stmt->close();
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}

$conn->close();
?>
