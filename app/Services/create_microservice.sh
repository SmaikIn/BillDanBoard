#!/bin/bash

# Запрос пользователю ввести название микросервиса
read -p "Введите название микросервиса (PascalCase, в единственном числе): " serviceName

# Создаем папку с названием микросервиса и переходим в нее
mkdir $serviceName
cd $serviceName || exit

# Создаем папки Dto и Repositories
mkdir Dto
mkdir Repositories

# Создаем файлы LaravelNameService.php и NameService.php
cat <<EOF > Laravel${serviceName}Service.php
<?php

namespace App\Services\\${serviceName};
final readonly class Laravel${serviceName}Service implements ${serviceName}Service
{
    public function __construct(
    ){
    }
    public function find(){
      return null;
    }

    public function delete(){
      return null;
    }

    public function create (){
      return null;
    }

    public function update(){
      return null;
    }
}
EOF

cat <<EOF > ${serviceName}Service.php
<?php

namespace App\Services\\${serviceName};
interface ${serviceName}Service
{
    public function find();

    public function delete();

    public function create ();

    public function update();
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

# Создаем файлы DatabaseNameRepository и CacheNameRepository в папке Repositories
cat <<EOF > Repositories/${serviceName}Repository.php
<?php

namespace App\Services\\${serviceName}\Repositories;
interface ${serviceName}Repository
{
}
EOF

cat <<EOF > Repositories/Database${serviceName}Repository.php
<?php

namespace App\Services\\${serviceName}\Repositories;
final readonly class Database${serviceName}Repository implements ${serviceName}Repository
{
    public function __construct(
    ){
    }
}
EOF

cat <<EOF > Repositories/Cache${serviceName}Repository.php
<?php

namespace App\Services\\${serviceName}\Repositories;
final readonly class Cache${serviceName}Repository implements ${serviceName}Repository
{
    public function __construct(
    ){
    }
}
EOF

echo "Папка с микросервисом ${serviceName} успешно создана!"
