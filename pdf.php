<?php
ob_start();
session_start(); //Inicia una nueva sesión o reanuda la existente
require 'conexion.php'; //Agregamos el script de Conexión
if(!isset($_SESSION["id_usuario"])){
	header("Location: index.php");
}
$IDAlumno=$_GET['IDAlumno'];
$sqlA="SELECT CONCAT(Nombres,' ',Apellido_paterno,' ',Apellido_materno) AS nombre,IDAlumno as IDA FROM Tbl_alumno WHERE IDAlumno='$IDAlumno'";
$resultA=$mysqli->query($sqlA);
$rowA=$resultA->fetch_array(MYSQLI_ASSOC);
$nombre=$rowA['nombre'];
$IDA=$rowA['IDA'];
$IDMatricula=$_GET['IDMatricula'];
$Nro_compromiso=$_GET['Nro_compromiso'];
$sql="SELECT cp.Fecha AS Fecha,cp.IDMatricula AS IDMatricula,cp.Nro_compromiso AS Nro_compromiso,cp.Pago AS Pago,cp.Estado AS Estado FROM ((Tbl_compromiso_pago AS cp INNER JOIN Tbl_matricula_carrera AS mc ON cp.IDMatricula=mc.IDMatricula)INNER JOIN Tbl_alumno AS a ON mc.IDAlumno=a.IDAlumno) WHERE cp.IDMatricula='$IDMatricula' AND cp.Nro_compromiso='$Nro_compromiso'";
$result=$mysqli->query($sql);
$row=$result->fetch_array(MYSQLI_ASSOC);
$codigo=$row['IDMatricula'].$row['Nro_compromiso'];
?>
<html><head>
<title>Upein</title>
    <link href="img/favicon.ico" rel="shortcut icon" type="image/x-icon">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head><body>
  <div class="container">
  <table>
  <tr><td><img style="width : 80px;" src="logo.png"></td>
  <td>
  <table><tr><td><h5>UNIVERSIDAD PERUANA DE INVESTIGACIÓN Y NEGOCIOS S.A.C.</h5></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><?php echo date('d-m-Y');?></td></tr>
  <tr><td><p>Av. Salaverry 1810 Jesús María - Lima</p></td><td></td><td><?php echo "N°.".$codigo;?></td></tr></table>
  </tr>
  </table><br>
  <h5><?php echo "&nbsp;&nbsp;Señor(a): ".$nombre;?></h5>  
  <h6><?php echo "&nbsp;&nbsp;Codigo: ".$IDA;?></h6>          
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Fecha</th>
        <th>IDMatricula</th>
        <th>Nro_compromiso</th>
        <th>Tipo</th>
        <th>Pago</th>
      </tr>
    </thead>
    <tbody>
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
            <td><?php echo $row['Pago'];?></td>
        </tr>
    </tbody>
  </table>
</div>
</body></html>
<?php	
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