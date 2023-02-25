<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\LinkBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\LinkBundle\Dto\LinkApiDtoInterface;
use Evrinoma\LinkBundle\Exception\LinkCannotBeSavedException;
use Evrinoma\LinkBundle\Exception\LinkInvalidException;
use Evrinoma\LinkBundle\Exception\LinkNotFoundException;
use Evrinoma\LinkBundle\Facade\Link\FacadeInterface;
use Evrinoma\LinkBundle\Serializer\GroupInterface;
use Evrinoma\UtilsBundle\Controller\AbstractWrappedApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class LinkApiController extends AbstractWrappedApiController implements ApiControllerInterface
{
    private string $dtoClass;

    private ?Request $request;

    private FactoryDtoInterface $factoryDto;

    private FacadeInterface $facade;

    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        FacadeInterface $facade,
        string $dtoClass
    ) {
        parent::__construct($serializer);
        $this->request = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
        $this->dtoClass = $dtoClass;
        $this->facade = $facade;
    }

    /**
     * @Rest\Post("/api/link/create", options={"expose": true}, name="api_link_create")
     *
     * @OA\Post(
     *     tags={"link"},
     *     description="the method perform create link",
     *
     *     @OA\RequestBody(
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(
     *                 example={
     *                     "class": "Evrinoma\LinkBundle\Dto\LinkApiDto",
     *                     "id": "48",
     *                     "name": "Instagram",
     *                     "url": "http://www.instagram.com/intertechelectro",
     *                     "position": "1",
     *                 },
     *                 type="object",
     *
     *                 @OA\Property(property="class", type="string", default="Evrinoma\LinkBundle\Dto\LinkApiDto"),
     *                 @OA\Property(property="id", type="string"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="url", type="string"),
     *                 @OA\Property(property="position", type="int"),
     *             )
     *         )
     *     )
     * )
     *
     * @OA\Response(response=200, description="Create link")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var LinkApiDtoInterface $linkApiDto */
        $linkApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusCreated();

        $json = [];
        $error = [];
        $group = GroupInterface::API_POST_LINK;

        try {
            $this->facade->post($linkApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Create link', $json, $error);
    }

    /**
     * @Rest\Put("/api/link/save", options={"expose": true}, name="api_link_save")
     *
     * @OA\Put(
     *     tags={"link"},
     *     description="the method perform save link for current entity",
     *
     *     @OA\RequestBody(
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(
     *                 example={
     *                     "class": "Evrinoma\LinkBundle\Dto\LinkApiDto",
     *                     "active": "b",
     *                     "id": "48",
     *                     "name": "Instagram",
     *                     "url": "http://www.instagram.com/intertechelectro",
     *                     "position": "1",
     *                 },
     *                 type="object",
     *
     *                 @OA\Property(property="class", type="string", default="Evrinoma\LinkBundle\Dto\LinkApiDto"),
     *                 @OA\Property(property="id", type="string"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="url", type="string"),
     *                 @OA\Property(property="active", type="string"),
     *                 @OA\Property(property="position", type="int"),
     *             )
     *         )
     *     )
     * )
     *
     * @OA\Response(response=200, description="Save link")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var LinkApiDtoInterface $linkApiDto */
        $linkApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_PUT_LINK;

        try {
            $this->facade->put($linkApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Save link', $json, $error);
    }

    /**
     * @Rest\Delete("/api/link/delete", options={"expose": true}, name="api_link_delete")
     *
     * @OA\Delete(
     *     tags={"link"},
     *
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\LinkBundle\Dto\LinkApiDto",
     *             readOnly=true
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     *
     * @OA\Response(response=200, description="Delete link")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var LinkApiDtoInterface $linkApiDto */
        $linkApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusAccepted();

        $json = [];
        $error = [];

        try {
            $this->facade->delete($linkApiDto, '', $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->JsonResponse('Delete link', $json, $error);
    }

    /**
     * @Rest\Get("/api/link/criteria", options={"expose": true}, name="api_link_criteria")
     *
     * @OA\Get(
     *     tags={"link"},
     *
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\LinkBundle\Dto\LinkApiDto",
     *             readOnly=true
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         description="position",
     *         in="query",
     *         name="position",
     *
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         description="name",
     *         in="query",
     *         name="name",
     *
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         description="url",
     *         in="query",
     *         name="url",
     *
     *         @OA\Schema(
     *             type="string",
     *         )
     *     )
     * )
     *
     * @OA\Response(response=200, description="Return link")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var LinkApiDtoInterface $linkApiDto */
        $linkApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_CRITERIA_LINK;

        try {
            $this->facade->criteria($linkApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get link', $json, $error);
    }

    /**
     * @Rest\Get("/api/link", options={"expose": true}, name="api_link")
     *
     * @OA\Get(
     *     tags={"link"},
     *
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\LinkBundle\Dto\LinkApiDto",
     *             readOnly=true
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     *
     * @OA\Response(response=200, description="Return link")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var LinkApiDtoInterface $linkApiDto */
        $linkApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_GET_LINK;

        try {
            $this->facade->get($linkApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get link', $json, $error);
    }

    /**
     * @param \Exception $e
     *
     * @return array
     */
    public function setRestStatus(\Exception $e): array
    {
        switch (true) {
            case $e instanceof LinkCannotBeSavedException:
                $this->setStatusNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $this->setStatusConflict();
                break;
            case $e instanceof LinkNotFoundException:
                $this->setStatusNotFound();
                break;
            case $e instanceof LinkInvalidException:
                $this->setStatusUnprocessableEntity();
                break;
            default:
                $this->setStatusBadRequest();
        }

        return [$e->getMessage()];
    }
}
