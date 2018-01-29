<?php

/**
 * @param $id = post_id
 * @param $user_id = user_id
 */
function formComment($id, $user_id, $message)
{
    if(isset($_SESSION['soc_id'])) {
        $html = "<div class='btn change'>
                <a href='#' id='$id' onclick='modal_data(this.id)' data-toggle='modal' data-target='.modal-comment'>Ответить</a>
             </div>";
        if($_SESSION['soc_id'] == $user_id){
            $html .= "<div class='btn change'>
                <a href='#' id='$id' onclick='modal_edit(this.id)' data-toggle='modal' data-target='.modal-comment'>Редактировать</a>
             </div>";
        }
        return $html;
    }
    return false;
}