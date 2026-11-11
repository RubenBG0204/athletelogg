<?php
declare(strict_types=1);

//Constantes globales: se definen aquípara cambiarlas en un solo sitio
const APP_NAME = 'AthleteLog';
const STUDENT_NAME = 'Rubén Barrutia Grasa';

// Las cookies duran 30 días (en segundos).
const COOKIE_LIFETIME = 60 * 60 * 24 * 30;

// Cookies de preferencias. Están en una lista para poder borrarlas todas con un foreach.
const PREFERENCE_COOKIES = ['theme', 'weight_unit', 'tips'];