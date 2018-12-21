/**
 * Created by ice on 12.03.2016.
 */
var _prepareFormData = function(data) {
    var returned = {};
    $.each(data, function(i, info){
        if(info['name'].indexOf('[]') > 0) {
            if(returned[info['name']] === undefined)
                returned[info['name']] = [];
            returned[info['name']].push(info['value']);
        } else
            returned[info['name']] = info['value'];
    });

    return returned;
};

$(function(){
    toastr.options = {
        "closeButton": true,
        "debug": true,
        "progressBar": true,
        "preventDuplicates": true,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "1000",
        "timeOut": "7000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
});