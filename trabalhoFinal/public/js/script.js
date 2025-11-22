document.addEventListener('DOMContentLoaded', function(){
  const form = document.getElementById('evalForm');
  if (!form) return;
  form.addEventListener('submit', function(e){
    const dispositivo = form.querySelector('select[name="dispositivo_id"]');
    const setor = form.querySelector('select[name="setor_id"]');
    if (dispositivo && !dispositivo.value) {
      e.preventDefault();
      alert('Por favor selecione o dispositivo antes de enviar.');
      dispositivo.focus();
      return false;
    }
    if (setor && !setor.value) {
      e.preventDefault();
      alert('Por favor selecione o setor antes de enviar.');
      setor.focus();
      return false;
    }
    const perguntas = document.querySelectorAll('.pergunta');
    for (let q of perguntas) {
      const firstRadio = q.querySelector('input[type=radio]');
      if (!firstRadio) continue;
      const name = firstRadio.name;
      const checked = document.querySelector('input[name="'+name+'"]:checked');
      if (!checked) {
        e.preventDefault();
        alert('Por favor responda todas as perguntas antes de enviar.');
        firstRadio.focus();
        return false;
      }
    }
    return true;
  });
});
