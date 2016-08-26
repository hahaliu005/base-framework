编码规范
===

仅与管理平台有关的数据库表均添加'adm_', 如: 管理平台的permissions表应是'adm_permissions'

所有自定义函数名均使用小驼峰表示法, 如: getUserName()

所有自定义的类名使用大驼峰表示法, 如: class CustomUserProvider()

尽量使用PHP7的语法特性, 如指定参数类型, 指定函数返回类型, 使用'?:'等, 如:
```
public function comment(Request $request): array
protect function foo(array $arr): int
a ?: b
```

数据库表中每张表均需加入created_at,updated_at,deleted_at

所有的路由均需加上路由名, 如:
```
Route::get('user/info/{id}', [
    'as' => 'user.info',
    'uses' => 'UserController@info',
]);
```

公有方法使用public, 私有方法使用protect, 特殊需求可使用private

数据库连接符统一使用下划线'_'
