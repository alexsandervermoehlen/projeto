<?php
    if (isset($_POST['gravar'])) {
        try {
            $stmt = $conn->prepare(
                'INSERT INTO cidades (codigo, nome, estado) values (:codigo, :nome, :estado)');
            //$stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute(array('codigo' => $_POST['codigo'], 'nome' => $_POST['nome'],
                                 'estado' => $_POST['estado']));
            //$stmt->execute();
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
?>
<form method="post">
    <div class="form-group">
        <label for="nome">Codigo</label>
        <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Codigo">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome">
        <label for="nome">Estado</label>
        <input type="text" class="form-control" name="estado" id="estado" placeholder="Estado">
    </div>
    <input type="submit" name="gravar" value="Gravar">
</form>
