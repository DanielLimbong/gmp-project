<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Area;
use Haruncpi\LaravelIdGenerator\IdGenerator;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AreaController extends Controller
{
    public function getCreateArea(){
        return view('area.create');
    }
    public function storeArea(Request $request){
    $prefix = 'A';
    $id = IdGenerator::generate(['table' => 'areas', 'length' => 3, 'prefix' => $prefix]);
    // $formattedId = sprintf("%03d", $id);
    $deletion_indicator = $request->has('status') ? 'Active' : 'Deactive';
    $area = new Area;
    $area->id = $id;
    $area->area_name = $request->name;
    $area->deletion_indicator = $deletion_indicator;
    $area->save();

    return redirect()->route('user.area')->with('success', 'Area Created!');
    }

    public function getEditArea(Area $area){
        return view ('area.edit', ['area' => $area]);
    }

    public function editArea(Request $request, Area $area){
        if($area->area_name === null){
            $area_name = $area->area_name;
        }
        else{
            $area_name = $request->name;
        }
        $area->area_name = $area_name;
        $deletion_indicator = $request->has('status') ? 'Active' : 'Deactive';
        $area->deletion_indicator = $deletion_indicator;
        $area->save();

        return redirect()->route('user.area')->with('success', 'Area Edited!');
    }

        public function areaIndex(){
            $areas = Area::all();
            return response()->json($areas);
        }
}
