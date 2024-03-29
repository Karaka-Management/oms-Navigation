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

$nav    = $this->getData('nav-element');
$routes = $this->data['routes'] ?? [];

/**
 * @var \phpOMS\Views\View $this
 */
echo $this->data['nav']->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <section class="portlet">
            <div class="portlet-head"><?= $this->getHtml('NavigationElement'); ?></div>
            <div class="portlet-body">
                <div class="form-group">
                    <label for="iId"><?= $this->getHtml('Id'); ?></label>
                    <input id="iId" name="id" type="text" value="<?= $nav->id; ?>">
                </div>

                <div class="form-group">
                    <label for="iApp"><?= $this->getHtml('App'); ?></label>
                    <input id="iApp" name="app" type="text" value="<?= $this->printHtml((string) $nav->app); ?>">
                </div>

                <div class="form-group">
                    <label for="iPidRaw"><?= $this->getHtml('PidRaw'); ?></label>
                    <input id="iPidRaw" name="pidRaw" type="text" value="<?= $this->printHtml($nav->pidRaw); ?>">
                </div>

                <div class="form-group">
                    <label for="iName"><?= $this->getHtml('Name'); ?></label>
                    <input id="iName" name="name" type="text" value="<?= $this->printHtml($nav->name); ?>">
                </div>

                <div class="form-group">
                    <label for="iType"><?= $this->getHtml('Type'); ?></label>
                    <input id="iType" name="type" type="text" value="<?= $this->printHtml((string) $nav->type); ?>">
                </div>

                <div class="form-group">
                    <label for="iSubtype"><?= $this->getHtml('Subtype'); ?></label>
                    <input id="iSubtype" name="subtype" type="text" value="<?= $this->printHtml((string) $nav->subtype); ?>">
                </div>

                <div class="form-group">
                    <label for="iLinkStatus"><?= $this->getHtml('LinkStatus'); ?></label>
                    <input id="iLinkStatus" name="status" type="text" value="<?= $this->printHtml((string) $nav->status); ?>">
                </div>

                <div class="form-group">
                    <label for="iUri"><?= $this->getHtml('Uri'); ?></label>
                    <input id="iUri" name="uri" type="text" value="<?= $this->printHtml($nav->uri); ?>">
                </div>

                <div class="form-group">
                    <label for="iFrom"><?= $this->getHtml('From'); ?></label>
                    <input id="iFrom" name="from" type="text" value="<?= $this->printHtml($nav->from); ?>">
                </div>

                <div class="form-group">
                    <label for="iParent"><?= $this->getHtml('Parent'); ?></label>
                    <input id="iParent" name="parent" type="text" value="<?= $this->printHtml((string) $nav->parent); ?>">
                </div>

                <div class="form-group">
                    <label for="iOrder"><?= $this->getHtml('Order'); ?></label>
                    <input id="iOrder" name="order" type="text" value="<?= $this->printHtml((string) $nav->order); ?>">
                </div>

                <div class="form-group">
                    <label for="iPermission"><?= $this->getHtml('Permission'); ?></label>
                    <input id="iPermission" name="permPerm" type="text" value="<?= $this->printHtml((string) $nav->permissionPerm); ?>">
                </div>

                <div class="form-group">
                    <label for="iPermissionType"><?= $this->getHtml('PermissionType'); ?></label>
                    <input id="iPermissionType" name="permType" type="text" value="<?= $this->printHtml((string) $nav->permissionType); ?>">
                </div>

                <div class="form-group">
                    <label for="iPermissionElement"><?= $this->getHtml('PermissionElement'); ?></label>
                    <input id="iPermissionElement" name="permElement" type="text" value="<?= $this->printHtml($nav->permissionElement); ?>">
                </div>
            </div>
            <div class="portlet-foot"><input id="iSubmitGeneral" name="submitGeneral" type="submit" value="<?= $this->getHtml('Save', '0', '0'); ?>"></div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Routes'); ?><i class="g-icon download btn end-xs">download</i></div>
            <div class="slider">
            <table id="navList" class="default sticky">
                <thead>
                <tr>
                    <td><?= $this->getHtml('Status'); ?>
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
                    <td><?= $this->getHtml('App'); ?>
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
                    <td><?= $this->getHtml('Module'); ?>
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
                    <td><?= $this->getHtml('Route'); ?>
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
                    <td><?= $this->getHtml('Destination'); ?>
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
                    <td><?= $this->getHtml('Methods'); ?>
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
                <tbody>
                <?php $count = 0;
                foreach ($routes as $route => $data) : ++$count; ?>
                    <tr tabindex="0">
                        <td><?= $this->printHtml($data['app'] ?? ''); ?>
                        <td><?= $this->printHtml($data['module'] ?? ''); ?>
                        <td><?= $this->printHtml($route); ?>
                        <td><?= $this->printHtml($data['dest'] ?? ''); ?>
                        <td><?= $this->printHtml($data['verb'] ?? ''); ?>
                <?php endforeach; ?>
                <?php if ($count === 0) : ?>
                    <tr><td colspan="8" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                <?php endif; ?>
            </table>
            </div>
            <div class="portlet-foot">
                <a tabindex="0" class="button" href="<?= UriFactory::build($previous ?? ''); ?>"><?= $this->getHtml('Previous', '0', '0'); ?></a>
                <a tabindex="0" class="button" href="<?= UriFactory::build($next ?? ''); ?>"><?= $this->getHtml('Next', '0', '0'); ?></a>
            </div>
        </div>
    </div>
</div>
