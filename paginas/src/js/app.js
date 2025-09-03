//Script para ver y no ver contraseña
function togglePasswordVisibility() {
  const passwordInput = document.getElementById("password");
  const toggleIcon = document.querySelector(".toggle-password");

  const isPassword = passwordInput.type === "password";
  passwordInput.type = isPassword ? "text" : "password";

  // Cambiar ícono (opcional)
  toggleIcon.textContent = isPassword ? "🔒" : "🔓";
}

//Script para ver y no ver repetir contraseña
function togglePassword2Visibility() {
  const passwordInput = document.getElementById("password2");
  const toggleIcon = document.querySelector(".toggle-password");

  const isPassword = passwordInput.type === "password";
  passwordInput.type = isPassword ? "text" : "password";

  // Cambiar ícono (opcional)
  toggleIcon.textContent = isPassword ? "🔒" : "🔓";
}

//Script para agregar cámaras
$(function () {
  let step = 0; // contador para saber cuántas cámaras extra mostramos

  $("#btn-add-camera").on("click", function () {
    if (step === 0) {
      // Muestra Cam 4 y su Time
      $(".cam-extra").slice(0, 2).slideDown();
      step++;
    } else if (step === 1) {
      // Muestra Cam 5 y su Time
      $(".cam-extra").slice(2, 4).slideDown();
      step++;
      // Opcional: ocultar botón cuando ya se mostraron todas
      $("#row-add-camera").hide();
    }
  });
});

//Script para el editor de texto
tinymce.init({
  selector: "#editor",
  plugins: "lists link image formatselect code help wordcount textcolor font",
  toolbar:
    "undo redo | formatselect |bold italic underline forecolor backcolor | fontselect fontsizeselect | bullist numlist outdent indent | removeformat | code",
  menubar: true,

  // Colores fosforescentes personalizados
  color_map: [
    "ff00ff",
    "Fucsia fosforescente",
    "00ff00",
    "Verde fosforescente",
    "00ffff",
    "Cian fosforescente",
    "ffff00",
    "Amarillo fosforescente",
    "ff9900",
    "Naranja brillante",
    "ff0000",
    "Rojo brillante",
    "ffffff",
    "Blanco",
    "000000",
    "Negro",
  ],

  color_cols: 8,
});
