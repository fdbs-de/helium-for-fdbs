<?php

namespace App\Http\Controllers\Apps\PagesAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apps\Pages\CreateMenuRequest;
use App\Http\Requests\Apps\Pages\DestroyMenuRequest;
use App\Http\Requests\Apps\Pages\DuplicateMenuRequest;
use App\Http\Requests\Apps\Pages\UpdateMenuRequest;
use App\Http\Resources\Apps\Pages\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index()
    {
        return Inertia::render('Apps/PagesAdmin/Menus/Index');
    }



    public function search(Request $request)
    {
        $query = Menu::select('*');
        
        if ($request->search)
        {
            $query->whereFuzzy(function ($query) use ($request) {
                $query
                ->orWhereFuzzy('name', $request->search);
            });
        }
        
        $total = $query->count();

        $limit = $request->size ?? 20;
        $offset = $request->size * ($request->page ?? 0) - $request->size;

        // Clamp the offset to 0 and limit
        $offset = max(0, $offset);
        $offset = min($offset, intdiv($total, $limit) * $limit);
        
        $data = $query->orderBy('created_at', 'desc')->limit($limit)->offset($offset)->get();

        return response()->json([
            'data' => MenuResource::collection($data),
            'total' => $total,
        ]);
    }



    public function create(Request $request, Menu $menu)
    {
        return Inertia::render('Apps/PagesAdmin/Menus/Create', [
            'item' => MenuResource::make($menu),
        ]);
    }



    public function store(CreateMenuRequest $request)
    {
        $menu = Menu::create($request->validated());

        return redirect()->route('admin.pages.menus.editor', MenuResource::make($menu));
    }



    public function duplicate(DuplicateMenuRequest $request, Menu $menu)
    {
        $menu->duplicate();

        return back();
    }



    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());

        return redirect()->route('admin.pages.menus.editor', MenuResource::make($menu));
    }



    public function delete(DestroyMenuRequest $request)
    {
        Menu::whereIn('id', $request->ids)->delete();

        return back();
    }
}
