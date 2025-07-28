<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha 		   = date("Y-m-d");
$gestion       = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];


$tematica = $link->real_escape_string($_POST['tematica']);
$descripcion = $link->real_escape_string($_POST['descripcion']);

$file_name = $_FILES['file']['name'];

$directorio = '../img/';
//compruebo si las características del archivo son las que deseo
        if ($file_name != '' || $file_name != null) {

                    $subir_archivo = $directorio.basename($file_name);

                if (move_uploaded_file($_FILES['file']['tmp_name'],$subir_archivo)) {

					$sql7 =" INSERT INTO tematica (tematica, descripcion, url, idusuario) ";
					$sql7.=" VALUES ('$tematica','$descripcion','$subir_archivo','$idusuario_ss') ";
					$result7 = mysqli_query($link,$sql7);

                    header("Location:tematicas.php");
      
                    } else {
                    
                    header("Location:nueva_tematica.php");

                    }
                }
        else
            {
                /******* En caso de modificar sin adjuntar o cambiar el archivo adjunnto ******/
                header("Location:nueva_tematica.php");        
            }  






if (!((strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "jpeg")) && ($tamano_archivo < 100000))) {
   	echo "La extensión o el tamaño de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .gif o .jpg<br><li>se permiten archivos de 100 Kb máximo.</td></tr></table>";
}else{
   	if (move_uploaded_file($_FILES['userfile']['tmp_name'], 'img/'.$nombre_archivo)){




        header("Location:tematicas.php");


   	}else{
      		echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
   	}
}














        

?>