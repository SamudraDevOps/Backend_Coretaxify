<?php

namespace App\Services;

use App\Models\Group;
use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Models\GroupUser;
use App\Support\Interfaces\Repositories\GroupRepositoryInterface;
use App\Support\Interfaces\Services\GroupServiceInterface;

class GroupService extends BaseCrudService implements GroupServiceInterface {
    protected function getRepositoryClass(): string {
        return GroupRepositoryInterface::class;
    }

    public function create(array $data): ?Model {
        $data['user_id'] = auth()->id();
        // $data['class_code'] = Group::generateClassCode();

        $group = parent::create($data);

        // // Attach logged in user to the newly created group
        // $group->users()->attach(auth()->id());

        return $group;
    }

    public function joinGroup(array $data): ?Model {
        $group = Group::where('class_code', $data['class_code'])->first();
        $groupId = $group->id;

        $groupUser = GroupUser::create([
            'user_id' => auth()->id(),
            'group_id' => $groupId,
        ]);

        return $groupUser;
    }
}