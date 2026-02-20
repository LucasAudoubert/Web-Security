<?php

require_once __DIR__ . '/../../model/plant_model.php';
$pdo = connectDB();

$plants = getAllPlants($pdo);