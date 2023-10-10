<?php
// src/Controller/ProductController.php
namespace App\Controller;

// ...
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    #[Route(name: 'product_create')]
    public function createProduct(Request $request, ProductRepository $productRepository): Response
    {
        // Lấy dữ liệu từ yêu cầu POST
        $data = json_decode($request->getContent(), true);

        // Gọi hàm xử lý logic trong Repository và lấy dữ liệu sau khi xử lý
        $processedData = $productRepository->createProduct($data);

        // Trả về dữ liệu sau khi xử lý
        return $processedData;
    }

    #[Route(name: 'product_read_all')]
    public function readAllProduct(ProductRepository $productRepository): Response
    {
        // Gọi hàm xử lý logic trong Repository và lấy dữ liệu sau khi xử lý
        $processedData = $productRepository->readAllProduct();

        // Trả về dữ liệu sau khi xử lý
        return $processedData;
    }

    #[Route(name: 'product_read_one')]
    public function readOneProduct(ProductRepository $productRepository, int $id): Response
    {
        // Gọi hàm xử lý logic trong Repository và lấy dữ liệu sau khi xử lý
        $processedData = $productRepository->readOneProduct($id);

        // Trả về dữ liệu sau khi xử lý
        return $processedData;
    }

    #[Route(name: 'product_update')]
    public function updateProduct(Request $request, ProductRepository $productRepository, int $id): Response
    {
        // Lấy dữ liệu từ yêu cầu POST
        $data = json_decode($request->getContent(), true);

        // Gọi hàm xử lý logic trong Repository và lấy dữ liệu sau khi xử lý
        $processedData = $productRepository->updateProduct($data, $id);

        // Trả về dữ liệu sau khi xử lý
        return $processedData;
    }

    #[Route(name: 'product_delete')]
    public function deleteProduct(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        $data = [
            "message" => "Delete success",
            "data" => [
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'description' => $product->getDescription(),
            ]
        ];

        $entityManager->remove($product);
        $entityManager->flush();

        return new JsonResponse($data);
    }
}
