<!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-{{ $id }}">
    Delete
</button>

<!-- Modal -->
<div class="modal fade" id="delete-{{ $id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <h3>Are you sure?</h3>
        <form action="{{ route($route, $id) }}" method="POST">
            @csrf 
            @method("DELETE")
            <button type="submit" class="btn btn-danger">Yes</button>
        </form>
    </div>
   
    </div>
</div>
</div>