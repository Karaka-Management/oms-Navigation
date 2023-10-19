<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Navigation
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\Navigation\Models\NavigationType;

/**
 * @var \Modules\Navigation\Views\NavigationView $this
 */
if (isset($this->nav[NavigationType::TOP])) : ?>
    <ul id="t-nav" role="list">
        <?php $unread = $this->data['unread'];
        foreach ($this->nav[NavigationType::TOP] as $key => $parent) :
        foreach ($parent as $id => $link) : ?>
        <li><a
            id="link-<?= $id; ?>"
            target="<?= $link['nav_target']; ?>"
            href="<?= \phpOMS\Uri\UriFactory::build($link['nav_uri']); ?>"
            <?= $link['nav_action'] !== null ? ' data-action=\'' . $link['nav_action'] . '\'' : ''; ?>>
                <?php if (isset($link['nav_icon'])) : ?>
                    <i class="g-icon infoIcon">
                        <?= $this->printHtml($link['nav_icon']); ?>
                        <?php if (isset($unread[$link['nav_from']]) && $unread[$link['nav_from']] > 0) : ?>
                            <span class="badge"><?= $unread[$link['nav_from']]; ?></span>
                        <?php endif; ?>
                    </i>
                <?php endif; ?>
                <span class="link"><?= $this->getHtml($link['nav_name'], 'Navigation'); ?><span></a>
        <?php endforeach; endforeach; ?>
    </ul>
<?php endif;
