<?php

function gerar_select($tabela, $coluna, $name, $selected = '') {
    global $conn;
    $res = mysqli_query($conn, "SELECT DISTINCT $coluna FROM $tabela WHERE habilitada = 1 ORDER BY $coluna");
    $html = "<select name='$name' id='edit_$name' class='form-select' required>";
    $html .= "<option value=''>Selecione</option>";
    while ($row = mysqli_fetch_assoc($res)) {
        $valor = htmlspecialchars($row[$coluna]);
        $sel = ($valor == $selected) ? 'selected' : '';
        $html .= "<option value='$valor' $sel>$valor</option>";
    }
    $html .= "</select>";
    return $html;
}
