<?php
include_once 'google-api-php-client-2.2.4/vendor/autoload.php';

//configurar variable de entorno
putenv('GOOGLE_APPLICATION_CREDENTIALS=credenciales.json');

$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->setScopes(['https://www.googleapis.com/auth/drive.file']);
try{
//instanciamos el servicio
$service = new Google_Service_Drive($client);
	
	$nombre=$_FILES['upload']['name'];
	$guardado=$_FILES['upload']['tmp_name'];

	if(!file_exists('archivos')){
		mkdir('archivos',0777,true);
		if(move_uploaded_file($guardado, 'archivos/'.$nombre)){
			echo "Archivo guardado con exito";
		}else{
			echo "El archivo no se pudo guardar";
		}
	}else{
		if(move_uploaded_file($guardado, 'archivos/'.$nombre)){
			echo "Archivo guardado con exito";
		}else{
			echo "El archivo no se pudo guardar";
		}
	}


$file_path = 'archivos/'.$nombre;

//instacia de archivo
$file = new Google_Service_Drive_DriveFile();
$file->setName($nombre);

//obtenemos el mime type
$finfo = finfo_open(FILEINFO_MIME_TYPE); 
$mime_type=finfo_file($finfo, $file_path);

//id de la carpeta donde hemos dado el permiso a la cuenta de servicio 
$file->setParents(array("1tj22PQZdpfuFOBAPIG_C3SK_7khjpCjG"));
$file->setDescription('archivo subido desde php');
$file->setMimeType($mime_type);

$result = $service->files->create(
  $file,
  array(
    'data' => file_get_contents($file_path),
    'mimeType' => $mime_type,
    'uploadType' => 'media',
  )
);

echo '<a href="https://drive.google.com/open?id='.$result->id.'" target="_blank">'.$result->name.'</a>';

}catch(Google_Service_Exception $gs){
 
  $m=json_decode($gs->getMessage());
  echo $m->error->message;

}catch(Exception $e){
    echo $e->getMessage();
  
}
?>