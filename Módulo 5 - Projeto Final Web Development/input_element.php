<?php

function inputField($placeholder, $name, $type, $value, $id, $onchange, $autocomplete)
{

    $element =
        "
    <div class=\"input-container\">
        <input type='$type' name='$name' id='$id' placeholder='$placeholder' value='$value' onchange='$onchange' autocomplete='$autocomplete' required>
    </div>
    ";
    echo $element;
}
