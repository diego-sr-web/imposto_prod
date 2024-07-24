<?php
// Define o caminho para o arquivo que armazenará o contador
$contadorFile = 'contador.txt';

// Verifica se é uma requisição AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Verifica se o arquivo existe, se não, cria e inicializa com 0
    if (!file_exists($contadorFile)) {
        file_put_contents($contadorFile, 0);
    }

    // Lê o valor atual do contador
    $contador = (int)file_get_contents($contadorFile);

    // Incrementa o contador
    $contador++;

    // Salva o novo valor no arquivo
    file_put_contents($contadorFile, $contador);

    // Retorna o valor atualizado do contador
    echo $contador;

    // Termina o script para não executar o HTML abaixo
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contador AJAX e PHP com Timer</title>
</head>
<body>
    <h1>Contador AJAX e PHP com Timer</h1>
    <p>Valor do contador: <span id="contador">0</span></p>
    <button id="incrementar">Incrementar Contador</button>

    <script>
        // Função para atualizar o contador
        function atualizarContador() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '<?php echo basename(__FILE__); ?>', true); // Chama o mesmo arquivo
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); // Define o header para detectar requisição AJAX
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('contador').innerText = xhr.responseText;
                }
            };
            xhr.send();
        }

        // Adiciona o evento de clique ao botão
        document.getElementById('incrementar').addEventListener('click', function() {
            atualizarContador();
        });

        // Atualiza o contador ao carregar a página
        window.onload = function() {
            atualizarContador();
            // Configura o timer para atualizar o contador a cada 5 segundos (5000 ms)
            setInterval(atualizarContador, 5000);
        };
    </script>
</body>
</html>
