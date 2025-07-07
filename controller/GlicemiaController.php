<?php
use PHPMailer\PHPMailer\PHPMailer;
use Dompdf\Dompdf;

require_once __DIR__ . '/../vendor/autoload.php';

class GlicemiaController
{
    private $conexao;

    public function __construct()
    {
        global $connection;
        $this->conexao = $connection;
    }

    public function index()
    {
        global $lista;

        $lista = Glicemia::all();

        require_once '../view/glicemia/listar.php';
    }

    public function create()
    {
        require_once '../view/glicemia/editar.php';
    }

    public function store()
    {
        $id = $_REQUEST['id'] ?? null; 
        $data = $_REQUEST['data'] ?? "";
        $valor = $_REQUEST['valor'] ?? "";
        $hora = $_REQUEST['hora'] ?? "";

        // Limpa e formata a hora: remove tudo que não for número
        $hora = preg_replace('/\D/', '', trim($hora)); //
        if (strlen($hora) === 4) { 
            $hora = substr($hora, 0, 2) . ':' . substr($hora, 2, 2); //
        }

        // Validação de campos obrigatórios
        if (empty($data) || empty($valor) || empty($hora)) {
            global $mensagem;
            $mensagem = "Todos os campos são obrigatórios";
            require_once '../view/glicemia/editar.php';
            return;
        }

        $glicemia = new Glicemia();
        $glicemia->id = $id;
        $glicemia->data = $data . " " . $hora . ":00";
        $glicemia->valor = $valor;
        $glicemia->save();

        // Redireciona para listagem
        $this->index();
    }

    public function edit()
    {
        $id = $_REQUEST['id'];

        global $dados;

        $dados = Glicemia::find($id);

        require_once '../view/glicemia/editar.php';
    }

        public function delete()
    {
        $id = $_REQUEST['id'] ?? null;

        if ($id === null) {
            global $mensagem;
            $mensagem = "Glicemia não encontrada";
            $this->index();
            return;
        }

        Glicemia::delete($id);

        $this->index();
    }

    public function relatorio()
    {
    echo "<p>Entrou no método relatorio()</p>";
    $de = $_GET['de'] ?? null;
    $ate = $_GET['ate'] ?? null;
    $pacienteId = $_GET['paciente_id'] ?? null;

    echo "<p>Data inicial: $de</p>";
    echo "<p>Data final: $ate</p>";

    $pacienteId = $_GET['paciente_id'] ?? null;

    if (!$pacienteId) {
    $mensagem = "Paciente não informado.";
    require '../view/glicemia/relatorio.php';
    return;
    }

    echo "<p>Sessão OK - paciente_id: " . $_SESSION['paciente_id'] . "</p>";

     if (empty($de) || empty($ate) || empty($pacienteId)) {
        $mensagem = "Preencha todos os campos.";
        require '../view/glicemia/relatorio-form.php';
        return;
    }

    $pacienteId = $_GET['paciente_id'] ?? null;
    $connection = $this->conexao;

    $de .= " 00:00:00";
    $ate .= " 23:59:59";

    $sql = "SELECT * FROM glicemia WHERE paciente_id = :paciente_id AND data_hora BETWEEN :de AND :ate ORDER BY data_hora";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':paciente_id', $pacienteId);
    $stmt->bindParam(':de', $de);
    $stmt->bindParam(':ate', $ate);
    $stmt->execute();

    $dados = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo "<pre>";
    var_dump($dados);
    echo "</pre>";

    require '../view/glicemia/relatorio_resultado.php';
    }

   public function exportarPdf()
    {
    $de = $_POST['de'] ?? '';
    $ate = $_POST['ate'] ?? '';
    $pacienteId = $_POST['paciente_id'] ?? null;

    if (empty($de) || empty($ate) || empty($pacienteId)) {
        echo "Dados insuficientes para gerar o relatório PDF.";
        return;
    }

    // Carrega os dados
    $connection = $this->conexao;
    $de .= " 00:00:00";
    $ate .= " 23:59:59";

    $stmt = $connection->prepare("SELECT * FROM glicemia WHERE paciente_id = :paciente_id AND data_hora BETWEEN :de AND :ate ORDER BY data_hora");
    $stmt->bindParam(':paciente_id', $pacienteId);
    $stmt->bindParam(':de', $de);
    $stmt->bindParam(':ate', $ate);
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_OBJ);

    // Gera HTML
    ob_start();
    include '../view/glicemia/pdf_resultado.php';
    $html = ob_get_clean();

    // Gera PDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Exibe no navegador
    $dompdf->stream("relatorio_glicemia.pdf", ["Attachment" => false]);
    }


    public function enviarEmail()
    {
    $pacienteId = $_POST['paciente_id'] ?? null;
    $de = $_POST['de'] ?? '';
    $ate = $_POST['ate'] ?? '';

    if (!$pacienteId || !$de || !$ate) {
        echo "Dados insuficientes para gerar o relatório.";
        return;
    }

    // Busca os dados da glicemia
    $dados = Glicemia::porPacienteEPeriodo($pacienteId, $de, $ate);

    if (empty($dados)) {
        echo "Nenhum dado encontrado para o período.";
        return;
    }

    // Gera o conteúdo HTML do relatório
    ob_start();
    $de = htmlspecialchars($de);
    $ate = htmlspecialchars($ate);
    include '../view/glicemia/pdf_resultado.php';
    $html = ob_get_clean();

    // Gera PDF com Dompdf
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $pdfOutput = $dompdf->output();
    file_put_contents('/tmp/relatorio_glicemia.pdf', $pdfOutput);

    // Busca e-mail do médico vinculado ao paciente
    $stmt = $this->conexao->prepare("SELECT m.email 
                                     FROM medico m
                                     JOIN paciente p ON p.medico_id = m.id
                                     WHERE p.id = :id");
    $stmt->bindParam(':id', $pacienteId);
    $stmt->execute();
    $medico = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$medico || empty($medico->email)) {
        echo "E-mail do médico não encontrado.";
        return;
    }

    // Envia o e-mail com PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->setFrom('seusistema@dominio.com', 'Sistema de Glicemia');
        $mail->addAddress($medico->email);
        $mail->Subject = 'Relatório de Glicemia do Paciente';
        $mail->Body = 'Segue anexo o relatório de glicemia.';
        $mail->addAttachment('/tmp/relatorio_glicemia.pdf');
        $mail->send();

        echo "Relatório enviado com sucesso para o médico.";
    } catch (Exception $e) {
        echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
}
}
