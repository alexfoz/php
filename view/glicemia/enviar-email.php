<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <form method="POST" action="/glicemia/exportar-pdf">
        <input type="hidden" name="paciente_id" value="<?= $_GET['paciente_id'] ?>">
        <input type="hidden" name="de" value="<?= $_GET['de'] ?>">
        <input type="hidden" name="ate" value="<?= $_GET['ate'] ?>">
        <input type="submit" value="Exportar PDF">
        </form>
    
    </body>
</html>
