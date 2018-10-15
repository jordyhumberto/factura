<?php
session_start(); //Inicia una nueva sesión o reanuda la existente
require 'conexion.php'; //Agregamos el script de Conexión
if(!isset($_SESSION["id_usuario"])){
	header("Location: index.php");
}
$IDAlumno=$_GET['IDAlumno'];
$IDSemestre=$_GET['IDSemestre'];
$sql="SELECT cp.Fecha AS Fecha,cp.IDMatricula AS IDMatricula,cp.Nro_compromiso AS Nro_compromiso,cp.Pago AS Pago,cp.Estado AS Estado FROM ((Tbl_compromiso_pago AS cp INNER JOIN Tbl_matricula_carrera AS mc ON cp.IDMatricula=mc.IDMatricula)INNER JOIN Tbl_alumno AS a ON mc.IDAlumno=a.IDAlumno) WHERE a.IDAlumno='$IDAlumno' AND mc.IDSemestre='$IDSemestre'";
$result=$mysqli->query($sql);
$cont=0;
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
        <div style="display:flex;justify-content:flex-end;"><a href="semestre.php?IDAlumno=<?php echo $IDAlumno;?>" class="btn btn-danger">Regresar</a></div><br>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>IDMatricula</th>
                <th>Nro_compromiso</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Pago</th>
                <th>Recibo</th>
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
                    <td>
                        <?php if ($row['Estado']=='01') {?>
                            <a href="pdf.php?IDMatricula=<?php echo $row['IDMatricula'];?>&Nro_compromiso=<?php echo $row['Nro_compromiso'];?>&IDAlumno=<?php echo $IDAlumno;?>" class="btn btn-success"><span class="glyphicon glyphicon-shopping-cart"></span></a>
                        <?php }else{?>
                            <a href="#" class="btn btn-info"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                        <?php } ?>
                    </td>
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
</body>
</html>