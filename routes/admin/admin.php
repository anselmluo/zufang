<?php
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('login', 'LoginController@index')->name('admin.login');
    Route::post('login', 'LoginController@login')->name('admin.login');

    //需要限制登录的路由组
    Route::group(['middleware' => ['ckadmin'],'as'=>'admin.'], function () {
        Route::get('index', 'IndexController@index')->name('index');
//        Route::get('welcome','IndexController@welcome')->name('welcome')->middleware(['ckadmin]);
        Route::get('welcome', 'IndexController@welcome')->name('welcome');

        Route::get('logout', 'IndexController@logout')->name('logout');

        //用户管理
        Route::get('user/index','UserController@index')->name('user.index');
        Route::get('/user/add', 'UserController@create')->name('user.create');
        Route::post('/user/add','UserController@store')->name('user.store');

        Route::delete('/user/del/{id}','UserController@del')->name('user.del');
        Route::get('/user/restores/{id}','UserController@restores')->name('user.restores');
        Route::delete('/user/delall','UserController@delall')->name('user.delall');


        /*Route::get('user/email',function (){

            //发送文本邮件
            \Mail::raw('ceshi',function (\Illuminate\Mail\Message $message){
//                获取回调方法中的形参
//                dump(func_get_args());
//                给谁
                $message->to('kerwinluo@126.com');
//                主题
                $message->subject('ceshi');
            });


            \Mail::send('mail.adduser',['user'=>'张三'],function (\Illuminate\Mail\Message $message){
//                给谁
                $message->to('kerwinluo@126.com');
//                主题
                $message->subject('ceshi');
            });
        });*/

        Route::get('/user/edit/{id}','UserController@edit')->name('user.edit');
        Route::put('/user/edit/{id}','UserController@update')->name('user.edit');

        Route::match(['get','post'],'/user/role/{user}','UserController@role')->name('user.role');

        Route::get('role/node/{role}','RoleController@node')->name('role.node');
        Route::post('role/node/{role}','RoleController@nodeSave')->name('role.node');
        //资源路由
        Route::resource('role','RoleController');
        Route::resource('node','NodeController');
        Route::post('article/upfile','ArticleController@upfile')->name('article.upfile');
        //文章路由
        Route::resource('article','ArticleController');
        //房源属性
        Route::post('fangattr/upfile','FangAttrController@upfile')->name('fangattr.upfile');
        Route::resource('fangattr','FangAttrController');

    });
});