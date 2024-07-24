<?php
// Define o caminho para o arquivo que armazenará o contador
$contadorFile = 'contador.txt';

// Função para obter dados da API externa
function obterDadosAPI() {
    // O endpoint da API
    $url = 'https://economia.awesomeapi.com.br/json/last/USD-BRL,EUR-BRL,BTC-BRL,ETH-BRL';

    // Inicializa uma sessão cURL
    $ch = curl_init($url);

    // Define as opções do cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Executa a requisição cURL
    $response = curl_exec($ch);

    // Verifica por erros no cURL
    if (curl_errno($ch)) {
        curl_close($ch);
        return 'Curl error: ' . curl_error($ch);
    }

    // Fecha a sessão cURL
    curl_close($ch);

    // Decodifica a resposta JSON
    $data = json_decode($response, true);

    // Verifica se os dados foram recebidos com sucesso
    if ($data === null) {
        return 'Error decoding JSON';
    }

    return $data;
}

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

    // Obtém os dados da API externa
    $dadosAPI = obterDadosAPI();

    // Retorna o valor atualizado do contador e os dados da API em formato JSON
    echo json_encode(['contador' => $contador, 'api' => $dadosAPI]);

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
    <div id="dadosAPI"></div>

    <script>
        // Função para atualizar o contador e exibir dados da API
        function atualizarContador() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '<?php echo basename(__FILE__); ?>', true); // Chama o mesmo arquivo
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); // Define o header para detectar requisição AJAX
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var resposta = JSON.parse(xhr.responseText);
                    document.getElementById('contador').innerText = resposta.contador;
                    document.getElementById('dadosAPI').innerText = JSON.stringify(resposta.api, null, 2);
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
