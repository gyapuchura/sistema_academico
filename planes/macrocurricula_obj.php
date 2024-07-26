<?php include("../cabf.php");?>
<option value="0">Elegir MACROCURRÍCULA</option>
<?php
include("../inc.config.php");
$options="";

$idobjetivo_anual = $_POST["objetivo_anual"];

$sql2 = "SELECT idmacrocurricula, codigo, macrocurricula FROM macrocurricula WHERE idobjetivo_anual='$idobjetivo_anual' ORDER BY idmacrocurricula";
$result2 = mysqli_query($link,$sql2);
if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
    echo "<option value=". $row2[0]. ">".$row2[1]." - ".$row2[2]."</option>";
} while ($row2 = mysqli_fetch_array($result2));
} else {
echo "No se encontraron resultados!";
}
?>
