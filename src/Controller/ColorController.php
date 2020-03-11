<?php


namespace App\Controller;


use App\Entity\Color;
use App\Repository\ColorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/colores")
 * Class ColorController
 * @package App\Controller
 */
class ColorController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $this->serializer = $serializer;
        $this->em = $em;
    }

    /**
     * @Route("{page<\d+>?1{type<\w/>&json}", name="color_show_all", methods={"GET"})
     * @param ColorRepository $color
     * @param Request $request
     * @return Response
     */
    public function showAll(ColorRepository $color, Request $request)
    {
        try {
            $page = $request->query->get('page');
            $type = $request->query->get('type');
            if(is_null($page) || $page < 1) {
                $page = 1;
            }
            $limit = 10;
            $colors = $color->findAllColor($page, $limit);
            if ($type === 'xml') {
                $data = $this->serializer->serialize($colors, 'xml', ['attributes' => ['id', 'name', 'color']]);
                $response = new Response($data,Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/xml');
            } else {
                $data = $this->serializer->serialize($colors, 'json', ['attributes' => ['id', 'name', 'color']]);
                $response = new Response($data,Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
            }
            return $response;
        } catch (\Exception $exception) {
            return new Response($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }


    /**
     * @Route("/{id}", name="color_show", methods={"GET"})
     * @param Color $color
     * @return Response
     */
    public function show(Color $color)
    {
        try {
            $data = $this->serializer->serialize($color, 'json');

            $response = new Response($data,Response::HTTP_OK);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        } catch (\Exception $exception) {
            return new Response($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }


    /**
     * @Route("/create/", name="color_create", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        try {
            $data = $request->getContent();
            $color = $this->serializer->deserialize($data, Color::class, 'json');

            $em = $this->em;
            $em->persist($color);
            $em->flush();

            return new Response('', Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return new Response($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}