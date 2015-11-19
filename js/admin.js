 $(function() {
    
    base_url = $('#base_url').val();
    
    //Se ejecuta cuando se envia el formulario para acceder
    $('#form_login').off('submit');
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
    
    
    $('.edit-user').off('click');
    $('.edit-user').on('click',function(){
        var li = this;
        var dataAjax = new getDataAjax(base_url + 'admin/user');
        dataAjax.data = {id:$(li).closest('li').find('input').val()};
        dataAjax.spin = false;
        dataAjax.ok = function(data){
            $('#dialog').html(data.msg);
            show_dialog(450, 350, function(){
                save_user();
                $('#saveUser').submit();
            });
        }
        dataAjax.getData();
    });
    
    $('.add-user').off('click');
    $('.add-user').on('click',function(){
        var li = this;
        var dataAjax = new getDataAjax(base_url + 'admin/insert_user');
        //dataAjax.data = {id:$(li).closest('li').find('input').val()};
        dataAjax.spin = false;
        dataAjax.ok = function(data){
            $('#dialog').html(data.msg);
            show_dialog(450, 350, function(){
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
    
    $('.delete-user').on('click',function(){
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
});