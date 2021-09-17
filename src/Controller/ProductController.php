<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Order;
use App\Entity\Product;
use App\Form\ColorType;

use App\Form\OrderType;
use App\Entity\Category;
use App\Entity\Quantity;
use App\Form\FilterType;
use App\Form\ProductType;
use App\Form\QuantityType;
use App\Service\CartHelper;
use App\Service\ProductHelper;
use App\Repository\CartRepository;
use App\Repository\SizeRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    protected $productRepository;
    protected $categoryRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * @Route("/product/new", name="product_new")
     * @Route("/product/edit/{id}", name="product_edit")
     *
     * @return Response
     */
    public function new(Product $product = null, Request $request, ProductHelper $productHelper): Response
    {
        if($product == null){
            $product =new Product();
        } 

        $form = $this->createForm(ProductType::class, $product);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
   
           $saved = $productHelper->handle($product);
             
           if($saved){
                return $this->redirectToRoute('product_show', [
                    'id' => $product->getId(),
                    'slug' => $product->getSlug()
                ]);
            }
        }
        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/product/show/{id<\d+>}/{slug}/{colorIndex<\d+>?0}/{sizeIndex<\d+>?0}", 
     * name="product_show",
     * requirements ={"slug":"[a-z0-9\-]*"},
     * priority = 2
     * )
     */

    public function show($id, $colorIndex, $sizeIndex, CartHelper $cartHelper, ProductRepository $productRepository, Request $request,  SizeRepository $sizeRepository): Response
    {
        $product = $productRepository->findProduct($id);
        $sizeId = $product->getColors()[$colorIndex]->getSizes()[$sizeIndex]->getId();
        $size = $sizeRepository->find($sizeId);

        $order = new Order();
        $order->setSize($size);
        $quantityForm = $this->createForm(OrderType::class, $order);
        $quantityForm->handleRequest($request);

        if ($size && $quantityForm->isSubmitted() && $quantityForm->isValid()) {

            $cartHelper->addOrder($order, $size);

            return $this->redirectToRoute('cart');
        }

        if ($request->isXmlHttpRequest()) {

            $view = $this->renderView('product/_show.html.twig', [
                'product' => $product,
                'colorIndex' => $colorIndex,
                'sizeIndex' => $sizeIndex,
                'quantity_form' => $quantityForm->createView()

            ]);

            return $this->json(['content' => $view]);
         }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'colorIndex' => $colorIndex,
            'sizeIndex' => $sizeIndex,
            'quantity_form' => $quantityForm->createView()
        ]);
    }


    /**
     * @Route("/product/{category?}/{subCategory?}", name="product_list"
     * )
     */
    public function list(PaginatorInterface $paginator, Request $request, $category, $subCategory, EntityManagerInterface $em, SubCategoryRepository $rp): Response
    {

        //dd($rp->getUniqueValues());
        $categories = $this->categoryRepository->findAllWithSubCategories();

        $filterForm = $this->createForm(FilterType::class);
        $filterForm->handleRequest($request);
        $filterData = null;
        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            $filterData = $filterForm->getData();
        }
 
        $searchParam = $request->query->get('q');
           
        $query = $this->productRepository->findProducts($category, $subCategory, $filterData, $searchParam);

        $products = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9,/*limit per page*/
            array('wrap-queries' => true)
        );

        if ($request->isXmlHttpRequest()) {

            $view = $this->renderView('product/_list_product.html.twig', [
                'products' => $products,

            ]);

            return $this->json(['content' => $view]);
            die;
        }


        return $this->render('product/list.html.twig', [
            'categories' => $categories,
            'products' => $products,
            'filter_form' => $filterForm->createView()

        ]);
    }

    public function listCategories(): Response
    {
        $categories = $this->categoryRepository->findAllWithSubCategories();
        $response = $this->render('utils/_list_categories.html.twig', [
            'categories' => $categories,

        ]);
        $response->setPublic();
        $response->setMaxAge(600);

        return $response;
    }

    public function sideNav(): Response
    {
        $categories = $this->categoryRepository->findAllWithSubCategories();
        $response = $this->render('utils/_side_nav.html.twig', [
            'categories' => $categories,

        ]);
        $response->setPublic();
        $response->setMaxAge(600);

        return $response;
    }
}
  