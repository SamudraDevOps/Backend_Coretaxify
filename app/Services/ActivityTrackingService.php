<?php

namespace App\Services;

use App\Models\AssignmentUser;
use App\Models\AssignmentUserActivity;
use Illuminate\Database\Eloquent\Collection;

class ActivityTrackingService
{
    public function logActivity(AssignmentUser $assignmentUser, string $activityType, string $description, array $data = []): AssignmentUserActivity
    {
        return AssignmentUserActivity::create([
            'assignment_user_id' => $assignmentUser->id,
            'user_id' => auth()->id(),
            'activity_type' => $activityType,
            'description' => $description,
            'data' => $data
        ]);
    }

    public function getRecentActivities(AssignmentUser $assignmentUser, int $limit = 20): Collection
    {
        return $assignmentUser->activities()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getActivitiesByType(AssignmentUser $assignmentUser, string $activityType, int $limit = 20): Collection
    {
        return $assignmentUser->activities()
            ->where('activity_type', $activityType)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getActivitySummary(AssignmentUser $assignmentUser): array
    {
        // Load activities as collection first
        $activities = $assignmentUser->activities()->orderBy('created_at', 'desc')->get();

        $summary = [
            'total_activities' => $activities->count(),
            'activity_types' => [],
            'first_activity' => $activities->last()?->created_at,
            'last_activity' => $activities->first()?->created_at,
            'most_active_day' => null
        ];

        // Group by activity type
        $typeGroups = $activities->groupBy('activity_type');
        foreach ($typeGroups as $type => $typeActivities) {
            $summary['activity_types'][$type] = $typeActivities->count();
        }

        // Find most active day - use collection groupBy with closure
        $dayGroups = $activities->groupBy(function ($activity) {
            return $activity->created_at->format('Y-m-d');
        });

        if ($dayGroups->count() > 0) {
            $mostActiveDay = $dayGroups->sortByDesc(function ($dayActivities) {
                return $dayActivities->count();
            })->first();

            $summary['most_active_day'] = [
                'date' => $mostActiveDay->first()->created_at->format('Y-m-d'),
                'activity_count' => $mostActiveDay->count()
            ];
        }

        return $summary;
    }
}
