<?php include("../cabf.php");?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Cursos</title>
</head>

<body>
<option value="">Elegir MACROCURRICULA</option>
<?php
include("../inc.config.php");
$options="";
$idobjetivo_anual = $_POST["objetivo_anual"];
/*
Realizamos una consulta ala tabla autor
para mostrar los datos en un combo
*/

$sql = " SELECT idmacrocurricula, codigo, macrocurricula FROM macrocurricula WHERE idobjetivo_anual = '$idobjetivo_anual' ";
$result = mysqli_query($link,$sql);
if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
echo "<option value=". $row[0]. "> ". $row[1].".- ". $row[2]." </option>";
} while ($row = mysqli_fetch_array($result));
} else {
echo "No se encontraron resultados!";
}
?>
</body>
</html>