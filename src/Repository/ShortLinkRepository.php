<?php

namespace App\Repository;

use App\Entity\ShortLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @extends ServiceEntityRepository<ShortLink>
 *
 * @method ShortLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShortLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShortLink[]    findAll()
 * @method ShortLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortLinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShortLink::class);
    }

    public function shortLink(Request $request): JsonResponse
    {
        $link = json_decode($request->getContent(), true);

        $shortLink = new ShortLink();

        $linkInit = $link['link'];

        // Tạo một chuỗi ngẫu nhiên để làm đường dẫn rút gọn
        $shortCode = substr(md5(uniqid()), 0, 6);

        // Tạo đường dẫn rút gọn bằng cách kết hợp URL cơ sở và mã ngẫu nhiên
        $linkShort = 'https://shortUrl.short/'.$shortCode;

        // Thiết lập các thuộc tính của Product từ dữ liệu đầu vào
        $shortLink->setLinkInit($linkInit);
        $shortLink->setLinkShort($linkShort);

        // Lưu đối tượng ShortLink vào cơ sở dữ liệu
        $entityManager = $this->getEntityManager();
        $entityManager->persist($shortLink);
        $entityManager->flush();

        return new JsonResponse(
            [
                "message" => "Short link successfully",
                "data" => $shortLink->getAllValues()
            ],
            Response::HTTP_OK
        );
    }
}
