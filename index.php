<?php
include 'dbconfig.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Management System</title>

    <!-- Page Styling -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="text-center p-4">
                    <h1>Shop Management System</h1>
                    <em class="fw-bold">&OpenCurlyDoubleQuote;For Better management of products in your shop!&CloseCurlyDoubleQuote;</em>
                </div>
                <?php if (isset($_GET['status'])) { ?>
                    <div id="alert" role="alert" class="alert alert-<?php echo isset($_GET['status']) && $_GET['status'] == 'success' ? 'success' : 'danger'; ?>">
                        <?php echo urldecode(base64_decode($_GET['msg'])); ?>
                        <div id="countdown" class="float-end"></div>
                    </div>
                <?php } ?>
                <form action="<?php echo isset($_GET['action']) && $_GET['action'] == 'edit_product' ? 'app.php?action=update_product&id=' . $_GET['id'] : 'app.php?action=add_product'; ?>" method="post" class="pb-4">
                    <div class="form-group">
                        <?php
                        if (isset($_GET['action']) && $_GET['action'] == 'edit_product') {
                            $product_id = $_GET['id'];
                            $sql = $conn->prepare("SELECT * FROM products WHERE unique_id = ?");
                            $sql->bind_param('s', $product_id);
                            $sql->execute();
                            $arr = $sql->get_result();
                            $value = $arr->fetch_assoc();
                            if ($value) {
                                $name = $value['name'];
                            } else {
                                $name = '';
                            }
                        }
                        ?>
                        <label class="form-label fw-bold" for="product_name"><?php echo isset($_GET['action']) && $_GET['action'] == 'edit_product' ? 'Edit' : 'Add'; ?> Product</label>
                        <div class="d-flex">
                            <input required type="text" value="<?php echo isset($_GET['action']) && $_GET['action'] == 'edit_product' ? $name : ''; ?>" name="product_name" id="product_name" class="form-control" placeholder="Enter product name">
                            <button type="submit" class="btn btn-primary col-2 ms-3"><?php echo isset($_GET['action']) && $_GET['action'] == 'edit_product' ? 'Update' : 'Add'; ?></button>
                        </div>
                    </div>
                </form>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title fw-bold">Product Lists</div>
                    </div>
                    <div class="card-body">
                        <?php
                        $query = $conn->prepare("SELECT * FROM products");
                        $query->execute();
                        $row = $query->get_result();
                        ?>
                        <table class="table">
                            <thead>
                                <th class="col-1">SN</th>
                                <th class="col-8">Name</th>
                                <th class="col-3 text-center">Action</th>
                            </thead>
                            <tbody>
                                <?php
                                if ($row) {
                                    foreach ($row as $key => $product) {
                                        echo '
                                <tr>
                                    <td>' . ++$key . '</td>
                                    <td>' . $product['name'] . '</td>
                                    <td class="text-center">
                                        <a href="index.php?action=edit_product&id=' . $product['unique_id'] . '" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="app.php?action=delete_product&id=' . $product['unique_id'] . '" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                                ';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- JavaScripts -->
<script type="text/script" src="bootstrap/js/bootstrap.min.js"></script>
<script>
    if (window.location.href.indexOf('index.php?status') != -1) {
        setTimeout(function() {
            window.location.href = 'index.php';
            // document.getElementById('alert').removeClass('alert');
        }, 3000);
        document.getElementById("countdown").textContent = '3s fade';
    }
</script>

</html>