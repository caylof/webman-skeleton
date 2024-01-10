<?php

namespace app\model;

use app\shared\trait\ModelCommon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use support\Model;

/**
 * user 用户表
 * @property integer $id (主键)
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $nickname 昵称
 * @property string $avatar 头像
 * @property string $created_at 
 * @property string $updated_at
 */
class User extends Model
{
    use ModelCommon;

    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = [];
    protected $hidden = [
        'password'
    ];

    public function password(): Attribute {
        return new Attribute(
            get: null,
            set: fn(string $value) => password_hash($value, PASSWORD_DEFAULT),
        );
    }

    public static function findByUsername(string $username): ?static
    {
        /* @var $user ?static */
        $user = static::query()->where('username', $username)->first();
        return $user;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}
