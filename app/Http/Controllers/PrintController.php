<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use charlieuki\ReceiptPrinter\ReceiptPrinter;

class PrintController extends Controller
{
    public function print(Request $request){
        $printer = new ReceiptPrinter;
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );
        $printer->addPhones($request->phones);

        $printer->setStore($request->order_id, $request->store_name, $request->store_address, $request->store_email, $request->store_website);

        $printer->setCurrency($request->currency);

        $printer->setDate($request->date);

        foreach ($request->items as $item) {
            $printer->addItem(
                $item['name'],
                $item['qty'],
                $item['sale_price'] ? $item['sale_price'] :  $item['price'],
                $item['discount']
            );
        }
        $printer->calculateDiscount();

        $printer->addTotal($request->total);
        $printer->addSubTotal($request->sub_total);

        $printer->setLogo(public_path('logo-small.png'));
        $printer->setQRcode("$request->store_website/shop");
        $printer->printReceipt();
    }
}
