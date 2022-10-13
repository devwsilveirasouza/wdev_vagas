<main>

    <section>
        <a href="index.php">
            <button class="btn btn-success">Voltar</button>
        </a>
    </section>
    <!-- Usando a constante criada para o titulo dinâmico -->
    <h2 class="mt-3"><?=TITLE?></h2>

    <form method="post">

        <div class="form-group">
            <label for="">Título</label>
            <input type="text" name="titulo" value="<?=$obVaga->titulo?>" class="form-control" rows="5" />
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <textarea name="descricao" class="form-control" rows="5"><?=$obVaga->descricao?></textarea>
        </div>

        <div class="form-group">
            <label>Status</label>
            <div>

                <div class="form-check form-check-inline">
                    <label class="form-control">                        
                        <input type="radio" name="ativo" value="s" checked />
                        Ativo
                    </label>
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-control">                        
                        <input type="radio" name="ativo" value="n" <?=$obVaga->ativo == 'n' ? 'checked' : ''?> />
                        Inativo
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Enviar</button>
        </div>

    </form>

</main>