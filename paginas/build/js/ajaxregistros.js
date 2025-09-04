document.addEventListener('DOMContentLoaded', () => {
  const vbMenu = document.getElementById('vb-menu');
  let currentCell = null;
  let touchTimer = null;

  // Función para mostrar menú
  const showMenu = (cell, x, y) => {
    currentCell = cell;
    vbMenu.style.display = 'block';
    vbMenu.style.top = `${y}px`;
    vbMenu.style.left = `${x}px`;
  };

  document.querySelectorAll('.vb-cell').forEach(cell => {

    // Desktop: click derecho
    cell.addEventListener('contextmenu', e => {
      e.preventDefault();
      showMenu(cell, e.pageX, e.pageY);
    });

    // Mobile/Tablet: presionar prolongadamente
    cell.addEventListener('touchstart', e => {
      touchTimer = setTimeout(() => {
        const touch = e.touches[0];
        showMenu(cell, touch.pageX, touch.pageY);
      }, 600); // 600ms = presion prolongada
    });

    cell.addEventListener('touchend', e => {
      clearTimeout(touchTimer); // si levantan antes de 600ms, no pasa nada
    });

    cell.addEventListener('touchmove', e => {
      clearTimeout(touchTimer); // si mueven el dedo, cancelamos
    });
  });

  // Selección ✅ o ❌
  vbMenu.querySelectorAll('button').forEach(btn => {
    btn.addEventListener('click', () => {
      const value = btn.dataset.value;
      const symbol = value === "1" ? "✅" : "❌";

      let hidden = currentCell.querySelector('input[type="hidden"]');
      hidden.value = value;

      currentCell.textContent = symbol;
      currentCell.appendChild(hidden);

      vbMenu.style.display = 'none';
    });
  });

  // Cerrar menú si clickeamos fuera
  document.addEventListener('click', e => {
    if (!vbMenu.contains(e.target)) {
      vbMenu.style.display = 'none';
    }
  });
});
