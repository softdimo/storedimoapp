$('.rango_fecha').daterangepicker({
    autoUpdateInput: false, // 🔹 evita que el input se rellene automáticamente
    locale: {
      format: 'YYYY-MM-DD',
      applyLabel: 'Aplicar',
      cancelLabel: 'Cancelar',
      daysOfWeek: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
      monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
      firstDay: 1
    }
  });
  
  // 🔸 Este bloque actualiza el input SOLO si se hace clic en "Aplicar"
  $('.rango_fecha').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
  });
  
  // 🔸 Este bloque limpia el input si se hace clic en "Cancelar"
  $('.rango_fecha').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
  });
  