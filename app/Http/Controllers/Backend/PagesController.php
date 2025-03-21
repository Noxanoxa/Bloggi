<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\{Page, Category, PostMedia};
use App\Traits\HandlesPostImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{File, Validator};
use Intervention\Image\Facades\Image;
use Stevebauman\Purify\Facades\Purify;

/**
 * Class PagesController
 *
 * Controller for handling page-related backend requests.
 */
class PagesController extends Controller
{
    use HandlesPostImages;

    /**
     * PagesController constructor.
     * Redirects to login form if the user is not authenticated.
     */
    public function __construct() {
        if(\auth()->check()){
            $this->middleware('auth');
        }
        else {
            return view('backend.auth.login');
        }
    }

    /**
     * Display a listing of the pages.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!\auth()->user()->ability('admin', 'manage_pages,show_pages')){
            return redirect('admin/index');
        }

        $pages = Page::wherePostType('page')
                     ->when(request('keyword') != '', function($q) {
                         $q->search(request('keyword'));
                     })
                     ->when(request('category') != '', function($q) {
                         $q->whereCategoryId(request('category'));
                     })
                     ->when(request('status') != '', function($q) {
                         $q->whereStatus(request('status'));
                     })
                     ->orderBy(request('sort_by') ?? 'id', request('order_by') ?? 'desc')
                     ->paginate(request('limit_by') ?? 10)
                     ->withQueryString();

        $categories= Category::orderBy('id', 'desc')->select('id', 'name', 'name_en')->get();
        return view('backend.pages.index', compact('pages', 'categories'));
    }

    /**
     * Show the form for creating a new page.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (!\auth()->user()->ability('admin', 'create_pages')){
            return redirect('admin/index');
        }
        $categories= Category::orderBy('id', 'desc')->select('id', 'name', 'name_en')->get();
        return view('backend.pages.create', compact('categories') );
    }

    /**
     * Store a newly created page in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!\auth()->user()->ability('admin', 'create_pages')){
            return redirect('admin/index');
        }
        $validator = Validator::make($request->all(), [
            'title'          => 'required',
            'title_en'       => 'required',
            'description'    => 'required|min:50',
            'description_en' => 'required|min:50',
            'status'         => 'required',
            'category_id'    => 'required',
            'images.*'       => 'nullable|mimes:jpg,jpeg,png,gif|max:20000',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data ['title']          = $request->title;
        $data ['title_en']       = $request->title_en;
        $data ['description']    = Purify::clean($request->description, ['HTML.Allowed' => 'video,source']);
        $data ['description_en'] = Purify::clean($request->description_en, ['HTML.Allowed' => 'video,source']);
        $data ['status']         = $request->status;
        $data ['post_type']      = 'page';
        $data ['comment_able']   = 0;
        $data ['category_id']    = $request->category_id;

        $page = auth()->user()->posts()->create($data);

        $this->handlePostImages($page, $request->images);

        return redirect()->route('admin.pages.index')->with([
            'message' => 'Page Created Successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Display the specified page.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        if (!\auth()->user()->ability('admin', 'display_pages')){
            return redirect('admin/index');
        }
        $page = Page::with(['media'])->whereId($id)->wherePostType('page')->first();
        return view('backend.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified page.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if (!\auth()->user()->ability('admin', 'update_pages')){
            return redirect('admin/index');
        }
        $categories= Category::orderBy('id', 'desc')->select('id', 'name', 'name_en')->get();
        $page = Page::with(['media'])->whereId($id)->wherePostType('page')->first();
        return view('backend.pages.edit', compact('categories', 'page'));
    }

    /**
     * Update the specified page in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if (!\auth()->user()->ability('admin', 'update_pages')){
            return redirect('admin/index');
        }
        $validator = Validator::make($request->all(), [
            'title'          => 'required',
            'title_en'       => 'required',
            'description'    => 'required|min:50',
            'description_en' => 'required|min:50',
            'status'         => 'required',
            'category_id'    => 'required',
            'images.*'       => 'nullable|mimes:jpg,jpeg,png,gif|max:20000',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $page = Page::whereId($id)->wherePostType('page')->first();
        if($page) {
            $data ['title']          = $request->title;
            $data ['title_en']       = $request->title_en;
            $data ['slug']           = null;
            $data ['slug_en']        = null;
            $data ['description']    = Purify::clean($request->description);
            $data ['description_en'] = Purify::clean($request->description_en);
            $data ['status']         = $request->status;
            $data ['category_id']    = $request->category_id;

            $page->update($data);

            if ($request->images && count($request->images) > 0) {
                $i = 1;
                foreach ($request->images as $file) {
                    $filename  = $page->slug . '-' . time() . '-' . $i . '.'
                                 . $file->getClientOriginalExtension();
                    $file_size = $file->getSize();
                    $file_type = $file->getMimeType();
                    $path      = public_path('assets/posts/' . $filename);
                    Image::make($file->getRealPath())->resize(
                        800,
                        null,
                        function ($constraint) {
                            $constraint->aspectRatio();
                        }
                    )->save($path, 100);

                    $page->media()->create([
                        'file_name' => $filename,
                        'file_size' => $file_size,
                        'file_type' => $file_type,
                    ]);
                    $i++;
                }
            }

            return redirect()->route('admin.pages.index')->with([
                'message'    => 'Page Updated Successfully',
                'alert-type' => 'success',
            ]);
        }
        return redirect()->route('admin.pages.index')->with([
            'message' => 'Something was wrong please try again later',
            'alert-type' => 'danger',
        ]);
    }

    /**
     * Remove the specified page from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (!\auth()->user()->ability('admin', 'delete_pages')){
            return redirect('admin/index');
        }
        $page = Page::whereId($id)->wherePostType('page')->first();
        if($page)
        {
            if($page->media->count() >0) {
                foreach($page->media as $media) {
                    if(File::exists('assets/posts/'. $media->file_name)){
                        unlink('assets/posts/'. $media->file_name);
                    }
                }
            }

            $page->delete();

            return  redirect()->route('admin.pages.index')->with([
                'message' => 'Page Deleted Successfully',
                'alert-type' => 'success',
            ]);
        }
        return redirect()->route('admin.pages.index')->with([
            'message' => 'Something was wrong. Page Not Found',
            'alert-type' => 'danger',
        ]);
    }

    /**
     * Remove a specific image from a page.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function removeImage(Request $request){
        if (!\auth()->user()->ability('admin', 'delete_pages')){
            return redirect('admin/index');
        }
        $media = PostMedia::whereId($request->media_id)->first();
        if($media){
            if(File::exists('assets/posts/'.$media->file_name)) {
                unlink('assets/posts/'.$media->file_name);
            }
            $media->delete();
            return true;
        }
        return false;
    }
}
