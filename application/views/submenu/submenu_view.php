<?php 
    if(isset($submenus) && $submenus){
        foreach($submenus as $submenu){
            echo '<li style="display:none;" class="submenu-o">';
            echo '<input type="hidden" name="tipo" value="'.$submenu['tipo'].'" />';
            echo '<input type="hidden" name="id" value="'.$submenu['id'].'" />';
            echo '<a href="';
            echo ($submenu['url'] != '')?$submenu['url']:'#';
            echo '">'.$submenu['nombre'].'</a>';
            if(isset($session) && $session){
                echo '<button class="editSm ui-icon ui-icon-pencil">l</button>';
                echo '<button class="deleteSm ui-icon ui-icon-trash">X</button>';
            }
            echo '</li>';
        }
        if (isset($session) && $session){
            echo '<li class="submenu-o"><input type="hidden" name="menu_id" value="'.$menu.'" /><button class="add-submenu submenu-o ui-icon ui-icon-plusthick">+</button></li>';
        }
    } else {
        echo '<li style="display:none;" class="submenu-o">No hay contenido</li>';
        if (isset($session) && $session){
            echo '<li class="submenu-o"><input type="hidden" name="menu_id" value="'.$menu.'" /><button class="add-submenu submenu-o ui-icon ui-icon-plusthick">+</button></li>';
        }
    }
?>