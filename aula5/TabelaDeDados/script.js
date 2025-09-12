document.addEventListener("DOMContentLoaded", () => {

  const tabela = document.getElementById("tabela-notas");
  const botaoLinha = document.getElementById("btn-linha-media");
  const botaoColuna = document.getElementById("btn-coluna-media");

  let linhaJaAdicionada = false;
  let colunaJaAdicionada = false;

  function adicionarLinhaMedia() {
    if (linhaJaAdicionada) return;

    const corpo = tabela.querySelector("tbody");
    const linhas = corpo.querySelectorAll("tr");
    const quantidadeNotas = tabela.rows[0].cells.length - 1;

    const somaNotas = Array(quantidadeNotas).fill(0);

    linhas.forEach(linha => {
      for (let i = 1; i <= quantidadeNotas; i++) {
        somaNotas[i - 1] += parseFloat(linha.cells[i].textContent);
      }
    });

    const novaLinha = tabela.insertRow(-1);
    novaLinha.insertCell(0).textContent = "Média da Turma";

    somaNotas.forEach(soma => {
      const media = soma / linhas.length;
      novaLinha.insertCell(-1).textContent = media.toFixed(2);
    });

    linhaJaAdicionada = true;
  }

  function adicionarColunaMedia() {
    if (colunaJaAdicionada) return;

    const cabecalho = tabela.querySelector("thead tr");
    const linhas = tabela.querySelectorAll("tbody tr");

    cabecalho.appendChild(document.createElement("th")).textContent = "Média";

    linhas.forEach(linha => {
      const quantidadeNotas = linha.cells.length - 1;
      let soma = 0;

      for (let i = 1; i < linha.cells.length; i++) {
        soma += parseFloat(linha.cells[i].textContent);
      }

      const media = soma / quantidadeNotas;
      linha.appendChild(document.createElement("td")).textContent = media.toFixed(2);
    });

    colunaJaAdicionada = true;
  }

  botaoLinha.addEventListener("click", adicionarLinhaMedia);
  botaoColuna.addEventListener("click", adicionarColunaMedia);

});
