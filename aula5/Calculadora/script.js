document.addEventListener('DOMContentLoaded', () => {
  const inputValor1   = document.getElementById('valor1');
  const inputValor2   = document.getElementById('valor2');
  const selectOperador = document.getElementById('operador');
  const divResultado  = document.getElementById('resultado');
  const buttonCalcular = document.getElementById('calcBtn');
  const buttonLimpar   = document.getElementById('clearBtn');

  function limparClassesResultado() {
    divResultado.classList.remove('pos', 'neg', 'zer');
  }

  function formatarNumero(numero) {
    if (!isFinite(numero)) return String(numero);
    const numeroArredondado = Number(numero.toFixed(8));
    return numeroArredondado % 1 === 0 
      ? numeroArredondado.toFixed(0) 
      : String(numeroArredondado);
  }

  function calcularResultado() {
    if (inputValor1.value.trim() === '' || inputValor2.value.trim() === '') {
      limparClassesResultado();
      divResultado.textContent = 'Preencha os dois valores';
      return;
    }

    const numero1   = Number(inputValor1.value);
    const numero2   = Number(inputValor2.value);
    const operador  = selectOperador.value;

    if (isNaN(numero1) || isNaN(numero2)) {
      limparClassesResultado();
      divResultado.textContent = 'Valores inválidos';
      return;
    }

    if (operador === '/' && numero2 === 0) {
      limparClassesResultado();
      divResultado.textContent = 'Erro: divisão por zero';
      return;
    }

    let resultadoCalculado;
    switch (operador) {
      case '+': resultadoCalculado = numero1 + numero2; break;
      case '-': resultadoCalculado = numero1 - numero2; break;
      case '*': resultadoCalculado = numero1 * numero2; break;
      case '/': resultadoCalculado = numero1 / numero2; break;
      default:  resultadoCalculado = NaN;
    }

    if (!isFinite(resultadoCalculado)) {
      limparClassesResultado();
      divResultado.textContent = 'Erro no cálculo';
      return;
    }

    limparClassesResultado();
    divResultado.textContent = formatarNumero(resultadoCalculado);

    if (resultadoCalculado > 0) {
      divResultado.classList.add('pos');
    } else if (resultadoCalculado < 0) {
      divResultado.classList.add('neg');
    } else {
      divResultado.classList.add('zer');
    }
  }

  buttonCalcular.addEventListener('click', calcularResultado);
  buttonLimpar.addEventListener('click', () => {
    inputValor1.value = '';
    inputValor2.value = '';
    selectOperador.value = '+';
    limparClassesResultado();
    divResultado.textContent = '—';
    inputValor1.focus();
  });

  [inputValor1, inputValor2].forEach(campo => {
    campo.addEventListener('keydown', (evento) => {
      if (evento.key === 'Enter') {
        evento.preventDefault();
        calcularResultado();
      }
    });
  });
});
