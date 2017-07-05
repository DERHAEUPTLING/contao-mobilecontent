<?php

namespace Derhaeuptling\MobileContent;

use Contao\Database;

class Upgrade
{
    /**
     * @var \Contao\Database
     */
    private $db;

    /**
     * MobileContentUpgrade constructor.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Run the upgrade
     */
    public function run()
    {
        $this->updateTable('tl_article');
        $this->updateTable('tl_content');
    }

    /**
     * Update the table
     *
     * @param string $table
     */
    private function updateTable($table)
    {
        if (!$this->db->fieldExists('showatdevice', $table)) {
            return;
        }


        if (!$this->db->fieldExists('hideOnDesktop', $table)) {
            $this->db->query("ALTER TABLE $table ADD COLUMN `hideOnDesktop` char(1) NOT NULL default ''");
        }

        if (!$this->db->fieldExists('hideOnMobile', $table)) {
            $this->db->query("ALTER TABLE $table ADD COLUMN `hideOnMobile` char(1) NOT NULL default ''");
        }

        $records = $this->db->query("SELECT id, showatdevice FROM $table");

        while ($records->next()) {
            $this->db->prepare("UPDATE $table %s WHERE id=?")->set([
                'hideOnDesktop' => ($records->showatdevice === 'm') ? 1 : '',
                'hideOnMobile' => ($records->showatdevice === 'd') ? 1 : '',
            ])->execute($records->id);
        }

        $this->db->query("ALTER TABLE `$table` DROP `showatdevice`");
    }
}
