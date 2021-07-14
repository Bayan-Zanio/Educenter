<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\CourseImage;
use App\Models\Tag;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with('category')->latest()->orderBy('name', 'ASC')->paginate(10);
        return view('admin.courses.index', [
            'courses' => $courses,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.courses.create', [
            'course' => new Course(),
            'categories' => Category::all(),
            'tags' => '',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Course::validateRules());

        $request->merge([
            'slug' => Str::slug($request->post('name')),
            'store_id' => 1,
        ]);

        $data = $request->all();


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $data['image'] = $file->store('/images', [
                'disk' => 'uploads'
            ]);
            
        }

        $courses = Course::create($data);

        $courses->tags()->attach($this->getTags($request));


        return redirect()->route('admin.courses.index')
            ->with('success', "Course($courses->name) created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $courses = Course::finOrFail($id);
        return view('admin.courses.show', [
            'courses' => $courses,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        
        return view('admin.courses.edit', [
            'course' => $course,
            'categories' => Category::all(),
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $courses = Course::findOrFail($id);

        $request->validate(Course::validateRules());

        $data = $request->all();
        $previous = false;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $data['image'] = $file->store('/images', [
                'disk' => 'uploads'
            ]);
            $previous = $courses->image;
        }

        $courses->update($data);
        if ($previous) {
            Storage::disk('uploads')->delete($previous);
        }

        $courses->tags()->sync($this->getTags($request));

        

        return redirect()->route('admin.courses.index')
            ->with('success', "Course($courses->name) update!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $courses = Course::findOrFail($id);
        $courses->delete();

        if ($courses->image) {
            Storage::disk('uploads')->delete($courses->image);
            //unlink(public_path('images/' . $product->image));
        }

        return redirect()->route('admin.courses.index')
            ->with('success', "Course($courses->name) deleted!");
    }

    public function trash()
    {
        return view('admin.courses.trash' , [
            'courses' => Course::onlyTrashed()->paginate(),
        ]);
    }

    public function restore($id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->restore();
        return redirect()
        ->route('admin.courses.trash')
        ->with('success' , 'Course restord');
    }

    public function forceDelete($id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->forceDelete();
        return redirect()
        ->route('admin.courses.trash')
        ->with('success' , 'Course deleted forever.');
    }

    protected function getTags(Request $request)
    {
        $tag_ids = [];

        $tags = $request->post('tags');
        $tags = json_decode($tags);
        if (is_array($tags) && count($tags) > 0) {

            foreach ($tags as $tag) {
                $tag_name = $tag->value;
                $tagModel = Tag::firstOrCreate([
                    'name' => $tag_name
                ], [
                    'slug' => Str::slug($tag_name)
                ]);

                $course_tags[] = $tagModel->id;
            }
        }

        return $tag_ids;
    }
}
