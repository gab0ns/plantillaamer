$(document).on('ready',function(){
    base_url = $('#base_url').val();
    
    $('#wrap').tooltip({
        track: true,
        show: {
            effect: "slideDown",
            delay: 250
        }
    });
    click_tree = false;
    menu_id = 0;
    
    outtree_mouse();
    
    colores = new Array('original','greenyellow','twogreen','green','blue','red');
    
    arboles = new Array(
        '<img class="img-color" style="display:none;" src="'+base_url + 'images/logo.png" width="480px" height="514px" />',
        '<img class="img-color" style="display:none;" src="'+base_url + 'images/3SS_0.png" width="480px" height="514px" />',
        '<img class="img-color" style="display:none;" src="'+base_url + 'images/5SS_0.png" width="480px" height="514px" />',
        '<img class="img-color" style="display:none;" src="'+base_url + 'images/6SS_0.png" width="480px" height="514px" />',
        '<img class="img-color" style="display:none;" src="'+base_url + 'images/7SS_0.png" width="480px" height="514px" />',
        '<img class="img-color" style="display:none;" src="'+base_url + 'images/9SS_0.png" width="480px" height="514px" />'
    );

    $('.menu').off('click');
    $('.menu').on('click',function(e){
        if (!click_tree){
            e.preventDefault();
            click_tree = true;
            var link = this;
            var li = $(this).closest('li');
            var tipo = $(li).find('input').eq(0).val();
            var tree = '';
            var loadImage = '';
            if(tipo == 1){
                menu_id = $(li).find('input').eq(1).val();
                get_submenu(menu_id);
                current_tree = $(this).attr('value');
                tree = jQuery.inArray(current_tree,colores);
                loadImage = $(arboles[tree]);
            }
            $('#logo').find('img').eq(0).hide({
                effect: 'explode',
                duration: 1000,
                complete: function(){
                    if (tipo == 1){
                        $('#logo').find('.logo').append(loadImage);
                        $('#logo').find('img').eq(1).show({
                            effect: 'explode',
                            duration: 1000,
                            complete:function(){
                                divide_image();
                                $('#logo').find('#intree').css('display','none');
                            }
                        });
                    } else {
                        $('#outtree').css('display','none');
                        window.location = $(link).attr('href');
                    }
                }
            });
        }
    });
    
    $('.editM').off('click');
    $('.editM').on('click',function(){
        var id = $(this).closest('li').find('input').eq(1).val();
        var dataAjax = new getDataAjax(base_url + 'admin/edit_menu');
        dataAjax.data = {id:id};
        dataAjax.spin = false;
        dataAjax.ok = function(data){
            $('#dialog').html(data.msg);
            $('#wrap').css('display','none');
            show_dialog('450', '600',
                function(){
                    $('#dialog').find('form').submit();
                },
                function(){
                    $('#wrap').css('display','block');
                }
            );
            update_menu();
        }
        dataAjax.getData();
    });
    
    $('.deleteM').off('click');
    $('.deleteM').on('click',function(){
        var id = $(this).closest('li').find('input').eq(1).val();
        show_confirm('¿Está seguro de querer eliminar el elemento?', function(){
            var numMenusIn = $('#intree').find('li').length;
            var numMenusOut= $('#outtree').find('li').length;
            var totalMenus = numMenusIn + (numMenusOut - 1);
            if(totalMenus > 6){
                var dataAjax = new getDataAjax(base_url + 'admin/delete_menu');
                dataAjax.data = {id:id};
                dataAjax.spin = false;
                dataAjax.ok = function(data){
                    show_exito_afterClose(data.msg, function(){
                        window.location.reload();
                    });
                }
                dataAjax.getData();
            } else {
                show_error('No se pudo eliminar porque no pueden haber menos de 6 elementos.');
            }
        });
    });
    
    $('.add-menu').off('click');
    $('.add-menu').on('click',function(){
        var dataAjax = new getDataAjax(base_url + 'admin/new_menu');
        dataAjax.spin = false;
        dataAjax.ok = function(data){
            $('#dialog').html(data.msg);
            $('#wrap').css('display','none');
            show_dialog('450', '600',
                function(){
                    $('#dialog').find('form').submit();
                },
                function(){
                    $('#wrap').css('display','block');
                }
            );
            update_menu();
        }
        dataAjax.getData();
    });
});

function divide_image(){
    var img = $('.img-color');
    var bg = $(img).attr('src');
    img.css('display', 'none');
    var pos = '',w = '',h = '';
    for (var i = 0; i < 3; i++) {
        switch (i) {
        case 0:
            $('<div class="image-block imgL posI"/>').
                css({
                    width: 480,
                    height: 282,
                    'background-image': 'url(\''+bg+'\')',
                    backgroundPosition: '0px 0px'
                }).prependTo('.logo');
            break;
        case 1:
            $('<div class="image-block posI" style="margin:280px 0 0 0;" />').
                css({
                    width: 480,
                    height: 89,
                    'background-image': 'url(\''+bg+'\')',
                    backgroundPosition: '0px -281px'
                }).prependTo('.logo');
            break;
        case 2:
            $('<div class="image-block imgL posI" style="margin:374px 0 0 0;" />').
                css({
                    width: 480,
                    height: 140,
                    'background-image': 'url(\''+bg+'\')',
                    backgroundPosition: '0px -375px'
                }).prependTo('.logo');
            break;
        default:
            break;
        }
    }
    $('<button id="close" class="'+current_tree+'-button-close" style="display:none;">X</button>').prependTo('.logo');
    $('<div id="contenido" style="display:none;" />').appendTo('.logo');
    go_back_tree();
}

function get_submenu(id){
    var dataAjax = new getDataAjax(base_url + 'menu/id');
    dataAjax.data = {id:id};
    dataAjax.spin = false;
    dataAjax.ok = function(data){
        if ($('#outtree').find('.menu-o').length > 0){
            $('#outtree').find('.menu-o').hide({
                effect:'fade',
                duration:1000,
                complete:function(){
                    submenu_links(data,1000);
                }
            });
        } else {
            submenu_links(data,3000);
        }
    }
    dataAjax.getData();
}

function submenu_links(data,duration){
    $('#outtree').append(data.msg);
    $('#outtree').find('.submenu-o').find('a').addClass(current_tree);
    $('#wrap').tooltip( "option", "tooltipClass", "tooltip-"+current_tree);
    $('#outtree').find('.submenu-o').show({
        effect:'fade',
        duration:duration,
        complete:function(){
            submenu_link_event();
            readEventsSubmenu();
        }
    });
}

function submenu_link_event(){
    show_content = false;
    current_link = 0;
    click_submenu = false;

    $('#outtree').find('.submenu-o').find('a').off('click');
    $('#outtree').find('.submenu-o').find('a').on('click',function(e){
        if ($(this).closest('li').find('input').eq(0).val() != 0){
            e.preventDefault();
            if (!click_submenu){
                click_submenu = true;
                var link = this;
                var contenido = function get_contenido(){
                    if ($(link).closest('li').find('input').eq(0).val() == 1){
                        var dataAjax = new getDataAjax(base_url + 'menu/contenido');
                        dataAjax.data = {id:$(link).closest('li').find('input').eq(1).val()};
                        dataAjax.spin = $('body');
                        dataAjax.ok = function(data){
                            $('#contenido').html(data.msg);
                            $('#contenido').fadeTo('fast',1,'linear',function(){
                                click_submenu = false;
                                $('#close').show('fast');
                            });
                        };
                        dataAjax.getData();
                    } else {
                        var dataAjax = new getDataAjax(base_url + 'menu/contenidoid');
                        dataAjax.data = {id:$(link).closest('li').find('input').eq(1).val()};
                        dataAjax.spin = $('body');
                        dataAjax.ok = function(data){
                            traerDoc(data.msg.id);
                        };
                        dataAjax.getData();
                    }
                };

                if (current_link != link){
                        $(current_link).removeClass("enlace");
                        current_link = link;
                        $(link).addClass("enlace");
                        if (!show_content){
                            show_animation(contenido);
                        } else {
                            $('#contenido').fadeOut('fast','linear',function(){
                                contenido();
                            });
                        }
                } else {
                        if (!show_content){
                            show_animation(contenido);
                            $(this).addClass("enlace");
                        } else {
                            hide_animation();
                            $(current_link).removeClass("enlace");
                        }
                }
            }
        }
});

$('#close').off('click');
$('#close').on('click',function(){
    hide_animation();
    $(current_link).removeClass("enlace");
});
    
}

function go_back_tree(){
    $('#logo').find('.image-block').eq(1).attr('title','Inicio');
    $('#logo').find('.image-block').eq(1).css('cursor','pointer');
    $('#logo').find('.image-block').eq(1).off('click');
    $('#logo').find('.image-block').eq(1).on('click',function(){
        if (click_tree){
            click_tree = false;
            $('#logo').find('.image-block').remove();
            $('#logo').find('.logo').find('img').eq(1).css('display','inline-block');
            $('#logo').find('.logo').find('img').eq(1).off('click');
            go_back_links();
            $('#logo').find('.logo').find('img').eq(1).hide({
                effect: 'explode',
                duration: 1000,
                complete: function(){
                    $('#logo').find('img').eq(0).show({
                        effect: 'explode',
                        duration: 1000,
                        complete:function(){
                            $('#logo').find('.logo').find('img').eq(1).remove();
                            $('#logo').find('#intree').css('display','block');
                        }
                    });
                }
            });
        }
    });
}

function go_back_links(){
    if ($('#outtree').find('.submenu-o').length > 0){
        $('#outtree').find('.submenu-o').hide({
            effect:'fade',
            duration:1000,
            complete:function(){
                if ($('#outtree').find('.menu-o').length > 0){
                    $('#outtree').find('.menu-o').show({
                        effect:'fade',
                        duration:1000,
                        complete:function(){
                            $('#wrap').tooltip("option", "tooltipClass","tooltip-greenyellow");
                            $('#outtree').find('.submenu-o').remove();
                        }
                    });
                } else {
                    $('#wrap').tooltip("option", "tooltipClass","tooltip-greenyellow");
                    $('#outtree').find('.submenu-o').remove();
                }
            }
        });
    } else {
        if ($('#outtree').find('.menu-o').length > 0){
            $('#outtree').find('.menu-o').show({
                effect:'fade',
                duration:1000,
                complete:function(){
                    $('#wrap').tooltip("option", "tooltipClass","tooltip-greenyellow");
                    $('#outtree').find('.submenu-o').remove();
                }
            });
        } else {
            $('#wrap').tooltip("option", "tooltipClass","tooltip-greenyellow");
        }
    }
}


function show_animation(callback){
        show_content = true;
        $("#logo").find('.image-block').eq(2).animate({top:'-270px',opacity:0.3},'slow',function(){
            click_submenu = false;
        });
        $("#logo").find('.image-block').eq(1).hide('fade',{percent: 3},'slow',function(){ 
            if (callback)
                    callback();
        });
        $("#logo").find('.image-block').eq(0).animate({top:'230px',opacity:0.3},'slow');
        $("#outtree").animate({'margin-top':'100px'},'slow');
}

function hide_animation(callback){
        show_content = false;
        $('#close').hide();
        $('#contenido').fadeOut('fast','linear',function(){
                $("#logo").find('.image-block').eq(2).animate({top:'5px',opacity:1},'slow',function(){
                    click_submenu = false;
                });
                $("#logo").find('.image-block').eq(1).show('fade',{percent: 100},'slow');
                $("#logo").find('.image-block').eq(0).animate({top:'5px',opacity:1},'slow');
                $("#outtree").animate({'margin-top':'40px'},'slow');
        });
}

function outtree_mouse(){
    var inTree = false;
    var visibleAlert = true;

    $('#intree').find('li').on('mouseenter',function(){
        inTree = true;
    });

    $('#intree').find('li').on('mouseleave',function(obj){
        inTree = false;
        visibleAlert = false;
    });
    
    /*$('#intree').on('mouseleave',function(obj){
        inTree = false;
        visibleAlert = true;
    });*/

    $(document).on('mousemove',function(mouse){
        if (visibleAlert == true){
            if (inTree == false){
                $('#cursorOut').show('fast','linear',function(){
                        $('#cursorOut').css('left',mouse.pageX);
                        $('#cursorOut').css('top',mouse.pageY);
                });
            } else {
                    $('#cursorOut').hide('fast','linear',function(){
                            $('#treeout').css('left',mouse.pageX);
                            $('#treeout').css('top',mouse.pageY);
                    });
            }
        }
    });
}

function update_menu(){
    var selectColor = $('#selectColor').val();
    setCurrentImageColor(selectColor);
    
    $('#selectColor').off('change');
    $('#selectColor').on('change',function(){
        setCurrentImageColor($(this).val());
    });
    
    $('#edit_menu').off('submit');
    $('#edit_menu').on('submit',function(e){
        e.preventDefault();
        var dataSend = $(this).serializeArray();
        var dataAjax = new getDataAjax($(this).attr('action'));
        dataAjax.data = $(this).serialize();
        dataAjax.spin = false;
        dataAjax.ok = function(data){
            show_exito_afterClose(data.msg, function(){
                window.location.reload();
            });
        };
        dataAjax.getData();
    });
}

function setCurrentImageColor(selectColor){
    var colorNow = jQuery.inArray(selectColor,colores);
    var loadImage = $(arboles[colorNow]);
    $(loadImage).css('display','inline');
    $(loadImage).attr('width','300');
    $(loadImage).attr('height','300');
    $('#imageTree').html(loadImage);
}

function update_submenu(){
    $('#edit_submenu').off('submit');
    $('#edit_submenu').on('submit',function(e){
        e.preventDefault();
        var dataSend = $(this).serializeArray();
        var dataAjax = new getDataAjax($(this).attr('action'));
        dataAjax.data = $(this).serialize();
        dataAjax.spin = false;
        dataAjax.ok = function(data){
            show_exito_afterClose(data.msg, function(){
                window.location.reload();
            });
        };
        dataAjax.getData();
    });
}

function readEventsSubmenu(){
    $('.editSm').off('click');
    $('.editSm').on('click',function(){
        var id = $(this).closest('li').find('input').eq(1).val();
        var dataAjax = new getDataAjax(base_url + 'admin/edit_submenu');
        dataAjax.data = {id:id};
        dataAjax.spin = false;
        dataAjax.ok = function(data){
            $('#dialog').html(data.msg);
            $('#wrap').css('display','none');
            show_dialog('800', '600',
                function(){
                    $('#dialog').find('form').submit();
                },
                function(){
                    $('#wrap').css('display','block');
                }
            );
            tipoSubmenu();
        }
        dataAjax.getData();
    });
    
    $('.deleteSm').off('click');
    $('.deleteSm').on('click',function(){
        var id = $(this).closest('li').find('input').eq(1).val();
        show_confirm('¿Está seguro de querer eliminar el elemento?', function(){
            var dataAjax = new getDataAjax(base_url + 'admin/delete_submenu');
            dataAjax.data = {id:id};
            dataAjax.spin = false;
            dataAjax.ok = function(data){
                show_exito_afterClose(data.msg, function(){
                    window.location.reload();
                });
            }
            dataAjax.getData();
        });
    });
    
    $('.add-submenu').off('click');
    $('.add-submenu').on('click',function(){
        var dataAjax = new getDataAjax(base_url + 'admin/new_submenu');
        dataAjax.data = {menu_id:menu_id};
        dataAjax.spin = false;
        dataAjax.ok = function(data){
            $('#dialog').html(data.msg);
            $('#wrap').css('display','none');
            show_dialog('800', '600',
                function(){
                    $('#dialog').find('form').submit();
                },
                function(){
                    $('#wrap').css('display','block');
                }
            );
            tipoSubmenu();
        }
        dataAjax.getData();
    });
}

function tipoSubmenu(){
    jsLoaded = false;
    if($('#tipoSm').val() == 1){
        CKEDITOR_BASEPATH = base_url + 'js/ckeditor/';
        $.getScript(base_url + "js/ckeditor/ckeditor.js", function(data, textStatus, jqxhr) {
            jsLoaded = true;
            var textarea = document.getElementById('contenidoText');
            var editor = CKEDITOR.replace('contenidoText');
        });
    }
    $('#tipoSm').off('change');
    $('#tipoSm').on('change',function(){
        var tipoVal = $(this).val();
        
        if(tipoVal == 1){
            if(!jsLoaded){
                CKEDITOR_BASEPATH = base_url + 'js/ckeditor/';
                $.getScript(base_url + "js/ckeditor/ckeditor.js", function(data, textStatus, jqxhr) {
                    jsLoaded = true;
                    var textarea = document.getElementById('contenidoText');
                    var editor = CKEDITOR.replace('contenidoText');
                    CKEDITOR.on('contenidoText', function(){
                        modified = true;
                    });
                });
            } else {
                $('#contenidoText').val('');
                $('#url').val('');   
            }
            editSubmenuSend();
        } else if(tipoVal == 0) {
            $('#contenidoText').val('');
            $('#url').val('');
            $('#url').attr('type','text');
            $('#url').attr('name','url');
            $('#url').closest('div').find('p').text('Url:');
            editSubmenuSend();
        } else if(tipoVal == 2) {
            $('#url').attr('type','file');
            $('#url').attr('name','doc');
            $('#url').closest('div').find('p').text('Archivo:');
            editSubmenuSendFile();
        }
    });
}

function editSubmenuSend(){
    $('#edit_submenu').off('submit');
    $('#edit_submenu').on('submit',function(e){
        e.preventDefault();
        var data = '';
        if($('#tipoSm').val() == 1){
            var value = CKEDITOR.instances['contenidoText'].getData();
            data = $(this).serialize() + '&menu_id=' + encodeURI(menu_id) + '&contenido=' + encodeURIComponent(value);
        } else {
            data = $(this).serialize() + '&menu_id=' + encodeURI(menu_id);
        }

        var dataAjax = new getDataAjax($(this).attr('action'));
        dataAjax.data = data;
        dataAjax.spin = false;
        dataAjax.ok = function(data){
            show_exito_afterClose(data.msg, function(){
                //window.location.reload();
            });
        };
        dataAjax.getData();
    });
}
function editSubmenuSendFile(){
    $('#edit_submenu').off('submit');
    $('#edit_submenu').on('submit',function(e){
        e.preventDefault();
        var url = $(this).attr('action');
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: url,
            enctype: 'multipart/form-data',
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false
        })
        .done(function(data){
            if(data.status == 'OK'){
                show_exito_afterClose(data.msg,function(){
                    window.location.reload(true);
                });
            }else{
                show_error(data.msg);
            }
        })
        .complete(function(){
        }) 
        .fail(function (){
            show_error('Ha ocurrido un error. Intentelo de nuevo m&aacute;s tarde.');
        });
    });
}

function traerDoc(id){
    /*var testFrame = $("IFRAME");
    //$("#testFrame").remove();
    testFrame.id = "doc";
    testFrame.width="110%";
    testFrame.height="800";
    testFrame.scrolling="no";
    testFrame.frameborder="0px";
    testFrame.src = base_url + 'docs/' + id + ".pdf?wmode=transparent"; //Sacar el nombre del fichero pdf desde el parametro
    $('#contenido').html(testFrame);*/
    
   var doc = $('<object width="100%" data="' + base_url + 'docs/' + id + '.pdf" type="application/pdf" />');
   $(doc).append('<embed src="' + base_url + 'docs/' + id + '.pdf" type="application/pdf" />');
   $('#contenido').html(doc);
   $('#contenido').fadeTo('fast',1,'linear',function(){
        click_submenu = false;
        $('#close').show('fast');
   });

}