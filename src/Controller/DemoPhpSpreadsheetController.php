<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\StreamedResponse;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Product;

class DemoPhpSpreadsheetController extends AbstractController
{

    public function index(ManagerRegistry $doctrine): Response
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'NAME');
        $sheet->setCellValue('C1', 'DESCRIPTION');
        $sheet->setCellValue('D1', 'BRAND');
        $sheet->setCellValue('E1', 'CATEGORY');
        $sheet->setCellValue('F1', 'PRICE');

        $products = $doctrine->getRepository(Product::class)->findAll();

        $arrayData = [];

        foreach ($products as $key => $value) {
            $arrayData[$key][] = $value->getCode();
            $arrayData[$key][] = $value->getName();
            $arrayData[$key][] = $value->getDescription();
            $arrayData[$key][] = $value->getBrand();
            $arrayData[$key][] = $value->getCategory()->getName();
            $arrayData[$key][] = $value->getPrice();
        }

        $spreadsheet->getActiveSheet()->fromArray($arrayData, NULL, 'A2');

        $dateTime = date('d-m-Y-H-i-s');
    
        $filename = "document-".$dateTime.".xlsx";

        $contentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        $writer = new Xlsx($spreadsheet);

        $response = new StreamedResponse();
        $response->headers->set('Content-Type', $contentType);
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename.'"');
        $response->setPrivate();
        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->setCallback(function() use ($writer) {
            $writer->save('php://output');
        });

        return $response;
    }
}
