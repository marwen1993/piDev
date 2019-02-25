<?php
/**
 * Created by PhpStorm.
 * User: chevc
 * Date: 25/04/2018
 * Time: 18:42
 */

namespace MobileApiBundle\Controller;
use MobileApiBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;



class TaskController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function allAction()
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('MobileApiBundle:Task')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function findAction($id)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('MobileApiBundle:Task')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $task = new Task();
        $task->setName($request->get('name'));
        $task->setStatus($request->get('status'));
        $em->persist($task);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($task);
        return new JsonResponse($formatted);
    }
}
