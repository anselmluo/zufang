<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Traits\Btn;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseController extends Controller
{

    //
    use SoftDeletes,Btn;
    protected $pagesize = 10;
    public function __construct()
    {
        $this->pagesiz = config('page.pagesize');
    }
}
