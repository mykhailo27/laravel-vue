<?php

namespace App\Http\Controllers\Package;

use App\Constants\Ability;
use App\Http\Controllers\Controller;
use App\Http\Resources\Variant\VariantCollection;
use App\Http\Resources\Variant\VariantResource;
use App\Models\Package;
use App\Models\Variant;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PackageApiController extends Controller
{
    public function addVariant(Package $package, Variant $variant): Response
    {
        $added = PackageModelController::addVariant($package, $variant);

        return response([
            'message' => $added
                ? 'Variant has been added successful'
                : 'Fail to add variant to an package',
            'success' => $added,
            'variant' => new VariantResource($variant)
        ]);
    }

    public function deleteMultiple(Request $request): Response
    {
        try {
            $this->authorize(Ability::DELETE_ANY, Package::class);

            $ids = $request->get('ids');
            $deleted = PackageModelController::delete($ids);
            $success = $deleted === count($ids);

            return response([
                'success' => $success,
                'message' => $success ? 'All packages deleted' : 'Some packages deleted',
            ]);
        } catch (AuthorizationException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function delete(Request $request): Response
    {
        try {
            $package = PackageModelController::getById($request->get('id'));

            $this->authorize(Ability::DELETE, $package);

            $deleted = PackageModelController::delete($package->id);
            return response([
                'success' => $deleted,
                'message' => $deleted ? 'Package deleted' : 'Package fail to be deleted',
            ]);
        } catch (AuthorizationException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function variants(Package $package): Response
    {
        return response([
            'success' => true,
            'message' => 'Load package variants',
            'variants' => new VariantCollection($package->variants)
        ]);
    }

    public function removeVariant(Package $package, Variant $variant): Response
    {
        $removed = PackageModelController::removeVariant($package, $variant);

        return response([
            'message' => $removed
                ? 'Variant has been removed successful'
                : 'Fail to remove variant from a package',
            'success' => $removed,
            'variant' => new VariantResource($variant)
        ]);
    }
}
