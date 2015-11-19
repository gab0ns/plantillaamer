<div id="logo">
    <div class="logo">
        <img src="<?php echo base_url(); ?>images/logo.png" width="480px"/>
    </div>
    <?php 
    if (isset($menus) && $menus != FALSE){ 
        $current = 0;
        
        //arriba de el árbol
        echo '<ul id="intree">';
        for($i = $current;$i < 6; $i++){
            $div = '<li ';
            switch ($i){
                case 0:
                    $div .= 'style="margin-left:90px; width:288px; height:65px;"';
                    break;
                case 1:
                    $div .= 'style="margin:5px 0 0 80px; width:307px; height:65px;"';
                    break;
                case 2:
                    $div .= 'style="margin:5px 0 0 90px; width:288px; height:65px;"';
                    break;
                case 3:
                    $div .= 'style="width:33px; height:65px; margin:5px 0 0 222px;"';
                    break;
                case 4:
                    $div .= 'style="width:480px; height:93px; margin:5px 0 0 0px;"';
                    break;
                case 5:
                    $div .= 'style="width:95px; height:135px; margin:5px 0 0 190px;"';
                    break;
            }
            $div .= '>';
            $div .= '<input type="hidden" name="tipo" value="'.$menus[$i]['tipo'].'" />';
            $div .= '<input type="hidden" name="id" value="'.$menus[$i]['id'].'" />';
            if(isset($session) && $session){
                $div .= '<button class="editM ui-icon ui-icon-pencil">l</button>';
                $div .= '<button class="deleteM ui-icon ui-icon-trash">X</button>';
            }
            $a = '<a title="'.$menus[$i]['nombre'].'" class="menu" href="';
            $a .= ($menus[$i]['url'] != '')?$menus[$i]['url']:'#';
            $a .= '" value="'.$menus[$i]['color'].'">&nbsp;</a>';
            $div .= $a;
            $div .= '</li>';
            $current++;
            echo $div;
        }
        echo '</ul></div>';
        
        echo '<ul id="outtree">';
        for($i = $current;$i < count($menus);$i++){
            $div = '<li class="menu-o">';
            $div .= '<input type="hidden" name="tipo" value="'.$menus[$i]['tipo'].'" />';
            $div .= '<input type="hidden" name="id" value="'.$menus[$i]['id'].'" />';
            $a = '<a href="';
            $a .= ($menus[$i]['url'] != '')?$menus[$i]['url']:'#';
            $a .= '"';
            $a .= ' class="menu" ';
            $a .= ' value="'.$menus[$i]['color'].'">'.$menus[$i]['nombre'];
            $a .= '</a>';
            $div .= $a;
            if(isset($session) && $session){
                $div .= '<button class="editM ui-icon ui-icon-pencil">l</button>';
                $div .= '<button class="deleteM ui-icon ui-icon-trash">X</button>';
            }
            $div .= '</li>';
            echo $div;
        }
        if(isset($session) && $session){
                echo '<li class="menu-o"><button class="add-menu ui-icon ui-icon-plusthick">+</button></li>';
            }
        echo '</ul>';
    }
 ?>
    <div id="cursorOut"><span class="ui-icon ui-icon-alert"></span>Coloque el cursor sobre el árbol</div>