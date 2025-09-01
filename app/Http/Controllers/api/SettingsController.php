<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

class SettingsController extends Controller
{

    #[OAT\Get(
        path: '/api/settings',
        tags: ['settings'],
        description: 'Retrieves a key value array with settings of backend application',
        responses: [
            new OAT\Response(
                description: 'Settings obtained correctly',
                response: 200,
                content: new OAT\JsonContent(
                    type: 'object',
                    properties: [
                        new OAT\Property(property: 'APP_NAME', type: 'string', example: 'Default', description: 'The name of application'),
                        new OAT\Property(property: 'APP_ICON', type: 'string', example: 'http://tudominio.com/storage/app_resources/archivo.extension', description: 'The url to access to the icon'),
                    ]
                )
            ),
        ]
    )]
    /**
     * Retrieve all recent settings in application
     */
    public function index(SettingsService $settings_service){
        return $settings_service->retrieveSettings();
    }
}
