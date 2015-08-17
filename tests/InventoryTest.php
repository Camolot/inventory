<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Inventory.php';

    $server = 'mysql:host=localhost;dbname=inventory_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class InventoryTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Inventory::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $description = "Blue candy";
            $test_inventory = new Inventory($description);

            //Act
            $test_inventory->save();

            //Assert
            $result = Inventory::getAll();
            $this->assertEquals($test_inventory, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $description = "Blue candy";
            $description2 = "Light blue candy";
            $test_Inventory = new Inventory($description);
            $test_Inventory->save();
            $test_Inventory2 = new Inventory($description2);
            $test_Inventory2->save();

            //Act
            $result = Inventory::getAll();

            //Assert
            $this->assertEquals([$test_Inventory, $test_Inventory2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $description = "Blue candy";
            $description2 = "Light blue candy";
            $test_Inventory = new Inventory($description);
            $test_Inventory->save();
            $test_Inventory2 = new Inventory($description2);
            $test_Inventory2->save();

            //Act
            Inventory::deleteAll();

            //Assert
            $result = Inventory::getAll();
            $this->assertEquals([], $result);
        }

        function test_getId()
        {
            //Arrange
            $description = "Blue candy";
            $id = 1;
            $test_Inventory = new Inventory($description, $id);

            //Act
            $result = $test_Inventory->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_find()
        {
            $description = "Blue candy";
            $description2 = "Light blue candy";
            $test_Inventory = new Inventory($description);
            $test_Inventory->save();
            $test_Inventory2 = new Inventory($description2);

            //Act
            $id = $test_Inventory->getId();
            $result = Inventory::find($id);

            //Assert
            $this->assertEquals($test_Inventory, $result);
        }
    }
?>
