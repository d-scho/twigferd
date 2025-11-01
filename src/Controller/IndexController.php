<?php

declare(strict_types=1);

namespace App\Controller;

use Dompdf\Dompdf;
use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\ZugferdDocumentPdfBuilder;
use horstoeko\zugferd\ZugferdProfiles;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

final readonly class IndexController
{
    #[Route('/', methods: ['GET'])]
    public function __invoke(Environment $twig): Response
    {
        $html = $twig->render('index.html.twig');

        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4');
        $pdf->render();

        $xmlBuilder = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_BASIC);
        $xmlBuilder->setDocumentInformation(
            documentNo: 'documentNo',
            documentTypeCode: ZugferdInvoiceType::INVOICE,
            documentDate: new \DateTimeImmutable(),
            invoiceCurrency: 'EUR',
        );
        $xmlBuilder->setDocumentSeller('seller');

        $zugferdBuilder = new ZugferdDocumentPdfBuilder(
            $xmlBuilder,
            $pdf->output(),
        );
        $zugferdBuilder->generateDocument();

        $fileName = 'some_file_name.pdf';

        $binaryString = $zugferdBuilder->downloadString();

        return new Response(
            $binaryString,
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
                'Content-Length' => strlen($binaryString),
            ],
        );
    }
}
