<?php  
	$directorio = 'archivos';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Subida de archivos a Drive</title>
</head>
<body>
	<h1>Subir un archivo a Drive</h1>
	<form method="post" action="upload.php" enctype="multipart/form-data"> 
		<input type="file" name="upload">
		<input type="submit" value="Enviar">
	</form> 
	<div>
		<h1>Archivos existentes en el directorio</h1>
		<?php 
			if($dir = opendir($directorio)){
				while ($archivo = readdir($dir)) {
					if ($archivo != '.' && $archivo != '..') 
					echo "Archivo: <strong>$archivo</strong><br/>";
				}
			}
		?>
	</div>
</body>
</html>

