<?php
// URL da API JSONPlaceholder
$url = "https://jsonplaceholder.typicode.com/posts";

// Inicializa cURL
$ch = curl_init();

// Define a URL e outras opções
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executa a requisição e captura a resposta
$response = curl_exec($ch);

// Fecha a sessão cURL
curl_close($ch);

// Decodifica a resposta JSON
$data = json_decode($response, true);

// Exibe os dados
foreach ($data as $post) {
    echo "ID: " . $post['id'] . "<br>";
    echo "Title: " . $post['title'] . "<br>";
    echo "Body: " . $post['body'] . "<br><br>";
}
?>
