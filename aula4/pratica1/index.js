function verificarLogin() {
    const usuarioInput = document.getElementById("usuario");
    const senhaInput = document.getElementById("senha");

    const usuario = usuarioInput.value;
    const senha = senhaInput.value;

    usuarioInput.classList.remove("senhaErrada");
    senhaInput.classList.remove("senhaErrada");

    if (usuario === "user" && senha === "pass") {
      alert("Login Ok");
    } else {
      alert("Usuário ou senha incorretos.");
      usuarioInput.classList.add("senhaErrada");
      senhaInput.classList.add("senhaErrada");
    }
  }