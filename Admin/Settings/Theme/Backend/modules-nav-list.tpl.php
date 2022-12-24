<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\Admin\Template\Backend
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

/**
 * @var \phpOMS\Views\View $this
 */
$navs = $this->getData('navs') ?? [];
$apps = $this->getData('apps') ?? [];

echo $this->getData('nav')->render();
?>

<div class="row">
    <div class="col-xs-12">
        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Navigation'); ?><i class="fa fa-download floatRight download btn"></i></div>
            <div class="slider">
            <table id="navElements" class="default sticky">
                <thead>
                <tr>
                    <td><?= $this->getHtml('Active'); ?>
                    <td><?= $this->getHtml('App'); ?>
                        <label for="navElements-sort-1">
                            <input type="radio" name="navElements-sort" id="navElements-sort-1">
                            <i class="sort-asc fa fa-chevron-up"></i>
                        </label>
                        <label for="navElements-sort-2">
                            <input type="radio" name="navElements-sort" id="navElements-sort-2">
                            <i class="sort-desc fa fa-chevron-down"></i>
                        </label>
                        <label>
                            <i class="filter fa fa-filter"></i>
                        </label>
                    <td><?= $this->getHtml('ID', '0', '0'); ?>
                        <label for="navElements-sort-1">
                            <input type="radio" name="navElements-sort" id="navElements-sort-1">
                            <i class="sort-asc fa fa-chevron-up"></i>
                        </label>
                        <label for="navElements-sort-2">
                            <input type="radio" name="navElements-sort" id="navElements-sort-2">
                            <i class="sort-desc fa fa-chevron-down"></i>
                        </label>
                        <label>
                            <i class="filter fa fa-filter"></i>
                        </label>
                    <td><?= $this->getHtml('Order'); ?>
                        <label for="navElements-sort-1">
                            <input type="radio" name="navElements-sort" id="navElements-sort-1">
                            <i class="sort-asc fa fa-chevron-up"></i>
                        </label>
                        <label for="navElements-sort-2">
                            <input type="radio" name="navElements-sort" id="navElements-sort-2">
                            <i class="sort-desc fa fa-chevron-down"></i>
                        </label>
                        <label>
                            <i class="filter fa fa-filter"></i>
                        </label>
                    <td class="wf-100"><?= $this->getHtml('Name'); ?>
                        <label for="navElements-sort-1">
                            <input type="radio" name="navElements-sort" id="navElements-sort-1">
                            <i class="sort-asc fa fa-chevron-up"></i>
                        </label>
                        <label for="navElements-sort-2">
                            <input type="radio" name="navElements-sort" id="navElements-sort-2">
                            <i class="sort-desc fa fa-chevron-down"></i>
                        </label>
                        <label>
                            <i class="filter fa fa-filter"></i>
                        </label>
                    <td><?= $this->getHtml('Link'); ?>
                        <label for="navElements-sort-1">
                            <input type="radio" name="navElements-sort" id="navElements-sort-1">
                            <i class="sort-asc fa fa-chevron-up"></i>
                        </label>
                        <label for="navElements-sort-2">
                            <input type="radio" name="navElements-sort" id="navElements-sort-2">
                            <i class="sort-desc fa fa-chevron-down"></i>
                        </label>
                        <label>
                            <i class="filter fa fa-filter"></i>
                        </label>
                </thead>
                <tbody>
                    <?php $c = 0;
                    foreach ($navs as $nav) : ++$c; ?>
                    <tr>
                        <td><label class="checkbox" for="iActive-<?= $c; ?>">
                                <input id="iActive-<?= $c; ?>" type="checkbox" name="active_route" value="<?= $this->printHtml($nav->uri); ?>"<?= true ? ' checked' : ''; ?>>
                                <span class="checkmark"></span>
                            </label>
                        <td><?= $this->printHtml($apps[$nav->app]?->name); ?>
                        <td><?= $nav->id; ?>
                        <td><?= $nav->order; ?>
                        <td><?= $this->printHtml($nav->name); ?>
                        <td><?= $this->printHtml($nav->uri); ?>
                    <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
