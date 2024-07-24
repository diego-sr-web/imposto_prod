function recarregarPagina() {
  setTimeout(function () {
    location.reload();
  }, 15 * 60 * 1000);
} // 15 minutos * 60 segundos * 1000 milissegundos
//window.onload = recarregarPagina;





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