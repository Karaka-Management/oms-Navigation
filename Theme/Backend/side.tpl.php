<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules\Navigation
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

use \Modules\Navigation\Models\LinkType;
use \Modules\Navigation\Models\NavigationType;

/**
 * @var \Modules\Navigation\Views\NavigationView $this
 */
if (isset($this->nav[NavigationType::SIDE])) : ?>
<div id="nav-side-outer" class="oms-ui-state">
    <ul id="nav-side-inner" class="nav" role="navigation">
        <?php
        $uriPath = $this->request->uri->getPath();
        foreach ($this->nav[NavigationType::SIDE][LinkType::CATEGORY] as $key => $parent) : ?>
        <li><input class="oms-ui-state" id="nav-<?= $this->printHtml($parent['nav_name']); ?>" type="checkbox">
            <ul>
                <li><label for="nav-<?= $this->printHtml($parent['nav_name']); ?>">
                    <?php if (isset($parent['nav_icon'])) : ?>
                        <i class="<?= $this->printHtml($parent['nav_icon']); ?>"></i>
                    <?php endif; ?>
                    <span><?= $this->getHtml($parent['nav_name'], 'Navigation'); ?></span><i class="fa fa-chevron-right expand"></i></label>
                    <?php if (isset($this->nav[NavigationType::SIDE][LinkType::LINK])) :
                        foreach ($this->nav[NavigationType::SIDE][LinkType::LINK] as $key2 => $link) :
                            if ($link['nav_parent'] === $key) :
                                $uri = \phpOMS\Uri\UriFactory::build($link['nav_uri']);
                            ?>
                                <li><a href="<?= $uri; ?>"><?= $this->getHtml($link['nav_name'], 'Navigation'); ?></a>
                            <?php endif;
                        endforeach;
                    endif; ?>
            </ul>
        <?php endforeach; ?>
    </ul>
</div>
<?php
endif;
