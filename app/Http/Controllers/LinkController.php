<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Link/Index', [
            'dominio' => env('APP_URL'),
            'links' => Link::with('user:id,name')->latest()->get()
        ]);
    }

    public function redirect($slug)
    {
        $item = Link::where('url_new', $slug)->first();

        if ($item) {
            $item->access_count += 1;
            $item->save();
            
            Statistic::create([
                'link_id' => $item->id,
                'accessed_at' => now()
            ]);
            return redirect($item->url_original);
        } else {
            abort(404);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'url' => 'required|url',
        ];
    
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => 'Por favor, forneça uma URL válida.']);
        }

        $url_encurtada = $this->gerarLinkEncurtado();

        $link = Link::create([
            'url_original' => $request->input('url'),
            'url_new' => $url_encurtada,
            'user_id' => \Auth::user()->id,
        ]);

        return response()->json(['url_encurtada' => $url_encurtada], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $link = Link::findOrFail($id);
        $link->deleteOrFail();
        return response()->json(['message' => 'URL deletada com sucesso!']);
    }

    private function gerarLinkEncurtado()
    {
        $dataHora = now()->format('YmdHis');
        $hash = substr(md5(uniqid(rand(), true)), 0, 8);
        return $dataHora . $hash;
    }
}
