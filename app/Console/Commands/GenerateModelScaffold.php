<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Str;

class Model {

    public string $name;
    public string $studly;
    public string $camel;
    public string $snake;
    public string $upper;
    public string $upperSnake;
    public string $lower;
    public string $kebab;
    public string $kebabPlural;

    public function __construct(string $modelName) {
        $this->name = $modelName;
        $this->studly = Str::studly($modelName);
        $this->camel = Str::camel($modelName);
        $this->snake = Str::snake($modelName);
        $this->upper = Str::upper($modelName);
        $this->upperSnake = Str::upper($this->snake);
        $this->lower = Str::lower($modelName);
        $this->kebab = Str::kebab($modelName);
        $this->kebabPlural = Str::plural($this->kebab);
    }
}

class GenerateModelScaffold extends Command {
    private static Model $model;
    private static bool $withAll = false;
    private static bool $withMigration = false;
    private static bool $withSeeder = false;
    private static bool $withFactory = false;
    private static bool $withController = false;
    private static bool $withApiController = false;
    private static bool $withTest = false;
    private static bool $asPivot = false;
    private static array $excluded = [];
    private static bool $showHelp = false;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:scaffold {model : The name of the model}
                            {--a|all : Generate seeder, controller, factory}
                            {--m|migration : Generate a migration for the model}
                            {--s|seeder : Generate a seeder for the model}
                            {--f|factory : Generate a factory for the model}
                            {--controller : Generate a controller for the model}
                            {--api-controller : Generate an API controller for the model}
                            {--test : Generate a test for the model}
                            {--p|pivot : Generate a pivot model for the model}
                            {--e|exclude=* : Do not generate files for the specified model}
                            {--h|help : Display this help message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold model, repository, service, controller, request files for a model with optional seeder and factory structure generation.';

    /**
     * Execute the console command.
     */
    public function handle(): void {
        self::$model = new Model($this->argument('model'));
        self::$withAll = $this->option('all');
        self::$withMigration = $this->option('migration');
        self::$withSeeder = $this->option('seeder');
        self::$withFactory = $this->option('factory');
        self::$withController = $this->option('controller');
        self::$withApiController = $this->option('api-controller');
        self::$withTest = $this->option('test');
        self::$asPivot = $this->option('pivot');
        self::$excluded = $this->option('exclude');
        self::$showHelp = $this->option('help');

        if (self::$showHelp) {
            $this->help();

            return;
        }

        if (self::$withAll) {
            self::$withMigration = !in_array('migration', self::$excluded);
            self::$withSeeder = !in_array('seeder', self::$excluded);
            self::$withFactory = !in_array('factory', self::$excluded);
            self::$withController = !in_array('controller', self::$excluded);
            self::$withApiController = !in_array('api-controller', self::$excluded);
            self::$withTest = !in_array('test', self::$excluded);
        }

        $this->generateModel();
        $this->generateFiles();

        $model = self::$model->name;

        $this->info('Scaffolding for model ' . $model . ' is completed.');
    }

    protected function generateModel(): void {
        $options = [
            'name' => self::$model->name,
            '--migration' => self::$withMigration,
            '--seed' => self::$withSeeder,
            '--factory' => self::$withFactory,
            '--pivot' => self::$asPivot,
        ];

        $modelName = self::$model->name;
        $withSeeder = self::$withSeeder;
        $withFactory = self::$withFactory;
        $asPivot = self::$asPivot;

        Artisan::call('make:model', $options);

        $this->info("Model {$modelName} generated with migration" . ($withSeeder ? ' and seeder' : '') . ($withFactory ? ' and factory' : '') . ($asPivot ? ' as pivot' : ''));
    }

    protected function generateFiles(): void {
        $paths = $this->definePaths();
        $templates = $this->defineTemplates();

        foreach ($paths as $key => $path) {
            File::ensureDirectoryExists(dirname($path));

            if (!File::exists($path) && $key !== 'controller' && $key !== 'apiController') {
                File::put($path, $templates[$key]);
                $this->info("File created: {$path}");
            } else {
                if ($key !== 'controller' && $key !== 'apiController') {
                    $this->warn("File already exists, skipping: {$path}");
                }
            }
        }

        if (self::$withController) {
            $this->generateController();
            if (self::$withTest) {
                $this->generateControllerTest();
            }
        }
        if (self::$withApiController) {
            $this->generateApiController();
            if (self::$withTest) {
                $this->generateApiControllerTest();
            }
        }
    }

    protected function definePaths(): array {
        $basePath = app_path();
        $resourcePath = resource_path();
        $modelNameStudly = self::$model->studly;
        $modelCamel = self::$model->camel;

        $paths = [
            'repositoryInterface' => "{$basePath}/Support/Interfaces/Repositories/{$modelNameStudly}RepositoryInterface.php",
            'serviceInterface' => "{$basePath}/Support/Interfaces/Services/{$modelNameStudly}ServiceInterface.php",
            'repository' => "{$basePath}/Repositories/{$modelNameStudly}Repository.php",
            'service' => "{$basePath}/Services/{$modelNameStudly}Service.php",
            'controller' => "{$basePath}/Http/Controllers/{$modelNameStudly}Controller.php",
            'storeRequest' => "{$basePath}/Http/Requests/{$modelNameStudly}/Store{$modelNameStudly}Request.php",
            'updateRequest' => "{$basePath}/Http/Requests/{$modelNameStudly}/Update{$modelNameStudly}Request.php",
            'resource' => "{$basePath}/Http/Resources/{$modelNameStudly}Resource.php",
        ];

        return $paths;
    }

    protected function defineTemplates(): array {
        $templates = [
            'repositoryInterface' => $this->getRepositoryInterfaceTemplate(),
            'serviceInterface' => $this->getServiceInterfaceTemplate(),
            'repository' => $this->getRepositoryTemplate(),
            'service' => $this->getServiceTemplate(),
            'storeRequest' => $this->getStoreRequestTemplate(),
            'updateRequest' => $this->getUpdateRequestTemplate(),
            'resource' => $this->getResourceTemplate(),
        ];

        return $templates;
    }

    protected function generateController(): void {
        $modelNameStudly = self::$model->studly;
        $modelNameCamel = self::$model->camel;
        $controllerPath = app_path("Http/Controllers/{$modelNameStudly}Controller.php");

        if (File::exists($controllerPath)) {
            $this->warn("File already exists, skipping: {$controllerPath}");

            return;
        }

        $controllerContent = $this->getControllerTemplate($modelNameStudly, $modelNameCamel);
        File::put($controllerPath, $controllerContent);

        $this->info("Controller created: {$controllerPath}");
    }

    protected function generateApiController(): void {
        $modelNameStudly = self::$model->studly;
        $modelNameCamel = self::$model->camel;
        $apiControllerPath = app_path("Http/Controllers/Api/Api{$modelNameStudly}Controller.php");

        if (File::exists($apiControllerPath)) {
            $this->warn("File already exists, skipping: {$apiControllerPath}");

            return;
        }

        $apiControllerContent = $this->getApiControllerTemplate();
        File::put($apiControllerPath, $apiControllerContent);

        $this->info("API Controller created: {$apiControllerPath}");
    }

    protected function generateControllerTest(): void {
        $modelNameStudly = self::$model->studly;
        $controllerTestPath = base_path("tests/Feature/Http/Controllers/{$modelNameStudly}ControllerTest.php");

        if (File::exists($controllerTestPath)) {
            $this->warn("File already exists, skipping: {$controllerTestPath}");

            return;
        }

        $controllerTestContent = $this->getControllerTestTemplate();
        File::put($controllerTestPath, $controllerTestContent);

        $this->info("Controller Test created: {$controllerTestPath}");
    }

    protected function generateApiControllerTest(): void {
        $modelNameStudly = self::$model->studly;
        $apiControllerTestPath = base_path("tests/Feature/Http/Controllers/Api/Api{$modelNameStudly}ControllerTest.php");

        if (File::exists($apiControllerTestPath)) {
            $this->warn("File already exists, skipping: {$apiControllerTestPath}");

            return;
        }

        $apiControllerTestContent = $this->getApiControllerTestTemplate();
        File::put($apiControllerTestPath, $apiControllerTestContent);

        $this->info("API Controller Test created: {$apiControllerTestPath}");
    }

    protected function getRepositoryInterfaceTemplate(): string {
        $modelName = self::$model->studly;

        return <<<PHP
        <?php

        namespace App\Support\Interfaces\Repositories;

        use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\Contracts\BaseRepositoryInterface;

        interface {$modelName}RepositoryInterface extends BaseRepositoryInterface {}
        PHP;
    }

    protected function getServiceInterfaceTemplate(): string {
        $modelName = self::$model->studly;

        return <<<PHP
        <?php

        namespace App\Support\Interfaces\Services;

        use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

        interface {$modelName}ServiceInterface extends BaseCrudServiceInterface {}
        PHP;
    }

    protected function getRepositoryTemplate(): string {
        $modelName = self::$model->studly;

        return <<<PHP
        <?php

        namespace App\Repositories;

        use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\BaseRepository;
        use App\Models\\{$modelName};
        use App\Support\Interfaces\Repositories\\{$modelName}RepositoryInterface;
        use App\Traits\Repositories\HandlesFiltering;
        use App\Traits\Repositories\HandlesRelations;
        use App\Traits\Repositories\HandlesSorting;
        use Illuminate\Database\Eloquent\Builder;

        class {$modelName}Repository extends BaseRepository implements {$modelName}RepositoryInterface {
            use HandlesFiltering, HandlesRelations, HandlesSorting;

            protected function getModelClass(): string {
                return {$modelName}::class;
            }

            protected function applyFilters(array \$searchParams = []): Builder {
                \$query = \$this->getQuery();

                \$query = \$this->applySearchFilters(\$query, \$searchParams, ['name']);

                \$query = \$this->applyColumnFilters(\$query, \$searchParams, ['id']);

                \$query = \$this->applyResolvedRelations(\$query, \$searchParams);

                \$query = \$this->applySorting(\$query, \$searchParams);

                return \$query;
            }
        }
        PHP;
    }

    protected function getServiceTemplate(): string {
        $modelName = self::$model->studly;

        return <<<PHP
        <?php

        namespace App\Services;

        use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
        use App\Support\Interfaces\Repositories\\{$modelName}RepositoryInterface;
        use App\Support\Interfaces\Services\\{$modelName}ServiceInterface;

        class {$modelName}Service extends BaseCrudService implements {$modelName}ServiceInterface {
            protected function getRepositoryClass(): string {
                return {$modelName}RepositoryInterface::class;
            }
        }
        PHP;
    }

    protected function getControllerTemplate(): string {
        $modelName = self::$model->studly;
        $modelNameCamel = self::$model->camel;

        return <<<PHP
        <?php

        namespace App\Http\Controllers;

        use App\Http\Requests\\{$modelName}\Store{$modelName}Request;
        use App\Http\Requests\\{$modelName}\Update{$modelName}Request;
        use App\Http\Resources\\{$modelName}Resource;
        use App\Models\\{$modelName};
        use App\Support\Interfaces\Services\\{$modelName}ServiceInterface;
        use Illuminate\Http\Request;

        class {$modelName}Controller extends Controller {
            public function __construct(protected {$modelName}ServiceInterface \${$modelNameCamel}Service) {}

            public function index(Request \$request) {
                \$perPage = \$request->get('perPage', 10);
                \$data = {$modelName}Resource::collection(\$this->{$modelNameCamel}Service->getAllPaginated(\$request->query(), \$perPage));

                if (\$this->ajax()) {
                    return \$data;
                }

                return inertia('{$modelName}/Index');
            }

            public function create() {
                return inertia('{$modelName}/Create');
            }

            public function store(Store{$modelName}Request \$request) {
                if (\$this->ajax()) {
                    return \$this->{$modelNameCamel}Service->create(\$request->validated());
                }
            }

            public function show({$modelName} \${$modelNameCamel}) {
                \$data = {$modelName}Resource::make(\${$modelNameCamel});

                if (\$this->ajax()) {
                    return \$data;
                }

                return inertia('{$modelName}/Show', compact('data'));
            }

            public function edit({$modelName} \${$modelNameCamel}) {
                \$data = {$modelName}Resource::make(\${$modelNameCamel});

                return inertia('{$modelName}/Edit', compact('data'));
            }

            public function update(Update{$modelName}Request \$request, {$modelName} \${$modelNameCamel}) {
                if (\$this->ajax()) {
                    return \$this->{$modelNameCamel}Service->update(\${$modelNameCamel}, \$request->validated());
                }
            }

            public function destroy({$modelName} \${$modelNameCamel}) {
                if (\$this->ajax()) {
                    return \$this->{$modelNameCamel}Service->delete(\${$modelNameCamel});
                }
            }
        }
        PHP;
    }

    protected function getApiControllerTemplate(): string {
        $modelName = self::$model->studly;
        $modelNameCamel = self::$model->camel;

        return <<<PHP
    <?php

    namespace App\Http\Controllers\Api;

    use App\Http\Requests\\{$modelName}\Store{$modelName}Request;
    use App\Http\Requests\\{$modelName}\Update{$modelName}Request;
    use App\Http\Resources\\{$modelName}Resource;
    use App\Models\\{$modelName};
    use App\Support\Interfaces\Services\\{$modelName}ServiceInterface;
    use Illuminate\Http\Request;

    class Api{$modelName}Controller extends ApiController {
        public function __construct(
            protected {$modelName}ServiceInterface \${$modelNameCamel}Service
        ) {}

        /**
         * Display a listing of the resource.
         */
        public function index(Request \$request) {
            \$perPage = request()->get('perPage', 5);

            return {$modelName}Resource::collection(\$this->{$modelNameCamel}Service->getAllPaginated(\$request->query(), \$perPage));
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Store{$modelName}Request \$request) {
            return \$this->{$modelNameCamel}Service->create(\$request->validated());
        }

        /**
         * Display the specified resource.
         */
        public function show({$modelName} \${$modelNameCamel}) {
            return new {$modelName}Resource(\${$modelNameCamel});
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Update{$modelName}Request \$request, {$modelName} \${$modelNameCamel}) {
            return \$this->{$modelNameCamel}Service->update(\${$modelNameCamel}, \$request->validated());
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Request \$request, {$modelName} \${$modelNameCamel}) {
            return \$this->{$modelNameCamel}Service->delete(\${$modelNameCamel});
        }
    }
    PHP;
    }

    protected function getStoreRequestTemplate(): string {
        $modelName = self::$model->studly;

        return <<<PHP
        <?php

        namespace App\Http\Requests\\{$modelName};

        use Illuminate\Foundation\Http\FormRequest;

        class Store{$modelName}Request extends FormRequest {
            public function rules(): array {
                return [
                    // Add your validation rules here
                ];
            }
        }
        PHP;
    }

    protected function getUpdateRequestTemplate(): string {
        $modelName = self::$model->studly;

        return <<<PHP
        <?php

        namespace App\Http\Requests\\{$modelName};

        use Illuminate\Foundation\Http\FormRequest;

        class Update{$modelName}Request extends FormRequest {
            public function rules(): array {
                return [
                    // Add your validation rules here
                ];
            }
        }
        PHP;
    }

    protected function getResourceTemplate(): string {
        $modelName = self::$model->studly;

        return <<<PHP
        <?php

        namespace App\Http\Resources;

        use Illuminate\Http\Resources\Json\JsonResource;

        class {$modelName}Resource extends JsonResource {
            public function toArray(\$request): array {
                return [
                    'id' => \$this->id,
                    'created_at' => \$this->created_at->toDateTimeString(),
                    'updated_at' => \$this->updated_at->toDateTimeString(),
                ];
            }
        }
        PHP;
    }

    protected function getControllerTestTemplate(): string {
        $modelName = self::$model->studly;
        $modelRoute = self::$model->kebabPlural;

        return <<<PHP
    <?php

    use App\Models\User;

    test('index method returns paginated {$modelRoute}', function () {
        create{$modelName}();

        \$response = actAsAdmin()->getJson('/{$modelRoute}?page=1&perPage=5');

        \$response->assertStatus(200)
            ->assertJsonStructure(['data', 'meta'])
            ->assertJsonCount(1, 'data');
    });

    test('create method returns create page', function () {

        \$response = actAsAdmin()->get('/{$modelRoute}/create');

        \$response->assertStatus(200)
            ->assertInertia(fn (\$assert) => \$assert->component('{$modelName}/Create'));
    });

    test('store method creates new {$modelName}', function () {
        \$data = [
            'name' => 'Test name',
        ];

        \$response = actAsAdmin()->postJson('/{$modelRoute}', \$data);

        \$response->assertStatus(201)
            ->assertJsonStructure(['id', 'name']);
        \$this->assertDatabaseHas('{$modelRoute}', \$data);
    });

    test('show method returns {$modelName} details', function () {
        \$model = create{$modelName}();

        \$response = actAsAdmin()->getJson("/{$modelRoute}/{\$model->id}");

        \$response->assertStatus(200)
            ->assertJson(['id' => \$model->id, 'name' => \$model->name]);
    });

    test('edit method returns edit page', function () {
        \$model = create{$modelName}();

        \$response = actAsAdmin()->get("/{$modelRoute}/{\$model->id}/edit");

        \$response->assertStatus(200)
            ->assertInertia(fn (\$assert) => \$assert->component('{$modelName}/Edit'));
    });

    test('update method updates {$modelName}', function () {
        \$model = create{$modelName}();
        \$updatedData = [
            'name' => 'Updated name',
        ];

        \$response = actAsAdmin()->putJson("/{$modelRoute}/{\$model->id}", \$updatedData);

        \$response->assertStatus(200)
            ->assertJson(\$updatedData);
        \$this->assertDatabaseHas('{$modelRoute}', \$updatedData);
    });

    test('destroy method deletes {$modelName}', function () {
        \$model = create{$modelName}();

        \$response = actAsAdmin()->deleteJson("/{$modelRoute}/{\$model->id}");

        \$response->assertStatus(204);
        \$this->assertDatabaseMissing('{$modelRoute}', ['id' => \$model->id]);
    });
    PHP;
    }

    protected function getApiControllerTestTemplate(): string {
        $modelName = self::$model->studly;
        $modelNameCamel = self::$model->camel;
        $modelNamePlural = Str::plural($modelNameCamel);

        return <<<PHP
    <?php

    use App\Models\User;

    test('index method returns paginated {$modelNamePlural}', function () {
        create{$modelName}();

        \$response = actAsAdmin()->getJson('/api/{$modelNamePlural}?page=1&perPage=5');

        \$response->assertStatus(200)
            ->assertJsonStructure(['data', 'meta'])
            ->assertJsonCount(1, 'data');
    });

    test('store method creates new {$modelNameCamel}', function () {
        \$data = [
            'name' => 'Test name',
        ];

        \$response = actAsAdmin()->postJson('/api/{$modelNamePlural}', \$data);

        \$response->assertStatus(201)
            ->assertJsonStructure(['id', 'name']);
        \$this->assertDatabaseHas('{$modelNamePlural}', \$data);
    });

    test('show method returns {$modelNameCamel} details', function () {
        \$model = create{$modelName}();

        \$response = actAsAdmin()->getJson("/api/{$modelNamePlural}/{\$model->id}");

        \$response->assertStatus(200)
            ->assertJson(['id' => \$model->id, 'name' => \$model->name]);
    });

    test('update method updates {$modelNameCamel}', function () {
        \$model = create{$modelName}();
        \$updatedData = [
            'name' => 'Updated name',
        ];

        \$response = actAsAdmin()->putJson("/api/{$modelNamePlural}/{\$model->id}", \$updatedData);

        \$response->assertStatus(200)
            ->assertJson(\$updatedData);
        \$this->assertDatabaseHas('{$modelNamePlural}', \$updatedData);
    });

    test('destroy method deletes {$modelNameCamel}', function () {
        \$model = create{$modelName}();

        \$response = actAsAdmin()->deleteJson("/api/{$modelNamePlural}/{\$model->id}");

        \$response->assertStatus(204);
        \$this->assertDatabaseMissing('{$modelNamePlural}', ['id' => \$model->id]);
    });
    PHP;
    }
}
