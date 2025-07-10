<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'MapController::index');
$routes->post('/peta/update', 'MapController::UpdateStatus');

$routes->get('/pelaporan', 'ReportController::index');
$routes->post('/pelaporan/laporan-baru', 'ReportController::LaporanBaru');