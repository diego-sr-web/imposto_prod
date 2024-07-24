<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização Parcial de Página com Cron</title>
</head>
<body>
    <div id="content">
        <p><?php
// Exemplo de novo conteúdo dinâmico
echo "<p>Este é o novo conteúdo atualizado via AJAX em " . date('H:i:s') . ".</p>";
?></p>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            function atualizarConteudo() {
                $.ajax({
                    url: 'conteudo.php', // URL do script que retorna o novo conteúdo
                    method: 'GET',
                    success: function(data) {
                        $('#content').html(data); // Atualiza o conteúdo do div com o novo conteúdo
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao atualizar conteúdo:', error);
                    }
                });
            }

            // Chama a função atualizarConteudo a cada 5 segundos (5000 milissegundos)
            setInterval(atualizarConteudo, 5000);
        });
    </script>
</body>
</html>