<div id="edit_user">
    <input type="hidden" value="Editar Usuario" class="title_dialog" />
    <form id="saveUser" action="<?php echo base_url(); ?>admin/save_user" method="POST" >
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
        
        <div>
            Nombre:
            <input type="text" name="nombre" value="<?php echo $user['nombre']; ?>" />
        </div>
        
        <div>
            Usuario:
            <input type="text" name="usuario" value="<?php echo $user['usuario']; ?>" />
        </div>
        
        <div>
            Contrase&ntilde;a:
            <input type="password" name="password" value="" />
        </div>
        <div>
            Repetir Contrase&ntilde;a:
            <input type="password" name="rpassword" value="" />
        </div>
    </form>
</div>