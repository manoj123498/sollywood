<?php

namespace App\Http\Controllers\API\v1\Dashboard\Admin;

use Exception;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseError;
use App\Http\Resources\EventResource;
use Symfony\Component\HttpFoundation\Response;

class EventController extends AdminBaseController
{

    public function __construct(protected Event $model)
    {
        parent::__construct();
    }

    public function show(): JsonResponse
    {
        $event =  Event::all();
        if ($event){
            return $this->successResponse(__('web.events_found'), EventResource::collection($event));
        }
        return $this->errorResponse(
            ResponseError::ERROR_404, trans('errors.' . ResponseError::ERROR_404, [], $this->language),
            Response::HTTP_NOT_FOUND
        );
    }

    public function store(Request $request)
    {
        try {
            $event = $this->model->create([
                'title' => $request->title,
                'description' => $request->description,
                'cashback_amount' => $request->cashback_amount,
                'event_start_date' => $request->start,
                'event_end_date' => $request->end,
            ]);

            return $this->successResponse(trans('web.record_successfully_created'), EventResource::make($event));
        } catch (Exception $exception) {
            return $this->errorResponse(ResponseError::ERROR_400,
                $exception->getMessage(),
                Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $event =  Event::where('id',$id)->first();
        if ($event){
            try {
                $event->update([
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'cashback_amount' => $request->input('cashback_amount'),
                ]);

                return $this->successResponse(__('web.record_successfully_updated'), EventResource::make($event));
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

    public function destroy(string $id)
    {
        $event = $this->model->firstWhere('id', $id);
        if ($event) {
            try {
                $event->delete();
                return $this->successResponse(trans('web.record_successfully_deleted', []), []);
            } catch (Exception $exception) {
                return $this->errorResponse(ResponseError::ERROR_400,
                    $exception->getMessage(),
                    Response::HTTP_BAD_REQUEST);
            }
        } else {
            return $this->errorResponse(ResponseError::ERROR_404,
                trans('errors.' . ResponseError::ERROR_404, [], $this->language),
                Response::HTTP_NOT_FOUND);
        }
    }
}
