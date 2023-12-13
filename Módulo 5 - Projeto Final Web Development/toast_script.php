<?php

function Toast($toastSession, $toastText = 'Not defined', $toastBackground = '#BA2728', $toastDuration = '5000', $toastGravity = 'top')
{
    $_SESSION[$toastSession] = '<script type="text/javascript">Toastify({
        text: "' . $toastText . '",
        style: {
            background: "' . $toastBackground . '",
          },
          offset: {
            y: "70px"
          },
        duration: ' . $toastDuration . ',
        gravity: "' . $toastGravity . '",
    }).showToast();</script>';
}

function printToast($toastSession)
{
    echo $_SESSION[$toastSession];
    $_SESSION[$toastSession] = '';
}