<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Auditor
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

/**
 * @var \phpOMS\Views\View                      $this
 * @var \Modules\Navigation\Models\NavElement[] $navs
 */
$navs = $this->data['navigation'] ?? [];

$previous = empty($navs) ? 'admin/nav/list' : '{/base}/admin/nav/list?{?}&id=' . \reset($navs)->id . '&ptype=p';
$next     = empty($navs) ? 'admin/nav/list' : '{/base}/admin/nav/list?{?}&id=' . \end($navs)->id . '&ptype=n';

echo $this->data['nav']->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Navigation'); ?><i class="g-icon download btn end-xs">download</i></div>
            <div class="slider">
            <table id="navList" class="default sticky">
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', '0', '0'); ?>
                        <label for="navList-sort-1">
                            <input type="radio" name="navList-sort" id="navList-sort-1">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="navList-sort-2">
                            <input type="radio" name="navList-sort" id="navList-sort-2">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                    <td><?= $this->getHtml('PageId'); ?>
                        <label for="navList-sort-3">
                            <input type="radio" name="navList-sort" id="navList-sort-3">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="navList-sort-4">
                            <input type="radio" name="navList-sort" id="navList-sort-4">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                    <td><?= $this->getHtml('Name'); ?>
                        <label for="navList-sort-5">
                            <input type="radio" name="navList-sort" id="navList-sort-5">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="navList-sort-6">
                            <input type="radio" name="navList-sort" id="navList-sort-6">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                    <td><?= $this->getHtml('Type'); ?>
                        <label for="navList-sort-7">
                            <input type="radio" name="navList-sort" id="navList-sort-7">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="navList-sort-8">
                            <input type="radio" name="navList-sort" id="navList-sort-8">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                    <td class="wf-100"><?= $this->getHtml('Subtype'); ?>
                        <label for="navList-sort-9">
                            <input type="radio" name="navList-sort" id="navList-sort-9">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="navList-sort-10">
                            <input type="radio" name="navList-sort" id="navList-sort-10">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                    <td><?= $this->getHtml('Uri'); ?>
                        <label for="navList-sort-13">
                            <input type="radio" name="navList-sort" id="navList-sort-13">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="navList-sort-14">
                            <input type="radio" name="navList-sort" id="navList-sort-14">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                    <td><?= $this->getHtml('Provider'); ?>
                        <label for="navList-sort-15">
                            <input type="radio" name="navList-sort" id="navList-sort-15">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="navList-sort-16">
                            <input type="radio" name="navList-sort" id="navList-sort-16">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                    <td><?= $this->getHtml('Parent'); ?>
                        <label for="navList-sort-17">
                            <input type="radio" name="navList-sort" id="navList-sort-17">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="navList-sort-18">
                            <input type="radio" name="navList-sort" id="navList-sort-18">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                <tbody>
                <?php $count = 0;
                foreach ($navs as $key => $nav) : ++$count;
                    $url = UriFactory::build('{/base}/admin/module/settings?id=Navigation&nav=' . $nav->id); ?>
                    <tr tabindex="0" data-href="<?= $url; ?>">
                        <td><a href="<?= $url; ?>"><?= $nav->id; ?></a>
                        <td><a href="<?= $url; ?>"><?= $nav->pidRaw; ?></a>
                        <td><a href="<?= $url; ?>"><?= $nav->name; ?></a>
                        <td><a href="<?= $url; ?>"><?= $nav->type; ?></a>
                        <td><a href="<?= $url; ?>"><?= $nav->subtype; ?></a>
                        <td><a href="<?= $url; ?>"><?= $nav->uri; ?></a>
                        <td><a href="<?= $url; ?>"><?= $nav->from; ?></a>
                        <td><a href="<?= $url; ?>"><?= $nav->parent; ?></a>
                <?php endforeach; ?>
                <?php if ($count === 0) : ?>
                    <tr><td colspan="8" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                <?php endif; ?>
            </table>
            </div>
            <!--
            <div class="portlet-foot">
                <a tabindex="0" class="button" href="<?= UriFactory::build($previous); ?>"><?= $this->getHtml('Previous', '0', '0'); ?></a>
                <a tabindex="0" class="button" href="<?= UriFactory::build($next); ?>"><?= $this->getHtml('Next', '0', '0'); ?></a>
            </div>
            -->
        </div>
    </div>
</div>
