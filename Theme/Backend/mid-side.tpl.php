<?php
/**
 * Jingga
 *
 * PHP Version 8.2
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

/* Looping through all links */
if (isset($this->nav[\Modules\Navigation\Models\NavigationType::CONTENT_SIDE])) : ?>
    <div>
        <h1>
            <?= $this->getHtml('Navigation', 'Navigation'); ?>
            <i class="g-icon min">remove</i><i class="g-icon max vh">add</i>
        </h1>
        <div class="bc-1">
            <ul id="ms-nav" role="list">
            <?php
            foreach ($this->nav[\Modules\Navigation\Models\NavigationType::CONTENT_SIDE] as $key => $parent) {
                foreach ($parent as $link) {
                    /** @var array $data */
                    if ($link['nav_parent'] == $data[1]) {
                        echo '<li><a href="' , \phpOMS\Uri\UriFactory::build($link['nav_uri']) , '">'
                            , $this->getHtml('5', 'Backend', $link['nav_name']) , '</a>';
                    }
                }
            }
            ?>
            </ul>
        </div>
    </div>
<?php endif;
