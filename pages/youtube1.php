<?php
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
  // Converte o timestamp para uma data no formato "d/m/Y H:i:s"
  $dataFormatada = date('d/m/Y H:i:s', $timestamp);
  return $dataFormatada;
}

function converterParaData2($timestamp)
{
  // Converte o timestamp para uma data no formato "d/m/Y H:i:s"
  $dataFormatada = date('d/m', $timestamp);
  return $dataFormatada;
}

function abreviarString($string, $limite)
{
  // Verifica se a string é maior que o limite
  if (strlen($string) > $limite) {
    // Abrevia a string e adiciona "..." no final
    $abreviada = substr($string, 0, $limite - 3) . '...';
    return $abreviada;
  } else {
    // Retorna a string original se ela não ultrapassar o limite
    return $string;
  }
}
?>





<?php

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

  // Exibe os dados do índice IBovespa
  $simbolo = $ibovespa['symbol'];
  // echo "Nome: " . $ibovespa['longName'] . "<br>";
  // echo "Preço Atual: " . $ibovespa['regularMarketPrice'] . "<br>";
  // echo "Variação: " . $ibovespa['regularMarketChange'] . "<br>";
  // echo "Variação Percentual: " . $ibovespa['regularMarketChangePercent'] . "%<br>";
  // echo "Última Atualização: " . $ibovespa['regularMarketTime'] . "<br>";
} else {
  echo "Dados do índice IBovespa não encontrados.";
}

?>


<?php
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
?>



<?php
// Função para buscar dados de câmbio históricos para BTC-BRL
function btcSemanal()
{
  $symbol = 'BTC-BRL';
  $apiUrl = "https://economia.awesomeapi.com.br/json/daily/$symbol/10";

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

// Define o cabeçalho de resposta como JSON
//header('Content-Type: application/json');

// Retorna os dados como JSON
$btc_semanal = json_encode($result, JSON_PRETTY_PRINT);

// Decodifica a string JSON para um array associativo
$btc_semanal_array = json_decode($btc_semanal, true);

// Exibe as datas
$btc_data_semanal = json_encode(array_reverse($btc_semanal_array['dates']));
$btc_valor_semanal = json_encode(array_reverse($btc_semanal_array['values']))
?>




<?php
// Função para buscar dados de câmbio históricos para BTC-BRL
function dolarSemanal()
{
  $symbol = 'USD-BRL';
  $apiUrl = "https://economia.awesomeapi.com.br/json/daily/$symbol/10";

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

// Define o cabeçalho de resposta como JSON
//header('Content-Type: application/json');

// Retorna os dados como JSON
$dolar_semanal = json_encode($result, JSON_PRETTY_PRINT);

// Decodifica a string JSON para um array associativo
$dolar_semanal_array = json_decode($dolar_semanal, true);

// Exibe as datas
$dolar_data_semanal = json_encode(array_reverse($dolar_semanal_array['dates']));
$dolar_valor_semanal = json_encode(array_reverse($dolar_semanal_array['values']));
?>


<!doctype html>
<html lang="en">

<head>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Oswald:wght@200..700&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Bebas+Neue&display=swap');

    .bg {
      background: #C3CBC8;
    }

    .bg1 {
      background: #4b4b5a;
    }

    .bg2 {
      background: #DA9835;
    }

    .bg3 {
      background: #f3b92f;
    }

    .bg-w {
      background: #fff;
    }

    .valor-moeda {
      min-height: 150px;
    }

    .rs {
      font-size: 10px;
      color: #ccc;
    }

    .box {
      border-radius: 6px;
    }

    .box-nome {
      font-family: "Barlow Condensed", sans-serif;
      font-weight: 100;
      font-style: normal;
      font-size: 16px;
      text-transform: uppercase;
      color: #fff !important;
      text-align: center;
      margin: 0 !important;
      padding: 0 !important;
    }

    .box-valor {
      font-family: "Bebas Neue", sans-serif;
      font-weight: 500;
      font-style: normal;
      font-size: 35px;
      color: #f3b92f;
      text-align: center;
      margin: 0 !important;
      padding: 0 !important;
    }

    .box-time {
      font-family: "Oswald", sans-serif;
      font-size: 10px;
      color: #bbb;
      font-weight: 400;
      text-align: center;
      margin: 0 !important;
      padding: 0 !important;
    }

    .div-sobreposta {
      position: absolute;
      top: 0px;
      left: 80px;
      width: 150px;
      height: 20px;
      background-color: rgba(255, 0, 0, 0);
      z-index: 9999;
      padding: 10px;
      font-family: "Oswald", sans-serif;
      font-weight: 300;
      font-size: 10px;
      margin: 0px;
      padding: 3px;
    }

    /* .item {
      background-color: #f3b92f;
      color: #333 ;
    }

    .item:nth-last-child(-n+2) {
      background-color: #333;
      color: #f3b92f ;
    } */
  </style>

  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .banner-container {
      position: relative;
      width: 100%;
      height: 300px;
      /* Ajuste conforme necessário */
      overflow: hidden;
    }

    .banner {
      position: absolute;
      top: 0;
      left: 100%;
      width: 100%;
      height: 100%;
      background-color: #ddd;
      text-align: center;
      line-height: 300px;
      /* Alinhar verticalmente, ajuste conforme necessário */
      font-size: 24px;
      transition: left 1s ease-in-out;
    }

    .banner.active {
      left: 0;
    }

    .banner.inactive {
      left: -100%;
    }

    #video-frame {
      width: 100%;
      height: 100%;
    }
  </style>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg">

  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <div class="card">
          <iframe id="impostometro" class="bg3" src="https://impostometro.com.br/widget/contador/" width="1050" height="130" scrolling="yes" frameborder="0"></iframe>
        </div>
      </div>
    </div>
  </div>

  <div id="data-atual" class="div-sobreposta"> </div>

  <div class="container">
    <div class="row bg-w">
      <div class="col-6">
        <canvas id="dolargraph"></canvas>
      </div>
      <div class="col-6">
        <canvas id="bitcoingraph"></canvas>
      </div>
    </div>

    <div class="row">
      <div class="col d-flex align-items-stretch mt-2 bgw">
        <div class="card w-100">
          <div class="card-body box bg1">
            <?php
            // Supondo que $ibovespa['regularMarketPrice'] já está definido
            $preco = $ibovespa['regularMarketPrice'];

            if ($preco < 0) {
              $ibov_cor = '#ff9688';
              $simbol = '-';
              $icon = "<i class='bi bi-arrow-down-short'></i>";
            } else {
              $simbol = '+';
              $ibov_cor = '#90ee90 ';
              $ibov_icon = "<i class='bi bi-arrow-up-short'></i>";
            }
            ?>
            <h5 class="card-title box-nome">IBOVESPA</h5>
            <p class="card-text box-valor">
              <?php echo $ibovespa['regularMarketPrice']; ?>
            </p>
            <p class="card-text box-time" style="font-size:10px; color: <?= $ibov_cor; ?> ">
              <?= $simbol ?>
              <?php echo $ibovespa['regularMarketChange']; ?> 
              <?= $ibov_icon ; ?>
              (<?php echo $ibovespa ['regularMarketChangePercent']; ?>%)
            </p>
          </div>
        </div>
      </div>

      <?php foreach ($data as $itens) :
        $string = $itens['name'];
        $titulo = abreviarString($string, 19);
      ?>
        <div class="col d-flex align-items-stretch mt-2 bgw">
          <div class="card w-100">
            <div class="card-body box bg1">
              <h5 class="card-title box-nome"><?php echo $titulo; ?></h5>
              <p class="card-text box-valor"><?php echo converterParaReais($itens['ask']) ?></p>
              <p class="card-text box-time"><?php echo converterParaData($itens['timestamp']) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>


  <script>
    function recarregarPagina() {
      setTimeout(function() {
        location.reload();
      }, 15 * 60 * 1000);
    } // 15 minutos * 60 segundos * 1000 milissegundos

    window.onload = recarregarPagina;
  </script>


  <script>
    // Dados para o gráfico de Dólar
    const dolarData = {
      labels: <?php echo $dolar_data_semanal; ?>,
      datasets: [{
        label: 'Dólar(USD)/Real(BRL)',
        data: <?php echo $dolar_valor_semanal; ?>,
        borderColor: 'rgba(36,83,81,1)',
        backgroundColor: 'rgba(36,83,81,0.8)',
        fill: true,
        tension: 0.6
      }]
    };

    // Configuração do gráfico de Dólar
    const dolarConfig = {
      type: 'line',
      data: dolarData,
      options: {
        scales: {
          x: {
            title: {
              display: true,
            }
          },
          y: {
            title: {
              display: true,
              text: 'Taxa de Câmbio (BRL)'
            }
          }
        },
        plugins: {
          legend: {
            display: true,
            position: 'top'
          }
        }
      }
    };
    const dolarCtx = document.getElementById('dolargraph').getContext('2d');
    const dolarGraph = new Chart(dolarCtx, dolarConfig);
    const bitcoinData = {
      labels: <?php echo $btc_data_semanal; ?>,
      datasets: [{
        label: 'Bitcoin/Real(BRL)',
        data: <?php echo $btc_valor_semanal; ?>,
        borderColor: 'rgba(172,79,83,1)',
        backgroundColor: 'rgba(172,79,83,0.8)',
        fill: true,
        tension: 0.6
      }]
    };

    const bitcoinConfig = {
      type: 'line',
      data: bitcoinData,
      options: {
        scales: {
          x: {
            title: {
              display: true,
            }
          },
          y: {
            title: {
              display: true,
              text: 'Preço (R$-BRL)'
            }
          }
        },
        plugins: {
          legend: {
            display: true,
            position: 'top'
          }
        }
      }
    };

    // Renderização do gráfico de Bitcoin
    const bitcoinCtx = document.getElementById('bitcoingraph').getContext('2d');
    const bitcoinGraph = new Chart(bitcoinCtx, bitcoinConfig);
  </script>


  <script>
    // Função para atualizar a data em tempo real
    function atualizarData() {
      // Obtém a data atual
      var dataAtual = new Date();

      // Formata a data no formato desejado (dd/mm/aaaa hh:mm:ss)
      var dataFormatada = ("0" + dataAtual.getDate()).slice(-2) + "/" + ("0" + (dataAtual.getMonth() + 1)).slice(-2) + "/" + dataAtual.getFullYear() + " " + ("0" + dataAtual.getHours()).slice(-2) + ":" + ("0" + dataAtual.getMinutes()).slice(-2) + ":" + ("0" + dataAtual.getSeconds()).slice(-2);

      // Atualiza o conteúdo do elemento HTML com a data formatada
      document.getElementById("data-atual").textContent = dataFormatada;
    }

    // Chama a função para atualizar a data a cada segundo
    setInterval(atualizarData, 1000);
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>