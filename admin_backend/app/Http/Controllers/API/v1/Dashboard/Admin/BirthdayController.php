<?php

namespace App\Http\Controllers\API\v1\Dashboard\Admin;

use Exception;
use App\Models\Birthday;
use Illuminate\Http\Request;
use App\Helpers\ResponseError;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\BirthdayResource;
use Symfony\Component\HttpFoundation\Response;

class BirthdayController extends AdminBaseController
{

    public function __construct(
        protected Birthday $model
    )
    {
        parent::__construct();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $birth =  Birthday::where('id',$id)->first();
        if ($birth){
            return $this->successResponse(__('web.birthday_cashback_found'), BirthdayResource::make($birth));
        }
        return $this->errorResponse(
            ResponseError::ERROR_404, trans('errors.' . ResponseError::ERROR_404, [], $this->language),
            Response::HTTP_NOT_FOUND
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $unit =  Birthday::where('id',$id)->first();
        if ($unit){
            try {
                $unit->update([
                    'gift_amount' => $request->input('gift_amount'),
                ]);

                return $this->successResponse(__('web.record_successfully_updated'), BirthdayResource::make($unit));
            } catch (Exception $exception) {
                return $this->errorResponse(
                    ResponseError::ERROR_400, $exception->getMessage(),
                    Response::HTTP_BAD_REQUEST
                );
            }
        }
        return $this->errorResponse(
            ResponseError::ERROR_404, trans('errors.' . ResponseError::ERROR_404, [], $this->language),
            Response::HTTP_NOT_FOUND
        );
    }
}
