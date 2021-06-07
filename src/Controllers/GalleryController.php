<?php

namespace Rodsaseg\LaravelSaseg\Controllers;

use Rodsaseg\LaravelSaseg\Models\Gallery;
use Illuminate\Http\Request;
use App\DataTables\GalleryDataTable;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GalleryDataTable $dataTable)
    {
        $info = [
            'title' => 'Galería',
            'breadcrumb' => [
                [
                    'title' => 'Todos',
                    'route' => 'panel.galleries.index',
                    'active' => true
                ]
            ],
            'buttons' => [
                [
                    'title' => 'Agregar Nuevo',
                    'route' => 'panel.galleries.create'
                ]
            ]
        ];
        return $dataTable->render('vendor.panel.galleries.index', $info);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $info = [
            'title' => 'Galería',
            'breadcrumb' => [
                [
                    'title' => 'Todos',
                    'route' => 'panel.galleries.index'
                ],
                [
                    'title' => 'Agregar Nuevo',
                    'route' => 'panel.galleries.create',
                    'active' => true
                ]
            ]
        ];
        return view('vendor.panel.galleries.create', $info);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'images' => 'required'
        ]);
        $input = $request->input();
        $input['images'] = json_decode($input['images']);
        $input['slug'] = Str::slug($input['title']);
        if(Gallery::where('slug', $input['slug'])->get()->count() > 0){
            return redirect()->back()->withInput($request->input())->withErrors(['invalid' => 'Ya existe una galería con el mismo nombre']);
        }else{
            $gallery = Gallery::create($input);
            //Agregamos las imágenes
            if((isset($input['images'])) && (count($input['images']) > 0)){
                foreach($input['images'] as $key => $image){
                    $gallery->addMedia($image->file_name)
                            ->preservingOriginal()
                            ->withCustomProperties(['type' => 'image', 'alt' => '', 'link' => '', 'order' => $k])
                            ->toMediaCollection('gallery');
                }
            }
            return redirect()->route('panel.galleries.edit', ['id' => $gallery->id])->with('success', 'Operación exitosa');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Int $id)
    {
        $info = [
            'title' => 'Galería',
            'breadcrumb' => [
                [
                    'title' => 'Todos',
                    'route' => 'panel.galleries.index'
                ],
                [
                    'title' => 'Modificar',
                    'route' => 'panel.galleries.edit',
                    'params' => ['id' => $id],
                    'active' => true
                ]
            ]
        ];
        if(Gallery::find($id)){
            $info['gallery'] = Gallery::find($id);
            return view('vendor.panel.galleries.edit', $info);
        }else{
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Int $id)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);
        $input = $request->input();
        if(isset($input['images']))
            $input['images'] = json_decode($input['images']);
        $input['slug'] = Str::slug($input['title']);
        if(Gallery::where('slug', $input['slug'])->where('id', '!=', $id)->get()->count() > 0){
            return redirect()->back()->withInput($request->input())->withErrors(['invalid' => 'Ya existe una galería con el mismo nombre']);
        }else{
            $gallery = Gallery::find($id);
            $gallery->update($input);
            /**
             * TODO: Update gallery is missing
             */
            return redirect()->route('panel.galleries.edit', ['id' => $gallery->id])->with('success', 'Operación exitosa');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        if(Gallery::find($id)){
            Gallery::destroy($id);
            return response(['success' => true], 200);
        }else{
            return response(['success' => false], 404);
        }
    }
}
