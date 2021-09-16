<?php

namespace App\Controller;

use App\Entity\Sale;
use App\Entity\Size;
use App\Form\SaleType;
use App\Entity\SaleForm;
use App\Repository\SaleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SaleController extends AbstractController
{
    /**
     * @Route("/sale/{id<\d+>}", name="sale")
     */
    public function index(Size $size, Request $request, SaleRepository $saleRepo,  EntityManagerInterface $em): Response
    {
        $saleForm = (new SaleForm())
            ->setName($size->getProduct()->getName())
            ->setColor($size->getColor()->getName())
            ->setSize($size->getName())
            ->setPrice($size->getPrice())
            ->setStock($size->getStock());

        $form = $this->createForm(SaleType::class, $saleForm);
        //  dd($request);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldSales = $saleRepo->findOldSaleBySize($size->getId(), $saleForm->getStartDate());
           // dd($oldSales);
            foreach ($oldSales as $oldSale) {
                if ($oldSale->getStartDate() < $saleForm->getEndDate()) {
                    $oldSale->setEndDate($saleForm->getStartDate());
                    $em->persist($oldSale);
                    $em->flush();
                }
            }
            $sale = (new Sale())
                ->setStartDate($saleForm->getStartDate())
                ->setEndDate($saleForm->getEndDate())
                ->setMinItems($saleForm->getMinItems())
                ->setRate($saleForm->getRate())
                ->setSize($size);

            $em->persist($sale);
            $em->flush();
        }
        return $this->render('sale/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
