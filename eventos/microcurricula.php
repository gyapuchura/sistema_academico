
<?php include("../cabf.php");?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Microcurricula</title>
</head>

<body>
<option value="">Elegir CURSO (MICROCURRICULA)</option>
<?php
include("../inc.config.php");
$options="";
$idmacrocurricula = $_POST["macrocurricula"];
/*
Realizamos una consulta ala tabla autor
para mostrar los datos en un combo
*/
$sql = " SELECT microcurricula.idmicrocurricula, microcurricula.codigo, tematica.tematica, nivel_curricular.nivel_curricular FROM microcurricula, tematica, nivel_curricular ";
$sql.= " WHERE microcurricula.idtematica=tematica.idtematica AND microcurricula.idnivel_curricular=nivel_curricular.idnivel_curricular AND microcurricula.idmacrocurricula = '$idmacrocurricula' ";
$result = mysqli_query($link,$sql);
if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
echo "<option value=". $row[0]. "> ". $row[1].".- ". $row[2]." - ". $row[3]."</option>";
} while ($row = mysqli_fetch_array($result));
} else {
echo "No se encontraron resultados!";
}
?>
</body>
</html>