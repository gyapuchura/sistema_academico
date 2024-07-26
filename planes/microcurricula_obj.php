<?php include("../cabf.php");?>
<?php include("../inc.config.php");
$gestion       =  date("Y");
$idmacrocurricula = $_POST['macrocurricula'];
?>
</div>
<!-- desde aqui es la tabla dinamica de busqueda ---->
<div class="row">
<div class="col-md-12"></div>
</div>

<div class="table-responsive">
      <table class="table table-bordered" id="example" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Nª</th>
                    <th>CÓDIGO MICRO</th>
                    <th>TEMÁTICA DEL CURSO</th>
                    <th>CARGA HORARIA</th>
                    <th>PRE-REQUISITO</th>
                    <th>COSTO DEL CURSO</th>
                    <th>DETALLE</th>
                </tr>
            </thead>
			<tbody>
                
            <?php
            $numero=1;
            $sql =" SELECT microcurricula.idmicrocurricula, microcurricula.codigo, tematica.tematica, microcurricula.carga_horaria, ";
            $sql.=" microcurricula.pre_requisito, microcurricula.costo FROM microcurricula, tematica ";
            $sql.=" WHERE microcurricula.idtematica=tematica.idtematica AND microcurricula.idmacrocurricula='$idmacrocurricula' ORDER BY microcurricula.idmicrocurricula ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
            ?>
				<tr>
                <td><?php echo $numero;?></td>
				<td><?php echo $row[1];?></td>
                <td><?php echo $row[2];?></td>
				<td><?php echo $row[3];?></td>
                <td><?php 
                        $sqlu_p =" SELECT idtematica, tematica FROM tematica WHERE idtematica='$row[4]'";
                        $result_p = mysqli_query($link,$sqlu_p);
                        $row_p = mysqli_fetch_array($result_p);               
                          echo $row_p[1];?></td>
                <td><?php echo $row[5];?></td>
                <td>                                                
                <form name="VALIDA" action="valida_microcurricula_mod_o.php" method="post">
                <input name="idmicrocurricula" type="hidden" value="<?php echo $row[0];?>">
                <button type="submit" class="btn btn-primary">VER MICRO</button></form>
                </td>
                </tr>  
            <?php
            $numero=$numero+1;  
            }
            while ($row = mysqli_fetch_array($result));
            } else {
            }
            ?>
        </tbody>
    </table>
</div>


<div class="row">    
    <div class="col-lg-12"></div>
</div>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap.min.js"></script>
<script src="../js/script.js"></script>
<script>
$(document).ready(function() {
$('#example2').DataTable( {
    "lengthMenu": [[ 3, 5, 10, 25, 50, -1], [ 3, 5, 10, 25, 50, "All"]] ,
    "language": {
        "lengthMenu": "Mostrar _MENU_ registros por pagina",
        "zeroRecords": "No se encontraron resultados en su busqueda",
        "searchPlaceholder": "Buscar registros",
        "info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
        "infoEmpty": "No existen registros",
        "infoFiltered": "(filtrado de un total de _MAX_ registros)",
        "search": "Buscar:",
        "paginate": {
            "first":    "Primero",
            "last":    "Último",
            "next":    "Siguiente",
            "previous": "Anterior"
        },
    }
} );
} );
</script>  