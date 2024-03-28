<?php
// Šeit jābūt kodam, kas izgūst rezervētos datumus no datubāzes vai cita avota
// Piemēra labad, šeit ir statiski definēti rezervētie datumi
$reserved_dates = [
    ["title" => "Reserved", "start" => "2024-03-05", "color" => "red"],
    ["title" => "Reserved", "start" => "2024-03-15", "color" => "red"],
    // Jūs jāaizstāj šie dati ar dinamiski iegūtiem rezervētajiem datumiem
];

header('Content-Type: application/json');
echo json_encode($reserved_dates);
?>
