<a href="<?php echo base_url(); ?>admin" class="btn btn-primary btn-block">Regresar</a>
<div id="admin_view">
    <?php
    if (isset($users) && $users){
        echo '<h3>Usuarios</h3>';
        $current_user = $this->session->userdata('user');
        echo '<ul>';
        foreach($users as $user){
            if ($user['id'] == $current_user['id'])
                echo '<li><input type="hidden" value="'.$user['id'].'" />'.$user['nombre'].'<button class="edit-user ui-icon ui-icon-pencil">i</button></li>';
            else
                echo '<li><input type="hidden" value="'.$user['id'].'" />'.$user['nombre'].'<button class="edit-user ui-icon ui-icon-pencil">i</button><button class="delete-user ui-icon ui-icon-trash">X</button></li>';
        }
        echo '</ul>';
    }
    ?>
    <button class="add-user btn btn-lg btn-primary btn-block">Agregar usuario</button>
</div>