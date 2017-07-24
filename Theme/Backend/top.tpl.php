<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
/**
 * @var \Modules\Navigation\Views\NavigationView $this
 */
if (isset($this->nav[\Modules\Navigation\Models\NavigationType::TOP])): ?>
    <ul id="t-nav" role="navigation">

        <?php $unread = $this->getData('unread');
        foreach ($this->nav[\Modules\Navigation\Models\NavigationType::TOP] as $key => $parent) :
        foreach ($parent as $link) : ?>
        <li><a href="<?= \phpOMS\Uri\UriFactory::build($link['nav_uri']); ?>">

                <?php if (isset($link['nav_icon'])) : ?>
                    <i class="<?= htmlspecialchars($link['nav_icon'], ENT_COMPAT, 'utf-8'); ?> infoIcon"><?php if(isset($unread[$link['nav_from']]) && $unread[$link['nav_from']] > 0) : ?><span class="badge"><?= htmlspecialchars($unread[$link['nav_from']], ENT_COMPAT, 'utf-8'); ?></span><?php endif; ?></i>
                <?php endif; ?>

                <?= $this->getHtml($link['nav_name']) ?></a>
            <?php endforeach;
            endforeach; ?>

    </ul>
<?php endif;
