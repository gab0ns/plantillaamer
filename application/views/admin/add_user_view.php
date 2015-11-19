<div id="edit_user">
    <input type="hidden" value="Nuevo Usuario" class="title_dialog" />
    <form id="addUser" action="<?php echo base_url(); ?>admin/add_user" method="POST" >
        <div>
            Nombre:
            <input type="text" name="nombre" value="" />
        </div>
        
        <div>
            Usuario:
            <input type="text" name="usuario" value="" />
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