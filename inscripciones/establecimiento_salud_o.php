<?php include("../cabf_o.php");?>
<?php
include("../inc.config.php");
$idred_salud = $_POST["red_salud"];?>
<option value="">MUNICIPIO - ESTABLECIMIENTO DE SALUD</option>
<?php
$numero = 1;
$sql2 = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.codigo_establecimiento, establecimiento_salud.establecimiento_salud, ";
$sql2.= " municipios.municipio FROM establecimiento_salud, municipios WHERE establecimiento_salud.idmunicipio=municipios.idmunicipio AND ";
$sql2.= " establecimiento_salud.idred_salud='$idred_salud' ORDER BY municipios.municipio ";
$result2 = mysqli_query($link,$sql2);
if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
echo "<option value=".$row2[0]."> ".$numero.".- Mun. ". $row2[3]." - Establecimiento: ".$row2[2]." </option>";
$numero = $numero+1;
} while ($row2 = mysqli_fetch_array($result2));
} else {
echo "No se encontraron resultados!";
}
?>
