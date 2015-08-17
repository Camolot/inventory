<?php
class Inventory
{
    private $description;
    private $id;

    function __construct($description, $id = null)
    {
        $this->description = $description;
        $this->id = $id;
    }

    function setDescription($new_description)
    {
        $this->description = (string) $new_description;
    }

    function getDescription()
    {
        return $this->description;
    }

    function save() {

        $GLOBALS['DB']->exec("INSERT INTO items (description) VALUES ('{$this->getDescription()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll() {

        $returned_items = $GLOBALS['DB']->query("SELECT * FROM items;");
        $items = array();
        foreach($returned_items as $item) {
            $description = $item['description'];
            $id = $item['id'];
            $new_item = new Inventory($description, $id);
            array_push($items, $new_item);
        }
        return $items;
    }

    static function deleteAll() {
        $GLOBALS['DB']->exec("DELETE FROM items;");
    }

    function getId() {
        return $this->id;
    }

    static function find($search_id) {
        $found_item = null;
        $items = Inventory::getAll();
        foreach($items as $item) {
            $item_id = $item->getId();
            if ($item_id == $search_id) {
                $found_item = $item;
            }
        }
        return $found_item;
    }
}
?>
