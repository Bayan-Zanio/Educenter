<x-dashboard-layout title="Add Course">


<form action="{{  route('admin.courses.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    
    @include('admin.courses._form',[
    'button_label' =>'Add'
    ])

</form>
</x-dashboard-layout>