<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // Hàm xử lý logic cụ thể với dữ liệu truyền vào và trả về dữ liệu sau khi xử lý
    public function updateProduct(array $data, int $id): Response
    {
        // Lấy sản phẩm cần cập nhật từ cơ sở dữ liệu dựa trên ID
        $product = $this->find($id);

        if (!$product) {
            return new  JsonResponse(
                [
                    "message" => "Product not found",
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        // Cập nhật dữ liệu sản phẩm với dữ liệu mới
        if (isset($data['name'])) {
            $product->setName($data['name']);
        }
        if (isset($data['price'])) {
            $product->setPrice($data['price']);
        }
        if (isset($data['description'])) {
            $product->setDescription($data['description']);
        }

        // Lưu thay đổi vào cơ sở dữ liệu
        $entityManager = $this->getEntityManager(); //  quản lý lưu, truy vấn, cập nhật và xóa dữ liệu.
        $entityManager->persist($product); // thêm product vào quản lý để lưu sau flush 
        $entityManager->flush(); // Sau khi flush() được gọi product sẽ được lưu

        // Trả về dữ liệu sau khi xử lý
        return new  JsonResponse(
            [
                "message" => "Product updated successfully",
                "data" => $product->getAllValues()
            ],
            Response::HTTP_OK
        );
    }

    public function createProduct(array $data): Response
    {
        // Tạo một đối tượng Product mới
        $product = new Product();

        // Thiết lập các thuộc tính của Product từ dữ liệu đầu vào
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setDescription($data['description']);

        // Lưu đối tượng Product vào cơ sở dữ liệu
        $entityManager = $this->getEntityManager();
        $entityManager->persist($product);
        $entityManager->flush();

        // Trả về đối tượng Product sau khi được tạo và lưu vào cơ sở dữ liệu
        return new  JsonResponse(
            [
                "message" => "Product created successfully",
                "data" => $product->getAllValues()
            ],
            Response::HTTP_OK
        );
    }

    public function readAllProduct(): JsonResponse
    {
        $products = $this->findAll();
        $productList = array_map(function ($product) {
            return $product->getAllValues();
        }, $products);
        return new  JsonResponse(
            [
                "message" => "Product Read successfully",
                "data" => $productList
            ],
            Response::HTTP_OK
        );
    }

    public function readOneProduct($id): JsonResponse
    {
        $product = $this->find($id);

        if (!$product) {
            return new  JsonResponse(
                [
                    "message" => "Product not found",
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        return new  JsonResponse(
            [
                "message" => "Product Read successfully",
                "data" => $product->getAllValues()
            ],
            Response::HTTP_OK
        );
    }
}
