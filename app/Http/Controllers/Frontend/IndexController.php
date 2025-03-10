<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Notifications\NewCommentForPostOwnerNotify;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Contact;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewCommentForAdminNotify;

/**
 * Class IndexController
 *
 * Controller for handling frontend requests related to posts, comments, contacts, categories, archives, authors, and tags.
 */
class IndexController extends Controller
{
    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::with(['media', 'user', 'tags'])
                     ->whereHas('category', function($query) {
                         $query->whereStatus('1');
                     })
                     ->whereHas('user', function($query) {
                         $query->whereStatus('1');
                     })
                     ->post()->active()->orderBy('id', 'desc')->paginate(5);

        return view('frontend.index', compact('posts'));
    }

    /**
     * Search for posts based on a keyword.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $keyword = isset($request->keyword) && $request->keyword != '' ? $request->keyword : null;

        $posts = Post::with(['media', 'user', 'tags'])
                     ->whereHas('category', function($query) {
                         $query->whereStatus('1');
                     })
                     ->whereHas('user', function($query) {
                         $query->whereStatus('1');
                     });

        if($keyword != null)
        {
            $posts = $posts->search($keyword, null, true);
        }

        $posts = $posts->post()->active()->orderBy('id', 'desc')->paginate(5);

        return view('frontend.index', compact('posts'));
    }

    /**
     * Display the specified post.
     *
     * @param string $slug
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function post_show($slug)
    {
        $post = Post::with(['category', 'media', 'user', 'tags', 'approved_comments' => function($query) {
            $query->orderBy('id', 'desc');
        }]);

        $post = $post->whereHas('category', function($query) {
            $query->whereStatus('1');
        })
                     ->whereHas('user', function($query) {
                         $query->whereStatus('1');
                     });

        $post = Post::where('slug_en', $slug);
        $post = $post->active()->first();

        if($post) {
            $blade = $post->post_type == 'post' ?  'post' : 'page';
            return view('frontend.'. $blade, compact('post'));
        } else {
            return redirect()->route('frontend.index');
        }
    }

    /**
     * Store a newly created comment for the specified post.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store_comment(Request $request, $slug)
    {
        $validation  = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'url' => 'nullable|url',
            'comment' => 'required|min:10',
        ]);

        if($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $post = Post::whereSlug($slug)->wherePostType('post')->whereStatus('1')->first();

        if($post) {
            $userId = auth()->check() ? auth()->id() : null;
            $data['name']          = $request->name;
            $data['email']         = $request->email;
            $data['url']           = $request->url;
            $data['ip_address']    = $request->ip();
            $data['comment']       = Purify::clean($request->comment);
            $data['post_id']       = $post->id;
            $data['user_id']       = $userId;

            $comment = $post->comments()->create($data);

            if(auth()->guest() || auth()->id() != $post->user_id){
                $post->user->notify(new NewCommentForPostOwnerNotify($comment));
            }
            User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['admin', 'editor']);
            })->each(function($admin, $key) use($comment){
                $admin->notify(new NewCommentForAdminNotify($comment));
            });

            return redirect()->back()->with([
                'message' => 'Comment Added Successfully',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Something went wrong',
            'alert-type' => 'danger'
        ]);
    }

    /**
     * Display the contact form.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('frontend.contact');
    }

    /**
     * Handle the submission of the contact form.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function do_contact(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'nullable|numeric',
            'title' => 'required|min:5',
            'message' => 'required|min:10',
        ]);

        if($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $data['name']       = $request->name;
        $data['email']      = $request->email;
        $data['mobile']     = $request->mobile;
        $data['title']      = $request->title;
        $data['message']    = $request->message;

        Contact::create($data);

        return redirect()->back()->with([
            'message' => 'Your Message Sent Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display posts for the specified category.
     *
     * @param string $slug
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function category($slug)
    {
        $category = Category::whereSlug($slug)->orWhere('id', $slug)->whereStatus(1)->first()->id;
        if($category) {
            $posts = Post::with(['media', 'user', 'tags'])
                         ->whereCategoryId($category)
                         ->post()
                         ->active()
                         ->orderBy('id', 'desc')
                         ->paginate(5);
            return view('frontend.index', compact('posts'));
        }
        return redirect()->route('frontend.index');
    }

    /**
     * Display posts for the specified archive date.
     *
     * @param string $date
     * @return \Illuminate\View\View
     */
    public function archive($date)
    {
        $exploded_date = explode('-', $date);
        $month = $exploded_date[0];
        $year = $exploded_date[1];

        $posts = Post::with(['media', 'user', 'tags'])
                     ->whereMonth('created_at', $month)
                     ->whereYear('created_at', $year)
                     ->post()
                     ->active()
                     ->orderBy('id', 'desc')
                     ->paginate(5);

        return view('frontend.index', compact('posts'));
    }

    /**
     * Display posts for the specified author.
     *
     * @param string $username
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function author($username)
    {
        $author = User::whereUsername($username)->orWhere('id', $username)->whereStatus(1)->first()->id;
        if($author) {
            $posts = Post::with(['media', 'user', 'tags'])
                         ->whereUserId($author)
                         ->post()
                         ->active()
                         ->orderBy('id', 'desc')
                         ->paginate(5);
            return view('frontend.index', compact('posts'));
        }
        return redirect()->route('frontend.index');
    }

    /**
     * Display posts for the specified tag.
     *
     * @param string $slug
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function tag($slug)
    {
        $tag = Tag::whereSlug($slug)->orWhere('id', $slug)->first()->id;
        if($tag) {
            $posts = Post::with(['media', 'user', 'tags'])
                         ->whereHas('tags', function ($query) use($slug){
                             $query->where('slug', $slug);
                         })
                         ->post()
                         ->active()
                         ->orderBy('id', 'desc')
                         ->paginate(5);
            return view('frontend.index', compact('posts'));
        }
        return redirect()->route('frontend.index');
    }
}
