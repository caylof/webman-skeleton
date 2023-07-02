<?php

namespace app\auth;

use app\shared\trait\ObjectToArray;
use app\shared\trait\StaticCreateSelf;

class User
{
    use StaticCreateSelf, ObjectToArray;

    public string| int $id;
    public string $name;
}
