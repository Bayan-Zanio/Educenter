<x-dashboard-layout title="Edit Course">

<form action="{{  route('admin.courses.update', $course->id )  }}" method="post"
 enctype="multipart/form-data">
    @csrf
    @method('put')

   @include('admin.courses._form',[
    'button_label' =>'Update'
   ])

</form>

</x-dashboard-layout>