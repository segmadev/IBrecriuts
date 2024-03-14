<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\View\View;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\ServicesRepository;
use App\Http\Requests\CreateServicesRequest;
use App\Http\Requests\UpdateServicesRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ServicesController extends AppBaseController
{
    /**
     * @var ServicesRepository
     */
    private $servicesRepository;

    public function __construct(ServicesRepository $servicesRepository)
    {
        $this->servicesRepository = $servicesRepository;
    }

    /**
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        return view('services.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateServicesRequest $request): JsonResponse
    {
        $input = $request->all();
        $this->servicesRepository->store($input);

        return $this->sendSuccess(__('messages.flash.services_save'));
//        return $this->sendSuccess('This functionality not allowed in demo.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Services $services): JsonResponse
    {
        return $this->sendResponse($services, __('messages.flash.services_retrieve'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Services $services): JsonResponse
    {
        return $this->sendResponse($services, __('messages.flash.services_retrieve'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return void
     */
    public function update(UpdateServicesRequest $request, Services $services)
    {
        $input = $request->all();
        $this->servicesRepository->updateServices($input, $services->id);
        return $this->sendSuccess(__('messages.flash.service_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(Services $services): JsonResponse
    {
        $services->delete();

        return $this->sendSuccess(__('messages.flash.services_delete'));
    }

    /**
     * @param  int  $media
     */
    public function downloadImage(Services $services): Media
    {
        $media = $services->getMedia('services')->first()->id;
        /** @var Media $mediaItem */
        $mediaItem = Media::findOrFail($media);

        return $mediaItem;
    }
}
