<?php
$namesrc = $_REQUEST['namesrc'];
if( $namesrc !== ""){
    $namesrc = strtolower($namesrc);
    $len = strlen($namesrc);
    for ($c = 0; $c < $dCounter; $c++) {
        if(stristr($namesrc, substr($depsList[$c]['nome'], 0, $len))){
?>

    <table class="single-td dep-list-single-td" data-dep-id="<?php echo $depsList[$c]['id']; ?>" data-dep-name="<?php echo $depsList[$c]['nome']; ?>" data-emp-id="<?php echo $_REQUEST['empId']; ?>" data-emp-name="<?php echo $_REQUEST['empName']; ?>">
        <tr>
            <td><?php echo $depsList[$c]['id']; ?></td>
            <td><?php echo $depsList[$c]['nome']; ?></td>
            <td><?php echo $depsList[$c]['cpf']; ?></td>
        </tr>
    </table>

<?php
        }
    }
}
?>
<script>
    /**
     * Confirmação para adicionar dependente cadastrado
     */
    $("table.dep-list-single-td").click(function(){
        var el = $(this);
        var confirmMsg;
        var confirmAdd = confirm("Adicionar dependente " + el.data("depName") +
        " ao funcionário " + el.data("empName") + "?");
        if(confirmAdd == true){
            confirmMsg = "Funcionário adicionado com sucesso";
            window.location.replace("http://localhost/Lti/addDependent/"+el.data("empId")+"/"+el.data("depId"));
        }
    });
</script>