/**
 * Created by ice on 12.03.2016.
 */
var $ajax = new AJAX();
function AJAX()
{
    var _that = this;

    this.request = function(link,data,requestType,local_triggers,dataType) {
	this.json(link,data,requestType,local_triggers,dataType);
    };

    this.json = function(link,data,requestType,local_triggers, datatype){
        data             = (data              === undefined || data              === null ) ? {}        : data;
        requestType      = (requestType       === undefined || requestType       === null ) ? 'post'    : requestType;
        local_triggers   = (local_triggers    === undefined || local_triggers    === null ) ? {}        : local_triggers;
        datatype   	 = (datatype          === undefined || datatype    	 === null ) ? "json"    : datatype;

        $.ajax({
            url         : link,
            data        : data,
            type        : requestType,
            dataType    : datatype,
            xhrFields: {
                withCredentials: true
            },
            beforeSend  : function(){
                $(window).trigger('ajax_global:beforeSend');

                return true;
            },
            success     : function(response){
                if(typeof response != 'object') {
                            $(window).trigger('ajax_global:success');
                            //локальный триггер, задается при вызове
                            if(local_triggers.success !== undefined) {
                                $(window).trigger(local_triggers.success, [response]);
                            }
                            if(response.messages !== undefined) {
                                $(window).trigger('ajax_global:messages', ['success', response.messages]);
                            }
                }

                if(response.error !== undefined && response.error == true) {
                    $(window).trigger('ajax_global:error');
                    //локальный триггер, задается при вызове
                    if(local_triggers.error !== undefined) {
                        $(window).trigger(local_triggers.error, [response]);
                    }

                    if(response.messages !== undefined) {
                        $(window).trigger('ajax_global:messages', ['error', response.messages]);
                    }
                }

                if(response.success !== undefined && response.success == true) {
                    $(window).trigger('ajax_global:success');
                    //локальный триггер, задается при вызове
                    if(local_triggers.success !== undefined) {
                        $(window).trigger(local_triggers.success, [response]);
                    }
                    if(response.messages !== undefined) {
                        $(window).trigger('ajax_global:messages', ['success', response.messages]);
                    }
                }

                if(response.triggers !== undefined) {
                    $.each(response.triggers, function(e, trigger){
                        $(window).trigger(trigger, [response]);
                    });
                }
            },
            error       : function() {
                $(window).trigger('ajax_global:error');
                //локальный триггер, задается при вызове
                if(local_triggers.error !== undefined) {
                    $(window).trigger(local_triggers.error);
                }
            }
        }).complete(function(data) {
            $(window).trigger('ajax_global:complete');
            //локальный триггер, задается при вызове
            if(local_triggers.complete !== undefined) {
                $(window).trigger(local_triggers.complete);
            }
        });
    };
}

$(function() {
    $(window).on('ajax_global:messages', function(e, type, messages) {
        $.each(messages, function(i, message) {
            if(message.title !== undefined && message.title) {
                toastr[type](message.text, message.title);
            } else {
                toastr[type](message.text);
            }
        });
    });
});