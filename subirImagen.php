<?php
header("Access-Control-Allow-Origin: *");
 if (isset($_FILES['file'])) {
    if (is_uploaded_file($_FILES['file']['tmp_name'])) {
        $tmp_name = $_FILES["file"]["tmp_name"];
        $ext = "." . end(explode(".", $_FILES['file']['name']));
        $name = uniqid('',TRUE);
        if(move_uploaded_file($tmp_name, '../img/'.$name.$ext)){
            $vec = array(
                'status' => "200" ,
                'nombre' => $name.$ext,
            );
            echo json_encode($vec);
        }else {
            $vec = array('status' => "500", "mensaje"=>"No se movio #".$_FILES["file"]["error"]);
            echo json_encode($vec);
        }
    } else {
        $vec = array('status' => "500", "mensaje"=>"No se subio");
        echo json_encode($vec);
    }
} else {
    $vec = array('status' => "500", "mensaje"=>"No se detecta");
    echo json_encode($vec);
}
?>