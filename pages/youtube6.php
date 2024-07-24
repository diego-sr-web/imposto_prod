<?php include '../controller/function.php'; ?>
<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap demo</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="../css/estilo.css">
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
    <div class="row bg-w pt-2">
      <div class="col-7">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" data-bs-interval="22000">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div><canvas id="dolargraph" style="max-height: 240px !important;"></canvas></div>
            </div>
            <div class="carousel-item">
              <div><canvas id="bitcoingraph" style="max-height: 240px !important;"></canvas></div>
            </div>
            <div class="carousel-item">
            <div>
              <canvas id="gasolinagraph" style="max-height: 240px !important;"></canvas></div>
            </div>
          </div>
          <button hidden class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button hidden class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
      <div class="col-5" style="margin:0; padding:0" >
        <iframe style="margin:0; padding:0" width="400" height="225"
         
        src="https://www.youtube.com/embed/gpMEc95p1y4?si=7lULajGuiMSmTXoa" 
        
        title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
      </div>
    </div>

    <div class="row">
      <div class="col d-flex align-items-stretch mt-2 bgw">
        <div class="card w-100">
          <div class="card-body box bg1">
            <?php
            // Supondo que $ibovespa['regularMarketPrice'] já está definido
            $preco = convertNumero($ibovespa['regularMarketChange']);

            if ($preco < 0) {
              $ibov_cor = '#ff9688';
              $ibov_icon = "<i class='bi bi-arrow-down-short'></i>";
            } else {
              $ibov_cor = '#90ee90 ';
              $ibov_icon = "<i class='bi bi-arrow-up-short'></i>";
            }
            ?>
            <h5 class="card-title box-nome">IBOVESPA</h5>
            <p class="card-text box-valor">
              <?php echo $ibovespa['regularMarketPrice']; ?>
            </p>
            <p class="card-text box-time" style="font-size:10px; color: <?= $ibov_cor; ?> ">
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
              <h5 class="card-title box-nome"><?php echo primeiraPalavra($titulo); ?></h5>
              <p class="card-text box-valor"><?php echo converterParaReais($itens['ask']) ?></p>
              <p class="card-text box-time"><?php echo converterParaDataBr($itens['timestamp']) ?><p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="container-fluid bg3 mt-2">
    <div class="row">
        <br><br><br><br><br>
    </div>
  </div>

  <script>
  // Dados estáticos para o gráfico de gasolina (12 meses)
  const gasolinaData = {
    labels: ['Jun/23','Jul/23', 'Ago/23', 'Set/23', 'Out/23', 'Nov/23', 'Dez/23', 'Jan/24', 'Fev/24', 'Mar/24', 'Abr/24', 'Mai/24', 'Jun/24'],
    datasets: [{
      label: '(R$)Preço da Gasolina - 12 MESES',
      data: [5.27, 5.39, 5.53, 5.64, 5.53, 5.44, 5.40, 5.39, 5.60, 5.62, 5.72, 5.71, 5.89], // Dados estáticos de exemplo
      borderColor: 'rgba(255, 0, 0, 1)',
      backgroundColor: 'rgba(255, 0, 0, 0.3)',
      fill: true,
      tension: 0.4
    }]
  };

  // Configuração do gráfico de gasolina
  const gasolinaConfig = {
    type: 'line',
    data: gasolinaData,
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
          },
          ticks: {
            callback: function(value) {
              return value.toFixed(2).replace('.', ',');
            }
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

  // Renderização do gráfico de gasolina
  const gasolinaCtx = document.getElementById('gasolinagraph').getContext('2d');
  const gasolinaGraph = new Chart(gasolinaCtx, gasolinaConfig);
</script>

<div class="carousel-item">
  <div><canvas id="gasolinagraph" style="max-height: 240px !important;"></canvas></div>
</div>

  
<script>
      // Dados para o gráfico de Dólar
  const dolarData = {
    labels: <?php echo $dolar_data_semanal; ?>,
    datasets: [{
      label: 'Dólar/Real(R$)',
      data: <?php echo $dolar_valor_semanal; ?>,
      borderColor: 'rgba(36,83,81,1)',
      backgroundColor: 'rgba(36,83,81,0.3)',
      fill: true,
      tension: 0.4
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
          },
          ticks: {
            callback: function(value) {
              return value.toFixed(2).replace('.', ',');
            }
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
      borderColor: 'rgba(0, 0, 139,1)',
      backgroundColor: 'rgba(0, 0, 139,0.3)',
      fill: true,
      tension: 0.4
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
          },
          ticks: {
            callback: function(value) {
              return value.toFixed(2).replace('.', ',');
            }
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




<script src="../js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>