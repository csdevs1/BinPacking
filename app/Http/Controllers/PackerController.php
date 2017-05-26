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
  $packer->addBox(new TestBox('Le petite box', 30000, 30000, 100, 100, 2960, 2960, 8, 22000));
  $packer->addBox(new TestBox('Le grande box', 3000, 3000, 150, 150, 2960, 2960, 80, 10000));
  $packer->addItem(new TestItem('Item 1', 50, 50, 20, 15000, true));
  $packer->addItem(new TestItem('Item 2', 50, 50, 20, 200, false));
  $packer->addItem(new TestItem('Item 3', 50, 50, 20, 200, true)); // you can even choose if an item needs to be kept flat (packed "this way up")
  $packedBoxes = $packer->pack();

  echo("These items fitted into " . count($packedBoxes) . " box(es)" . PHP_EOL);
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



  /*
   * To just see if a selection of items will fit into one specific box
   */
  $box = new TestBox('Le box', 300, 300, 10, 10, 296, 296, 8, 1000);

  $items = new ItemList();
  $items->insert(new TestItem('Item 1', 297, 296, 2, 200, true));
  $items->insert(new TestItem('Item 2', 297, 296, 2, 500, true));
  $items->insert(new TestItem('Item 3', 296, 296, 4, 290, true));

  $volumePacker = new VolumePacker($box, $items);
  $packedBox = $volumePacker->pack();
  /* $packedBox->getItems() contains the items that fit */
    }
}
