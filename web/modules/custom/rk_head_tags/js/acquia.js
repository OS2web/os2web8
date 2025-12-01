(function (Drupal, drupalSettings) {

    var statistics_enabled
    var cookie_less_tracking
    var document_tracking_enabled

    if(drupalSettings.rk_head_tags.acquia_settings.enabled) {
        statistics_enabled = true;
    } else {
        statistics_enabled = false;
    }
    
    if(drupalSettings.rk_head_tags.acquia_settings.cookie_less_tracking) {
        cookie_less_tracking = true;
    } else {
        cookie_less_tracking = false;
    }

    if(drupalSettings.rk_head_tags.acquia_settings.document_tracking_enabled) {
        document_tracking_enabled = true;
    } else {
        document_tracking_enabled = false;
    }

    var documentExtList = (drupalSettings.rk_head_tags.acquia_settings.form_document_extensions || '')
        .replace(/"/g, '')   // remove all quotes
        .split(',')

    // Initialize Monsido tracking
    window._monsido = window._monsido || {
        token: drupalSettings.rk_head_tags.acquia_settings.token,
        statistics: {
            enabled: statistics_enabled,
            cookieLessTracking: cookie_less_tracking,
            documentTracking: {
                enabled: document_tracking_enabled,
                documentCls: "monsido_download",
                documentIgnoreCls: "monsido_ignore_download",
                documentExt: documentExtList
            },
        },
    };
})(Drupal, drupalSettings);

// Load Monsido script asynchronously
(function(Drupal, drupalSettings) {
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.async = true;
    s.src = drupalSettings.rk_head_tags.acquia_settings.form_script_path;
    var x = document.getElementsByTagName('script')[0];
    x.parentNode.insertBefore(s, x);
})(Drupal, drupalSettings);

