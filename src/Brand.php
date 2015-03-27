<?php

    class Brand
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO brands (name) VALUES ('{$this->getName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE brands SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE brand_id = {$this->getId()};");
        }

        function addStore($store)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$this->getId()}, {$store->getId()});");
        }

        function getStores()
        {
            $query = $GLOBALS['DB']->query("SELECT stores.* FROM
                brands JOIN brands_stores ON (brands.id = brands_stores.brand_id)
                JOIN stores ON (brands_stores.store_id = stores.id)
                WHERE brands.id = {$this->getId()};");
            $matching_stores = $query->fetchAll(PDO::FETCH_ASSOC);

            $found_stores = array();
            foreach($matching_stores as $place){
                $name = $place['name'];
                $id = $place['id'];
                $new_store = new Store($name, $id);
                array_push($found_stores, $new_store);
            }
            return $found_stores;
        }

        static function getAll()
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brands = $statement->fetchAll(PDO::FETCH_ASSOC);

            $returned_brands = array();
            foreach($brands as $shoe){
                $name = $shoe['name'];
                $id = $shoe['id'];
                $new_brand = new Brand($name, $id);
                array_push($returned_brands, $new_brand);
            }
            return $returned_brands;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands *;");
            $GLOBALS['DB']->exec("DELETE FROM brands_stores *;");
        }

        static function find($search_id)
        {
            $found_brand = null;
            $all_brands = Brand::getAll();
            foreach($all_brands as $shoe){
                if ($shoe->getId() == $search_id){
                    $found_brand = $shoe;
                }
            }
            return $found_brand;
        }
    }

 ?>
