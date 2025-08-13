<?php
function renderWithLayout(string $templatePath, array $data = []): string {
    extract($data);
    
    ob_start();
    include $templatePath;
    $content = ob_get_clean();
    
    return $content;
}