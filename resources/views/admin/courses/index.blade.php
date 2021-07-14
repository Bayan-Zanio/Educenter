<x-dashboard-layout title="Courses" >


@can ('create' , App\Models\Course::class)
<div class="table-toolbar mb-3">
<a href="{{  route('admin.courses.create')  }}" class="btn btn-info">Create</a>
</div>
@endcan

<form action="{{ route('admin.courses.index') }}" method="get" class="d-flex mb-4">
    <input type="text" name="name" class="form-control me-2" placeholder="Search by name">
    <select name="parent_id" class="form-control me-2">
        <option value="">All Courses</option>
        @foreach ($courses as $course)
        <option value="{{ $course->id }}">{{ $course->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-secondary">Filter</button>
</form>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>category</th>
            <th>Added date</th>
            <th>Course hours</th>
            <th>Status</th>
            <th>Created At</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($courses as $course)
        <tr>
            <td>{{ $course->id }}</td>
            <td>@can ('update' , $course)<a href="{{  route('admin.courses.edit', [$course->id])  }}">@endcan {{ $course->name }}</a></td>
            <td>{{ $course->category->name }}</td>
            <td>{{ $course->date_of_add }}</td>
            <td>{{ $course->duration }}</td>
            <td>{{ $course->status }}</td>
            <td>{{ $course->created_at }}</td>
            <td>

                @can ('delete' , $course)
                <form action="{{  route('admin.courses.destroy' , [$course->id])  }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</x-dashboard-layout>