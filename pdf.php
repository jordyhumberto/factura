<?php
ob_start();
session_start(); //Inicia una nueva sesión o reanuda la existente
require 'conexion.php'; //Agregamos el script de Conexión
if(!isset($_SESSION["id_usuario"])){
	header("Location: index.php");
}
$IDAlumno=$_GET['IDAlumno'];
$sqlA="SELECT CONCAT(Nombres,' ',Apellido_paterno,' ',Apellido_materno) AS nombre FROM Tbl_alumno WHERE IDAlumno='$IDAlumno'";
$resultA=$mysqli->query($sqlA);
$rowA=$resultA->fetch_array(MYSQLI_ASSOC);
$nombre=$rowA['nombre'];
$IDSemestre=$_GET['IDSemestre'];
$sql="SELECT cp.Fecha AS Fecha,cp.IDMatricula AS IDMatricula,cp.Nro_compromiso AS Nro_compromiso,cp.Pago AS Pago,cp.Estado AS Estado FROM ((Tbl_compromiso_pago AS cp INNER JOIN Tbl_matricula_carrera AS mc ON cp.IDMatricula=mc.IDMatricula)INNER JOIN Tbl_alumno AS a ON mc.IDAlumno=a.IDAlumno) WHERE a.IDAlumno='$IDAlumno' AND mc.IDSemestre='$IDSemestre'";
$result=$mysqli->query($sql);
$cont=0;
?>
<html><head>
<title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head><body>
  <div class="container">
  <table><tr><td><img style="width : 80px;" src="logo.png"></td><td><h3>UNIVERSIDAD PERUANA DE INVESTIGACIÓN Y NEGOCIOS S.A.C.</h3></td>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td><?php echo date('d/m/Y');?></td></tr></table>
  <h4><?php echo "&nbsp;&nbsp;Señor(a): ".$nombre;?></h4>            
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Fecha</th>
        <th>IDMatricula</th>
        <th>Nro_compromiso</th>
        <th>Tipo</th>
        <th>Estado</th>
        <th>Pago</th>
      </tr>
    </thead>
    <tbody>
    <?php while ($row=$result->fetch_array(MYSQLI_ASSOC)) {?>
        <tr>
            <td><?php echo $row['Fecha'];?></td>
            <td><?php echo $row['IDMatricula'];?></td>
            <td><?php echo $row['Nro_compromiso'];?></td>
            <td><?php switch ($row['Nro_compromiso']) {
                case 0:
                    echo "Matricula";
                    break;
                case 1:
                    echo "Primer pago";
                    break;
                case 2:
                    echo "Segundo pago";
                    break;
                case 3:
                    echo "Tercer pago";
                    break;
                case 4:
                    echo "Cuarto pago";
                    break;
                case 5:
                    echo "Quinto pago";
                    break;
            }?></td>
            <td><?php if ($row['Estado']=='01') {
                echo 'CANCELAR';
            }else {
                echo 'CANCELADO';
            };?></td>
            <td><?php echo $row['Pago'];$cont = $cont + $row['Pago'];?></td>
        </tr>
    <?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total S/.</td>
                <td><?php echo $cont;?></td>
            </tr>
    </tbody>
  </table>
</div>
</body></html>
<?php	
    $cadena="hola";
	//referenciar o DomPDF com namespace
	use Dompdf\Dompdf;

	// include autoloader
	require_once("dompdf/autoload.inc.php");

	//Criando a Instancia
	$dompdf = new DOMPDF();

	// Carrega seu HTML
    $dompdf->load_html(ob_get_clean());
	//Renderizar o html
	$dompdf->render();

	//Exibibir a página
	$dompdf->stream(
		"factura.pdf", 
		array(
			"Attachment" => false //Para realizar o download somente alterar para true
		)
	);
?>