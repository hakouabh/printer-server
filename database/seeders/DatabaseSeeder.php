<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use charlieuki\ReceiptPrinter\ReceiptPrinter;
use PhpAidc\LabelPrinter\Enum\Unit;
use PhpAidc\LabelPrinter\Enum\Anchor;
use PhpAidc\LabelPrinter\Enum\Charset;
use PhpAidc\LabelPrinter\Printer;
use PhpAidc\LabelPrinter\Label\Label;
use PhpAidc\LabelPrinter\Label\Element;
use PhpAidc\LabelPrinter\CompilerFactory;
use PhpAidc\LabelPrinter\Connector\ArrayConnector;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $label = Label::create(Unit::MM(), 43, 25)
            ->charset(Charset::UTF8())
            ->add(Element::textBlock(168, 95, 'Hello!', 'Univers', 8)->box(338, 100, 0)->anchor(Anchor::CENTER()))
            ->add(Element::barcode(10, 10, '123456', 'CODE93')->height(60))
        ;

        (new Printer(new ArrayConnector(), CompilerFactory::tspl()))->print($label);
    }
}
