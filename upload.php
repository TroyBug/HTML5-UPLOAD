<?php
    header("Content-Type: text/html; charset=utf-8");

    $fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);

    
    if($fn) {//异步上传
        file_put_contents(
            'uploads/' . $fn,
            file_get_contents('php://input')
        );
        echo rawurldecode($fn)." uploaded";
        exit();
    }
    else {//非异步
        $files = $_FILES['fileSelect'];

        foreach ($files['error'] as $id => $err) {
            if ($err == UPLOAD_ERR_OK) {
                $fn = $files['name'][$id];
                move_uploaded_file(
                    $files['tmp_name'][$id],
                    'uploads/' . rawurlencode($fn)
                );
                echo "<p>File <i>$fn</i> uploaded.</p>";
            } else {
                echo '上传大小超过限制';
            }
        }
    }
    
?>