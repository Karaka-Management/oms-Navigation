<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Navigation\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Navigation\Models;

use phpOMS\Account\Account;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\Message\RequestAbstract;

/**
 * Navigation class.
 *
 * @package Modules\Navigation\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class Navigation
{
    /**
     * Navigation array.
     *
     * Array of all navigation elements sorted by type->parent->id
     *
     * @var array
     * @since 1.0.0
     */
    public array $nav = [];

    /**
     * Singleton instance.
     *
     * @var null|self
     * @since 1.0.0
     */
    public static ?self $instance = null;

    /**
     * Database pool.
     *
     * @var DatabasePool
     * @since 1.0.0
     */
    private DatabasePool $dbPool;

    /**
     * Constructor.
     *
     * @param RequestAbstract $request Request hashes
     * @param Account         $account Account
     * @param DatabasePool    $dbPool  Database pool
     * @param int             $unit    Unit
     * @param int             $appId   App id
     *
     * @since 1.0.0
     */
    private function __construct(RequestAbstract $request, Account $account, DatabasePool $dbPool, int $unit, int $appId)
    {
        $this->dbPool = $dbPool;
        $this->load($request->getHash(), $account, $unit, $appId);
    }

    /**
     * Load navigation based on request.
     *
     * @param string[] $hashes  Request hashes
     * @param Account  $account Account
     * @param int      $unit    Unit
     * @param int      $app     App name
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function load(array $hashes, Account $account, int $unit, int $app) : void
    {
        if (empty($this->nav)) {
            $this->nav = [];

            $query = new Builder($this->dbPool->get('select'));
            $sth   = $query->select('*')
                ->from('nav')
                ->whereIn('nav.nav_pid', $hashes)
                ->andWhere('nav.nav_status', '=', LinkStatus::ACTIVE)
                ->orderBy('nav.nav_order', 'ASC')
                ->execute();

            if ($sth === null) {
                return;
            }

            $tempNav = $sth->fetchAll(\PDO::FETCH_GROUP);

            foreach ($tempNav as $id => $link) {
                $isReadable = $account->hasPermission(
                    (int) $link[0]['nav_permission_permission'],
                    $unit,
                    $app,
                    (string) $link[0]['nav_from'],
                    (int) $link[0]['nav_permission_category'],
                    (int) $link[0]['nav_permission_element']
                );

                if ($isReadable) {
                    $tempNav[$id][0]['readable'] = true;

                    $this->setReadable($tempNav, $tempNav[$id][0]['nav_parent']);
                }
            }

            foreach ($tempNav as $id => $link) {
                if (isset($link[0]['readable']) && $link[0]['readable']) {
                    $this->nav[$link[0]['nav_type']][$link[0]['nav_subtype']][$id] = $link[0];
                }
            }
        }
    }

    /**
     * Set navigation elements as readable
     *
     * @param array $nav    Full Navigation
     * @param int   $parent Parent id
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function setReadable(array &$nav, int $parent) : void
    {
        if (!isset($nav[$parent])) {
            return;
        }

        $nav[$parent][0]['readable'] = true;

        if (isset($nav[$nav[$parent][0]['nav_parent']])
            && (!isset($nav[$nav[$parent][0]['nav_parent']][0]['readable'])
                || !$nav[$nav[$parent][0]['nav_parent']][0]['readable'])
        ) {
            $this->setReadable($nav, $nav[$parent][0]['nav_parent']);
        }
    }

    /**
     * Get instance.
     *
     * @param null|RequestAbstract $hashes  Request hashes
     * @param Account              $account Account
     * @param DatabasePool         $dbPool  Database pool
     * @param int                  $unit    Unit
     * @param int                  $appId   App name
     *
     * @return \Modules\Navigation\Models\Navigation
     *
     * @throws \Exception
     *
     * @since 1.0.0
     */
    public static function getInstance(?RequestAbstract $hashes, Account $account, DatabasePool $dbPool, int $unit, int $appId)
    {
        if (!isset(self::$instance)) {
            if (!isset($hashes)) {
                throw new \Exception('Invalid parameters');
            }

            self::$instance = new self($hashes, $account, $dbPool, $unit, $appId);
        }

        return self::$instance;
    }

    /**
     * Get navigation based on account permissions
     *
     * @return array
     *
     * @since 1.0.0
     */
    public function getNav() : array
    {
        return $this->nav;
    }
}
