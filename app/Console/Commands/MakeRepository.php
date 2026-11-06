<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    protected $signature = 'make:repository {name}';
    protected $description = 'Create a new repository with interface';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $interfaceName = "{$name}RepositoryInterface";
        $repositoryName = "{$name}Repository";
        $requestName = "use App\Http\Requests\{$name}Request;";
        
        $interfacePath = app_path("Repositories/{$interfaceName}.php");
        $repositoryPath = app_path("Repositories/{$repositoryName}.php");

        if (File::exists($interfacePath) || File::exists($repositoryPath)) {
            $this->error("Repository or interface already exists!");
            return false;
        }

        // Create interface
        $interfaceTemplate = "<?php

            namespace App\Repositories;
            {$requestName}
            interface {$interfaceName}
            {
                public function getAll();
                public function getById(\$id);
                public function create({$name}Request \$request);
                public function update(\$id, {$name}Request \$request);
                public function delete(\$id);
            }
            ";
        File::ensureDirectoryExists(app_path('Repositories'));
        File::put($interfacePath, $interfaceTemplate);

        // Create repository implementation
        $repositoryTemplate = "<?php

            namespace App\Repositories;
            {$requestName}
            use App\Models\\$name;

            class {$repositoryName} extends BaseRepository implements {$interfaceName}
            {
                public function getAll()
                {
                    return {$name}::all();
                }

                public function getById(\$id)
                {
                    return {$name}::findOrFail(\$id);
                }

                public function create({$name}Request \$request)
                {
                    return {$name}::create(\$request);
                }

                public function update(\$id, {$name}Request \$request)
                {
                    \$model = \$this->getById(\$id);
                    \$model->update(\$data);
                    return \$model;
                }

                public function delete(\$id)
                {
                    \$model = \$this->getById(\$id);
                    return \$model->delete();
                }
            }
            ";
        File::put($repositoryPath, $repositoryTemplate);

        $this->info("{$interfaceName} and {$repositoryName} created successfully.");
    }
}