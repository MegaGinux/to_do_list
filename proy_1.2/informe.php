<?php
session_start();
$dir = dirname(__FILE__);
require_once $dir."/conexion.php";
require('C:\wamp64\www\proy_1.1\fpdf186\fpdf.php');

$link = conectarse();

$usuario_id = $_SESSION["cc"]; // ID del usuario
$sql = "select t.titulo, t.contenido, t.fecha_inicio, t.hora_inicio, t.fecha_fin, t.hora_terminada,
        t.tiempo,c.catgoria,p.prioridad
        from tarea t,categoria c, prioridad p
        where t.prioridad_id = p.id
        and t.terminada = 1
        and t.categoria_id = c.id
        and usuario_id = ?";

$query_todas = "select count(id) as numero_todas 
                from tarea 
                where usuario_id = ?";

$query_existentes = "select count(id) as numero_existentes 
                    from tarea 
                    where fecha_inicio >= curdate() 
                    and terminada = 0 
                    and eliminada = 0 
                    and activa = 0
                    and usuario_id = ?";

$query_activas = "select count(id) as numero_activas 
                from tarea 
                where activa = 1 
                and terminada = 0 
                and eliminada = 0 
and usuario_id = ?";

$query_terminadas = "select count(id) as numero_terminados 
                from tarea 
                where terminada = 1 
                and usuario_id = ?";

$query_vencidas = "select count(id) as numero_vencidas 
                from tarea 
                where fecha_inicio < curdate() 
                and terminada = 0 
                and activa = 0 
                and eliminada = 0 
                and usuario_id = ?";

$query_borradas = "select count(id) as numero_borradas 
                from tarea 
                where eliminada = 1 
                and usuario_id = ?";

$query_fh_actual = "select now() as fh_actual";

$query_tiempo = "select SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo))) as total_tiempo
                from tarea
                where terminada = 1
                and usuario_id = ?;";

$stmt = $link->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$stmt_todas = $link->prepare($query_todas);
$stmt_todas->bind_param("i", $usuario_id);
$stmt_todas->execute();
$result_todas = $stmt_todas->get_result();
$row_todas = $result_todas->fetch_assoc();

$stmt_existentes = $link->prepare($query_existentes);
$stmt_existentes->bind_param("i", $usuario_id);
$stmt_existentes->execute();
$result_existentes = $stmt_existentes->get_result();
$row_existentes = $result_existentes->fetch_assoc();

$stmt_activas = $link->prepare($query_activas);
$stmt_activas->bind_param("i", $usuario_id);
$stmt_activas->execute();
$result_activas = $stmt_activas->get_result();
$row_activas = $result_activas->fetch_assoc();

$stmt_terminadas = $link->prepare($query_terminadas);
$stmt_terminadas->bind_param("i", $usuario_id);
$stmt_terminadas->execute();
$result_terminadas = $stmt_terminadas->get_result();
$row_terminadas = $result_terminadas->fetch_assoc();

$stmt_vencidas = $link->prepare($query_vencidas);
$stmt_vencidas->bind_param("i", $usuario_id);
$stmt_vencidas->execute();
$result_vencidas = $stmt_vencidas->get_result();
$row_vencidas = $result_vencidas->fetch_assoc();

$stmt_borradas = $link->prepare($query_borradas);
$stmt_borradas->bind_param("i", $usuario_id);
$stmt_borradas->execute();
$result_borradas = $stmt_borradas->get_result();
$row_borradas = $result_borradas->fetch_assoc();

$stmt_fh = $link->prepare($query_fh_actual);
$stmt_fh->execute();
$result_fh = $stmt_fh->get_result();
$row_fh = $result_fh->fetch_assoc();

$stmt_t = $link->prepare($query_tiempo);
$stmt_t->bind_param("i", $usuario_id);
$stmt_t->execute();
$result_t = $stmt_t->get_result();
$row_t = $result_t->fetch_assoc();

$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(0, 10, 'Tareas Terminadas', 0, 1, 'C');


$tableWidth = 20 + 50 + 25 + 25 + 25 + 25 + 20 + 20 + 20;
$x = ($pdf->GetPageWidth() - $tableWidth) / 2;
$pdf->SetX($x);

$pdf->Cell(20, 10, 'Titulo', 1, 0, 'C');
$pdf->Cell(50, 10, 'Contenido', 1, 0, 'C');
$pdf->Cell(25, 10, 'Fecha Inicio', 1, 0, 'C');
$pdf->Cell(25, 10, 'Hora Inicio', 1, 0, 'C');
$pdf->Cell(25, 10, 'Fecha Fin', 1, 0, 'C');
$pdf->Cell(25, 10, 'Hora Fin', 1, 0, 'C');
$pdf->Cell(20, 10, 'Tiempo', 1, 0, 'C');
$pdf->Cell(20, 10, 'Prioridad', 1, 0, 'C');
$pdf->Cell(20, 10, 'Categoria', 1, 1, 'C');

while ($row = $result->fetch_assoc()) {

    $pdf->SetX($x);

    $pdf->Cell(20, 10, $row['titulo'], 1, 0, 'L');
    $pdf->Cell(50, 10, $row['contenido'], 1, 0, 'L');
    $pdf->Cell(25, 10, $row['fecha_inicio'], 1, 0, 'C');
    $pdf->Cell(25, 10, $row['hora_inicio'], 1, 0, 'C');
    $pdf->Cell(25, 10, $row['fecha_fin'], 1, 0, 'C');
    $pdf->Cell(25, 10, $row['hora_terminada'], 1, 0, 'C');
    $pdf->Cell(20, 10, $row['tiempo'], 1, 0, 'C');
    $pdf->Cell(20, 10, $row['prioridad'], 1, 0, 'C');
    $pdf->Cell(20, 10, $row['catgoria'], 1, 1, 'C');
}

$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(0, 10, 'Informe', 0, 1, 'C');
$pdf->Cell(0, 10, $row_fh['fh_actual'], 0, 1, 'C');
$headerY = $pdf->GetY(); 

$tableWidth = 100;
$tableHeight = 7 * 10; 

$pageWidth = $pdf->GetPageWidth();
$pageHeight = $pdf->GetPageHeight();

$x = ($pageWidth - $tableWidth) / 2;

$y = ($pageHeight - $headerY - $tableHeight) / 2 + $headerY;

$pdf->SetXY($x, $y); 
$pdf->Cell(50, 10, 'Todas', 1, 0, 'C');
$pdf->Cell(50, 10, $row_todas['numero_todas'], 1, 1, 'C');

$pdf->SetX($x); // Reinicia la posición X para las siguientes celdas
$pdf->Cell(50, 10, 'Sin activar', 1, 0, 'C');
$pdf->Cell(50, 10, $row_existentes['numero_existentes'], 1, 1, 'C');

$pdf->SetX($x);
$pdf->Cell(50, 10, 'Activas', 1, 0, 'C');
$pdf->Cell(50, 10, $row_activas['numero_activas'], 1, 1, 'C');

$pdf->SetX($x);
$pdf->Cell(50, 10, 'Terminadas', 1, 0, 'C');
$pdf->Cell(50, 10, $row_terminadas['numero_terminados'], 1, 1, 'C');

$pdf->SetX($x);
$pdf->Cell(50, 10, 'Tiempo', 1, 0, 'C');
$pdf->Cell(50, 10, $row_t['total_tiempo'], 1, 1, 'C');

$pdf->SetX($x);
$pdf->Cell(50, 10, 'Vencidas', 1, 0, 'C');
$pdf->Cell(50, 10, $row_vencidas['numero_vencidas'], 1, 1, 'C');

$pdf->SetX($x);
$pdf->Cell(50, 10, 'Borradas', 1, 0, 'C');
$pdf->Cell(50, 10, $row_borradas['numero_borradas'], 1, 1, 'C');

$pdf->Output();

?>
