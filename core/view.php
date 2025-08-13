<?php
function renderWithLayout($templatePath, $data = []) {
    extract($data);
    
    ob_start();
    include $templatePath;
    $content = ob_get_clean();
    
    return $content;
}