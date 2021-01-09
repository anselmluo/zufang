<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        dump($request->isMethod('ajax'));
        //自定义ajax请求
        if ($request->header('X-Requested-With') == 'XMLHttpRequest') {

            //排序 结构赋值 php7
            ['column'=>$column,'dir'=>$dir] = $request->get('order')[0];
            //传统写法
//            $orderArr = $request->get('order')[0];
//            $column = $orderArr['column'];
//            $dir = $orderArr['dir'];

            //获取排序字段
            $orderField = $request->get('columns')[$column]['data'];

            //开启位置
            $start = $request->get('start', 0);
            //开始时间he 结束时间
            $datemin = $request->get('datemin');
            $datemax = $request->get('datemin');
            //关键词
            $title = $request->get('title');
            $query = Article::where('id', '>', '0');
            //日期
            if (!empty($datemin) && !empty($datemax)) {
                $datemin = date('Y-m-d H:i:s', strtotime($datemin.'00:00:00'));
                $datemax = date('Y-m-d H:i:s', strtotime($datemax.'23:59:59'));
                $query->whereBetween('created_at', [$datemin, $datemax]);
            }
            //关键词
            if (!empty($title)) {
                $query->where('title', 'like', "%{$title}%");
            }
            //获取记录数
            $length = min(100, $request->get('length', 10));

            $total = $query->count();
            $articles = $query->orderBy($orderField,$dir)->offset($start)->limit($length)->get();
            /*
             * draw 客户端调用服务器端的次数
             * recordsTotal:获取记录总条数
             * recordsFiltered:数据过滤后总条数
             * data:具体数据
             */
            $res = [
                "draw" => $request->get('draw'),
                "recordsTotal" => $total,
                "recordsFiltered" => $total,
                "data" => $articles
            ];
            return $res;
        }
        return view('admin.article.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.article.create');
    }

    public function upfile(Request $request)
    {
        //封面图片
        $pic = config('up.pic');
        if($request->hasFile('file')){
            //shangchuan
            $p = $request->file('file')->store('','article');
            $pic = '/uploads/article/'.$p;
        }
        return ['status'=>0,'url'=>$pic];
    }
    /**
     * AddRequest 独立创建的验证规则
     * use App\Http\Requests\AddRequest;
     */
    public function store(AddRequest $request)
    {

        $post = $request->except(['_token','file']);
        //ruku
        Article::create($post);
        return redirect(route('admin.article.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
        return view('admin.article.edit',compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
        $putData = $request->except(['action','created_ad','updated_ad','deleted_ad','id']);
        $article->update($putData);
        return ['status'=>0,'url'=>route('admin.article.index')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //删除
        $article->delete();
        return 'shanchu';
    }
}
