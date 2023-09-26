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

/**
 * @var \Modules\Navigation\Views\NavigationView $this
 */

if (isset($this->nav[\Modules\Navigation\Models\NavigationType::CONTENT])
    && \phpOMS\Utils\ArrayUtils::inArrayRecursive($this->parent, $this->nav[\Modules\Navigation\Models\NavigationType::CONTENT], 'nav_parent')
) {
    echo '<div class="row"><div class="col-xs-12"><ul class="nav-top" role="list">';

    $uriPath = $this->request->uri->getPath();

    foreach ($this->nav[\Modules\Navigation\Models\NavigationType::CONTENT] as $key => $parent) {
        foreach ($parent as $link) {
            if ($link['nav_parent'] === $this->parent) {
                $uri = \phpOMS\Uri\UriFactory::build($link['nav_uri']);
                echo '<li'
                    . (\stripos($uri, $uriPath) !== false ? ' class="active"' : '')
                    . '><a tabindex="0" href="' . $uri . '">'
                    . $this->getHtml($link['nav_name'], 'Navigation') . '</a>';
            }
        }
    }

    echo '</ul></div></div>';
}
