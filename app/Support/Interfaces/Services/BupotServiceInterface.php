<?php

namespace App\Support\Interfaces\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface BupotServiceInterface extends BaseCrudServiceInterface {

public function penerbitan(array $data);

public function penghapusan(array $data);

}
