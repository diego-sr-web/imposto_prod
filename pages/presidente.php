<?php 
$dia_do_ano = intval(date('z'));
$ano = '2014';
$imposto_total_ano = '1913945777906.00';
$imposto_do_dia = ($imposto_total_ano / 365) * $dia_do_ano;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<div class="fh">
    <h4>Dia do ano: <?= $dia_do_ano ?></h2>
      <table>

        <tr>
          <th>Ano</th>
          <th>Presidente</th>
          <th>Dia <p id="data-atual"></p>
          </th>
          <th>expectativa</th>
        </tr>

        <tr>
          <td><?= $dia_do_ano ?></td>
          <td><img src="../assets/dilma.jpg" height="50px"></td>
          <td>R$ <span class="contador"><?= $imposto_do_dia; ?></span></td>
          <td>R$: <?= $imposto_total_ano ?> </td>
        </tr>

      </table>
  </div>



  <script>
    const meses = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];

    const hoje = new Date();
    const diaDoMes = hoje.getDate();
    const mes = hoje.getMonth();

    const dataFormatada = `${diaDoMes}/ ${meses[mes]}`;

    document.getElementById('data-atual').textContent = dataFormatada;

    // Obtém todos os elementos com a classe "contador"
    let elementosContador = document.getElementsByClassName('contador');
    for (let i = 0; i < elementosContador.length; i++) {
      let valorInicial = parseFloat(elementosContador[i].innerText);
      setInterval(function() {
        let contadorAtual = parseFloat(elementosContador[i].innerText);
        let incremento = Math.floor(Math.random() * (100001 - 20000)) + 20000.17;
        contadorAtual += incremento;
        elementosContador[i].innerText = contadorAtual.toFixed(2);
      }, 500);
    }
  </script>

</body>
</html>