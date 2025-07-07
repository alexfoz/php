<?php
$de = $de ?? '';
$ate = $ate ?? '';
$dados = $dados ?? [];
?>

<h2 style="text-align:center;">Relatório de Glicemia</h2>
<p style="text-align:center;">Período: <?= htmlspecialchars($de) ?> a <?= htmlspecialchars($ate) ?></p>

<?php if (empty($dados)) : ?>
    <p style="text-align:center;">Nenhum registro encontrado.</p>
<?php else: ?>
    <table border="1" cellpadding="6" cellspacing="0" width="100%" style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12px;">
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th>Data/Hora</th>
                <th>Valor</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dados as $linha): ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($linha->data_hora)) ?></td>
                    <td><?= htmlspecialchars($linha->valor) ?> mg/dL</td>
                    <td><?= htmlspecialchars($linha->observacao ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
