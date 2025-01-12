#!/bin/bash

# Запрос пользователю ввести название микросервиса
read -p "Введите название микросервиса (PascalCase, в единственном числе): " serviceName

# Создаем папку с названием микросервиса и переходим в нее
mkdir $serviceName
cd $serviceName || exit

# Создаем папки Dto и Repositories
mkdir Dto
mkdir Repositories
mkdir Events
mkdir Exceptions

# Создаем файлы LaravelNameService.php и NameService.php
cat <<EOF > Laravel${serviceName}Service.php
<?php

namespace App\Services\\${serviceName};

use App\Services\\${serviceName}\Repositories\\${serviceName}Repository;
use App\Services\\${serviceName}\Dto\Create${serviceName}Dto;
use App\Services\\${serviceName}\Dto\Update${serviceName}Dto;
final readonly class Laravel${serviceName}Service implements ${serviceName}Service
{
    public function __construct(
      private ${serviceName}Repository \$repository,
    ){
    }

    public function find(int \$id){
      return \$this->repository->find(\$id);
    }

    public function findMany(array \$arrayIds){
      return \$this->repository->findMany(\$arrayIds);
    }

    public function delete(int \$id){
      return \$this->repository->delete(\$id);
    }

    public function create(Create${serviceName}Dto \$dto){
      return \$this->repository->create(\$dto);
    }

    public function update(Update${serviceName}Dto \$dto){
       return \$this->repository->update(\$dto);
    }
}
EOF

cat <<EOF > ${serviceName}Service.php
<?php

namespace App\Services\\${serviceName};

use App\Services\\${serviceName}\Dto\Create${serviceName}Dto;
use App\Services\\${serviceName}\Dto\Update${serviceName}Dto;
interface ${serviceName}Service
{
    public function find(int \$id);

    public function findMany(array \$arrayIds);

    public function delete(int \$id);

    public function create(Create${serviceName}Dto \$dto);

    public function update(Update${serviceName}Dto \$dto);
}
EOF

# Создаем файл NameDto.php в папке Dto
cat <<EOF > Dto/${serviceName}Dto.php
<?php

namespace App\Services\\${serviceName}\Dto;

final readonly class ${serviceName}Dto
{
    public function __construct(
    ){
    }
}
EOF

# Создаем файл NameDto.php в папке Dto
cat <<EOF > Dto/Update${serviceName}Dto.php
<?php

namespace App\Services\\${serviceName}\Dto;

final readonly class Update${serviceName}Dto
{
    public function __construct(
    ){
    }

}
EOF

# Создаем файл NameDto.php в папке Dto
cat <<EOF > Dto/Create${serviceName}Dto.php
<?php

namespace App\Services\\${serviceName}\Dto;

final readonly class Create${serviceName}Dto
{
    public function __construct(
    ){
    }

}
EOF

# Создаем файлы DatabaseNameRepository и CacheNameRepository в папке Repositories
cat <<EOF > Repositories/${serviceName}Repository.php
<?php

namespace App\Services\\${serviceName}\Repositories;

use App\Services\\${serviceName}\Dto\Create${serviceName}Dto;
use App\Services\\${serviceName}\Dto\Update${serviceName}Dto;
interface ${serviceName}Repository
{
    public function find(int \$id);

    public function findMany(array \$arrayIds);

    public function delete(int \$id);

    public function create(Create${serviceName}Dto \$dto);

    public function update(Update${serviceName}Dto \$dto);
}
EOF

cat <<EOF > Repositories/Database${serviceName}Repository.php
<?php

namespace App\Services\\${serviceName}\Repositories;

use App\Services\\${serviceName}\Dto\Create${serviceName}Dto;
use App\Services\\${serviceName}\Dto\Update${serviceName}Dto;
final readonly class Database${serviceName}Repository implements ${serviceName}Repository
{
    public function __construct(
    ){
    }

    public function find(int \$id){
    //TODO logic
    }

    public function findMany(array \$arrayIds){
    //TODO logic
    }

    public function delete(int \$id){
    //TODO logic
    }

    public function create(Create${serviceName}Dto \$dto){
    //TODO logic
    }

    public function update(Update${serviceName}Dto \$dto){
    //TODO logic
    }
}
EOF

cat <<EOF > Repositories/Cache${serviceName}Repository.php
<?php

namespace App\Services\\${serviceName}\Repositories;

use App\Services\\${serviceName}\Dto\Create${serviceName}Dto;
use App\Services\\${serviceName}\Dto\Update${serviceName}Dto;
final readonly class Cache${serviceName}Repository implements ${serviceName}Repository
{
    public function __construct(
    ){
    }

    public function find(int \$id){
    //TODO logic
    }

    public function findMany(array \$arrayIds){
    //TODO logic
    }

    public function delete(int \$id){
    //TODO logic
    }

    public function create(Create${serviceName}Dto \$dto){
    //TODO logic
    }

    public function update(Update${serviceName}Dto \$dto){
    //TODO logic
    }

    private function formatToDto(Model ${serviceName}){
    //TODO logic
    }
}
EOF

echo "Папка с микросервисом ${serviceName} успешно создана!"
echo "Не забудьте определить реализацию интерфейсов в AppServiceProvider"
