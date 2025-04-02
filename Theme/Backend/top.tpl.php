<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Navigation
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
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
        <?php
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
                        <?php if (isset($this->data['unread'][$link['nav_from']]) && $this->data['unread'][$link['nav_from']] > 0) : ?>
                            <span class="badge"><?= \strlen((string) $this->data['unread'][$link['nav_from']]) >= 3 ? '∞' : $this->data['unread'][$link['nav_from']]; ?></span>
                        <?php endif; ?>
                    </i>
                <?php endif; ?>
                <span class="link"><?= empty($link['nav_name']) ? '' : $this->getHtml($link['nav_name'], 'Navigation'); ?><span></a>
        <?php endforeach; endforeach; ?>
    </ul>
<?php endif;
