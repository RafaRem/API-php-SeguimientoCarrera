<?php

class Facultad{

    public function insertFac(){
            $post = json_decode(file_get_contents("php://input")); 
            $db = DB();
            $db->startTransaction();
            $data = Array(
                  "facultad" => $post->facultad,             
            );
            $id = $db->insert ('facultad', $data);
            $db->commit();
            $db->disconnect();
            $data = Array();
            $data['status'] = 200;
            $data['mensaje'] = "ARTICULO CREADO CON EXITO";
            JSON($data);
      }

      public function updateFac(){
            $post = json_decode(file_get_contents("php://input")); 
            $db = DB();
            $db->startTransaction();
            $data = Array(
                "id"=> $post->id, 
                "facultad"=> $post->nombre,     
            );
            $db->where ('id',  $post->id)->update ('facultad', $data);
                if ($db->getLastErrno() != 0){
                      $db->rollback();
                      ERRORdb($db->getLastErrno());
                      $db->disconnect();
                      exit();}
                $db->commit();
                $db->disconnect();
                $data=Array();
                $data['status'] = 200;
                $data['mensaje'] = "MODIFICADO CON EXITO"; 
                JSON($data);
        }
    
        public function selectFac(){
            $post = json_decode(file_get_contents("php://input")); 
            $db = DB();
            $facultad = $db->rawQuery('select id, facultad from facultad;');
            if ($db->getLastErrno() != 0){
                $db->rollback();
                ERRORdb($db->getLastErrno());
                $db->disconnect();
                exit();}else{
          $db->disconnect();
          $data=$facultad;
          JSON($data);
        }
      }
}//Fin