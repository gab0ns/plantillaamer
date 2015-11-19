
//////////////////////////////////////SPIN//////////////////////////////////////
function show_spin(element){
    if (element === false);
    else {
        $.fn.spin.presets.flower = {
            lines: 13,
            length: 4,
            width: 2,
            radius: 6
        }
        if (element){
            $(element).spin('flower', 'black');
        } else {
            $('.ui-dialog-buttonset').spin('flower', 'black');
        }
    }
}

function hide_spin(element){
    if (element === false);
    else {
        if (element){
            $(element).spin(false);
        } else {
            $('.ui-dialog-buttonset').spin(false);
        }
    }
}
//////////////////////////////////////SPIN//////////////////////////////////////

/////////////////////////////////////ALERT//////////////////////////////////////

function show_error(texto,callBack){
    noty({
        text: texto + '<div><i>click para cerrar</i></div>',
        theme: 'defaultTheme',
        type:'error',
        timeout:false,
        animation: {
            open: {height: 'toggle'},
            close: {height: 'toggle'},
            easing: 'swing',
            speed: 500 // opening & closing animation speed
        },
        callback: {
            onShow: function() {},
            afterShow: function() {},
            onClose: function() {},
            afterClose: function() {
                enable_button();
                if (callBack){
                    callBack();
                }
            }
        }
    });
}

function show_exito_onShow(texto,callBack){
    noty({
        text: texto,
        type:'success',
        timeout:2500,
        callback: {
            onShow: function() {
                if (callBack){
                    callBack();
                }
            },
            afterShow: function() {},
            onClose: function() {},
            afterClose: function() {}
        }
    });
}

function show_exito_afterClose(texto,callBack){
    noty({
        text: texto,
        type:'success',
        timeout:2500,
        callback: {
            onShow: function() {},
            afterShow: function() {},
            onClose: function() {},
            afterClose: function() {
                enable_button();
                if (callBack){
                    callBack();
                }
            }
        }
    });
}

function show_alert(texto){
    noty({
        text: texto,
        type:'alert',
        timeout:2500
    });
}

function show_confirm(texto,callBack,element){
    if (element){
        $(element).noty({
            text: texto,
            type:'confirm',
            layout:'top',
            animation: {
            open: {height: 'toggle'},
            close: {height: 'toggle'},
            easing: 'swing',
            speed: 500 // opening & closing animation speed
        },
            buttons: [
                {addClass: 'btn btn-danger',
                text: 'Si',
                onClick: function($noty){
                    $noty.close();
                    callBack();
                    click_button = false;
                }},
                {addClass: 'btn btn-primary',
                text: 'Cancelar',
                onClick: function($noty){
                    $noty.close();
                    click_button = false;
                    enable_button();
                }},
            ]
        });
    } else {
        noty({
            text: texto,
            type:'confirm',
            buttons: [
                {addClass: 'btn btn-danger',
                text: 'Si',
                onClick: function($noty){
                    $noty.close();
                    callBack();
                    click_button = false;
                }},
                {addClass: 'btn btn-primary',
                text: 'Cancelar',
                onClick: function($noty){
                    $noty.close();
                    click_button = false;
                    enable_button();
                }},

            ]
        });
    }
}

/////////////////////////////////////ALERT//////////////////////////////////////

////////////////////////////////////DIALOG//////////////////////////////////////

function show_dialog(ancho,alto,callBack,callBack2){
    $('#dialog').dialog({
        dialogClass: 'no-close',
        show: 'blind',
        height: alto,
        width: ancho,
        draggable: false,
        modal:true,
        resizable: false,
        title: $('#dialog .title_dialog').val(),
        buttons:[
            {
                text:'Cancelar',
                click: function(){
                    click_button = false;
                    hide_dialog();
                }
            },
            {
                text:'Guardar',
                click: function(){
                    $('.ui-dialog-buttonpane').find('.ui-dialog-buttonset').find('button').last().attr('disabled','disabled');
                    if (callBack)
                        callBack();
                    else
                        $('#dialog').find('form').submit();
                }
            }
        ],
        close: function( event, ui ) {
            if (callBack2)
                callBack2();
        }
    });
}

function hide_dialog(){
    $('#dialog').dialog('close');
}

////////////////////////////////////DIALOG//////////////////////////////////////


////////////////////////////////DISABLE/ENABLE//////////////////////////////////

function form_disable(form){
    $(form).find('input:submit').attr('disabled', 'disabled');
}

function form_enable(form){
        $(form).find('input:submit').removeAttr('disabled');
}

function enable_button(){
    $('.ui-dialog-buttonpane').find('.ui-dialog-buttonset').find('button').last().removeAttr('disabled');
}

/////////////////////////



function trim(string){
    return string.replace(/^\s+/g,'').replace(/\s+$/g,'');
}

function getDataAjax(url){
    this.url = url;
    this.data = null;
    this.async = true;
    this.spin = null;
    this.type = 'POST';
    this.dataType = 'json';
    this.receivedData = null;
    this.ok = null;
    this.error = null;
    this.form = null;
    this.getData = function(){
        var nurl = this.url;
        var ndata = this.data;
        var nasync = this.async;
        var ntype = this.type;
        var ndataType = this.dataType;
        var error = this.error;
        var ok = this.ok;
        var spin = this.spin;
        var form = this.form;
        show_spin(this.spin);
        click_button = true;
        $.ajax({
            url: nurl,
            data: ndata,
            type: ntype,
            dataType: ndataType,
            async: nasync
        })
        .done(function (data){
            if (data.status == 'OK'){
                if (ok){
                    ok(data);
                }
            } else {
                if (error)
                    error(data);
                else
                    show_error(data.msg);
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown){
            show_error('Ha ocurrido un error. Intentelo de nuevo m&aacute;s tarde.');
        })
        .complete(function (){
            hide_spin(spin);
            if(form)
                form_enable(form);
            click_button = false;
        });
    }
}