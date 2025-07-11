<?php

namespace App\Http\Controllers\Api;

use App\DTOs\SaleCreateDTO;
use App\DTOs\SaleDTO;
use App\DTOs\SaleRequestDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SaleDeleteRequest;
use App\Http\Requests\SaleIndexRequest;
use App\Http\Requests\SaleRequest;
use App\Http\Requests\SaleShowRequest;
use App\Models\Sale;
use App\Services\SaleService;
use Illuminate\Http\Request;

use OpenApi\Attributes as OAT;
use OpenApi\Annotations as OA;
class SaleController extends Controller
{
    /**
     * Retrieve a pagination of sales based on the search by date
     */
    #[
        OAT\Get(
            path: '/api/sales',
            tags: ['sales'],
            description: 'Return a pagination of all sales',
            responses: [new OAT\Response(response: 200, description: 'Sales paginated', content: new OAT\MediaType(mediaType: 'application/json'))],
            parameters: [
                new OAT\QueryParameter(
                    name: 'searchQuery',
                    description: 'A date valid to filter sales',
                    required: false,
                    example: '2025-07-06'
                )
            ],
            security: [
            [
                'bearerToken' => [
                ],
            ],
        ]
        )
    ]
    public function index(SaleService $saleService, SaleIndexRequest $request)
    {
        $searchQuery = $request->query('searchQuery') ?? '';
        return $saleService->findAll($searchQuery);
    }

    /**
     *  Create a new sale with products
     */
    #[OAT\Post(
        path: '/api/sales/store',
        tags: ['sales'],
        description: 'Create a new sale with products included',
        security: [
            [
                'bearerToken' => []
            ]
        ],
        responses: [
            new OAT\Response(response: 200, description: 'Sale created correctly', content: new OAT\JsonContent(ref: '#/components/schemas/sale_response')),
            new OAT\Response(response: 422, description: 'Some data input is not permitted', content: new OAT\MediaType(mediaType: 'application/json')),
            new OAT\Response(response: 401, description: 'You need a PersonalAccessToken', content: new OAT\MediaType(mediaType: 'application/json'))
        ],
        requestBody: new OAT\RequestBody(
            required: true, 
            description: 'Data necessary to create the sale', 
            content: new OAT\JsonContent(
                ref: '#/components/schemas/sale_request'
            )
        )
    )]
    public function store(SaleRequest $request, SaleService $saleService)
    {
        $createDTO = new SaleRequestDTO($request->validated(), $request->user()->id);
        
        $dto = new SaleDTO($saleService->createAndAppendProducts($createDTO->getSaleData(), $createDTO->getProducts()));

        return response()->json($dto);
    }

    /**
     * Retrieve a sale.
     */
    #[OAT\Get(
        path:'/api/sales/show/{sale}',
        tags: ['sales'],
        parameters: [
            new OAT\Parameter(name: 'sale', in:'path', required:true, description: 'Id of the sale to get')
        ],
        responses: [
            new OAT\Response(response: '200', description: 'The sale specified in url', content: new OAT\JsonContent(ref: '#/components/schemas/sale_response')),
            new OAT\Response(response: '404', description: 'The sale does not exists in database'),
            new OAT\Response(response: '422', description: 'You send a invalid value in the URL Param'),
        ],
        security: [
            [
                'bearerToken' => []
            ]
        ]
    )]
    public function show(SaleShowRequest $request, SaleService $saleService)
    {
        $dto = new SaleDTO($saleService->findOne($request->sale));
        return response()->json($dto);
    }

    /**
     * Update the specified resource in storage.
     */
    #[OAT\Put(
        path: '/api/sales/update/{sale}',
        tags: ['sales'],
        responses: [
            new OAT\Response(response: 200, description: 'The sale modified correctly',content: new OAT\JsonContent(ref: '#/components/schemas/sale_response', type: 'object'))
        ],
        requestBody: new OAT\RequestBody(
            required: true,
            description: 'The request body may include all or only some of the following fields. All fields are optional unless otherwise specified.',
            content: new OAT\JsonContent(
                ref: '#/components/schemas/sale_request'
            )
            ),
        parameters: [
            new OAT\Parameter(name: 'sale', in:'path', required:true, description: 'Id of the sale to get', example: 1)
        ],
        security: [
            [
                'bearerToken' => []
            ]
        ]
    )]
    //TODO: DTO of the request
    public function update(SaleRequest $request, Sale $sale, SaleService $saleService)
    {
        $dto = new SaleRequestDTO($request->validated());
        
        return response()->json(new SaleDTO($saleService->update($sale->id, $dto->getSaleData(), $dto->getProducts())));
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OAT\Delete(
        path: '/api/sales/delete/{sale}',
        tags: ['sales'],
        parameters: [
            new OAT\Parameter(name: 'sale', in:'path', required:true, description: 'Id of the sale to get', example: 1)
        ],
        responses: [
            new OAT\Response(response: 200, description: 'The sale has entered to be cancelled', content: new OAT\JsonContent(type: 'boolean', example: true)),
            new OAT\Response(response: 422, description: 'Some of the inputs or input in URL Param are not valid'),
            new OAT\Response(response: 401, description: 'You need to use your personal access token'),
        ],
        security: [
            [
                'bearerToken' => []
            ]
        ],
    )]
    public function destroy(SaleDeleteRequest $request, SaleService $saleService)
    {
        $valid = $request->validated();
        return response()->json($saleService->delete($valid['sale'], ["soft" => true]));
    }
}
