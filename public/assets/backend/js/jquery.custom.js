// jQuery plugin to prevent double submission of forms
jQuery.fn.preventDoubleSubmission = function() {
    jQuery(this).on('submit',function(e){
        var $form = jQuery(this);

        if ($form.data('submitted') === true) {
            // Previously submitted - don't submit again
            e.preventDefault();
        } else {
            // Mark it so that the next submit can be ignored
            $form.data('submitted', true);
        }
    });

    // Keep chainability
    return this;
};

jQuery(document).ready(function() {
    jQuery('.datepicker').datetimepicker({
        locale: 'pl',
        format: 'YYYY-MM-DD HH:mm:ss'
    });

    jQuery('.iconpicker').iconpicker();

    jQuery(document).on('click', 'a.input-lang-switcher', function(e) {
        e.preventDefault();

        var $this = jQuery(this);
        var $button = jQuery('#' + $this.data('button'));
        var $lang = $this.data('lang');

        $button.html($this.html() +  ' <span class="caret"></span>');

        jQuery('.input-lang-switcher-input').addClass('hidden');
        jQuery('.input-lang-switcher-input.' + $lang).removeClass('hidden');
    });

    jQuery(document).on('click', 'a.confirmDelete', function(e) {
        e.preventDefault();

        var $this = jQuery(this);
        var redirectUri = $this.data('href');

        Swal.fire({
            title: "Uwaga!",
            text: "Czy na pewno chesz wykonać wybraną akcje?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Tak",
            cancelButtonText: "Nie"
        }).then((result) => {
            if (result.value) {
                window.location.href = redirectUri;
            }
        });
    });

    jQuery(document).on('click', 'a.ajaxStatus', function(e) {
        e.preventDefault();

        var $this = jQuery(this);
        var $img = $this.find('i');

        jQuery.ajax({
            url: $this.prop('href'),
            cache: false,
            dataType: 'json',
            success: function(data) {
                if (data.status === 'success') {
                    $this.prop('href', data.href);
                    $this.prop('class', data.hrefClass + ' ajaxStatus');
                    $img.prop('class', data.class);

                    swal('Uwaga!', 'Zapisano poprawnie', 'success');

                    if (typeof data.refresh !== "undefined" && data.refresh) {
                        window.location.reload();
                    }
                } else {
                    swal('Uwaga!', 'Błąd', 'error');
                }
            }
        });
    });
});
