<h4>Cadastra Novo Produto</h4>

<form method="POST" enctype="multipart/form-data" action="index.php?class=produto&op=store" onsubmit="return onSubmit()">
    <div class="form-group">
        <label for="nome">Nome do Produto*</label>
        <input type="text" required class="form-control" name="nome" id="nome">
    </div>
    <div class="form-group">
        <label for="sku">SKU*</label>
        <input type="text" required class="form-control" id="sku" name="sku">
    </div>
    <div class="form-group">
        <label for="sku">Valor*</label>
        <input type="number" required step="0.01" class="form-control" id="valor" name="valor">
    </div>
    <div class="form-group">
        <label for="sku">Estoque*</label>
        <input type="number" required class="form-control" id="estoque" name="estoque">
    </div>
    <div class="form-group">
        <label for="inputFoto">Foto do Produto*</label>
        <input type="file" name="inputFoto" class="form-control-file" id="inputFoto">
    </div>
    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="index.php?class=produto" class="btn btn-secondary">Voltar</a>
</form>

<script type="text/javascript">
    ///validação no front
    function validate(){
        let isValid = true;

        return isValid;
    }

    function onSubmit() {
        return validate()
    }
</script>
