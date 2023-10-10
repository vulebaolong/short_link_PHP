<?php

namespace App\Controller;

use App\Repository\ShortLinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShortLinkController extends AbstractController
{
    #[Route(name: 'short_link')]
    public function shortLink(ShortLinkRepository $shortLinkRepository, Request $request): JsonResponse
    {
        // Gọi hàm xử lý logic trong Repository và lấy dữ liệu sau khi xử lý
        $processedData = $shortLinkRepository->shortLink($request);

        // Trả về dữ liệu sau khi xử lý
        return $processedData;
    }
}
