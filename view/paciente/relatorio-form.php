<h2>Gerar Relatório de Glicemia</h2>

<form method="GET" action="/glicemia/relatorio">
    <input type="hidden" name="paciente_id" value="<?= htmlspecialchars($_GET['paciente_id']) ?>">
    <label>Data Inicial:</label>
    <input type="date" name="de" required>
    <label>Data Final:</label>
    <input type="date" name="ate" required>
    <input type="submit" value="Gerar">
</form>