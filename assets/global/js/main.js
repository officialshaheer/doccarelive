(function(document, window, $) {
    'use strict';

    var Site = window.Site;
    $(document).ready(function() {
        Site.run();
    });

    

    window.Parsley.on('field:error', function() {
      // This global callback will be called for any field that fails validation.
      console.log('Validation failed for: ', this.$element);
      this.$element.parent().removeClass('has-success').addClass('has-error');
    });
    window.Parsley.on('field:success', function() {
      // This global callback will be called for any field that fails validation.
      console.log('Validation failed for: ', this.$element);
      this.$element.parent().removeClass('has-error').addClass('has-success');
    });

    if( $('#date-of-birth-picker').length ) {
      $('#date-of-birth-picker').datepicker({
          format: 'yyyy/mm/dd',
          endDate:'-25y',
          autoclose: true,
      });
    }
    if( $('.dropify').length ) {
      $('.dropify').dropify({allowedFileExtensions: 'zip'});
    }

    $('.clockpicker').clockpicker();

    $('input').iCheck({checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue'});
    
})(document, window, jQuery);