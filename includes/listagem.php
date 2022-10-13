<?php

$resultados = "";
foreach ($vagas as $vaga) {
    $resultados .= '<tr>
                        <td>' . $vaga->id . '</td>
                        <td>' . $vaga->titulo . '</td>
                        <td>' . $vaga->descricao . '</td>
                        <td>' . ($vaga->ativo == 's' ? 'Ativo' : 'Inativo') . '</td>
                        <td>' . date('d/m/Y à\s H:i:s', strtotime($vaga->data)) . '</td>
                        <td>
                            <a href="editar.php?id=' . $vaga->id . '">
                                <button type="button" class="btn btn-primary btn-sm" title="Editar Vaga">Editar</button>
                            </a>
                            <a href="excluir.php?id=' . $vaga->id . '">
                                <button type="button" class="btn btn-danger btn-sm" title="Excluir Vaga">Excluir</button>
                            </a>
                        </td>
                     </tr>';
}

?>

<main>

    <section>
        <a href="cadastrar.php">
            <button class="btn btn-success">Nova Vaga</button>
        </a>
    </section>

    <section>

        <table class="table bg-light mt-3">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php echo $resultados; ?>
            </tbody>

        </table>

    </section>

</main>