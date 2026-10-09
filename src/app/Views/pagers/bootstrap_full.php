<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<?php if ($pager->getPageCount() > 1): ?>
    <nav aria-label="Навигация по комментариям" class="mb-4">
        <ul class="pagination mb-0">
            <li class="page-item<?= $pager->hasPreviousPage() ? '' : ' disabled' ?>">
                <?php if ($pager->hasPreviousPage()): ?>
                    <a class="page-link" href="<?= esc($pager->getPreviousPage(), 'attr') ?>" rel="prev">Назад</a>
                <?php else: ?>
                    <span class="page-link">Назад</span>
                <?php endif; ?>
            </li>

            <?php foreach ($pager->links() as $link): ?>
                <li class="page-item<?= $link['active'] ? ' active' : '' ?>">
                    <a class="page-link" href="<?= esc($link['uri'], 'attr') ?>">
                        <?= esc($link['title']) ?>
                    </a>
                </li>
            <?php endforeach; ?>

            <li class="page-item<?= $pager->hasNextPage() ? '' : ' disabled' ?>">
                <?php if ($pager->hasNextPage()): ?>
                    <a class="page-link" href="<?= esc($pager->getNextPage(), 'attr') ?>" rel="next">Вперёд</a>
                <?php else: ?>
                    <span class="page-link">Вперёд</span>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
<?php endif; ?>
