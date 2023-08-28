<?php
$action = $_GET['action'];

include 'classes.php';
$admin = new Admin();

if ($action == 'add_product') {
    $save = $admin->Store();
    if ($save)
        echo $save;
}

if ($action == 'update_product') {
    $update = $admin->Update();
    if ($update)
        echo $update;
}

if ($action == 'delete_product') {
    $delete = $admin->Delete();
    if ($delete)
        echo $delete;
}
