<?php include("../inc.config.php");?>
<?php
$gestion       =  date("Y");

$idobjetivo_anual = $_POST['objetivo_anual'];

?>

</div>
<!-- desde aqui es la tabla dinamica de busqueda ---->
<div class="row">
<div class="col-md-12"></div>
</div>

<div class="table-responsive">
<table id="example2" class="table table-striped table-bordered table-hover" cellspacing="1" width="100%">
            <thead>
            <th>Nª</th>
            <th>CÓDIGO MACROCURRICULA</th>
            <th>DENOMINACIÓN DE LA MACROCURRICULA</th>
            <th>AMBITO</th>
            <th>VER DETALLE</th>
            </thead>
            <tbody>

    <?php
    $numero=1;
    $sql =" SELECT macrocurricula.idmacrocurricula, macrocurricula.macrocurricula, ambito.ambito, ";
    $sql.=" macrocurricula.codigo, macrocurricula.correlativo, macrocurricula.idusuario FROM macrocurricula, ambito, objetivo_anual ";
    $sql.=" WHERE objetivo_anual.idobjetivo_anual=macrocurricula.idobjetivo_anual AND macrocurricula.idambito=ambito.idambito AND objetivo_anual.idobjetivo_anual='$idobjetivo_anual' ORDER BY macrocurricula.idmacrocurricula ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);
    while ($field = mysqli_fetch_field($result)){
    } do {
            ?>
       			<tr>
                <td><?php echo $numero;?></td>
				<td><?php echo $row[3];?></td>
                <td><?php echo $row[1];?></td>
				<td><?php echo $row[2];?></td>
                <td>                                                
                <form name="VALIDA" action="valida_macrocurricula_mod_o.php" method="post">
                <input name="idmacrocurricula" type="hidden" value="<?php echo $row[0];?>">
                <button type="submit" class="btn btn-primary">VER MACRO</button></form>
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