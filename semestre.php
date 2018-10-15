<?php
session_start(); //Inicia una nueva sesión o reanuda la existente
require 'conexion.php'; //Agregamos el script de Conexión
if(!isset($_SESSION["id_usuario"])){
	header("Location: index.php");
}
$id=$_SESSION["id_usuario"];
$sql="SELECT * FROM Tbl_usuario_alumno WHERE IdUA='$id'";
$result=$mysqli->query($sql);
$row=$result->fetch_array(MYSQLI_ASSOC);
$IDAlumno=$row['IDAlumno'];
$sqlS="SELECT * FROM Tbl_semestre";
$resultS=$mysqli->query($sqlS);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upein</title>
    <link href="img/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">	
	<script src="js/jquery.dataTables.min.js"></script>
    <script>
		$(document).ready(function(){
			$('#mitabla').DataTable({
				"order": [[0, "desc"]],
				"language":{
					"lengthMenu": "Mostrar _MENU_ registros por pagina",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtrada de _MAX_ registros)",
					"loadingRecords": "Cargando...",
					"processing":     "Procesando...",
					"search": "Buscar:",
					"zeroRecords":    "No se encontraron registros coincidentes",
					"paginate": {
						"next":       "Siguiente",
						"previous":   "Anterior"
					},					
				}
			});	
		});	
	</script>
</head>
<body>
    <div class="container"><br>
        <div style="display:flex;justify-content:flex-end;"><a href="logout.php" class="btn btn-danger">Logout</a></div><br>
        <table class="table table-hover" id="mitabla">
            <thead>
                <tr>
                    <th>IDSemestre</th>
                    <th>Descripcion</th>
                    <th>Fecha_Inicio</th>
                    <th>Fecha_Fin</th>
                    <th>Detalle</th>
                    <th>Ver Pagos</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($rowS=$resultS->fetch_array(MYSQLI_ASSOC)) {?>
                <tr>
                    <td><?php echo $IDS=$rowS['IDSemestre'];?></td>
                    <td><?php echo $rowS['Descripcion'];?></td>
                    <td><?php echo $rowS['Fecha_Inicio'];?></td>
                    <td><?php echo $rowS['Fecha_Fin'];?></td>
                    <td><?php echo $rowS['Detalle'];?></td>
                    <td><a href="pago.php?IDSemestre=<?php echo $IDS;?>&IDAlumno=<?php echo $IDAlumno;?>" class="btn btn-success"><span class="glyphicon glyphicon-eye-open"></span> ver</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>