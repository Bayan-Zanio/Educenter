<x-dashboard-layout title="Categories">



@can ('create' , App\Models\Category::class)
<div class="table-toolbar mb-3">
<a href="{{  route('admin.categories.create')  }}" class="btn btn-info">Create</a>
</div>
@endcan

<form action="{{ route('admin.categories.index') }}" method="get" class="d-flex mb-4">
    <input type="text" name="name" class="form-control me-2" placeholder="Search by name">
    <select name="parent_id" class="form-control me-2">
        <option value="">All Categories</option>
        @foreach ($parents as $parent)
        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-secondary">Filter</button>
</form>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Parent Name</th>
            <th>Created At</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>@can ('update' , $category)<a href="{{  route('admin.categories.edit',[$category->id])  }}">@endcan {{ $category->name }}</a></td>
            <td>{{ $category->parent->name }}</td>
            <td>{{ $category->created_at }}</td>
            <td>{{ $category->status }}</td>
            <td>
                
                @can ('delete' , $category)
                <form action="{{  route('admin.categories.destroy',[$category->id])  }}" method="post">
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