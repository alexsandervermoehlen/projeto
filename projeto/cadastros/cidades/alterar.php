<?php
    if (isset($_POST['alterar'])) {
        try {
            $stmt = $conn->prepare(
                'UPDATE cidades SET codigo = :codigo, nome = :nome, estado = :estado WHERE id = :id');
            //$stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute(array('codigo' => $_POST['codigo'], 'nome' => $_POST['nome'],
            'estado' => $_POST['estado'], 'id' => $_GET['id']));
            //$stmt->execute();
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
 
    if (isset($_GET['id'])) {
        $stmt = $conn->prepare('SELECT * FROM cidades WHERE id = :id');
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    }
    //$stmt->execute(array('id' => $id));
    $stmt->execute();
    $r = $stmt->fetchAll();
 
    //print_r($r);
?>
<form method="post">
    <input type="text" name="codigo" value="<?=$r[0]['codigo']?>">
    <input type="text" name="nome" value="<?=$r[0]['nome']?>">
    <input type="text" name="estado" value="<?=$r[0]['estado']?>">
    <input type="submit" name="alterar" value="Salvar">
</form>
