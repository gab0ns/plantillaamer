<div>
    <input type="hidden" value="Nuevo Contenido" class="title_dialog" />
    <form id="edit_submenu" action="<?php echo base_url();?>admin/save_submenu" >
        <input type="hidden" name="menu_id" value="<?php echo $menu; ?>" />
        <div>
            Título:
            <input type="text" name="nombre" value="" />
        </div>
        <div>
            Tipo:
            <select id="tipoSm" name="tipo">
            <?php
                $tipos = array(
                    array('n' => 'Enlace','val' => 0),
                    array('n' => 'Contenido','val' => '1'),
                    array('n' => 'Documento','val' => '2'));
                for($i = 0;$i < count($tipos);$i++){
                    echo '<option value="'.$tipos[$i]['val'].'">'.$tipos[$i]['n'].'</option>';
                }
            ?>
            </select>
        </div>
        
        <div>
            <p>Url:</p>
            <input id="url" type="text" name="url" value="" />
        </div>
        
        <div id="contentTipo">
            Contenido:
            <textarea id="contenidoText"></textarea>
        </div>
    </form>
</div>