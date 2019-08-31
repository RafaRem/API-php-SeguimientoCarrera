<?php

class Alumno{


      public function insertAlumno(){
            $post = json_decode(file_get_contents("php://input")); 
            $db = DB();
            $db->startTransaction();
            foreach($post as $rest) {
                  $materias = $rest->materias;
                  $data = Array(
                        "nombre" => $rest->nombre,
                        "matricula" => $rest->matricula,
                        "idcarrera" => $rest->idcarrera,
                        "generacion" => $rest->generacion,
                        "idfacultad" => $rest->idfacultad,
                        "plan" => $rest->plan,
                        "status" => 1
                  );
                  $id = $db->insert ('alumno', $data);
                  foreach($materias as $res){
                        $mat = Array(
                        "matricula"=> $res->matricula,
                        "clave"=>$res->clave,
                        "calificacion"=>$res->cal
                        );  
                        $idm = $db->insert ('calxmatxalum', $mat);
                  }
                  
                  
                  if ($db->getLastErrno() != 0){
                        $db->rollback();
                        ERRORdb($db->getLastErrno());
                        $data = Array();
                        $db->disconnect();
                    exit(); }
              }
            $db->commit();
            $db->disconnect();
            $data = Array();
            $data['status'] = 200;
            $data['mensaje'] = "ARTICULO CREADO CON EXITO";
            JSON($data);
      }

      public function updateAlumno(){
            $post = json_decode(file_get_contents("php://input")); 
            $db = DB();
            $db->startTransaction();
            $data = Array(
                  "nombre" => $post->nombre,
                  "matricula" => $post->matricula,
                  "idcarrera" => $post->carrera,
                  "generacion" => $post->generacion,
                  "idfacultad" => $post->facultad,
                  "status" => $post->status  
            );
            $db->where ('matricula',  $post->matricula)->update ('alumno', $data);
                if ($db->getLastErrno() != 0){
                      $db->rollback();
                      ERRORdb($db->getLastErrno());
                      $db->disconnect();
                      exit();}else{$db->commit();
                        $db->disconnect();
                        $data=Array();
                        $data['status'] = 200;
                        $data['mensaje'] = "MODIFICADO CON EXITO"; 
                        JSON($data);}
                
        }
    
      public function selectGeneracion(){
            $carrera = getReq('carrera');
            $db = DB();
            $Alumno = $db->rawQuery('SELECT generacion from alumno where idcarrera = ?;' , Array($carrera));
            if ($db->getLastErrno() != 0){
                  $db->rollback();
                  ERRORdb($db->getLastErrno());
                  $db->disconnect();
                  exit;}
            else{
                  $db->disconnect();
                  $data=$Alumno;
                  JSON($data);}
      }

      public function selectAlumno(){
            $matricula = getReq('matricula');
            $db = DB();
            $Alumno = $db->rawQuery('SELECT a.matricula, a.clave, a.calificacion, m.nombre, m.sem from calxmatxalum as a INNER JOIN materia as m where a.clave = m.clave and matricula = ?;' , Array($matricula));
            if ($db->getLastErrno() != 0){
                  $db->rollback();
                  ERRORdb($db->getLastErrno());
                  $db->disconnect();
                  exit;}
            else{
                  $db->disconnect();
                  $data=$Alumno;
                  JSON($data);}
      }
}