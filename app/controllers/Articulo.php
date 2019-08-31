<?php

class Articulo{

      public function crearArticulo(){
            $post = json_decode(file_get_contents("php://input"));
            $categorias = $post->categorias;
            $articulo = $post->articulo; 
            $db = DB();
            $db->startTransaction();
            $data = Array(
                  "nombre" => $articulo->nombre,
                  "descripcion" => $articulo->descripcion,
                  "size" => $articulo->size,
                  "marca" => $articulo->marca,
                  "modelo" => $articulo->modelo,
                  "idProveedor" => $articulo->idProveedor,
                  "precioCompra" => $articulo->precioCompra,
                  "precioVenta" => $articulo->precioVenta,
                  "stock" => $articulo->stock,
                  "estatus" => 1
            );
            if($articulo->imagen)
                  $data["imagen"] = $articulo->imagen;
            $idArticulo = $db->insert ('tblArticulos', $data);
            if ($db->getLastErrno() != 0) {
                  $db->rollback();
                  ERRORdb($db->getLastErrno());
                  $db->disconnect();
                  exit(); }
            foreach($categorias as $categoria) {
                  if($categoria->idCategoria == 0){
                        $data = Array();
                        $data["nombre"] = $categoria->nombre;
                        $categoria->idCategoria = $db->insert('tblCategorias', $data);
                        if ($db->getLastErrno() != 0){
                              $db->rollback();
                              ERRORdb($db->getLastErrno());
                              $db->disconnect();
                              exit(); }
                  }
                  $data = Array();
                  $data['idCategoria'] = $categoria->idCategoria;
                  $data['idArticulo'] = $idArticulo;
                  $db->insert('relArticuloCategoria', $data);
                  if ($db->getLastErrno() != 0){
                        $db->rollback();
                        ERRORdb($db->getLastErrno());
                        $db->disconnect();
                        exit(); }
            }
            if ($db->getLastErrno() != 0){
                  $db->rollback();
                  ERRORdb($db->getLastErrno());
                  $db->disconnect();
                  exit(); }
            else{
            $db->commit();
            $db->disconnect();
            $data = Array();
            $data['status'] = 200;
            $data['mensaje'] = "ARTICULO CREADO CON EXITO";
            JSON($data);}
      }

      public function modificarArticulo(){
            $post = json_decode(file_get_contents("php://input"));
            $categorias = $post->categorias;
            $post = $post->articulo;
            $db = DB();
            $db->startTransaction();
            $db->where('idArticulo',  $post->idArticulo)->delete('relArticuloCategoria');
            if ($db->getLastErrno() != 0){
                  $db->rollback();
                  ERRORdb($db->getLastErrno());
                  $db->disconnect();
                  exit(); }
            foreach($categorias as $categoria) {
                  if($categoria->idCategoria == 0){
                        $data = Array('nombre' => $categoria->nombre);
                        $categoria->idCategoria = $db->insert ('tblCategorias', $data);
                        if ($db->getLastErrno() != 0){
                              $db->rollback();
                              ERRORdb($db->getLastErrno());
                              $db->disconnect();
                              exit(); }
                  }
                  $data = Array('idCategoria' => $categoria->idCategoria, 'idArticulo' => $post->idArticulo);
                  $db->insert ('relArticuloCategoria', $data);
                  if ($db->getLastErrno() != 0){
                        $db->rollback();
                        ERRORdb($db->getLastErrno());
                        $db->disconnect();
                        exit(); }
            }
            $data = Array();
            if($post->nombre)
                  $data["nombre"] = $post->nombre;
            if($post->descripcion)
                  $data["descripcion"] = $post->descripcion;
            if($post->size)
                  $data["size"] = $post->size;
            if($post->marca)
                  $data["marca"] = $post->marca;
            if($post->modelo)
                  $data["modelo"] = $post->modelo;
            if($post->imagen)
                  $data["imagen"] = $post->imagen;  
            if($post->idProveedor)
                  $data["idProveedor"] = $post->idProveedor;
            if($post->precioCompra)
                  $data["precioCompra"] = $post->precioCompra;
            if($post->precioVenta)
                  $data["precioVenta"] = $post->precioVenta;
            if($post->stock)
                  $data["stock"] = $post->stock;
            if($post->estatus)
                  $data["estatus"] = $post->estatus;
            $db->where ('idArticulo',  $post->idArticulo)->update ('tblArticulos', $data);
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

      public function obtenerArticulosCategorias(){
            $db = DB();
            $articulos = $db->rawQuery("select a.idArticulo, a.nombre, a.descripcion, a.size, a.marca, a.modelo, a.imagen, p.nombre as proveedor, p.idProveedor, a.precioCompra, a.precioVenta, a.stock from tblArticulos as a CROSS JOIN tblProveedores as p WHERE a.idProveedor = p.idProveedor AND a.estatus = '1';");
            $data=Array();
            if ($db->getLastErrno() === 0){
                  $articulosAR = Array();
                  foreach ($articulos as $articulo) {
                        $categorias = $db->rawQuery('SELECT * FROM relArticuloCategoria ac INNER JOIN tblCategorias AS c ON c.idCategoria = ac.idCategoria WHERE ac.idArticulo = ?;',Array($articulo['idArticulo']));
                        if ($db->getLastErrno() != 0){
                              ERRORdb($db->getLastErrno());
                              $db->disconnect();
                              exit();}
                        $articulosAR[] = Array('articulo' => $articulo, 'categorias' => $categorias );
                  }
                  $data['status'] = 200;
                  $data['articulos'] = $articulosAR;
                  $data['mensaje'] = "ARTICULO MODIFICADO CON EXITO"; 
            }else {
                  $data['status'] = 500;
                  $data['error'] = $db->getLastError(); }
            $db->disconnect();
            JSON($data);
      }
      
      public function obtenerArticulos(){
            $db = DB();
            $articulos = $db->rawQuery("select a.idArticulo, a.nombre, a.descripcion, a.size, a.marca, a.modelo, a.imagen, p.nombre as proveedor, p.idProveedor, a.precioCompra, a.precioVenta, a.stock, a.estatus from tblArticulos as a CROSS JOIN tblProveedores as p WHERE a.idProveedor = p.idProveedor AND a.estatus = '1';");
            if ($db->getLastErrno() === 0){
                  $data['status'] = 200;
                  $data['articulos'] = $articulos;
                  if ($articulos){
                        $data['mensaje'] = "ARTICULOS OBTENIDOS CON EXITO"; }
                  else{
                        $data['mensaje'] = "NO SE ENCONTRARON ARTICULOS"; }}
            else {
                  $data['status'] = 500;
                  $data['error'] = $db->getLastError(); }
            $db->disconnect();
            JSON($data);
      }

      public function obtenerArticulo(){
            $db = DB();
            $articulo = $db->where("estatus",1)->where("idArticulo",getReq("idArticulo"))->getOne("tblArticulos");
            if ($db->getLastErrno() === 0){
                  $data['status'] = 200;
                  $data['articulo'] = $articulo;
                  if ($articulo){
                        $data['mensaje'] = "ARTICULO OBTENIDO CON EXITO"; }
                  else{
                        $data['mensaje'] = "NO SE ENCONTRO EL ARTICULO"; }}
            else {
                  $data['status'] = 500;
                  $data['error'] = $db->getLastError(); }
            $db->disconnect();
            JSON($data);
      }
     
      public function obtenerCategoriasArticulo(){
            $db = DB();
            $categorias = $db->rawQuery('SELECT * FROM relArticuloCategoria ac INNER JOIN tblCategorias AS c ON c.idCategoria = ac.idCategoria WHERE ac.idArticulo = ?;',Array(getReq('idArticulo')));
            if ($db->getLastErrno() === 0){
                  $data['status'] = 200;
                  $data['categorias'] = $categorias;
                  if ($categorias){
                        $data['mensaje'] = "CATEGORIAS OBTENIDAS CON EXITO"; }
                  else{
                        $data['mensaje'] = "NO SE ENCONTRO CATEGORIAS"; }}
            else {
                  $data['status'] = 500;
                  $data['error'] = $db->getLastError(); }
            $db->disconnect();
            JSON($data);
      }

}