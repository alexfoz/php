<?php
use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;

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
        $de = $_GET['de'] ?? null;
        $ate = $_GET['ate'] ?? null;

    if (!isset($_SESSION['paciente_id'])) {
        $mensagem = "Sessão expirada. Faça login novamente.";
        require '../view/glicemia/relatorio.php';
        return;
    }

    if (empty($de) || empty($ate)) {
        $mensagem = "Selecione o período.";
        require '../view/glicemia/relatorio.php';
        return;
    }

    $pacienteId = $_SESSION['paciente_id'];
    $connection = Glicemia::getConnection();

    $de .= " 00:00:00";
    $ate .= " 23:59:59";

    $sql = "SELECT * FROM glicemia WHERE paciente_id = :paciente_id AND data_hora BETWEEN :de AND :ate ORDER BY data_hora";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':paciente_id', $pacienteId);
    $stmt->bindParam(':de', $de);
    $stmt->bindParam(':ate', $ate);
    $stmt->execute();

    $dados = $stmt->fetchAll(PDO::FETCH_OBJ);

    var_dump($dados); // <-- Teste o retorno
    exit;

    require '../view/glicemia/relatorio_resultado.php';
    }

    public function exportarPdf()
    {
        ob_start();
        $_GET = $_POST;
        $this->relatorio();
        $html = ob_get_clean();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("relatorio_glicemia.pdf", ["Attachment" => true]);
    }

    public function enviarEmail()
    {
        ob_start();
        $_GET = $_POST;
        $this->relatorio();
        $html = ob_get_clean();

    // Salva PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfOutput = $dompdf->output();
        file_put_contents('/tmp/relatorio_glicemia.pdf', $pdfOutput);

        $connection = $this->conexao;
        $stmt = $connection->prepare("SELECT email FROM medico WHERE id = (SELECT medico_id FROM paciente WHERE id = :id)");
        $stmt->bindParam(':id', $_SESSION['paciente_id']);
        $stmt->execute();
        $medico = $stmt->fetch(PDO::FETCH_OBJ);

        $mail = new PHPMailer(true);
        $mail->setFrom('seusistema@dominio.com');
        $mail->addAddress($medico->email);
        $mail->Subject = 'Relatório de Glicemia';
        $mail->Body = 'Segue em anexo o relatório de glicemia do paciente.';
        $mail->addAttachment('/tmp/relatorio_glicemia.pdf');
        $mail->send();

        echo "Relatório enviado com sucesso para o médico.";
    }
}