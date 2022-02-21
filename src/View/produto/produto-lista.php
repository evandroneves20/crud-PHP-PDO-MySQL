<div class="row mb-3">
    <div class="col"><h4>Lista de Produtos</h4></div>
    <div class="col text-right">
        <a href="index.php?class=produto&op=create" class="btn btn-primary">Cadastrar novo Produto</a>
    </div>
</div>
<?php if (!is_null($message)) { ?>
    <div class="alert alert-<?php echo $message['type'] ?> alert-dismissible fade show" role="alert">
        <strong><?php echo $message['text'] ?></strong>.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

<?php

if (count($produtos) === 0) {
    ?>
    <div class="alert alert-secondary" role="alert">
        <strong>Não há produtos cadastrados</strong>.
    </div>
    <?php
} else {
    foreach ($produtos as $produto) {
        ?>
        <div class="card mb-3">
            <h5 class="card-header"><?php echo $produto->nome ?></h5>
            <div class="row no-gutters">
                <div class="col-8">
                    <div class="card-body">
                        <p class="card-text">
                            SKU: <span style="font-weight: bold"><?php echo $produto->sku ?></span> <br>
                            Valor: <span style="font-weight: bold">R$ <?php echo $produto->valor ?></span> <br>
                            Estoque: <span style="font-weight: bold"><?php echo $produto->estoque ?></span>
                        </p>
                        <div style="display: flex">
                            <a href="index.php?class=produto&op=edit&id=<?php echo $produto->id ?>"
                               class="btn btn-sm btn-warning mr-3">Editar</a>
                            <form action="index.php?class=produto&op=delete" method="POST"
                                  onsubmit="return onSubmitDelete()">
                                <input type="hidden" name="id" value="<?php echo $produto->id ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <img style="max-width: 200px" src="<?php echo $produto->foto ?>" alt="...">
                </div>
            </div>
        </div>
        <?php
    }
}

?>
<script>
    function onSubmitDelete() {
        const result = confirm('Deseja Realmente Excluir o registro?')

        if (!result) {
            return false
        }
    }
</script>
