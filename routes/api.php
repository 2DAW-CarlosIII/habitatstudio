<?php

use App\Http\Controllers\Api\TestimonioController;
use Illuminate\Routing\Route;

Route::get('/v1/testimonios',[TestimonioController::class,'index']);



# Desarrollo Web en Entorno Servidor - Segunda convocatoria 7


/* Crea un  TestimonioResource  que exponga:  id ,  contenido ,  valoracion ,  fecha_aprobacion , el
name  y  avatar_url  del usuario, y —si existe— el  nombre_casa  de la casa referenciada.
Implementa el endpoint público (sin autenticación):
que devuelva una colección de  TestimonioResource  con todos los testimonios que tengan
fecha_aprobacion  no nula, ordenados por  fecha_aprobacion  descendente.
C2 — Testimonios de una casa  (1 pto.)
Implementa el endpoint público:
GET /testimonios/{testimonio}/revisar
•
•
•
GET /api/v1/testimonios
GET /api/v1/casas/{casa}/testimonios
# Desarrollo Web en Entorno Servidor - Segunda convocatoria 7
 */
