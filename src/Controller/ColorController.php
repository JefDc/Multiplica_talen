<?php


namespace App\Controller;


use App\Entity\Color;
use App\Repository\ColorRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation;

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
     * @Route("/", name="color_show_all")
     * @param ColorRepository $color
     * @return Response
     */
    public function showAll(ColorRepository $color)
    {
        $colors = $color->findAllColor();
        $data = $this->serializer->serialize($colors, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }


    /**
     * @Route("/{id}", name="color_show")
     * @param Color $color
     * @return Response
     * @throws \Exception
     */
    public function show(Color $color)
    {

        $data = $this->serializer->serialize($color, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    /**
     * @Route("/create/", name="color_create", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $data = $request->getContent();
        $color = $this->serializer->deserialize($data, Color::class, 'json');

        $em = $this->em;
        $em->persist($color);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }
}