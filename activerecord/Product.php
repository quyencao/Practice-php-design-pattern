<?php

    class Product
    {

        private static $db;

        public function __construct()
        {

        }

        public static function connectDB()
        {
            try {
                self::$db = new PDO('mysql:host=localhost;dbname=sample', 'root', '');
            } catch (PDOException $exception) {

            }
        }

        public function getDB()
        {
            if (!isset(self::$db)) {
                self::connectDB();
            }
            return self::$db;
        }

        public static function find($id)
        {

            if (!isset(self::$db)) {
                self::connectDB();
            }

            $sql = "SELECT * FROM products WHERE id = :id";

            $select = self::$db->prepare($sql);

            $select->bindValue(':id', $id);

            $select->execute();

            $product = $select->fetch(PDO::FETCH_ASSOC);

            $productObj = new Product();

            foreach ($product as $key => $value) {
                $productObj->$key = $value;
            }

            return $productObj;
        }

        public static function all()
        {
            if (!isset(self::$db)) {
                self::connectDB();
            }

            $sql = "SELECT * FROM products";

            $select = self::$db->prepare($sql);

            $select->execute();

            $products = $select->fetchAll(PDO::FETCH_ASSOC);

            $productObjs = array();

            foreach ($products as $product) {
                $productObj = new Product();
                foreach ($product as $key => $value) {
                    $productObj->$key = $value;
                }
                array_push($productObjs, $productObj);
            }

            return $productObjs;
        }

        public static function delete($id)
        {
            if (!isset(self::$db)) {
                self::connectDB();
            }

            $sql = "DELETE FROM products WHERE id = :id";

            $delete = self::$db->prepare($sql);

            $delete->bindValue(':id', $id);

            $delete->execute();

            return $delete->rowCount();
        }

        public function save()
        {
            $product = $this;

            $productObj = get_object_vars($product);
            $properties = array_keys($productObj);

            var_dump($productObj);

            if (property_exists($product, 'id')) {
                $colvalSet = '';
                $id = 0;
                $i = 0;
                foreach ($productObj as $key => $val) {
                    if ($key !== "id") {
                        $pre = ($i > 0) ? ', ' : '';
//                        $val = htmlspecialchars(strip_tags($val));
                        if (is_numeric($val)) {
                            $colvalSet .= $pre . $key . "=" . $val;
                        } else {
                            $colvalSet .= $pre . $key . "='" . $val . "'";
                        }

                        $i++;
                    } else {
                        $id = intval($val);
                    }
                }

                $sql = "UPDATE products SET " . $colvalSet . " WHERE id = :id";

                $update = $this->getDB()->prepare($sql);

                $update->bindParam(':id', $id);

                $update->execute();

                return $update->rowCount();

            } else {

                $keyString = implode(',', $properties);
                $valueString = ':' . implode(',:', $properties);
                $sql = "INSERT INTO products (" . $keyString . ") VALUES (" . $valueString . ")";

                $insert = $this->getDB()->prepare($sql);

                foreach ($productObj as $key => $value) {
                    $insert->bindValue(':' . $key, $value);
                }

                $insert->execute();

                return $this->getDB()->lastInsertId();
            }

        }

        public static function create($product=array()) {
            if (!isset(self::$db)) {
                self::connectDB();
            }

            $keys = array_keys($product);

            $keyString = implode(',', $keys);
            $valString = ':'.implode(', :', $keys);
            $sql = "INSERT INTO products (" . $keyString . ") VALUES (" . $valString . ")";

            $insert = self::$db->prepare($sql);

            foreach ($product as $key => $value) {
                $insert->bindValue(':'.$key, $value);
            }

            $insert->execute();

            return self::$db->lastInsertId();
        }
    }