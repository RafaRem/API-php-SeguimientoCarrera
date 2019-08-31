<?php

class Carrera{
    public function insertCarrera(){
            $post = json_decode(file_get_contents("php://input")); 
            $db = DB();
            $db->startTransaction();
            $data = Array(
                  "nombre" => $post->nombre,
                  "idfac" => $post->idfac,      
            );
            $id = $db->insert ('carrera', $data);
            $db->commit();
            $db->disconnect();
            $data = Array();
            $data['status'] = 200;
            $data['mensaje'] = "ARTICULO CREADO CON EXITO";
            JSON($data);
            
            if ($db->getLastErrno() != 0){
                $db->rollback();
                ERRORdb($db->getLastErrno());
                $db->disconnect();
                exit(); }
      }

      public function updateCarrera(){
            
            $post = json_decode(file_get_contents("php://input")); 
            $db = DB();
            $db->startTransaction();
            $data = Array(
                "id"=> $post->id, 
                "nombre"=> $post->nombre,
                "idfac"=> $post->idfac,      
            );
            $db->where ('id',  $post->id)->update ('carrera', $data);
                if ($db->getLastErrno() != 0){
                      $db->rollback();
                      ERRORdb($db->getLastErrno());
                      $db->disconnect();
                      exit();}else{
                        $db->commit();
                        $db->disconnect();
                        $data=Array();
                        $data['status'] = 200;
                        $data['mensaje'] = "MODIFICADO CON EXITO"; 
                        JSON($data);
                      }
               
        }
    
        public function selectCarrera(){              
            $db = DB();
            $carreras = $db->rawQuery('select c.id, c.nombre, c.idfac from carrera as c');// CROSS JOIN facultad as f WHERE c.idfac = f.id;');
            if ($db->getLastErrno() != 0){
                $db->rollback();
                ERRORdb($db->getLastErrno());
                $db->disconnect();
                exit();}else{
          $db->disconnect();
          $data=$carreras;
          JSON($data);
        }
      }
}