<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/12
 * Time: 02:19
 */

namespace app\Http\Controllers\Home;



use App\Http\Model\City;
use Illuminate\Http\Request;

class RegionController extends BaseController
{
    public function getCity(Request $request)
    {

        if (! $parent_id = $request->input('parent_id')){
            $parent_id = 0;
        }
        $city = City::where('parent_id', $parent_id)->get()->toArray();
        return $this->Success($city);
    }
}