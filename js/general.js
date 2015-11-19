$(document).on('ready',function(){
    base_url = $('#base_url').val();
    
    var id_interval;
    var current_tree;
    $(document).tooltip({
            track: true
    });
    
    var colores = new Array('original','greenyellow','twogreen','green','blue','red');
    
    //Se ejecuta cuando se envia el formulario para acceder
    $('#form_login').on('submit',function(event){
        event.preventDefault();
        var dataAjax = new getDataAjax($(this).attr('action'));
        dataAjax.data = $(this).serialize();
        dataAjax.spin = $('#spin');
        dataAjax.ok = function(data){
            show_exito_afterClose(data.msg,function(){
                window.location = base_url + 'admin';
            });
        };
        dataAjax.getData();
    });
    
    
    var blue = '<div class="colors" width="500px;">';
    blue += '<button style="display:none;" id="close">X</button>';
    blue += '<img class="imgL posI" src="'+ base_url +'images/7SS_1.png" width="322px" style="display:none; margin-left:112px" />';
    blue += '<img class="posI" src="'+ base_url +'images/7SS_2.png" width="436px" title="Inicio" style="display:none; margin:303px 0 0 56px" />';
    blue += '<img class="imgL posI" src="'+ base_url +'images/7SS_3.png" width="500px" style="display:none; margin:391px 0 0 25px"/></div>';
    
    var arboles = new Array(
        '<img style="display:none; z-index: 140; width: 500px; height: 536px;" src="'+ base_url +'images/3SS_0.png" width="100%"/>',
        '<img style="display:none; z-index: 130; width: 500px; height: 536px;" src="'+ base_url +'images/5SS_0.png" width="100%"/>',
        '<img style="display:none; z-index: 120; width: 500px; height: 536px;" src="'+ base_url +'images/6SS_0.png" width="100%"/>',
        //'<img style="display:none; z-index: 110; width: 500px; height: 536px;" src="'+ base_url +'images/7SS_0.png" width="100%"/>',
        blue,
        '<img style="display:none; z-index: 100; width: 500px; height: 536px;" src="'+ base_url +'images/9SS_0.png" width="100%"/>'
    );

    $('.menu').on('click',function(e){
        var link = this;
        e.preventDefault();
        current_tree = $(this).closest('a').attr('value');
        //show_accordion();
        var tree = jQuery.inArray(current_tree,colores);
        var loadImage = $(arboles[tree - 1]);
        $('#logo').find('img').eq(0).hide({
            effect: 'explode',
            duration: 3000,
            complete: function(){
                if (current_tree == 'original'){
                    $('#logo').find('img').eq(0).show({
                        effect: 'explode',
                        duration: 3000,
                        complete:function(){
                            window.location = $(link).attr('href');
                        }
                    });
                } else {
                    //var arbol = $(arboles[tree - 1]);
                    var arbol = loadImage;
                    $('#logo').prepend(loadImage);
                    
                    $('#logo').find('div').eq(0).show(1, function(){
                        $('#logo').find('div').eq(0).find('img').show({
                        //arbol.show({
                        //$('#logo').find('img').eq(tree).show({
                            effect: 'explode',
                            duration: 3000,
                            complete:function(){
                                window.location = $(link).attr('href');
                            }
                        });
                    });
                }
            }
        });
    });
    
    $('#logo').find('img').eq(1).on('click',function(e){
        var link = this;
        e.preventDefault();
        console.log('ola k ace');
    });
    
    var show_content = false;
    var current_link;

    $('#logo').find('img').eq(1).addClass('cursor');

    /*$('#logo').find('img').eq(1).on('click',function(){
            //window.location = base_url + 'principal/menu';
    });*/

    $('#links').find('a').on('click',function(e){
            e.preventDefault();
            var contenido = function(){
                $('#contenido').html($('#text').html());
                $('#contenido').fadeTo('fast',1,'linear',function(){ 
                    $('#close').show('fast');
                });
            };

            //Si el link es diferente al actual
            if (current_link != this){
                    $(current_link).removeClass("enlace");
                    current_link = this;
                    $(this).addClass("enlace");

                    //Si no hay contenido mostrado
                    if (!show_content){
                            show_animation(contenido);
                    } else {
                    //Si hay contenido mostrado
                            $('#contenido').fadeOut('fast','linear',function(){
                                    contenido();
                            });
                    }
            //Si pulsa el link actual
            } else {
                    if (!show_content){
                            show_animation(contenido);
                            $(this).addClass("enlace");
                    } else {
                            hide_animation();
                            $(current_link).removeClass("enlace");
                    }
            }
    });

    $('#close').on('click',function(){
            hide_animation();
            $(current_link).removeClass("enlace");
    });

    function show_animation(callback){
            show_content = true;
            $("#logo").find('img').eq(0).animate({top:'-275px',opacity:0.3},'slow');
            $("#logo").find('img').eq(1).hide('scale',{percent: 3},'slow',function(){ 
                    if (callback)
                            callback();
            });
            $("#logo").find('img').eq(2).animate({top:'200px',opacity:0.3},'slow');
    }

    function hide_animation(callback){
            show_content = false;
            $('#close').hide();
            $('#contenido').fadeOut('fast','linear',function(){
                    $("#logo").find('img').eq(0).animate({top:'5px',opacity:1},'slow');
                    $("#logo").find('img').eq(1).show('scale',{percent: 100},'slow');
                    $("#logo").find('img').eq(2).animate({top:'5px',opacity:1},'slow');
            });
    }
    
    var showing = true;
    var img_current = 0,distance = 0;
    var n_tree = $('#logo').find('img').length;
    
    function show_accordion(){
        //mandar hacia atras si es diferente al 1.
        //Traer hacia al frente
        //--centrarlo y al mismo tiempo ocultar las demás (movimiento al centro);
        //id_interval = setInterval(function(){
        //},500);
        cicle();
    }
    
    function cicle(){
        if (showing){
            $('#logo').find('img').eq(img_current).css('display','inline-block');
            $("#logo").find('img').eq(img_current).animate(
                {
                    left:''+distance+'px'
                },
                {
                    duration: 1/8100,
                    complete: function(){
                        for(var i = img_current;i < n_tree - 1;i++){
                            $('#logo').find('img').eq(i).css('left',distance);
                        }
                        distance = distance + 150;
                        img_current++;
                        if (img_current > 5)
                            stop_interval();
                        cicle();
                    }
                }
            );
        }
    }
    
    function front_tree(){
        var tree = jQuery.inArray(current_tree,colores);
        $('#logo').find('img').eq(tree).css('z-index','160');
        var leftn = 150;
        var rightn = 150;
       // if (tree != 0 && tree != 5 != -1){
            for(var left = tree - 1; left >= 0;left--){
                $('#logo').find('img').eq(left).css('z-index',''+leftn+'');
                leftn = leftn - 10;
            }
            for(var right = tree + 1; right < n_tree;right++){
                $('#logo').find('img').eq(right).css('z-index',''+rightn+'');
                rightn = rightn - 10;
            }
        //}
        showing = true;
    }
    
    function join_tree(){
        
        if (showing){
            $("#logo").find('img').eq(img_current).animate(
                {
                    left:''+distance+'px'
                },
                {
                    duration: 1/8100,
                    complete: function(){
                        for(var i = img_current;i < n_tree - 1;i++){
                            $('#logo').find('img').eq(i).css('left',distance);
                        }
                        distance = distance + 150;
                        img_current++;
                        if (img_current > 5)
                            stop_interval();
                        cicle();
                    }
                }
            );
        }
    }
    
    function stop_reversa(){
        showing = false;
        //clearInterval(id_interval);
    }
    
    function stop_interval(){
        showing = false;
        front_tree();
        //clearInterval(id_interval);
    }
    
    $('#list_users').find('.edit-user').on('click',function(){
        var li = this;
        var dataAjax = new getDataAjax(base_url + 'admin/user');
        dataAjax.data = {id:$(li).closest('li').find('input').val()};
        dataAjax.spin = false;
        dataAjax.ok = function(data){
            $('#dialog').html(data.msg);
            show_dialog(300, 400, function(){
                save_user();
                $('#saveUser').submit();
            });
        }
        dataAjax.getData();
    });
    
    $('#list_users').find('.add-user').on('click',function(){
        var li = this;
        var dataAjax = new getDataAjax(base_url + 'admin/insert_user');
        //dataAjax.data = {id:$(li).closest('li').find('input').val()};
        dataAjax.spin = false;
        dataAjax.ok = function(data){
            $('#dialog').html(data.msg);
            show_dialog(300, 400, function(){
                add_user();
                $('#addUser').submit();
            });
        }
        dataAjax.getData();
    });
    
    function add_user(){
        $('#addUser').off('submit');
        $('#addUser').on('submit',function(e){
            e.preventDefault();
            var dataAjax = new getDataAjax(base_url + 'admin/add_user');
            dataAjax.data = $(this).serialize();
            dataAjax.spin = false;
            dataAjax.ok = function(data){
                show_exito_afterClose(data.msg,function(){
                    window.location.reload();
                });
            }
            dataAjax.getData();
        });
    }
    
    function save_user(){
        $('#saveUser').off('submit');
        $('#saveUser').on('submit',function(e){
            e.preventDefault();
            var dataAjax = new getDataAjax(base_url + 'admin/save_user');
            dataAjax.data = $(this).serialize();
            dataAjax.spin = false;
            dataAjax.ok = function(data){
                show_exito_afterClose(data.msg,function(){
                    window.location.reload();
                });
            }
            dataAjax.getData();
        });
    }
    
    $('#list_users').find('.delete-user').on('click',function(){
        var li = this;
        show_confirm('¿Está seguro de eliminar el usuario?', function(){
            var dataAjax = new getDataAjax(base_url + 'admin/delete_user');
            dataAjax.data = {
                id : $(li).closest('li').find('input').val()
            };
            dataAjax.spin = false;
            dataAjax.ok = function(data){
                show_exito_onShow(data.msg, function(){
                    $(li).closest('li').remove();
                });
            }
            dataAjax.getData();
        });
    });
    
    $('.add-menu').on('click',function(){
        var li = this;
        var dataAjax = new getDataAjax(base_url + 'admin/add_menu');
        //dataAjax.data = {id:$(li).closest('li').find('input').val()};
        dataAjax.spin = false;
        dataAjax.ok = function(data){
            $('#dialog').html(data.msg);
            show_dialog(400, 600, function(){
            });
        }
        dataAjax.getData();
    });
});