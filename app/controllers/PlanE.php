<?php

class PlanE{
    public function insertMateria(){
        $post = json_decode(file_get_contents("php://input")); 
        $db = DB();
        $db->startTransaction();
        $data = Array(
            "idcarrera",
            "plan", 
            "nombre",
            "clave", 
            "sem"     
        );
        foreach($post as $ret) { 
        $db->where("plan", $ret->plan);
        $db->where("carrera", $ret->idcarrera);
        if($db->has("plan")) {
        } else {
            $plan = Array(
                "generacion"=> $ret->ciclo,
                "plan"=> $ret->plan, 
                "carrera"=> $ret->idcarrera, 
            );
            $id = $db->insert('plan', $plan);
            if ($db->getLastErrno() != 0){
                $db->rollback();
                ERRORdb($db->getLastErrno());
                $db->disconnect();
            exit(); }
        }
        break;
        }
        foreach($post as $rest) {
            $data = Array(
            "idcarrera"=> $rest->idcarrera,
            "plan"=> $rest->plan, 
            "nombre"=> $rest->nombre,
            "clave"=> $rest->clave,    
            "sem" => $rest->sem, 
        );
            $db->insert('materia', $data); 
        }
        $db->commit();
        $db->disconnect();
        $data = Array();
        $data['status'] = 200;
        $data['mensaje'] = "ARTICULO CREADO CON EXITO";
        JSON($data);
    }
    public function updateMateria(){
        $post = json_decode(file_get_contents("php://input")); 
        $db = DB();
        $db->startTransaction();
        $data = Array(
            "idcarrera"=> $post->idcarrera,
            "plan"=> $post->plan, 
            "nombre"=> $post->nombre,
            "clave"=> $post->clave,      
        );
        $db->where ('clave',  $post->clave)->update ('materia', $data);
            if ($db->getLastErrno() != 0){
                  $db->rollback();
                  ERRORdb($db->getLastErrno());
                  $db->disconnect();
                  exit();}
            $db->commit();
            $db->disconnect();
            $data=Array();
            $data['status'] = 200;
            $data['mensaje'] = "ARTICULO MODIFICADO CON EXITO"; 
            JSON($data);
    }

    public function selectOneMateria(){
        $materia =get('materia');
        $db = DB();
        $Planes = $db->rawQuery('SELECT * from materia where clave = ?;' , Array($materia));
        if ($db->getLastErrno() != 0){
            $db->rollback();
            ERRORdb($db->getLastErrno());
            $db->disconnect();
            exit();}else{
      $db->disconnect();
      $data=$Planes;
      JSON($data);
    }    
  }

    public function selectMateria(){
        $plan =get('plan');
        $carrera= get('carrera');
        $db = DB();
        $Planes = $db->rawQuery('SELECT * from materia where plan = ? and idcarrera = ? and c.matricula = a.matricula;' , Array($plan, $carrera));
        if ($db->getLastErrno() != 0){
            $db->rollback();
            ERRORdb($db->getLastErrno());
            $db->disconnect();
            exit();}else{
      $db->disconnect();
      $data=$Planes;
      JSON($data);
    }    
  }
  public function selectMateriaMat(){
    $generacion =get('generacion');
    $materia= get('materia');
    $db = DB();
    $Planes = $db->rawQuery('SELECT a.generacion, c.clave, c.calificacion, c.matricula, a.nombre FROM alumno as a INNER JOIN calxmatxalum AS c WHERE a.generacion = ? and c.clave = ? and a.matricula = c.matricula;',Array($generacion, $materia));
    if ($db->getLastErrno() != 0){
        $db->rollback();
        ERRORdb($db->getLastErrno());
        $db->disconnect();
        exit();}else{
  $db->disconnect();
  $data=$Planes;
  JSON($data);
}
}

public function selectPlanCargar(){
    $generacion =get('generacion');
    $carrera = get('carrera');
    $encontro = false;
    $db = DB();
    $Planes = $db->rawQuery('SELECT m.clave, m.nombre FROM materia AS m  INNER JOIN alumno as a WHERE a.generacion = ? and m.idcarrera = ? and a.plan = m.plan;',Array($generacion, $carrera));  
    if ($db->getLastErrno() != 0){
        $db->rollback();
        ERRORdb($db->getLastErrno());
        $db->disconnect();
        exit();}
    else{
    $db->disconnect();
    $data=$Planes;
    JSON($data);
}  
}
public function selectMateriaGen(){
    $generacion =get('generacion');
    $carrera = get('carrera');
    $db = DB();
    $Planes = $db->rawQuery('SELECT * FROM alumno as a INNER JOIN calxmatxalum AS c WHERE a.generacion = ? and a.idcarrera = ? and c.matricula = a.matricula;',Array($generacion, $carrera));
    if ($db->getLastErrno() != 0){
        $db->rollback();
        ERRORdb($db->getLastErrno());
        $db->disconnect();
        exit();}else{
  $db->disconnect();
  $data=$Planes;
  JSON($data);
}
   
}
public function selectPlan(){

    $carrera= get('carrera');
    $db = DB();
    $Planes = $db->rawQuery('SELECT max(plan) as w from plan where carrera = ?;' , Array($carrera));
    if ($db->getLastErrno() != 0){
        $db->rollback();
        ERRORdb($db->getLastErrno());
        $db->disconnect();
        exit();}else{
    $db->disconnect();
    $data=$Planes;
    JSON($data);
    }
    }
    public function selectPlanxcar(){
        $carrera= get('carrera');
        $db = DB();

        $Planes = $db->rawQuery('SELECT plan from plan where carrera = ?;' , Array($carrera));
        if ($db->getLastErrno() != 0){
            $db->rollback();
            ERRORdb($db->getLastErrno());
            $db->disconnect();
            exit();}else{
        $db->disconnect();
        $data=$Planes;
        JSON($data);
        }
    }
    public function selectPlanpdf(){
        $carrera= get('carrera');
        $plan = get('plan');
        $db = DB();
        $Planes = $db->rawQuery('SELECT clave, nombre from materia where idcarrera = ? and plan = ?;' , Array($carrera, $plan));
        if ($db->getLastErrno() != 0){
            $db->rollback();
            ERRORdb($db->getLastErrno());
            $db->disconnect();
            exit();}else{
        $db->disconnect();
        $data=$Planes;
        JSON($data);
        }
    }
}//final

