<?php
//Alumo - Matrias
Router::get('insertAlumno','Alumno', 'insertAlumno');
Router::get('updateAlumno','Alumno', 'updateAlumno');
Router::get('selectAlumno','Alumno', 'selectAlumno');
Router::get('selectGeneracion','Alumno', 'selectGeneracion');

Router::get('insertFac','Facultad', 'insertFac');
Router::get('updateFac','Facultad', 'updateFac');
Router::get('selectFac','Facultad', 'selectFac');

Router::get('insertCarrera','Carrera', 'insertCarrera');
Router::get('updateCarrera','Carrera', 'updateCarrera');
Router::get('selectCarrera','Carrera', 'selectCarrera');


Router::get('insertMateria','PlanE', 'insertMateria');
Router::get('updateMateria','PlanE', 'updateMateria');
Router::get('selectMateria','PlanE', 'selectMateria');
Router::get('selectOneMateria','PlanE', 'selectOneMateria');
Router::get('selectMateriaGen','PlanE', 'selectMateriaGen'); 
Router::get('selectMateriaMat','PlanE', 'selectMateriaMat'); 
Router::get('selectPlan','PlanE', 'selectPlan');
Router::get('selectPlanpdf','PlanE', 'selectPlanpdf');
Router::get('selectPlanCargar','PlanE', 'selectPlanCargar');
Router::get('selectPlanxcar','PlanE', 'selectPlanxcar');



Router::get('obtenerCatalogo','Catalogo', 'obtenerCatalogo');
Router::get('obtenerTodosCatalogos','Catalogo', 'obtenerTodosCatalogos');
Router::get('obtenerCatalogos','Catalogo', 'obtenerCatalogos');
Router::get('modificarCatalogo','Catalogo', 'modificarCatalogo');
Router::get('agregarArticulo','Catalogo', 'agregarArticulo');
Router::get('quitarArticulo','Catalogo', 'quitarArticulo');

