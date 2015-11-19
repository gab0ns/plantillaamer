<div>
    <input type="hidden" value="Editar Menu" class="title_dialog" />
    <form id="edit_menu" action="<?php echo base_url();?>admin/update_menu" >
        <input type="hidden" name="id" value="<?php echo $menu['id']; ?>" />
        <div>
            Título:
            <input type="text" name="nombre" value="<?php echo $menu['nombre']; ?>" />
        </div>
        <div>
            Tipo:
            <select name="tipo">
            <?php
                $tipos = array(
                    array('n' => 'Contenido','val' => '1'),
                    array('n' => 'Enlace','val' => 0));
                for($i = 0;$i < count($tipos);$i++){
                    echo '<option ';
                    if ($tipos[$i]['val'] == $menu['tipo'])
                        echo ' selected=selected ';
                    echo 'value="'.$tipos[$i]['val'].'">'.$tipos[$i]['n'].'</option>';
                }
            ?>
            </select>
        </div>
        
        <div>
            Url:
            <input type="text" name="url" value="<?php echo ($menu['url'])?$menu['url']:''; ?>" />
        </div>
        
        <div>
            Color:
            <select id="selectColor" name="color">
            <?php
                $colores = array('original','greenyellow','twogreen','green','blue','red');
                for($i = 0;$i < count($colores);$i++){
                    echo '<option ';
                    if ($colores[$i] == $menu['color'])
                        echo ' selected=selected ';
                    echo 'value="'.$colores[$i].'">'.$colores[$i].'</option>';
                }
            ?>
            </select>
        </div>
        <div id="imageTree">
        </div>
    </form>
</div>