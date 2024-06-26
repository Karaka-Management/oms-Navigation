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
if (isset($this->nav[\Modules\Navigation\Models\NavigationType::CONTENT])) :
    foreach ($this->nav[\Modules\Navigation\Models\NavigationType::CONTENT] as $key => $parent) :
        foreach ($parent as $link) :
            if ($link['nav_parent'] == $this->parent) : ?>
                <section class="box w-33 lf">
                    <div class="inner cT">
                        <a href="<?= \phpOMS\Uri\UriFactory::build($link['nav_uri']); ?>">
                            <p><i class="g-icon"><?= $this->printHtml($link['nav_icon']); ?></i></p>
                            <p><?= $this->getHtml($link['nav_name'], 'Navigation'); ?></p>
                        </a>
                    </div>
                </section>
<?php endif; endforeach; endforeach; endif;
