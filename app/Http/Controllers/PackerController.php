<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DVDoug\BoxPacker\Packer;
use DVDoug\BoxPacker\Test\TestBox;  // use your own implementation
use DVDoug\BoxPacker\Test\TestItem; // use your own implementation
use DVDoug\BoxPacker\ItemList; // use your own implementation
use DVDoug\BoxPacker\VolumePacker; // use your own implementation

class PackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function packItems(){
        

  /*
   * To figure out which boxes you need, and which items go into which box
   */
        $packer = new Packer();
        $packer->addBox(new TestBox('Le petite box', 300, 300, 10, 10, 296, 296, 8, 1000));
        $packer->addBox(new TestBox('Le grande box', 300, 300, 100, 100, 2960, 2960, 80, 10000));
        $packer->addBox(new TestBox('Le grande box 1', 300, 300, 100, 100, 2960, 2960, 80, 10000));
        $packer->addItem(new TestItem('Item 1', 250, 250, 12, 200, false));
        $packer->addItem(new TestItem('Item 2', 250, 250, 12, 200, false));
        $packer->addItem(new TestItem('Item 3', 250, 250, 24, 200, true)); // you can even choose if an item needs to be kept flat (packed "this way up")
        $packedBoxes = $packer->pack();

  /*echo("These items fitted into " . count($packedBoxes) . " box(es)" . PHP_EOL);
  foreach ($packedBoxes as $packedBox) {
    $boxType = $packedBox->getBox(); // your own box object, in this case TestBox
    echo("This box is a {$boxType->getReference()}, it is {$boxType->getOuterWidth()}mm wide, {$boxType->getOuterLength()}mm long and {$boxType->getOuterDepth()}mm high" . PHP_EOL);
    echo("The combined weight of this box and the items inside it is {$packedBox->getWeight()}g" . PHP_EOL);

    echo("The items in this box are:" . PHP_EOL);
    $itemsInTheBox = $packedBox->getItems();
    foreach ($itemsInTheBox as $item) { // your own item object, in this case TestItem
      echo($item->getDescription() . PHP_EOL);
    }

    echo(PHP_EOL);
  }
*/


  /*
   * To just see if a selection of items will fit into one specific box
   */
        
        $box = new TestBox('Vehiculo 1', 300, 300, 10, 10, 296, 296, 8, 1000);
        $packer = new Packer();
        $packer->addBox(new TestBox('Vehiculo 1', 300, 300, 10, 10, 296, 296, 8, 1000));

        $items = new ItemList();  
        $facturas=array(
            'factura1'=>[
                ['nombre'=>'Caja 1','width'=>300, 'length'=>296, 'depth'=>2, 'weight'=>200, 'keepFlat'=>true,'factura'=>'factura1'],
                ['nombre'=>'Caja 2','width'=>207, 'length'=>296, 'depth'=>2, 'weight'=>500, 'keepFlat'=>true,'factura'=>'factura1'],
                ['nombre'=>'Caja 3','width'=>300, 'length'=>296, 'depth'=>4, 'weight'=>290, 'keepFlat'=>true,'factura'=>'factura1']
            ],
            'factura2'=>[
                ['nombre'=>'Caja 4','width'=>207, 'length'=>296, 'depth'=>2, 'weight'=>200, 'keepFlat'=>true,'factura'=>'factura2'],
                ['nombre'=>'Caja 5','width'=>207, 'length'=>296, 'depth'=>4, 'weight'=>290, 'keepFlat'=>true,'factura'=>'factura2']
            ],
            'factura3'=>[
                ['nombre'=>'Caja 6','width'=>207, 'length'=>296, 'depth'=>2, 'weight'=>200, 'keepFlat'=>true,'factura'=>'factura3'],
                ['nombre'=>'Caja 7','width'=>290, 'length'=>296, 'depth'=>2, 'weight'=>500, 'keepFlat'=>true,'factura'=>'factura3'],
                ['nombre'=>'Caja 8','width'=>2007, 'length'=>296, 'depth'=>4, 'weight'=>290, 'keepFlat'=>true,'factura'=>'factura3']
            ]
        );
        $i=array();
        $arr=array();
        $arr2=array(); // Array to store item description returned from Packer, it's used to check if value 'nombre' from factura is not present in arr2 (these values are the items that don't fit in a vehicle)
        $del_k=array();
        $not_assigned=array();
        foreach($facturas as $key=>$val){
            foreach($facturas[$key] as $k=>$v){
                //$packer->addItem(new TestItem($v['nombre'], $v['width'], $v['length'], $v['depth'], $v['weight'], $v['keepFlat']));
                $items->insert(new TestItem($v['nombre'], $v['width'], $v['length'], $v['depth'], $v['weight'], $v['keepFlat']));
                //$packedBox = $packer->pack();
                $volumePacker = new VolumePacker($box, $items);
                $packedBox = $volumePacker->pack();
                //var_dump($packedBox);
                foreach ($packedBox->items as $item) {
                    if(!in_array($item, $arr, true)){
                        $item=(array)$item;
                        $item['factura']=$key;
                        array_push($arr, $item);
                    }
                }
                foreach($arr as $key1=>$val1){
                    if(!in_array($val1, $i, true)){
                        array_push($i,$val1);
                    }
                }
            }
            
            foreach($facturas[$key] as $k=>$v){
                foreach($i as $key2=>$val2){
                   if(!in_array($val2['description'],$arr2, true)){
                       array_push($arr2,$val2['description']);
                   }
                }
                if(!in_array($v['nombre'],$arr2, true)){
                    foreach($i as $key2=>$val2){
                        if(in_array($key,$val2, true)){
                            if(!in_array($key2,$del_k, true)){
                                if(!in_array($key,$not_assigned, true)){
                                    array_push($not_assigned,$facturas[$key]);
                                }
                                array_push($del_k,$key2);
                                //array_push($not_assigned,$facturas[$key2]);
                            }
                        }
                    }
                }
            }
        }
        foreach($del_k as $k){
            unset($i[$k]);
        }
        var_dump($not_assigned);
        $response=array($packedBox->box,$i);
        echo json_encode($response);
        
   /*   $box = new TestBox('Vehiculo 1', 300, 300, 10, 10, 296, 296, 8, 1000);
        $packer = new Packer();
        $packer->addBox(new TestBox('Vehiculo 1', 300, 300, 10, 10, 296, 296, 8, 1000));

        $items = new ItemList();  
        $facturas=array(
            'factura1'=>[
                ['nombre'=>'Caja 1','width'=>300, 'length'=>296, 'depth'=>2, 'weight'=>200, 'keepFlat'=>true],
                ['nombre'=>'Caja 2','width'=>207, 'length'=>296, 'depth'=>2, 'weight'=>500, 'keepFlat'=>true],
                ['nombre'=>'Caja 3','width'=>300, 'length'=>296, 'depth'=>4, 'weight'=>290, 'keepFlat'=>true]
            ],
            'factura2'=>[
                ['nombre'=>'Caja 4','width'=>207, 'length'=>296, 'depth'=>2, 'weight'=>200, 'keepFlat'=>true],
                ['nombre'=>'Caja 5','width'=>207, 'length'=>296, 'depth'=>4, 'weight'=>290, 'keepFlat'=>true]
            ],
            'factura3'=>[
                ['nombre'=>'Caja 6','width'=>207, 'length'=>296, 'depth'=>2, 'weight'=>200, 'keepFlat'=>true],
                ['nombre'=>'Caja 7','width'=>290, 'length'=>296, 'depth'=>2, 'weight'=>500, 'keepFlat'=>true],
                ['nombre'=>'Caja 8','width'=>207, 'length'=>296, 'depth'=>4, 'weight'=>290, 'keepFlat'=>true]
            ]
        );
        $i=array();
        $arr=array();
        $arr2=array();
        $del_k=array();
        $_assigned=array();
        foreach($facturas as $key=>$val){
            foreach($facturas[$key] as $k=>$v){
                //$packer->addItem(new TestItem($v['nombre'], $v['width'], $v['length'], $v['depth'], $v['weight'], $v['keepFlat']));
                $items->insert(new TestItem($v['nombre'], $v['width'], $v['length'], $v['depth'], $v['weight'], $v['keepFlat']));
                //$packedBox = $packer->pack();
                $volumePacker = new VolumePacker($box, $items);
                $packedBox = $volumePacker->pack();
                //var_dump($packedBox);
                foreach ($packedBox->items as $item) {
                    if(!in_array($item, $arr, true)){
                        $item=(array)$item;
                        $item['factura']=$key;
                        array_push($arr, $item);
                    }
                }
                foreach($arr as $key1=>$val1){
                    if(!in_array($val1, $i, true)){
                        array_push($i,$val1);
                    }
                }
            }
            
            foreach($facturas[$key] as $k=>$v){
                foreach($i as $key2=>$val2){
                   if(!in_array($val2['description'],$arr2, true)){
                       array_push($arr2,$val2['description']);
                   }
                }
                if(!in_array($v['nombre'],$arr2, true)){
                    foreach($i as $key2=>$val2){
                        if(in_array($key,$val2, true)){
                            if(!in_array($key2,$del_k, true)){
                                array_push($del_k,$key2);
                            }
                        }
                    }
                }
            }
        }
        foreach($del_k as $k){
            unset($i[$k]);
        }
        $response=array($packedBox->box,$i);
        echo json_encode($response);*/
    }
}
