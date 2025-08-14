<?php if (isset($pagination) && $pagination['totalPages'] > 1): ?>
<div class="pagination">
    <?php if ($pagination['hasPrev']): ?>
        <a href="?page=<?= $pagination['currentPage'] - 1 ?>" class="pagination-link">&laquo; 前へ</a>
    <?php endif; ?>
    
    <?php for ($i = 1; $i <= $pagination['totalPages']; $i++): ?>
        <?php if ($i == $pagination['currentPage']): ?>
            <span class="pagination-current"><?= $i ?></span>
        <?php else: ?>
            <a href="?page=<?= $i ?>" class="pagination-link"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    
    <?php if ($pagination['hasNext']): ?>
        <a href="?page=<?= $pagination['currentPage'] + 1 ?>" class="pagination-link">次へ &raquo;</a>
    <?php endif; ?>
    
    <div class="pagination-info">
        <?= $pagination['totalCount'] ?>件中 <?= ($pagination['currentPage'] - 1) * 5 + 1 ?>-<?= min($pagination['currentPage'] * 5, $pagination['totalCount']) ?>件を表示
    </div>
</div>
<?php endif; ?>