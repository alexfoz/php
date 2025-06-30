<h2>Relatório de Glicemia</h2>
<p>Período: <?= htmlspecialchars($_GET['de']) ?> a <?= htmlspecialchars($_GET['ate']) ?></p>

<?php if (empty($dados)) : ?>
    <p>Nenhum registro encontrado.</p>
<?php else: ?>
    <table border="1">
        <tr>
            <th>Data/Hora</th>
            <th>Valor</th>
            <th>Observação</th>
        </tr>
        <?php foreach ($dados as $linha): ?>
            <tr>
                <td><?= date('d/m/Y H:i', strtotime($linha->data_hora)) ?></td>
                <td><?= htmlspecialchars($linha->valor) ?> mg/dL</td>
                <td><?= htmlspecialchars($linha->observacao ?? '') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<form method="POST" action="/glicemia/exportar-pdf">
    <input type="hidden" name="de" value="<?= $_GET['de'] ?>">
    <input type="hidden" name="ate" value="<?= $_GET['ate'] ?>">
    <input type="submit" value="Exportar PDF">
</form>

<form method="POST" action="/glicemia/enviar-email">
    <input type="hidden" name="de" value="<?= $_GET['de'] ?>">
    <input type="hidden" name="ate" value="<?= $_GET['ate'] ?>">
    <input type="submit" value="Enviar ao Médico">
</form>
