<?php
    require_once('./Product.php');

//    Product::create([
//       'name' => 'NEW NEW PRODUCT',
//       'description' => 'DESCRIPTION',
//       'price' => 12000,
//       'category_id' => 1,
//       'image' => 'http://kenh14cdn.com/thumb_w/660/2017/i8n3-1500397416279.jpg'
//    ]);

//    $product1 = Product::find(111);
//
//    $product1->price = 10000;
//
//    $product1->save();

//    $productTest = new Product();
//
//    $productTest->name = "New";
//    $productTest->description = "NEW DESCRIPTION";
//    $productTest->price = 14124;
//    $productTest->category_id = 1;
//    $productTest->image = "http://kenh14cdn.com/thumb_w/660/2017/i8n3-1500397416279.jpg";
//    $productTest->save();

//    print_r($product1);

//    $product2 = Product::find(2);

//    print_r($product2);

//    $delete = Product::delete(108);

//    echo $delete;

    $allProducts = Product::all();

    var_dump($allProducts);

