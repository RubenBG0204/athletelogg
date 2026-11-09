<?php
declare(strict_types=1);

// Datos maestros de la aplicación. Más adelante podrían venir de una base de datos,
// pero ahora viven en arrays para practicar con ellos.

// Clave = identificador interno; valor = datos del deporte.
$sports = [
    'running'    => ['name' => 'Running',     'category' => 'individual', 'unit' => 'km'],
    'swimming'   => ['name' => 'Natación',    'category' => 'individual', 'unit' => 'metros'],
    'weightlift' => ['name' => 'Halterofilia','category' => 'individual', 'unit' => 'kg'],
    'cycling'    => ['name' => 'Ciclismo',    'category' => 'individual', 'unit' => 'km'],
    'football'   => ['name' => 'Fútbol',      'category' => 'equipo',     'unit' => 'minutos'],
    'basketball' => ['name' => 'Baloncesto',  'category' => 'equipo',     'unit' => 'minutos'],
    'volleyball' => ['name' => 'Voleibol',    'category' => 'equipo',     'unit' => 'minutos'],
];

$levels = [
    'beginner' => 'Iniciación',
    'regional' => 'Regional',
    'national' => 'Nacional',
];

// Los usuarios guardan el hash de la contraseña, nunca la contraseña en texto plano.
$users = [
    'ana_runner' => [
        'name'          => 'Ana García',
        'password_hash' => '$2y$10$k7pCxrC8C4lv.xhleLT/kOxixySt0Tjva8W82nGMkZAERfpaQj2Vu',
        'sport'         => 'running',
    ],
    'marc_swim' => [
        'name'          => 'Marc Puig',
        'password_hash' => '$2y$10$NER5BEt8lu2YpUmJ/Egw7u/2z30eok.vykIv0.uf/xUk/R.1ak45i',
        'sport'         => 'swimming',
    ],
    'laura_ball' => [
        'name'          => 'Laura Soler',
        'password_hash' => '$2y$10$iD1srzKh3N8OB92mtiwLLOuOcITZKoKH9fcV1/4lovHx0Vg7iDH7G',
        'sport'         => 'basketball',
    ],
];

// Días de entrenamiento: clave = valor que viaja en el formulario.
$weekDays = [
    'monday'    => 'Lunes',
    'tuesday'   => 'Martes',
    'wednesday' => 'Miércoles',
    'thursday'  => 'Jueves',
    'friday'    => 'Viernes',
    'saturday'  => 'Sábado',
    'sunday'    => 'Domingo',
];