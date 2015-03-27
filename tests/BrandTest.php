<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Brand.php";
    require_once "src/Store.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
            Store::deleteAll();
        }

        function test_SetName()
        {
            //Arrange
            $name = "Nike";
            $test_shoe = new Brand($name);
            $new_name = "Abebe Bikilas";
            //Act
            $test_shoe->setName($new_name);
            $result = $test_shoe->getName();
            //Assert
            $this->assertEquals($new_name, $result);
        }

        function test_SetId()
        {
            //Arrange
            $name = "Nike";
            $id = 1;
            $test_shoe = new Brand($name, $id);
            $new_id = 2;
            //Act
            $test_shoe->setId($new_id);
            $result = $test_shoe->getId();
            //Assert
            $this->assertEquals($new_id, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Speedy Gonzalez";
            $test_shoe = new Brand($name);
            //Act
            $test_shoe->save();
            $result = Brand::getAll();
            //Assert
            $this->assertEquals($test_shoe, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Nike";
            $test_shoe = new Brand($name);
            $test_shoe->save();
            $name2 = "Whacko Running Shoes";
            $test_shoe2 = new Brand($name2);
            $test_shoe2->save();
            //Act
            $result = Brand::getAll();
            //Assert
            $this->assertEquals([$test_shoe, $test_shoe2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Cheap Cheap";
            $test_shoe = new Brand($name);
            $test_shoe->save();
            //Act
            Brand::deleteAll();
            $result = Brand::getAll();
            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Stomps";
            $test_shoe = new Brand($name);
            $test_shoe->save();
            $name2 = "Abebe Bikilas";
            $test_shoe2 = new Brand($name2);
            $test_shoe2->save();
            //Act
            $result = Brand::find($test_shoe2->getId());
            //Assert
            $this->assertEquals($test_shoe2, $result);
        }
        function test_update()
        {
            //Arrange
            $name = "Nike";
            $test_shoe = new Brand($name);
            $test_shoe->save();
            $new_name = "Abebe Bikilas";
            //Act
            $test_shoe->update($new_name);
            //Assert
            $this->assertEquals($new_name, $test_shoe->getName());
        }

        function test_delete()
        {
            //Arrange
            $name = "Zeds shoes";
            $test_shoe = new Brand($name);
            $test_shoe->save();
            $name2 = "Freds shoes";
            $test_shoe2 = new Brand($name2);
            $test_shoe2->save();
            //Act
            $test_shoe2->delete();
            $result = Brand::getAll();
            //Assert
            $this->assertEquals([$test_shoe], $result);
        }

        function testAddStore()
        {
            //Arrange
            $name = "Hairy shoes";
            $test_store = new Store($name);
            $test_store->save();

            $brand = "Barefoot";
            $test_brand = new Brand($brand);
            $test_brand->save();

            //Act
            $test_brand->addStore($test_store);
            $result = $test_brand->getStores();

            //Assert
            $this->assertEquals([$test_store], $result);
        }

        function testGetStores()
        {
            //Arrange
            $name = "Shoe go lucky";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Nanies";
            $test_store2 = new Store($name2);
            $test_store2->save();

            $brand = "Five Fingers";
            $test_brand = new Brand($brand);
            $test_brand->save();

            //Act
            $test_brand->addStore($test_store);
            $test_brand->addStore($test_store2);
            $result = $test_brand->getStores();

            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function testDeleteJoin()
        {
            //Arrange
            $name = "Silky running";
            $test_store = new Store($name);
            $test_store->save();

            $brand = "bounces";
            $test_brand = new Brand($brand);
            $test_brand->save();

            //Act
            $test_brand->addStore($test_store);
            $test_brand->delete();
            $result = $test_brand->getStores();

            //Assert
            $this->assertEquals([], $result);
        }

        function testDropStore()
        {
            //Arrange
            $name = "Shoe go lucky";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Nanies";
            $test_store2 = new Store($name2);
            $test_store2->save();

            $brand = "Five Fingers";
            $test_brand = new Brand($brand);
            $test_brand->save();

            //Act
            $test_brand->addStore($test_store);
            $test_brand->addStore($test_store2);
            $result2 = $test_brand->getStores();
            $test_brand->dropStore($test_store2);
            $result = $test_brand->getStores();


            //Assert
            $this->assertEquals([$test_store], $result);
        }


    }
?>
