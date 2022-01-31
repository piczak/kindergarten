<?php

namespace App\Core\Traits;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Trait StatusActionTrait
 * @package App\Core\Traits
 */
trait StatusActionTrait
{
    /**
     * @Route("/status", name="status")
     * @param Request $request
     * @return mixed
     */
    public function statusAction(Request $request)
    {
        $mapping = $this->getStatusActionMapping($request);

        $item = $this->getDoctrine()
            ->getRepository($mapping['entity'])
            ->find($request->get('id'))
        ;

        $newStatus = $request->get('status');

        $result = [
            'status' => 'error'
        ];

        if ($item && in_array($newStatus, $mapping['allowed'])) {
            $item->{$mapping['setMethod']}($newStatus);

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $result = [
                'status' => 'success',
                'href' => $mapping['mapping'][$newStatus]['href'],
                'hrefClass' => $mapping['mapping'][$newStatus]['hrefClass'],
                'class' => $mapping['mapping'][$newStatus]['class']
            ];
        }

        if ($request->isXmlHttpRequest()) {
            return $this->json($result);
        }

        return $this->redirectToRoute($mapping['redirect']);
    }
}
