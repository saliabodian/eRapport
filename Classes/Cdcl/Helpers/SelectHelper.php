<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 28/08/2017
 * Time: 15:34
 */

namespace Classes\Cdcl\Helpers;

use \Classes\Cdcl\Config\Config;


class SelectHelper {

    private $valuesList;
    private $selectedValue;
    private $attributesList;

    public function __construct($valuesList, $selectedValue=0, $attributesList=array()) {
        $this->valuesList = $valuesList;
        $this->selectedValue = $selectedValue;
        $this->attributesList = $attributesList;
    }

    /**
     * @return int
     */
    public function getSelectedValue() {
        return $this->selectedValue;
    }

    /**
     * @param int $selectedValue
     */
    public function setSelectedValue($selectedValue) {
        $this->selectedValue = $selectedValue;
    }

    public function getHTML() {
        // Get Config singleton
        $config = Config::getInstance();

        // Generate varaibles for view
        $selectValues = $this->valuesList;
        $selectedValue = $this->selectedValue;
        $attributesList = $this->attributesList;

        include $config->getViewsDir().'select.php';
    }

    public function displayHTML() {
        echo $this->getHTML();
    }
}