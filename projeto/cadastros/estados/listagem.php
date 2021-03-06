<?php
    if (isset($_GET['id']))
        $id = $_GET['id'];
 
    try {
        if (isset($id)) {
            $stmt = $conn->prepare('SELECT * FROM estados WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        } else {
            $stmt = $conn->prepare('SELECT * FROM estados');
        }
        //$stmt->execute(array('id' => $id));
        $stmt->execute();
   
        //while($row = $stmt->fetch()) {
        //while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
            //print_r($row);
        //}
 
        $result = $stmt->fetchAll();

        $iQuantidadeRegistros = count($result);
        $iTotalPaginas = ceil($iQuantidadeRegistros / NUM_REG_POR_PAGINA);
        $iControleRegistros = $iQuantidadeRegistros;

        for ($i = 1; $i <= $iTotalPaginas; $i++) {
            $aRegistrosPagina[$i] = [];
            $iNumerosRegistrosPorPag = NUM_REG_POR_PAGINA <= $iControleRegistros ? NUM_REG_POR_PAGINA :  $iControleRegistros;

            $iCount = 1;

            while ($iCount <= $iNumerosRegistrosPorPag) {
                array_push($aRegistrosPagina[$i], array_shift($result));
                $iCount++;
                $iControleRegistros--;
            }

            $iCount = 1;
        }
?>
<table border="1" class="table table-striped">
<tr>
            <td>Id</td>
            <td>Nome</td>
            <td>UF</td>
            <td>Ação</td>
</tr>
<?php
        if ($iQuantidadeRegistros) {
            foreach($aRegistrosPagina[$_GET['page']] as $row) {
                ?>
                <tr>
                    <td><?=$row['id']?></td>
                    <td><?=$row['nome']?></td>
                    <td><?=$row['sigla']?></td>
                    <td>
                        <a href="?modulo=estados&pagina=alterar&id=<?=$row['id']?>">Alterar</a>
                        <a href="?modulo=estados&pagina=deletar&id=<?=$row['id']?>">Excluír</a>
                    </td>
                </tr>
                <?php
            }
            ?>

            <tr>
                <td colspan="4" style="text-align: center">Páginas: 
                    
                    <?php 
                        for ($i = 1; $i <= $iTotalPaginas; $i++) {
                            ?>
                            <a href="?modulo=estados&pagina=listagem&page=<?=$i?>"><?=' '.$i. ' '?></a>
                            <?php
                        }
                    ?>
                </td>
            </tr>
            <?php
        } else {
            echo "Nenhum resultado retornado.";
        }
?>
</table>
<?php
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
