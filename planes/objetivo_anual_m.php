<option value="0">Elegir OBJETIVO ANUAL</option>
<?php
include("../inc.config.php");
$options="";

$idplan_anual = $_POST["plan_anual"];

$sql2 = "SELECT idobjetivo_anual, codigo, objetivo_anual FROM objetivo_anual WHERE idplan_anual='$idplan_anual' ORDER BY idobjetivo_anual";
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
