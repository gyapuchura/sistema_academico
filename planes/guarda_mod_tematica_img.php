<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha 		   = date("Y-m-d");
$gestion       = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idtematica_ss =  $_SESSION['idtematica_ss'];

$file_name = $_FILES['file']['name'];

$directorio = '../img/';


    if ($file_name != '' || $file_name != null) {

                    $subir_archivo = $directorio.basename($file_name);

                if (move_uploaded_file($_FILES['file']['tmp_name'],$subir_archivo)) {

                    $sql8 = " UPDATE tematica SET url ='$subir_archivo', idusuario='$idusuario_ss' ";
                    $sql8.= " WHERE idtematica ='$idtematica_ss' ";
                    $result8 = mysqli_query($link,$sql8);

                    header("Location:mostrar_tematica.php");
      
                    } else {
                    
                    header("Location:mostrar_tematica.php");

                    }
                }
        else
            {
                /******* En caso de modificar sin adjuntar o cambiar el archivo adjunnto ******/
                header("Location:mostrar_tematica.php");        
            }  
?>