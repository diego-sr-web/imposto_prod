<?php
  function convertNumero($valor)
  {
    setlocale(LC_MONETARY, 'pt_BR.UTF-8');
    $valorFormatado = number_format($valor, 2, ',', '.');
    return $valorFormatado;
  }
  
  function converterParaBlr($valor)
  {
    setlocale(LC_MONETARY, 'pt_BR.UTF-8');
    $valorFormatado = number_format($valor, 2);
    return $valorFormatado;
  }

  function converterParaReais($valor)
  {
    setlocale(LC_MONETARY, 'pt_BR.UTF-8');
    $valorFormatado = number_format($valor, 2, ',', '.');
    return "<span class ='rs'>R$</span>" . $valorFormatado;
  }

  function converterParaData($timestamp)
  {
    $dataFormatada = date('d/m/Y H:i:s', $timestamp);
    return $dataFormatada;
  }

  date_default_timezone_set('America/Sao_Paulo');

// Função para converter o timestamp para o formato desejado
function converterParaDataBr($timestamp) {
    return date('d/m/Y H:i:s', $timestamp);
}

  function converterParaData2($timestamp)
  {
    $dataFormatada = date('d/m', $timestamp);
    return $dataFormatada;
  }

  function abreviarString($string, $limite)
  {
    if (strlen($string) > $limite) {
      $abreviada = substr($string, 0, $limite - 3) . '...';
      return $abreviada;
    } else {
      return $string;
    }
  }

  function primeiraPalavra($string) {
    // Usa a função explode para dividir a string em palavras
    $palavras = explode(' ', $string);
    // Retorna a primeira palavra do array
    return $palavras[0];
}





  // URL da API para buscar o índice IBovespa
  $apiUrl = 'https://brapi.dev/api/quote/^BVSP';

  // Seu token de autenticação
  $token = 'gvPUz8ajiDXT7ywNjgL2ar';

  // Inicializa a sessão cURL
  $ch = curl_init();

  // Configura a URL e outras opções do cURL
  curl_setopt($ch, CURLOPT_URL, $apiUrl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

  // Adiciona o cabeçalho de autenticação
  $headers = [
    "Authorization: Bearer $token"
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // Executa a solicitação e armazena a resposta
  $response = curl_exec($ch);

  // Verifica se ocorreu algum erro na solicitação
  if ($response === false) {
    $error = curl_error($ch);
    curl_close($ch);
    die("Erro na solicitação cURL: $error");
  }

  // Fecha a sessão cURL
  curl_close($ch);

  // Decodifica a resposta JSON
  $data = json_decode($response, true);

  // Verifica se a resposta contém os dados esperados
  if (isset($data['results']) && !empty($data['results'])) {
    // Extrai os dados do índice IBovespa
    $ibovespa = $data['results'][0];
    
  } else {
    echo "Dados do índice IBovespa não encontrados.";
  }




  // The API endpoint
  $url = 'https://economia.awesomeapi.com.br/json/last/USD-BRL,EUR-BRL,BTC-BRL,ETH-BRL';

  // Initialize a cURL session
  $ch = curl_init($url);

  // Set the cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

  // Execute the cURL request
  $response = curl_exec($ch);

  // Check for cURL errors
  if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
    curl_close($ch);
    exit;
  }

  // Close the cURL session
  curl_close($ch);

  // Decode the JSON response
  $data = json_decode($response, true);

  // Check if data was received successfully
  if ($data === null) {
    echo 'Error decoding JSON';
    exit;
  }




  // Função para buscar dados de câmbio históricos para BTC-BRL
  function btcSemanal()
  {
    $symbol = 'BTC-BRL';
    $apiUrl = "https://economia.awesomeapi.com.br/json/daily/$symbol/30";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    if ($response === false) {
      $error = curl_error($ch);
      curl_close($ch);
      die("Erro na solicitação cURL: $error");
    }

    curl_close($ch);

    return json_decode($response, true);
  }

  // Busca os dados de câmbio históricos para BTC-BRL
  $btcRates = btcSemanal();

  // Inicializa arrays para armazenar os valores de câmbio e as datas
  $values = [];
  $dates = [];

  // Processa os dados retornados pela API
  if (is_array($btcRates)) {
    foreach ($btcRates as $rate) {
      $values[] = $rate['bid'];
      $dates[] = converterParaData2($rate['timestamp']);
    }
  }

  // Prepara o resultado final em formato JSON
  $result = [
    'values' => $values,
    'dates' => $dates
  ];

  // Retorna os dados como JSON
  $btc_semanal = json_encode($result, JSON_PRETTY_PRINT);

  // Decodifica a string JSON para um array associativo
  $btc_semanal_array = json_decode($btc_semanal, true);

  // Exibe as datas
  $btc_data_semanal = json_encode(array_reverse($btc_semanal_array['dates']));
  $btc_valor_semanal = json_encode(array_reverse($btc_semanal_array['values']));
  




  // Função para buscar dados de câmbio históricos para BTC-BRL
  function dolarSemanal()
  {
    $symbol = 'USD-BRL';
    $apiUrl = "https://economia.awesomeapi.com.br/json/daily/$symbol/30";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    if ($response === false) {
      $error = curl_error($ch);
      curl_close($ch);
      die("Erro na solicitação cURL: $error");
    }

    curl_close($ch);

    return json_decode($response, true);
  }

  // Busca os dados de câmbio históricos para BTC-BRL
  $dolarRates = dolarSemanal();

  // Inicializa arrays para armazenar os valores de câmbio e as datas
  $values = [];
  $dates = [];

  // Processa os dados retornados pela API
  if (is_array($dolarRates)) {
    foreach ($dolarRates as $rate) {
      $values[] = converterParaBlr($rate['bid']);
      $dates[] = converterParaData2($rate['timestamp']);
    }
  }

  // Prepara o resultado final em formato JSON
  $result = [
    'values' => $values,
    'dates' => $dates
  ];

  // Retorna os dados como JSON
  $dolar_semanal = json_encode($result, JSON_PRETTY_PRINT);

  // Decodifica a string JSON para um array associativo
  $dolar_semanal_array = json_decode($dolar_semanal, true);

  // Exibe as datas
  $dolar_data_semanal = json_encode(array_reverse($dolar_semanal_array['dates']));
  $dolar_valor_semanal = json_encode(array_reverse($dolar_semanal_array['values']));

