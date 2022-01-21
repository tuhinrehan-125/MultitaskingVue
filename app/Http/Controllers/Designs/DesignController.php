<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Design;
use Illuminate\Support\Str;
use App\Http\Resources\DesignResource;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\IDesign;

class DesignController extends Controller
{
    protected $designs;
    
    public function __construct(IDesign $designs)
    {
        $this->designs = $designs;
    }

    public function index() {
        // $designs = Design::all();
        $designs = $this->designs->all();
        return DesignResource::collection($designs);
    }

    public function update(Request $request, $id)
    {

        $design = Design::find($id);

        // $design = $this->designs->find($id);

        $this->authorize('update', $design);

        
        $this->validate($request, [
            'title' => ['required', 'unique:designs,title,'. $id],
            'description' => ['required', 'string', 'min:20', 'max:140'],
            'tags' => ['required'],
            // 'team' => ['required_if:assign_to_team,true']
        ]);

        // $design = Design::find($id);

        $design->update([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => Str::slug($request->title), 
            'is_live' => ! $design->upload_successful ? false : $request->is_live
        ]);

        $design->retag($request->tags);

        // return response()->json($design, 200);
        return new DesignResource($design);
        

        // $design = $this->designs->update($id, [
        //     'team_id' => $request->team,
        //     'title' => $request->title,
        //     'description' => $request->description,
        //     'slug' => Str::slug($request->title), 
        //     'is_live' => ! $design->upload_successful ? false : $request->is_live
        // ]);

        // apply the tags
        // $this->designs->applyTags($id, $request->tags);
        
        // return new DesignResource($design);
    }

    public function destroy($id)
    {
        // $design = $this->designs->find($id);
        $design = Design::findOrFail($id);

        $this->authorize('delete', $design);

        
        // delete the files associated to the record
        foreach(['thumbnail', 'large', 'original'] as $size){
            // check if the file exists in the database
            if(Storage::disk($design->disk)->exists("uploads/designs/{$size}/".$design->image)){
                Storage::disk($design->disk)->delete("uploads/designs/{$size}/".$design->image);
            }
        }
        $design->delete();
        
        // $this->designs->delete($id);
        
        return response()->json(['message' => 'Record deleted'], 200);

    }
}