$(function(){
  let toqueTimer;

  function mostrarMenu(x, y, celda) {
    $('#menuContextual').css({ top: y + 'px', left: x + 'px' }).fadeIn(100).data('celda', celda);
  }

  // Clic derecho (PC)
  $('.vb-cell').on('contextmenu', function(e){
    e.preventDefault();
    mostrarMenu(e.pageX, e.pageY, $(this));
  });

  // Toque prolongado (tablets)
  $('.vb-cell').on('touchstart', function(e){
    const celda = $(this);
    toqueTimer = setTimeout(function(){
      const touch = e.originalEvent.touches[0];
      mostrarMenu(touch.pageX, touch.pageY, celda);
    }, 600); // 600ms para considerar toque largo
  }).on('touchend touchmove', function(){
    clearTimeout(toqueTimer);
  });

  // Al hacer clic en una opción del menú
  $('#menuContextual svg').on('click', function(){
    const nuevoValor = $(this).data('value');
    const celda = $('#menuContextual').data('celda');
    const id = celda.data('id');

    $.post('paginas/backend/update_vb.php', { id: id, nuevo_valor: nuevoValor }, function(response){
      // Actualiza visualmente el contenido
      const nuevoSVG = (nuevoValor == 1)
        ? '<svg fill="green" viewBox="0 0 24 24"><path d="M20.285 6.709a1 1 0 0 0-1.414-1.418l-9.19 9.203-4.55-4.544a1 1 0 1 0-1.414 1.414l5.256 5.25a1 1 0 0 0 1.414 0l9.898-9.905z"/></svg>'
        : '<svg fill="red" viewBox="0 0 24 24"><path d="M18.364 5.636a1 1 0 0 0-1.414 0L12 10.586 7.05 5.636A1 1 0 0 0 5.636 7.05L10.586 12l-4.95 4.95a1 1 0 1 0 1.414 1.414L12 13.414l4.95 4.95a1 1 0 0 0 1.414-1.414L13.414 12l4.95-4.95a1 1 0 0 0 0-1.414z"/></svg>';
      celda.html(nuevoSVG).data('valor', nuevoValor);
      $('#menuContextual').fadeOut(100);
    });
  });

  // Ocultar menú si se hace clic en otro lado
  $(document).on('click', function(e){
    if (!$(e.target).closest('#menuContextual, .vb-cell').length) {
      $('#menuContextual').fadeOut(100);
    }
  });
});