<div>
    <input type="hidden" value="Edición Contenido" class="title_dialog" />
    <form id="edit_submenu" action="<?php echo base_url(); ?>admin/update_submenu" >
        <input type="hidden" name="id" value="<?php echo $submenu['id']; ?>" />
        <div>
            Título:
            <input type="text" name="nombre" value="<?php echo $submenu['nombre']; ?>" />
        </div>
        <div>
            Tipo:
            <select id="tipoSm" name="tipo">
            <?php
                $tipos = array(
                    array('n' => 'Enlace','val' => 0),
                    array('n' => 'Contenido','val' => '1'));
                for($i = 0;$i < count($tipos);$i++){
                    echo '<option ';
                    if ($tipos[$i]['val'] == $submenu['tipo'])
                        echo ' selected=selected ';
                    echo 'value="'.$tipos[$i]['val'].'">'.$tipos[$i]['n'].'</option>';
                }
            ?>
            </select>
        </div>
        
        <div>
            Url:
            <input id="url" type="text" name="url" value="<?php echo ($submenu['url'])?$submenu['url']:''; ?>" />
        </div>
        
        <div>
            Contenido:
            <textarea id="contenidoText"><?php echo (isset($submenu['contenido']) && $submenu['contenido'])?$submenu['contenido']:''; ?></textarea>
        </div>
    </form>
</div>