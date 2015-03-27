<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Store.php";
    require_once "src/Brand.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function test_SetName()
        {
            //Arrange
            $name = "Bubus";
            $test_store = new Store($name);
            $new_name = "Booboos";
            //Act
            $test_store->setName($new_name);
            $result = $test_store->getName();
            //Assert
            $this->assertEquals($new_name, $result);
        }

        function test_SetId()
        {
            //Arrange
            $name = "Booboos";
            $id = 1;
            $test_store = new Store($name, $id);
            $new_id = 2;
            //Act
            $test_store->setId($new_id);
            $result = $test_store->getId();
            //Assert
            $this->assertEquals($new_id, $result);
        }
        function test_save()
        {
            //Arrange
            $name = "Speedies";
            $test_store = new Store($name);
            //Act
            $test_store->save();
            $result = Store::getAll();
            //Assert
            $this->assertEquals($test_store, $result[0]);
        }
        function test_getAll()
        {
            //Arrange
            $name = "Nike Store";
            $test_store = new Store($name);
            $test_store->save();
            $name2 = "Whacko Running Store";
            $test_store2 = new Store($name2);
            $test_store2->save();
            //Act
            $result = Store::getAll();
            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }
        function test_deleteAll()
        {
            //Arrange
            $name = "Cheap Cheap Shoes";
            $test_store = new Store($name);
            $test_store->save();
            //Act
            Store::deleteAll();
            $result = Store::getAll();
            //Assert
            $this->assertEquals([], $result);
        }
        function test_find()
        {
            //Arrange
            $name = "Stomps store";
            $test_store = new Store($name);
            $test_store->save();
            $name2 = "Booboos";
            $test_store2 = new Store($name2);
            $test_store2->save();
            //Act
            $result = Store::find($test_store2->getId());
            //Assert
            $this->assertEquals($test_store2, $result);
        }
        function test_update()
        {
            //Arrange
            $name = "Nike running store";
            $test_store = new Store($name);
            $test_store->save();
            $new_name = "Kea running";
            //Act
            $test_store->update($new_name);
            //Assert
            $this->assertEquals($new_name, $test_store->getName());
        }
        function test_delete()
        {
            //Arrange
            $name = "Zeds shoes";
            $test_store = new Store($name);
            $test_store->save();
            $name2 = "Freds shoes";
            $test_store2 = new Store($name2);
            $test_store2->save();
            //Act
            $test_store2->delete();
            $result = Store::getAll();
            //Assert
            $this->assertEquals([$test_store], $result);
        }

        function testAddBrand()
        {
            //Arrange
            $name = "Toms";
            $test_store = new Store($name);
            $test_store->save();

            $brand = "Brooks";
            $test_brand = new Brand($brand);
            $test_brand->save();

            //Act
            $test_store->addBrand($test_brand);
            $result = $test_store->getBrands();

            //Assert
            $this->assertEquals([$test_brand], $result);
        }

        function testGetBooks()
        {
            //Arrange
            $name = "Burnhearts place";
            $test_store = new Store($name);
            $test_store->save();

            $brand = "Vibrams";
            $test_brand = new Brand($brand);
            $test_brand->save();

            $book_name2 = "Barefoot";
            $test_book2 = new Brand($book_name2);
            $test_book2->save();

            //Act
            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_book2);
            $result = $test_store->getBrands();

            //Assert
            $this->assertEquals([$test_brand, $test_book2], $result);
        }
        function testDeleteJoin()
        {
            //Arrange
            $name = "Steppin";
            $test_store = new Store($name);
            $test_store->save();

            $brand = "Flyers";
            $test_brand = new Brand($brand);
            $test_brand->save();

            //Act
            $test_store->addBrand($test_brand);
            $test_store->delete();
            $result = $test_brand->getStores();

            //Assert
            $this->assertEquals([], $result);
        }


    }
?>
