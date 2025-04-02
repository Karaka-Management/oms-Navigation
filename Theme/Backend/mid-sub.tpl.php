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

/**
 * @var \Modules\Navigation\Views\NavigationView $this
 */

if (isset($this->nav[\Modules\Navigation\Models\NavigationType::TAB])
    && \phpOMS\Utils\ArrayUtils::inArrayRecursive(
        $this->parent,
        $this->nav[\Modules\Navigation\Models\NavigationType::TAB],
        'nav_parent'
    )
) : ?>
    <div class="row">
        <div class="col-xs-12 tab-2">
            <ul class="nav-top-sub tab-links" role="list">
                <?php
                $uriPath = $this->request->uri->getPath();

                foreach ($this->nav[\Modules\Navigation\Models\NavigationType::TAB] as $key => $parent) {
                    foreach ($parent as $link) {
                        if ($link['nav_parent'] === $this->parent) {
                            $uri = \phpOMS\Uri\UriFactory::build($link['nav_uri']);
                            echo '<li'
                                , (\stripos($uri, $uriPath) !== false ? ' class="active"' : '')
                                , '><a tabindex="0" href="' , $uri , '">'
                                , $this->getHtml($link['nav_name'], 'Navigation') , '</a>';
                        }
                    }
                }
                ?>
            </ul>
        </div>
    </div>
<?php endif;
