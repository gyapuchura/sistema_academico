<?php include("../cabf.php");?>
<?php include("../inc.config.php");

      $b = $_POST['b'];

      if ($b == '' || $b == ' ') {
            echo "No se han escrito el nombre del municipio.";
      } else {
            $numero=1;
            $sql =" SELECT municipios.iddepartamento, municipios.idprovincia, municipios.idmunicipio, municipios.municipio, ";
            $sql.=" departamento.departamento FROM municipios, departamento WHERE municipios.iddepartamento=departamento.iddepartamento ";
            $sql.=" AND municipios.municipio LIKE '%$b%' ";
            $result = mysqli_query($link,$sql);

            $contar = mysqli_num_rows($result);

            if($contar == 0){
                  echo "No se han encontrado resultados para '<b>".$b."</b>'.";
            }else{
                  while($row = mysqli_fetch_array($result)){
                        $iddepartamento = $row[0];
                        $idprovincia    = $row[1];
                        $idmunicipio    = $row[2];
                        $departamento   = $row[4];
                        $municipio      = mb_strtoupper($row[3]);


                        echo $numero.".- ".$municipio." - ".$departamento." - ";
                        echo "<input name='idmunicipio' type='radio' value=".$idmunicipio." required>";	
                        echo "<input name='idprovincia' type='hidden' value=".$idprovincia.">";	
                        echo "<input name='iddepartamento' type='hidden' value=".$iddepartamento.">";	                        
                        echo "</br>"; 
                        
                        $numero = $numero+1;
                  }
            }
      
      }
?>