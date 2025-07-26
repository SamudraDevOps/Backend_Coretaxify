<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Notification\StoreNotificationRequest;
use App\Http\Requests\Notification\UpdateNotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Support\Interfaces\Services\NotificationServiceInterface;
use Illuminate\Http\Request;

class ApiNotificationController extends ApiController {
    public function __construct(
        protected NotificationServiceInterface $notificationService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $assignment, $sistem ) {
        $perPage = request()->get('perPage', 20);

        $notif = Notification::where('sistem_id', $sistem)
                ->paginate($perPage);

        return NotificationResource::collection($notif);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotificationRequest $request) {
        return $this->notificationService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($assignment, $sistem, Notification $notification) {
        return new NotificationResource($notification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotificationRequest $request, Notification $notification) {
        return $this->notificationService->update($notification, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Notification $notification) {
        return $this->notificationService->delete($notification);
    }
}
