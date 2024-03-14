<?php

namespace App\Repositories;

use App\Models\Services;
use Exception;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class ServicesRepository
 */
class ServicesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name', 'description'
    ];

    /**
     * @return array|string[]
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Services::class;
    }

    public function store($input): bool
    {
        try {
            /** @var Services $services */
            $services = $this->create($input);

            if (isset($input['services_image']) && ! empty($input['services_image'])) {
                $services->addMedia($input['services_image'])->toMediaCollection(Services::PATH,
                    config('app.media_disc'));
            }
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }

    public function updateServices($input, $servicesId)
    {
        try {
            /** @var Services $services */
            $services = $this->update($input, $servicesId);

            if (! empty($input['services_image'])) {
                $services->clearMediaCollection(Services::PATH);
                $services->addMedia($input['services_image'])->toMediaCollection(Services::PATH,
                    config('app.media_disc'));
            }
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
