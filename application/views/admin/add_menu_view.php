<div>
    <input type="hidden" value="Nuevo Menu" class="title_dialog" />
    <form id="edit_menu" action="<?php echo base_url();?>admin/save_menu" >
        <div>
            Título:
            <input type="text" name="nombre" value="" />
        </div>
        <div>
            Tipo:
            <select id="tipoMenu" name="tipo">
            <?php
                $tipos = array(
                    array('n' => 'Contenido','val' => '1'),
                    array('n' => 'Enlace','val' => 0));
                for($i = 0;$i < count($tipos);$i++){
                    echo '<option value="'.$tipos[$i]['val'].'">'.$tipos[$i]['n'].'</option>';
                }
            ?>
            </select>
        </div>
        
        <div>
            Url:
            <input id="url" type="text" name="url" value="" />
        </div>
        
        <div>
            Color:
            <select id="selectColor" name="color">
            <?php
                $colores = array('original','greenyellow','twogreen','green','blue','red');
                for($i = 0;$i < count($colores);$i++){
                    echo '<option value="'.$colores[$i].'">'.$colores[$i].'</option>';
                }
            ?>
            </select>
        </div>
        <div id="imageTree">
        </div>
    </form>
</div>