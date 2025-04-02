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

use \Modules\Navigation\Models\LinkType;
use \Modules\Navigation\Models\NavigationType;

/**
 * @var \Modules\Navigation\Views\NavigationView $this
 */
if (isset($this->nav[NavigationType::SIDE])) : ?>
<div id="nav-side-outer" class="oms-ui-state">
    <ul id="nav-side-inner" class="nav" role="list">
        <?php
        $uriPath = $this->request->uri->getPath();
        foreach ($this->nav[NavigationType::SIDE][LinkType::CATEGORY] as $key => $parent) : ?>
        <li><input name="category-<?= $key; ?>" class="oms-ui-state" id="nav-<?= $this->printHtml($parent['nav_name']); ?>" type="checkbox">
            <ul>
                <li><label for="nav-<?= $this->printHtml($parent['nav_name']); ?>">
                    <?php if (isset($parent['nav_icon'])) : ?>
                        <i class="g-icon"><?= $this->printHtml($parent['nav_icon']); ?></i>
                    <?php endif; ?>
                    <span><?= $this->getHtml($parent['nav_name'], 'Navigation'); ?></span><i class="g-icon expand">chevron_right</i></label>
                    <?php if (isset($this->nav[NavigationType::SIDE][LinkType::LINK])) :
                        foreach ($this->nav[NavigationType::SIDE][LinkType::LINK] as $key2 => $link) :
                            if ($link['nav_parent'] === $key) :
                                $uri = \phpOMS\Uri\UriFactory::build($link['nav_uri']);
                            ?>
                                <li><a href="<?= $uri; ?>"><?= $this->getHtml($link['nav_name'], 'Navigation'); ?>
                                    <?php if (isset($this->data['unread'][$link['nav_from']]) && $this->data['unread'][$link['nav_from']] > 0) : ?>
                                        <span class="badge"><?= \strlen((string) $this->data['unread'][$link['nav_from']]) >= 3 ? '∞' : $this->data['unread'][$link['nav_from']]; ?></span>
                                    <?php endif; ?>
                                    </a>
                            <?php endif;
                        endforeach;
                    endif; ?>
            </ul>
        <?php endforeach; ?>
    </ul>
</div>
<?php
endif;
