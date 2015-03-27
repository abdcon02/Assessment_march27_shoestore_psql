<?php

    class Store
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
            $statement = $GLOBALS['DB']->query("INSERT INTO stores (name) VALUES ('{$this->getName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE store_id = {$this->getId()};");
        }

        function addBrand($brand)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$brand->getId()}, {$this->getId()});");
        }

        function getBrands()
        {
            $query = $GLOBALS['DB']->query("SELECT brands.* FROM
                stores JOIN brands_stores ON (stores.id = brands_stores.store_id)
                JOIN brands ON (brands_stores.brand_id = brands.id)
                WHERE stores.id = {$this->getId()};");
            $brands = $query->fetchAll(PDO::FETCH_ASSOC);
            $found_brands = array();
            foreach($brands as $shoe){
                $name = $shoe['name'];
                $id = $shoe['id'];
                $new_brand = new Brand($name, $id);
                array_push($found_brands, $new_brand);
            }
            return $found_brands;
        }

        static function getAll()
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $stores = $statement->fetchAll(PDO::FETCH_ASSOC);

            $returned_store = array();
            foreach($stores as $place){
                $name = $place['name'];
                $id = $place['id'];
                $new_store = new Store($name, $id);
                array_push($returned_store, $new_store);
            }
            return $returned_store;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores *;");
        }

        static function find($search_id)
        {
            $found_store = null;
            $all_stores = Store::getAll();
            foreach($all_stores as $place){
                if ($place->getId() == $search_id){
                    $found_store = $place;
                }
            }
            return $found_store;
        }
    }

 ?>
