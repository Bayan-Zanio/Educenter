<x-dashboard-layout title="Trashed Categories" subtitle="sub">

<x-alert></x-alert>




<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Parent Name</th>
            <th>Deleted At</th>
            <th>Status</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($courses as $course)
        <tr>
            <td>{{ $course->id }}</td>
            <td><a href="{{  route('admin.courses.edit',[$course->id])  }}">{{ $course->name }}</a></td>
            
            <td>{{ $course->deleted_at }}</td>
            <td>{{ $course->status }}</td>
            <td>
                
                <form action="{{  route('admin.courses.restore',[$course->id])  }}" method="post">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-sm btn-primary">Restore</button>
                </form>
                
            </td>
            <td>
                
                <form action="{{  route('admin.courses.force-delete',[$course->id])  }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
                
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</x-dashboard-layout>